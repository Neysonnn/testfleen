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
		$this->load->model('webhost');

		$userid = $this->user->getId();
		$users = $this->usersModel->getUserById($userid, array(), array());
		
		$total = $this->webhostModel->getTotalWebhosts(array('user_id' => (int)$userid));
		$webhosts = $this->webhostModel->getWebhosts(array('user_id' => (int)$userid), array('web_tarifs', 'web_locations'), array(), $options);
		
		$this->data['webhosts'] = $webhosts;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('webuslugi/index', $this->data);
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
			case 'createsitee': {	
				$balance = $users['user_balance'];
				$upsum = "100"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 100,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: создание сайта" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$urlsite = @$this->request->post['urlsite'];
						$urlsite2 = @$this->request->post['urlsite2'];
						$serveridd = @$this->request->post['serveridd'];
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: создание сайта", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $urlsite . "<br>Доп. информация: " . $urlsite2 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'createforums': {	
				$balance = $users['user_balance'];
				$upsum = "100"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 100,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: создание форума" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$createforum = @$this->request->post['createforum'];
						$createforum2 = @$this->request->post['createforum2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: создание форума", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $createforum . "<br>Доп. информация: " . $createforum2 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'domains': {	
				$balance = $users['user_balance'];
				$upsum = "50"; // Стоимость услуги вместо "50" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 50,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: привязка домена" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$domain = @$this->request->post['domain'];
						$urldomain2 = @$this->request->post['urldomain2'];
						$urldomain3 = @$this->request->post['urldomain3'];
						$urldomain4 = @$this->request->post['urldomain4'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: привязка домена", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $domain . "<br>Домен стоит: " . $urldomain2 . "<br>Мой домен: " . $urldomain3 . "<br>Доп. информация: " . $urldomain4 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'ssls': {	
				$balance = $users['user_balance'];
				$upsum = "55"; // Стоимость услуги вместо "100" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 55,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: подключение ssl" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$ssl = @$this->request->post['ssl'];
						$ssl = @$this->request->post['ssl2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: подключение ssl", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $ssl . "<br>Доп. информация: " . $ssl2 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'domainruu': {	
				$balance = $users['user_balance'];
				$upsum = "250"; // Стоимость услуги вместо "250" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 250,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: домен .ru" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$urlvktelega = @$this->request->post['urlvktelega'];
						$domenru = @$this->request->post['domenru'];
						$domeninfo = @$this->request->post['domeninfo'];
						$serveridd = @$this->request->post['serveridd'];
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: домен .ru", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $urlvktelega . "<br>Название домена: " . $domenru . "<br>Доп. информация: " . $domeninfo . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'edittextt': {	
				$balance = $users['user_balance'];
				$upsum = "75"; // Стоимость услуги вместо "75" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 75,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: изменение текстов" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$edittext2 = @$this->request->post['edittext2'];
						$edittext3 = @$this->request->post['edittext3'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: изменение текстов", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $edittext2 . "<br>Доп. информация: " . $edittext3 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'styleforumm': {	
				$balance = $users['user_balance'];
				$upsum = "40"; // Стоимость услуги вместо "40" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 40,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: смена стиля форума" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$styleforum1 = @$this->request->post['styleforum1'];
						$styleforum2 = @$this->request->post['styleforum2'];
						$styleforum3 = @$this->request->post['styleforum3'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: смена стиля форума", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $styleforum1 . "<br>Ссылка на новый стиль: " . $styleforum2 . "<br>Доп. информация: " . $styleforum3 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
			case 'securityy': {	
				$balance = $users['user_balance'];
				$upsum = "99"; // Стоимость услуги вместо "99" введите свою стоимость
					if ($balance >= $upsum){
						$this->usersModel->downUserBalance($userid, $upsum);
							$wasteData = array(
							'user_id'			=> $userid,
							'waste_ammount'	=> 99,
							'waste_status'	=> 1,
							'waste_usluga'	=> "Покупка: защита от DDOS" // Название услуги
						);
						$this->wasteModel->createWaste($wasteData);
						$userid = $this->user->getId();
						$security1 = @$this->request->post['security1'];
						$security2 = @$this->request->post['security2'];
						$serveridd = @$this->request->post['serveridd'];
						
						$ticketData = array(
							'user_id'			=> $userid,
							'ticket_name'		=> "Заказ: защита от DDOS", // Название заказа
							'ticket_status'		=> 1,
							'category_id'		=> 666
						);
						$ticketid = $this->ticketsModel->createTicket($ticketData);	

						$messageData = array(
							'ticket_id'			=> $ticketid,
							'user_id'			=> $userid,
							'ticket_message'	=> "Мой Telegram/VK: " . $security1 . "<br>Доп. информация: " . $security2 . "<br>Web: " . $serveridd . " <br>Жду Вашего сообщения!"
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
