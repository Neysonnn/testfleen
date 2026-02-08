<?php
/* @mrsasha082 */
class indexController extends Controller {
	private $limit = 9;
	public function index($page = 1) {
		$this->document->setActiveSection('sites');
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
		$this->load->model('sites');

		$options = array(
			'start'		=>	($page - 1) * $this->limit,
			'limit'		=>	$this->limit
		);
		
		$total = $this->sitesModel->getTotalSites();
		$sites = $this->sitesModel->getSites(array(), array(), $options);			
		
		$paginationLib = new paginationLibrary();
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $this->config->url . 'sites/index/index/{page}';
		$pagination = $paginationLib->render();
		
		$this->data['sites'] = $sites;
		$this->data['pagination'] = $pagination;
		$this->data['user_sites'] = $this->sitesModel->getUserSites($this->user->getId());
		
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('sites/index', $this->data);
	}
	
	public function buy($sitesid = null) {
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
		$this->load->model('sites');
		$this->load->model('users');
		$this->load->model('waste');
		
		$error = $this->validate($sitesid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}	
		
		$balance = $this->user->getBalance();
		
		$sites = $this->sitesModel->getSitesById($sitesid);
		
		if($sites["sites_status"] != 1) {
			$this->data["status"] = "error";
			$this->data["error"] = "Данный сайт недоступен!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {	
			$price = $sites['sites_price'];
			
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
				'waste_usluga'	=> "Покупка сайта №" . $sites['sites_id']
			); 
			$this->wasteModel->createWaste($wasteData);
			
			$this->usersModel->downUserBalance($userid, $price);
			
			$freeData = array(
				'user_id'			=> $userid,
				'sites_id'			=> $sites['sites_id']
			); 
			$this->sitesModel->addSites($freeData);
						
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
			$this->data['success'] = "Сайт " . $sites['sites_name'] . " успешно был приобретен, с вашего счёта снято " . $sites['sites_price'] . " р!";	
		} else {
			$this->data['status'] = "error";
			$this->data['error'] = "Не POST запрос!";
		}
		return json_encode($this->data);
	}
	
	private function validate($sitesid) {
		$result = null;
		
		if(!$this->sitesModel->getSitesById(array('sites_id' => (int)$sitesid))) {
			$result = "Запрашиваемый сайт не существует!";
		}
		return $result;
	}
}
?>