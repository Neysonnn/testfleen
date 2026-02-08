<?php
/* @mrsasha082 */
class indexController extends Controller {
	private $limit = 9;
	public function index($page = 1) {
		$this->document->setActiveSection('forums');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}

		$this->load->library('pagination');
		$this->load->model('forums');

		$options = array(
			'start'		=>	($page - 1) * $this->limit,
			'limit'		=>	$this->limit
		);
		
		$total = $this->forumsModel->getTotalForums();
		$forums = $this->forumsModel->getForums(array(), array(), $options);			
		
		$paginationLib = new paginationLibrary();
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'forums/index/index/{page}';
		$pagination = $paginationLib->render();
		
		$this->data['forums'] = $forums;
		$this->data['pagination'] = $pagination;
		$this->data['user_forums'] = $this->forumsModel->getUserForums($this->user->getId());
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('forums/index', $this->data);
	}
	
	public function buy($forumsid = null) {
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
		$userid = $this->user->getId();
		$this->load->model('forums');
		$this->load->model('users');
		$this->load->model('waste');
		
		$error = $this->validate($forumsid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$balance = $this->user->getBalance();
		
		$forums = $this->forumsModel->getForumsById($forumsid);
		
		if($forums["forums_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Данный стиль для форума недоступен!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {	
			$price = $forums['forums_price'];
			
			if($balance < $price){
				$this->data['status'] = "error";
				$this->data['error'] = "Недостаточно средств!";
				return json_encode($this->data);
			}
			
			$userid = $this->user->getId();
			
			$wasteData = array(
				'user_id'		=> $userid,
				'waste_ammount'	=> $price,
				'waste_status'	=> 1,
				'waste_usluga'	=> "Покупка стиля для форума №" . $forums['forums_id']
			); 
			$this->wasteModel->createWaste($wasteData);
			
			$this->usersModel->downUserBalance($userid, $price);
			
			$freeData = array(
				'user_id'			=> $userid,
				'forums_id'			=> $forums['forums_id']
			); 
			$this->forumsModel->addForums($freeData);
						
			$user = $this->usersModel->getUserById($userid);			
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
			$this->data['success'] = "Стиль для форума" . $forums['forums_name'] . " успешно был приобретен, с вашего счёта снято " . $forums['forums_price'] . " р!";	
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос!";
		}
		return json_encode($this->data);
	}
	
	private function validate($forumsid) {
		$result = null;
		
		if(!$this->forumsModel->getForumsById(array('forums_id' => (int)$forumsid))) {
			$result = "Запрашиваемый стиль для форума не существует!";
		}
		return $result;
	}
}
?>