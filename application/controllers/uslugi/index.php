<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
class indexController extends Controller {
	public function index() {
		if(!$this->user->isLogged()) {
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('users');
		$this->load->model('servers');

		$userid = $this->user->getId();
		$users = $this->usersModel->getUserById($userid, array(), array());
		$this->data['servers'] = $this->serversModel->getServers(array('user_id' => (int)$userid), array('games', 'locations'), array(), $options);
		$this->data['serversOwners'] = $this->serversModel->getOwners(array('servers_owners.user_id' => $userid), array('servers', 'games', 'locations'));
		$this->data['users'] = $users;
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('uslugi/index', $this->data);
	}
	public function ajax_action_exchange($action = null) {
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
		$this->load->model('tickets');
		$this->load->model('ticketsMessages');

		$userid = $this->user->getId();
		$users = $this->usersModel->getUserById($userid, array(), array());

		switch($action) {
			case 'installl': {	
				$balance = $users['user_balance'];
				$upsum = "40"; // Стоимость услуги вместо "40" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 40,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: установка мода" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$pawnik = @$this->request->post['pawnik'];
						$pawnik2 = @$this->request->post['pawnik2'];
						$serveridd = @$this->request->post['serveridd'];
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: установка мода", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Ссылка на мод: " . $pawnik . "<br>Доп. информация: " . $pawnik2 . "<br>Сервер: " . $serveridd . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			case 'admin': {	
				$balance = $users['user_balance'];
				$upsum = "30"; // Стоимость услуги вместо "30" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 30,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: выдача админки" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$adm = @$this->request->post['adm'];
						$adm2 = @$this->request->post['adm2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: выдача админки", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Nick_Name: " . $adm . "<br>Доп. информация: " . $adm2 . "<br>Сервер: " . $serveridd . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			case 'editnames': {	
				$balance = $users['user_balance'];
				$upsum = "40"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 40,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: смена названия" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$editname = @$this->request->post['editname'];
						$editname2 = @$this->request->post['editname2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: смена названия", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Название сервера: " . $editname . "<br>Доп. информация: " . $editname2 . "<br>Сервер: " . $serveridd . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			case 'editlogos': {	
				$balance = $users['user_balance'];
				$upsum = "40"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 40,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: смена логотипа" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$editlogo = @$this->request->post['editlogo'];
						$editlogo2 = @$this->request->post['editlogo2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: смена логотипа", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Название логотипа: " . $editlogo . "<br>Доп. информация: " . $editlogo2 . "<br>Сервер: " . $serveridd . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			case 'serverconn': {	
				$balance = $users['user_balance'];
				$upsum = "100"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 100,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: Server Connect" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$serverconnect = @$this->request->post['serverconnect'];
						$serverconnect2 = @$this->request->post['serverconnect2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: Server Connect", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Telegram/VK: " . $serverconnect . "<br>Доп. информация: " . $serverconnect2 . "<br>Сервер: " . $serveridd . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			case 'servdonn': {	
				$balance = $users['user_balance'];
				$upsum = "100"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 100,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: автодонат" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$servdonate = @$this->request->post['servdonate'];
						$servdonate2 = @$this->request->post['servdonate2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: автодонат", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Telegram/VK: " . $servdonate . "<br>Доп. информация: " . $servdonate2 . " <br>Жду Вашего сообщения!"
						);
						$this->ticketsMessagesModel->createTicketMessage($messageData);
						$this->data['id'] = $ticketid;
						$this->data['status'] = "success";
						$this->data['success'] = "Вы успешно заказали услугу! С вашего счета списано ".$upsum." руб!";
					} else {
						$this->data['status'] = "error";
						$this->data['error'] = "На Вашем счету недостаточно средств!";
					}
				break;
			}
			default: {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы выбрали несуществующее действие!";
				break;
			}
			
		}

		return json_encode($this->data);
	}
}
?>