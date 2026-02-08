<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
class webhostModel extends Model {
	public function createWebhost($data) {	
		$sql = "INSERT INTO `webhost` SET ";
		$sql .= "`user_id` = '" . (int)$data['user_id'] . "', ";
		$sql .= "`web_password` = '" . $data['web_password'] . "', ";
		$sql .= "`tarif_id` = '" . (int)$data['tarif_id'] . "', ";
		$sql .= "`web_status` = '1', ";
		$sql .= "`web_date_reg` = NOW(), ";
		$sql .= "`web_date_end` = NOW() + INTERVAL " . (int)$data['web_days'] . " DAY,";
		$sql .= "`location_id` = '" . (int)$data['location_id'] . "'";
		$this->db->query($sql);
		$return=$this->db->getLastId();		
		return $return;
	}
		public function getModById($modid, $joins = array()) {
		$sql = "SELECT * FROM `webhost_mods`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
		}
		$sql .=  " WHERE `mod_id` = '" . (int)$modid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	public function updateServer($serverid, $data = array()) {
		$sql = "UPDATE `servers`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `server_id` = '" . (int)$serverid . "'";
		$query = $this->db->query($sql);
	}
	
	public function getweb($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `webhost`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON webhost.user_id=users.user_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function installWebhost($webid, $password) {
					$this->load->model('users');
		$web = $this->getWebhostById($webid, array('web_locations', 'web_tarifs'));
		if($web['location_panel'] == 1) {
			if(empty($web['tarif_fastpackage'])) return array('status' => 'error', 'description' => 'Произошла ошибка 0, не указан ID шаблона в настройках тарифа!');
			if(empty($web['tarif_ssd'])) return array('status' => 'error', 'description' => 'Произошла ошибка 0, не указан размер диска в настройках тарифа!');
			$curl_run = $this->curlWebserver(
				$web['location_ip'] . ':8888/login',
				array("username" => $web['location_user'], "password" => $web['location_password']),
				array('Content-Type: application/json'),
				'POST',
				15
			);
			if($curl_run['error']) {
				$this->deleteWebserverFromDB($webid);
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if(isset($curl_run['result']['code'])) {
					$this->deleteWebserverFromDB($webid);
					return array('status' => 'error', 'description' => 'Произошла ошибка 1 - ' . $curl_run['result']['code'] . '. Код ошибки: ' . $curl_run['result']['message']);
				}
				$curl_run2 = $this->curlWebserver(
					$web['location_ip'] . ':8888/api/users',
					array("username" => "ws" . $webid, "password" => $password, "roles" => "ROLE_USER", "quota" => (int) $web['tarif_ssd'] * 1024),
					array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
					'POST',
					15
				);
				if($curl_run2['error']) {
					$this->deleteWebserverFromDB($webid);
					return array('status' => 'error', 'description' => $curl_run2['error']);
				} else {
					if(isset($curl_run2['result']['code'])) {
						$this->deleteWebserverFromDB($webid);
						return array('status' => 'error', 'description' => 'Произошла ошибка 2 - ' . $curl_run2['result']['code'] . '. Код ошибки: ' . $curl_run2['result']['message']);
					}
					if(isset($curl_run2['result']['errors'])) {
						$this->deleteWebserverFromDB($webid);
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Ответ от сервера: ' . json_encode($curl_run2['result']['errors'], JSON_UNESCAPED_UNICODE));
					}
					if(!isset($curl_run2['result']['data']['id'])) {
						$this->deleteWebserverFromDB($webid);
						return array('status' => 'error', 'description' => 'Произошла ошибка 2, не был получен ID пользователя в панели Fastpanel!');
					}
					sleep(1);
					$curl_run3 = $this->curlWebserver(
						$web['location_ip'] . ':8888/api/limits/' . $curl_run2['result']['data']['id'],
						array("template_id" => (int) $web['tarif_fastpackage']),
						array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
						'PUT',
						15
					);
					if($curl_run3['error']) {
						$this->deleteWebserverFromDB($webid);
						return array('status' => 'error', 'description' => $curl_run3['error']);
					} else {
						if(isset($curl_run2['result']['code'])) {
							$this->deleteWebserverFromDB($webid);
							return array('status' => 'error', 'description' => 'Произошла ошибка 3 - ' . $curl_run3['result']['code'] . '. Код ошибки: ' . $curl_run3['result']['message']);
						}
						if(isset($curl_run3['result']['errors'])) {
							$this->deleteWebserverFromDB($webid);
							return array('status' => 'error', 'description' => 'Произошла ошибка 3. Ответ от сервера: ' . json_encode($curl_run3['result']['errors'], JSON_UNESCAPED_UNICODE));
						}
						
						if($web['tarif_ssh'] == 0) {
							$curl_run4 = $this->curlWebserver(
								$web['location_ip'] . ':8888/api/users/' . $curl_run2['result']['data']['id'] . '/ssh',
								array("ssh_access" => false),
								array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
								'PUT',
								15
							);
							if($curl_run4['error']) {
								$this->deleteWebserverFromDB($webid);
								return array('status' => 'error', 'description' => $curl_run4['error']);
							} else {
								if(isset($curl_run2['result']['code'])) {
									$this->deleteWebserverFromDB($webid);
									return array('status' => 'error', 'description' => 'Произошла ошибка 4 - ' . $curl_run4['result']['code'] . '. Код ошибки: ' . $curl_run4['result']['message']);
								}
								if(isset($curl_run4['result']['errors'])) {
									$this->deleteWebserverFromDB($webid);
									return array('status' => 'error', 'description' => 'Произошла ошибка 4. Ответ от сервера: ' . json_encode($curl_run4['result']['errors'], JSON_UNESCAPED_UNICODE));
								}
							}
						}
						
						$this->updateWebhost($webid, array('web_id_to_panel' => $curl_run2['result']['data']['id']));
						return array('status' => 'success');
					}
				}
			}
		} else if($web['location_panel'] == 2) {
			if(empty($web['tarif_isppackage'])) return array('status' => 'error', 'description' => 'Произошла ошибка 0, не указано название шаблона в настройках тарифа!');
			$curl_run = $this->curlWebserver(
				$web['location_ip'] .':1500/ispmgr?authinfo='. $web['location_user'] .':'. $web['location_password'] .'&out=json&lang=ru&func=user.add&name=ws' . $webid . '&fullname=ws' . $webid . '&passwd=' . $password . '&domain=ws' . $webid . '.fleen-web.ru&preset=' . $web['tarif_isppackage'] . '&status=1&sok=ok',
				false,
				false,
				'GET',
				15
			);
			if($curl_run['error']) {
				$this->deleteWebserverFromDB($webid);
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if (isset($curl_run['result']['doc']['error']['msg']['$'])) {
					$this->deleteWebserverFromDB($webid);
					return array('status' => 'error', 'description' => 'Произошла ошибка 1: ' . $curl_run['result']['doc']['error']['msg']['$']);
				}
				if (isset($curl_run['result']['doc']['ok'])) {
					return array('status' => 'success');
				}
			}
		} else {
			return array('status' => 'error', 'description' => 'Произошла ошибка, указана неверная панель в настройках локации!');
		}
	}

	public function deleteWebhost($webid) {
		$web = $this->getWebhostById($webid, array('web_locations'));
		if($web['location_panel'] == 1) {
			if($web['web_id_to_panel'] == 0) {
				return array('status' => 'error', 'description' => 'Возникла ошибка при получении ID пользователя в панели Fastpanel. Обратитесь к администрации!');
			}
			$curl_run = $this->curlWebserver(
				$web['location_ip'] . ':8888/login',
				array("username" => $web['location_user'], "password" => $web['location_password']),
				array('Content-Type: application/json'),
				'POST',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if(isset($curl_run['result']['code'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1 - ' . $curl_run['result']['code'] . '. Код ошибки: ' . $curl_run['result']['message']);
				}
				$curl_run2 = $this->curlWebserver(
					$web['location_ip'] . ':8888/api/users/' . $web['web_id_to_panel'],
					false,
					array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
					'DELETE',
				15);
				if($curl_run2['error']) {
					return array('status' => 'error', 'description' => $curl_run2['error']);
				} else {
					if(isset($curl_run2['result']['code'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2 - ' . $curl_run2['result']['code'] . '. Код ошибки: ' . $curl_run2['result']['message']);
					}
					if(isset($curl_run2['result']['errors'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Ответ от сервера: ' . json_encode($curl_run2['result']['errors'], JSON_UNESCAPED_UNICODE));
					}
					$this->deleteWebserverFromDB($webid);
					return array('status' => 'success');
				}
			}
		} else if($web['location_panel'] == 2) {
			$curl_run = $this->curlWebserver(
				$web['location_ip'] .':1500/ispmgr?authinfo='. $web['location_user'] .':'. $web['location_password'] .'&out=json&lang=ru&func=user.delete&elid=ws' . $webid . '&sok=ok',
				false,
				false,
				'GET',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if (isset($curl_run['result']['doc']['error']['msg']['$'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1: ' . $curl_run['result']['doc']['error']['msg']['$']);
				}
				if (isset($curl_run['result']['doc']['ok'])) {
					$this->deleteWebserverFromDB($webid);
					return array('status' => 'success');
				}
			}
		} else {
			return array('status' => 'error', 'description' => 'Произошла ошибка, указана неверная панель в настройках локации!');
		}
	}
	
	public function blockWebhost($webid) {
		$web = $this->getWebhostById($webid, array('web_locations'));
		if($web['location_panel'] == 1) {
			if($web['web_id_to_panel'] == 0) {
				return array('status' => 'error', 'description' => 'Возникла ошибка при получении ID пользователя в панели Fastpanel. Обратитесь к администрации!');
			}
			$curl_run = $this->curlWebserver(
				$web['location_ip'] . ':8888/login',
				array("username" => $web['location_user'], "password" => $web['location_password']),
				array('Content-Type: application/json'),
				'POST',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if(isset($curl_run['result']['code'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1 - ' . $curl_run['result']['code'] . '. Код ошибки: ' . $curl_run['result']['message']);
				}
				$curl_run2 = $this->curlWebserver(
					$web['location_ip'] . ':8888/api/users/' . $web['web_id_to_panel'] . '/status',
					array("enabled" => false),
					array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']), 
					'PUT',
					15
				);
				if($curl_run2['error']) {
					return array('status' => 'error', 'description' => $curl_run2['error']);
				} else {
					if(isset($curl_run2['result']['code'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2 - ' . $curl_run2['result']['code'] . '. Код ошибки: ' . $curl_run2['result']['message']);
					}
					if(isset($curl_run2['result']['errors'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Ответ от сервера: ' . json_encode($curl_run2['result']['errors'], JSON_UNESCAPED_UNICODE));
					}
					$this->updateWebhost($webid, array('web_status' => 0));
					return array('status' => 'success');
				}
			}
		} else if($web['location_panel'] == 2) {
			$curl_run = $this->curlWebserver(
				$web['location_ip'] .':1500/ispmgr?authinfo='. $web['location_user'] .':'. $web['location_password'] .'&out=json&lang=ru&func=user.suspend&elid=ws' . $webid . '&sok=ok',
				false,
				false,
				'GET',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if (isset($curl_run['result']['doc']['error']['msg']['$'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1: ' . $curl_run['result']['doc']['error']['msg']['$']);
				}
				if (isset($curl_run['result']['doc']['ok'])) {
					$this->updateWebhost($webid, array('web_status' => 0));
					return array('status' => 'success');
				}
			}
		} else {
			return array('status' => 'error', 'description' => 'Произошла ошибка, указана неверная панель в настройках локации!');
		}
	}
	
	public function unblockWebhost($webid) {
		$web = $this->getWebhostById($webid, array('web_locations'));
		if($web['location_panel'] == 1) {
			if($web['web_id_to_panel'] == 0) {
				return array('status' => 'error', 'description' => 'Возникла ошибка при получении ID пользователя в панели Fastpanel. Обратитесь к администрации!');
			}
			$curl_run = $this->curlWebserver(
				$web['location_ip'] . ':8888/login',
				array("username" => $web['location_user'], "password" => $web['location_password']),
				array('Content-Type: application/json'),
				'POST',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if(isset($curl_run['result']['code'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1 - ' . $curl_run['result']['code'] . '. Код ошибки: ' . $curl_run['result']['message']);
				}
				$curl_run2 = $this->curlWebserver(
					$web['location_ip'] . ':8888/api/users/' . $web['web_id_to_panel'] . '/status', 
					array("enabled" => true), 
					array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
					'PUT',
					15
				);
				if($curl_run2['error']) {
					return array('status' => 'error', 'description' => $curl_run2['error']);
				} else {
					if(isset($curl_run2['result']['code'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2 - ' . $curl_run2['result']['code'] . '. Код ошибки: ' . $curl_run2['result']['message']);
					}
					if(isset($curl_run2['result']['errors'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Ответ от сервера: ' . json_encode($curl_run2['result']['errors'], JSON_UNESCAPED_UNICODE));
					}
					$this->updateWebhost($webid, array('web_status' => 1));
					return array('status' => 'success');
				}
			}
		} else if($web['location_panel'] == 2) {
			$curl_run = $this->curlWebserver(
				$web['location_ip'] .':1500/ispmgr?authinfo='. $web['location_user'] .':'. $web['location_password'] .'&out=json&lang=ru&func=user.resume&elid=ws' . $webid . '&sok=ok',
				false,
				false,
				'GET',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if (isset($curl_run['result']['doc']['error']['msg']['$'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1: ' . $curl_run['result']['doc']['error']['msg']['$']);
				}
				if (isset($curl_run['result']['doc']['ok'])) {
					$this->updateWebhost($webid, array('web_status' => 1));
					return array('status' => 'success');
				}
			}
		} else {
			return array('status' => 'error', 'description' => 'Произошла ошибка, указана неверная панель в настройках локации!');
		}
	}

	public function updatepassUser($webid, $password) {

		$web = $this->getWebhostById($webid, array('web_locations', 'web_tarifs'));
		if($web['location_panel'] == 1) {
			if(empty($web['tarif_ssd'])) return array('status' => 'error', 'description' => 'Произошла ошибка 0, не указан размер диска в настройках тарифа!');
			if($web['web_id_to_panel'] == 0) {
				return array('status' => 'error', 'description' => 'Возникла ошибка при получении ID пользователя в панели Fastpanel. Обратитесь к администрации!');
			}
			$curl_run = $this->curlWebserver(
				$web['location_ip'] . ':8888/login',
				array("username" => $web['location_user'], "password" => $web['location_password']),
				array('Content-Type: application/json'),
				'POST',
				15
			);
			
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if(isset($curl_run['result']['code'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1 ' . $curl_run['result']['code'] . '. Код ошибки: ' . $curl_run['result']['message']);
				}
				if($webserver['location_reseller_status'] == 0) {
					$put_data = array("quota" => (int) $web['tarif_ssd'] * 1024, "password" => $password);
				} elseif($webserver['location_reseller_status'] == 1) {
					$put_data = array("quota" => (int) $web['tarif_ssd'] * 1024, "old_password" => $web['web_password'], "password" => $password);
				}
				$curl_run2 = $this->curlWebserver(
					$web['location_ip'] . ':8888/api/users/' . $web['web_id_to_panel'],
					$put_data,
					array('Content-Type: application/json', 'Authorization: Bearer ' . $curl_run['result']['data']['token']),
					'PUT',
					15
				);
				if($curl_run2['error']) {
					return array('status' => 'error', 'description' => $curl_run2['error']);
				} else {
					if(isset($curl_run2['result']['code'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2 - ' . $curl_run2['result']['code'] . '. Код ошибки: ' . $curl_run2['result']['message']);
					}
					if(isset($curl_run2['result']['errors']['old_password'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Возможно в настройках локации указан аккаунт реселлера, для которого требуется указать старый пароль пользователя. Насторойте локацию согласно документации.');
					}
					if(isset($curl_run2['result']['errors'])) {
						return array('status' => 'error', 'description' => 'Произошла ошибка 2. Ответ от сервера: ' . json_encode($curl_run2['result']['errors'], JSON_UNESCAPED_UNICODE));
					}
					return array('status' => 'success');
				}
			}
		} else if($web['location_panel'] == 2) {
			$curl_run = $this->curlWebserver(
				$web['location_ip'] .':1500/ispmgr?authinfo='. $web['location_user'] .':'. $web['location_password'] .'&out=json&lang=ru&func=user.edit&elid=ws' . $webid . '&passwd=' . $password . '&sok=ok',
				false,
				false,
				'GET',
				15
			);
			if($curl_run['error']) {
				return array('status' => 'error', 'description' => $curl_run['error']);
			} else {
				if (isset($curl_run['result']['doc']['error']['msg']['$'])) {
					return array('status' => 'error', 'description' => 'Произошла ошибка 1: ' . $curl_run['result']['doc']['error']['msg']['$']);
				}
				if (isset($curl_run['result']['doc']['ok'])) {
					return array('status' => 'success');
				}
			}
		} else {
			return array('status' => 'error', 'description' => 'Произошла ошибка, указана неверная панель в настройках локации!');
		}
	}
	public function updateDomain($webid, $domain) {
		$this->db->query("UPDATE `webhost` SET `web_domain` = '".$domain."' WHERE `webhost`.`web_id` = ".$webid.";");
	}
	public function deleteWebserverFromDB($webid) {
		$this->db->query("DELETE FROM `webhost` WHERE web_id = '" . (int) $webid . "'");
	}
	public function curlWebserver($url, $data = false, $header, $type = "GET", $timeout = 15) {
		$curl_webserver = curl_init();
		curl_setopt($curl_webserver, CURLOPT_URL, 'https://' . $url);
		curl_setopt($curl_webserver, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_webserver, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_webserver, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl_webserver, CURLOPT_HTTPHEADER, $header);
		if($type == "POST") curl_setopt($curl_webserver, CURLOPT_POST, true);
		if($type == "PUT" || $type == "DELETE") curl_setopt($curl_webserver, CURLOPT_CUSTOMREQUEST, $type);
		if($data != false) curl_setopt($curl_webserver, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
		curl_setopt($curl_webserver, CURLOPT_CONNECTTIMEOUT, $timeout);
		$result_webserver = curl_exec($curl_webserver);
		$error_webserver = curl_error($curl_webserver);
		if($error_webserver) $error_webserver = 'Произошла ошибка. Код ошибки: ' . str_replace(explode(":", $url)[0], "\"IP скрыт\"", $error_webserver);
		if(!$error_webserver) {
			if(!$result_webserver) $error_webserver = 'Произошла ошибка. Получен пустой ответ от сервера!';
		}
		curl_close($curl_webserver);
		return array('error' => $error_webserver, 'result' => json_decode($result_webserver, true));
	}
		public function getUserMods($userid) {
		$sql = "SELECT * FROM `users_mods1` WHERE `user_id` = '" . (int)$userid . "' ";
		$query = $this->db->query($sql);
		return $query->rows;
	}
		public function getMods($data = array(),$sort = array(), $options = array()) {
		$sql = "SELECT * FROM `webhost_mods`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function updateWebhost($webid, $data = array()) {
		$sql = "UPDATE `webhost`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " SET";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		$sql .= " WHERE `web_id` = '" . (int)$webid . "'";
		$query = $this->db->query($sql);
	}
	
	public function extendWebhost($webid, $days, $fromCurrent) {
		$sql = "UPDATE `webhost` SET web_date_end = ";
		if($fromCurrent)
			$sql .= "NOW()";
		else
			$sql .= "web_date_end";
		$sql .= "+INTERVAL " . (int)$days . " DAY WHERE web_id = '" . (int)$webid . "'";
		
		$this->db->query($sql);
	}
	
	public function getWebhosts($data = array(), $joins = array(), $sort = array(), $options = array()) {
		$sql = "SELECT * FROM `webhost`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON webhost.user_id=users.user_id";
					break;
				case "web_tarifs":
					$sql .= " ON webhost.tarif_id=web_tarifs.tarif_id";
					break;
				case "web_locations":
					$sql .= " ON webhost.location_id=web_locations.location_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		
		if(!empty($sort)) {
			$count = count($sort);
			$sql .= " ORDER BY";
			foreach($sort as $key => $value) {
				$sql .= " $key " . $value;
				
				$count--;
				if($count > 0) $sql .= ",";
			}
		}
		
		if(!empty($options)) {
			if ($options['start'] < 0) {
				$options['start'] = 0;
			}
			if ($options['limit'] < 1) {
				$options['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$options['start'] . "," . (int)$options['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getWebhostById($webid, $joins = array()) {
		$sql = "SELECT * FROM `webhost`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN $join";
			switch($join) {
				case "users":
					$sql .= " ON webhost.user_id=users.user_id";
					break;
				case "web_tarifs":
					$sql .= " ON webhost.tarif_id=web_tarifs.tarif_id";
					break;
				case "web_locations":
					$sql .= " ON webhost.location_id=web_locations.location_id";
					break;
			}
		}
		$sql .=  " WHERE `web_id` = '" . (int)$webid . "' LIMIT 1";
		$query = $this->db->query($sql);
		return $query->row;
	}
	
	public function getTotalWebhosts($data = array()) {
		$sql = "SELECT COUNT(*) AS count FROM `webhost`";
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . $this->db->escape($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$query = $this->db->query($sql);
		return $query->row['count'];
	}	
}
?>