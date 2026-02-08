<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
class autofsController extends Controller {
	public function index($serverid = null) {
		$this->document->setActiveSection('servers');
		$this->document->setActiveItem('autofs');
		$this->data['activesection'] = $this->document->getActiveSection();
		$this->data['activeitem'] = $this->document->getActiveItem();
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('servers');
		$this->load->model('users');

		$error = $this->validate($serverid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'servers/index');
		}
		
		$userid = $this->user->getId();
		
		$server = $this->serversModel->getServerById($serverid, array('games', 'locations'));
		$this->data['server'] = $server;

		$fs = $this->serversModel->getFs(array('fs_status' => 1),array(),array(), array());
		$this->data['userfs'] = $this->usersModel->getUserFs($userid);
        $this->data['fs'] = $fs;
		
		include_once 'application/controllers/common/main.php';
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('servers/autofs', $this->data);
	}
	
	public function action($serverid = null, $action = null) {
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 0) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		$userid = $this->user->getId();
		$this->load->model('servers');
		$this->load->model('users');
		$this->load->model('waste');
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$error = $this->validateFs($action);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$balance = $this->user->getBalance();
		$server = $this->serversModel->getServerById($serverid, array('users', 'locations', 'games'));

		if($server['server_status'] == 3) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет установка сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 4) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет переустановка сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 5) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет создание BackUP сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 6) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет восстанновление сервера из BackUP!";
			return json_encode($this->data);
		} else if($server['server_status'] == 7) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет обновление сервера!";
			return json_encode($this->data);
		} else if($server["server_status"] == 0) {
			$this->data["status"] = "error";
			$this->data["error"] = "Сервер заблокирован!";
			return json_encode($this->data);
		}
		
		$fss = $this->serversModel->getFsById($action);
		
		if($fss["fs_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Данный скрипт не доступен!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {	
			$price = $fss['fs_price'];
			if($balance < $price){
				$this->data['status'] = "error";
				$this->data['error'] = "Недостаточно средств";
				return json_encode($this->data);
			}
			$userid = $this->user->getId();
			$wasteData = array(
				'user_id'		=> $userid,
				'waste_ammount'	=> $price,
				'waste_status'	=> 1,
				'waste_usluga'	=> "Установка скрипта ".$fss['fs_id'].""
			); 
			$this->wasteModel->createWaste($wasteData);
			$this->usersModel->downUserBalance($userid, $price);
			$freeData = array(
				'user_id'			=> $userid,
				'fs_id'			=> "".$fss['fs_id'].""
			); 
			$this->usersModel->addFs($freeData);
						
			$user = $this->usersModel->getUserById($userid, array(), array(), array());
								
			if($user['ref'] != 0) {								
				$ref_percent = $this->config->ref_percent;
				$getpref = ($price * (1 + $ref_percent / 100)) - $price;
				$this->usersModel->upUserBalance($user['ref'], $getpref);
				$this->usersModel->upUserRMoney($user['ref'], $getpref);
														
				$wasteData = array(
					'user_id'		=> $user['ref'],
					'waste_ammount'	=> $getpref,
					'waste_status'	=> 0,
					'waste_usluga'	=> "Бонус с реферала ID-$userid"
				); 
				$this->wasteModel->createWaste($wasteData);
			}
				
			$this->data['status'] = "success";
			$this->data['success'] = "Скрипт ".$fss['fs_name']." успешно был приобретен, с вашего счёта снято ".$fss['fs_price']." р!";	
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос!";
		}
		return json_encode($this->data);
	}
	
	public function install($serverid = null, $install = null) {
		if(!$this->user->isLogged()) {
			$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 0) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		$userid = $this->user->getId();
		$this->load->model('servers');
		$this->load->model('users');
		$this->load->library('ssh2');
		$ssh2Lib = new ssh2Library();
		
		$error = $this->validate($serverid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$error = $this->validateFs($install);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$balance = $this->user->getBalance();
		$server = $this->serversModel->getServerById($serverid, array('users', 'locations', 'games'));

		if($server['server_status'] == 3) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет установка сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 4) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет переустановка сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 5) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет создание BackUP сервера!";
			return json_encode($this->data);
		} else if($server['server_status'] == 6) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет восстанновление сервера из BackUP!";
			return json_encode($this->data);
		} else if($server['server_status'] == 7) {
			$this->data["status"] = "error";
			$this->data["error"] = "Идет обновление сервера!";
			return json_encode($this->data);
		} else if($server["server_status"] == 0) {
			$this->data["status"] = "error";
			$this->data["error"] = "Сервер заблокирован!";
			return json_encode($this->data);
		}
		
		$fss = $this->serversModel->getFsById($install);
		
		if($fss["fs_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Данный скрипт не доступен!";
			return json_encode($this->data);
		}

		if($server["server_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Выключите сервер!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$price = $fss['fs_price'];
			$userid = $this->user->getId();
		    $link = $ssh2Lib->connect($server['location_ip'], $server['location_user'], $server['location_password']);
			$ssh2Lib->execute($link, 
				"
					cd /home/gs{$serverid}/filterscripts;
					rm ".$fss['fs_arch'].";
					wget ".$fss['fs_url'].";
					tar -xf ".$fss['fs_arch'].";
					rm ".$fss['fs_arch'].";
					chown -R gs". $server['server_id'] .":gameservers /home/gs". $server['server_id'] ."	
				"
			);
				
			$this->load->library('sftp');		
			$sftpLib = new sftpLibrary();		
			$sftpLink = $sftpLib->connect($server['location_ip'], $server['location_user'], $server['location_password']);

			$filterscripts = '';
			
			$file = $sftpLib->open($sftpLink, '/home/gs' . $serverid . '/server.cfg');
			if(empty($file)) {
				$ssh2Lib->execute($link, 'cp -Rp /home/cp/gameservers/files/' . $server['game_code'] .'/server.cfg /home/gs' . $serverid . '/');
				$ssh2Lib->execute($link, 'chown gs' . $serverid . ':gameservers -Rf /home/gs' . $serverid .'/server.cfg');
			}
		
			$txtProperties = explode("\n",$file);	
			for ($i = 0; $i < count($txtProperties); $i++) {
				if (strpos($txtProperties[$i], 'filterscripts') !== FALSE) {
					$filterscripts = substr($txtProperties[$i], 13);
				}
			} 	
	
			$configs = array(
				array(
					'File' => '/server.cfg',
					'ExecPattern' => false,
					'Required' => 1,
					'Values' => array(
						array(
							'Pattern' => 'filterscripts <value>',
							'Value' => $fss['fs_cfg'] . ' ' . $filterscripts,
							'Required' => 1
						)
					)
				)
			);
			
			foreach($configs as $cfg) {
				$file = $sftpLib->open($sftpLink, '/home/gs' . $serverid . '/' . $cfg['File']);

				if(empty($file) && $cfg['Required'] == 1) {
					break;
				}
									
				foreach($cfg['Values'] as $value) {
					$pattern = str_replace('<value>', '(.*)', $value['Pattern']);
					$replace = str_replace('<value>', $value['Value'], $value['Pattern']);

					if($value['Required'] == 1 && !preg_match('/' . $pattern . '/', $file)) {
						$file .= "\r\n" . $pattern;
					} else if($value['Required'] == -1 && preg_match('/' . $pattern . '/', $file)) {
						return False;
					}
					$file = preg_replace('/' . $pattern . '/', $replace, $file);
				}
				if($file != null) $sftpLib->write($sftpLink, '/home/gs' . $serverid . '/' . $cfg['File'], $file);
			}
			
			$ssh2Lib->disconnect($link);
			
			$this->data['status'] = "success";
			$this->data['success'] = "Скрипт ".$fss['fs_name']." был установлен";	
			$this->serversModel->action($serverid, 'start');
			$this->serversModel->updateServer($serverid, array("server_status" => 2));
		} 
		else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос!";
		}
		return json_encode($this->data);
	}
	
	private function validate($serverid) {
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->serversModel->getTotalServerOwners(array('server_id' => (int)$serverid, 'user_id' => (int)$userid, 'owner_status' => 1))) {
			if(!$this->serversModel->getTotalServers(array('server_id' => (int)$serverid, 'user_id' => (int)$userid))) {
				$result = "Запрашиваемый сервер не существует!";
			}
		}
		return $result;
	}
	

	
	private function validateFs($fsid) {
		$result = null;
		
		if(!$this->serversModel->getFsById(array('fs_id' => (int)$fsid))) {
			$result = "Запрашиваемый файл не существует!";
		}
		return $result;
	}
}
?>