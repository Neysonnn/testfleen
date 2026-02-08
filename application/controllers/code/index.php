<?php
/*
made vk.com/gtmayo69 
tg: @crontabone
thanks for the help @mrsasha_082
*/
class indexController extends Controller {
	public function index() {
		$this->document->setActiveSection('code');
        $this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->data['public'] = $this->config->public;

		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('code/index', $this->data);
	}
	
	public function code() {
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 1) {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('users');
        $this->load->model('waste');
		$this->load->model('games');
		$this->load->model('locations');
		$this->load->model('servers');
		$this->load->model('codes');	
		$userid = $this->user->getId();
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$code = $this->request->post['code'];
			$code_check = $this->usersModel->getSkidkaBySCode($code, true);
			$code_checkk = $this->usersModel->getSkidkaBySCode($code, false);
			$this->usersModel->getSkidkaByCode($code,true);
			if($code_check['cod'] == NULL){
				$this->data['status'] = "error";
				$this->data['error'] = "Данного кода не существует";
			}else{
				$ludi = array();
				if($code_checkk['ludi']) $ludi = json_decode($code_checkk['ludi'], true);
				
				if(in_array($userid, $ludi)) {
					$this->data['status'] = "error";
					$this->data['error'] = "Вы уже использовали этот код!";
					return json_encode($this->data);
				}
				
				array_push($ludi, $userid);
				$ludi_save = json_encode($ludi);
					
				if($code_check['money_ili_server'] == 1) 
				{
					$this->data['status'] = "success";
					$this->data['type'] = 0;
					$this->data['success'] = "Вы активировали код";	
					$dengi = $code_check['money'];
					$this->usersModel->upUserBalance($userid, $dengidengi);
					$wasteData = array(
						'user_id'			=> $userid,
						'waste_ammount'	=> $dengi,
						'waste_status'	=> 0,
						'waste_usluga'	=> "Использовал код на деньги"
						); 
					$this->wasteModel->createWaste($wasteData);
					$this->usersModel->upUserBalance($userid, $dengi);
					
					$this->codesModel->updatecode($code_checkk['id'], array('ludi' => $ludi_save));
				}
				elseif($code_check['money_ili_server'] == 2) 
				{
					$locationid = $code_check['locationid'];
					$gameid = $code_check['gameid'];
					$game = $this->gamesModel->getGameById($gameid);
					$port = $this->serversModel->getServerNewPort($locationid, $game['game_min_port'], $game['game_max_port']);
					$this->data['status'] = "success";
					$this->data['success'] = "Вы активировали код";	
					if($port) {
						$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
						$max=10;
						$size=StrLen($chars)-1;
						$password=null;
						while($max--)
						$password.=$chars[rand(0,$size)];
						$serverData = array(
							'user_id'			=> $userid,
							'game_id'			=> $code_check['gameid'],
							'location_id'		=> $code_check['locationid'],
							'server_mysql'		=> 0,
							'server_slots'		=> $code_check['slotiki'],
							'server_port'		=> $port,
							'server_password'	=> $password,
							'server_status'		=> 3,
							'server_days'		=> $code_check['server_day']
						);
					
						$serverid = $this->serversModel->createServer($serverData);
						$this->usersModel->downUserBalance($userid, $price);
						$wasteData = array(
						  'user_id'			=> $userid,
						  'waste_ammount'	=> $price,
						  'waste_status'	=> 1,
						  'waste_usluga'	=> "Использовал секретный код сервер: gs$serverid"
					    ); 
				        $this->wasteModel->createWaste($wasteData);

						$this->codesModel->updatecode($code_checkk['id'], array('ludi' => $ludi_save));
				
						$this->data['status'] = "success";
						$this->data['success'] = "Сервер успешно поставлен в очередь на установку.";
						$this->data['id'] = $serverid;		
						$this->data['type'] = 1;
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = "На выбранной Вами локации нет свободных портов для данной игры";
				}
				}
			}
		}

		return json_encode($this->data);
	}
}
?>
