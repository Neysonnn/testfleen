<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
class autoinstallController extends Controller {
	public function index($webid = null) {
		$this->document->setActiveSection('webhost');
		$this->document->setActiveItem('autoinstall');
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
		$this->load->model('webhost');
		$this->load->model('users');

		$error = $this->validate($webid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'webhost/index');
		}
		
		$userid = $this->user->getId();
		
		$webhost = $this->webhostModel->getWebhostById($webid, array('users','web_tarifs','web_locations'));
		$this->data['webhost'] = $webhost;
		$webhost2 = $this->webhostModel->getWebhostById($webid, array('users','web_tarifs','web_locations'));
		$this->data['webhost2'] = $webhost2;
		$mods = $this->webhostModel->getMods(array('mod_status' => 1),array(), array());
		$this->data['usermods'] = $this->webhostModel->getUserMods($userid);
        $this->data['mods'] = $mods;

		include_once 'application/controllers/common/main.php';
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webhost/autoinstall', $this->data);
	}
	
	public function action($webid = null, $action = null) {
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
		$this->load->model('webhost');
		$this->load->library('ssh2');
		$this->load->model('users');
		$this->load->model('waste');
		$ssh2Lib = new ssh2Library();
		
		$error = $this->validate($webid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		$balance = $this->user->getBalance();
		$webhost = $this->webhostModel->getWebhostById($webid, array('users','web_tarifs','web_locations'));
		if($webhost['web_status'] == 0) {
			$this->data['status'] = "error";
			$this->data['error'] = "Веб-хостинг заблокирован!";
			return json_encode($this->data);
		}
				if($webhost['web_domain'] == '') {
			$this->data['status'] = "error";
			$this->data['error'] = "Введите домен на гланой странице!";	
			return json_encode($this->data);		
		}
			if($webhost['web_domain'] == '') {
			$this->data['status'] = "error";
			$this->data['error'] = "Ошибка 540. Сообщение админу";	
			return json_encode($this->data);		
		}
		
		$mod = $this->webhostModel->getModById($action);
		
		if($mod["mod_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Данный сайт не доступен для установки!";
			return json_encode($this->data);
		}

		if($this->request->server['REQUEST_METHOD'] == 'POST') {	
			if($mod['mod_price'] > 0) {
				if($this->usersModel->checkFreeMode($userid, $mod['mod_id'])){
					$free_mode = 1;
				}
				$price = $mod['mod_price'];
				if(($balance < $price) and $free_mode != 1){
					$this->data['status'] = "error";
					$this->data['error'] = "Недостаточно средств";
					return json_encode($this->data);
				}
			}
		    $link = $ssh2Lib->connect($webhost['location_ip'], $webhost['localuser'], $webhost['localpass']);
			$ssh2Lib->execute($link, 
				"
					cd /var/www/ws".$webid."/data/www;
					rm -rf ".$webhost['web_domain'].";
					mkdir ".$webhost['web_domain'].";
					cd ".$webhost['web_domain'].";		
					wget ".$mod['mod_url'].";
					unzip -u ".$mod['mod_arch'].";	
                    rm ".$mod['mod_arch'].";
					chown -R ws".$webid.":ws".$webid." /var/www/ws".$webid.";
                    chmod 777 /var/www/ws".$webid."/data/www;					
					"
			);
			$ssh2Lib->disconnect($link);
			if($mod['mod_price'] > 0) {
				if($free_mode != 1){
					$userid = $this->user->getId();
					$wasteData = array(
						'user_id'			=> $userid,
						'waste_ammount'	=> $price,
						'waste_status'	=> 1,
						'waste_usluga'	=> "Установка сайта ".$mod['mod_name'].""
					); 
					$this->wasteModel->createWaste($wasteData);
					$this->usersModel->downUserBalance($userid, $price);
					$freeData = array(
						'user_id'			=> $userid,
						'mod_id'			=> "".$mod['mod_id'].""
					); 
					$this->usersModel->addMode($freeData);
							
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
					$this->data['success'] = "Сайт ".$mod['mod_name']." успешно был установлен,с вашего счёта снято ".$mod['mod_price']." р!";	
				} else{
					$this->data['status'] = "success";
					$this->data['success'] = "Сайт ".$mod['mod_name']." успешно был установлен. ";
				}
			} else {
				$this->data['status'] = "success";
				$this->data['success'] = "Сайт ".$mod['mod_name']." успешно был установлен.";
			}
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос!";
		}
		return json_encode($this->data);
	}
	private function validate($webid) {
		$result = null;
		
		$userid = $this->user->getId();
		
		if(!$this->webhostModel->getTotalWebhosts(array('web_id' => (int)$webid, 'user_id' => (int)$userid))) {
			$result = "Запрашиваемый веб-хостинг не существует!";
		}
		return $result;
	}
}
?>