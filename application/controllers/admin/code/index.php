<?php
/*
Copyright (c) 2020 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko and Alexander Zemlyanoy  (https://vk.com/id00v / https://vk.com/mrsasha082)
*/
class indexController extends Controller {
	private $limit = 20;
	public function index($page = 1) {
		$this->document->setActiveSection('admin/code');
		$this->document->setActiveItem('index');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->library('pagination');
		$this->load->model('codes');
		$this->load->model('games');
		$this->load->model('locations');
		
		$options = array(
			'start' => ($page - 1) * $this->limit,
			'limit' => $this->limit
		);
		
		$total = $this->codesModel->getTotalcode();
		$codes = $this->codesModel->getcode(array(), array(), $options);
		
		$paginationUrl = '/admin/code/index/index/{page}';
		$paginationLib = new paginationLibrary();
		$paginationLib->total = $total;
		$paginationLib->page = $page;
		$paginationLib->limit = $this->limit;
		$paginationLib->url = $paginationUrl;
		$pagination = $paginationLib->render();
		$games = $this->gamesModel->getGames(array('game_status' => 1));
		$locations = $this->locationsModel->getLocations(array('location_status' => 1));
		$this->data['games'] = $games;
		$this->data['locations'] = $locations;
		
		$this->data['codes'] = $codes;
		$this->data['pagination'] = $pagination;
		
		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/code/index', $this->data);
	}
	public function ajax2() {
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('codes');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST2();
			if(!$errorPOST) {
				$cod = @$this->request->post['code'];
                $uses = @$this->request->post['uses'];
				$days = @$this->request->post['days'];
				$gameid = @$this->request->post['gameid'];
				$slots = @$this->request->post['slots'];
				$locationid = @$this->request->post['locationid'];
				
				
				$locationData = array(
					'cod'		 	=> $cod,
					'uses'		 	   => $uses,
					'used'		 	   => 0,
					'money'		 	   => 0,
					'locationid' 	   => $locationid,
					'gameid' 		   => $gameid,
					'server_day' 	     	   => $days,
					'money_ili_server' => 2
				);
				
				$this->codesModel->createCode($locationData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали промо-Код!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	public function ajax() {
		if(!$this->user->isLogged()) {  
	  		$this->data['status'] = "error";
			$this->data['error'] = "Вы не авторизированы!";
			return json_encode($this->data);
		}
		if($this->user->getAccessLevel() < 3) {
			$this->data['status'] = "error";
			$this->data['error'] = "У вас нет доступа к данному разделу!";
			return json_encode($this->data);
		}
		
		$this->load->model('codes');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$cod = @$this->request->post['code'];
                $uses = @$this->request->post['uses'];
				$money = @$this->request->post['money'];
				
				
				$locationData = array(
					'cod'		 	=> $cod,
					'uses'		 	   => $uses,
					'used'		 	   => 0,
					'money'		 	   => $money,
					'locationid' 	   => 0,
					'gameid' 		   => 0,
					'server_day' 	     	   => 0,
					'money_ili_server' => 1,
					'slotiki' 	       => 0
				);
				
				$this->codesModel->createCode($locationData);
				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно создали промо-Код!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
				$cod = @$this->request->post['code'];
                $uses = @$this->request->post['uses'];
				$money = @$this->request->post['money'];
		
		if(mb_strlen($cod) < 2 || mb_strlen($cod) > 32) {
			$result = "Код должен содержать от 2 до 32 символов!";
		}
        elseif(mb_strlen($uses) < 1 || mb_strlen($uses) > 100000) {
            $result = "Введите количество использований от 1 до 100000!";
        }
        elseif(mb_strlen($money) < 1 || mb_strlen($money) > 1000000) {
            $result = "Введите количество рублей от 1 до 1000000!";
        }
		 
		return $result;
	}
	private function validatePOST2() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
				$cod = @$this->request->post['code'];
                $uses = @$this->request->post['uses'];
				$days = @$this->request->post['days'];
				$gameid = @$this->request->post['gameid'];
				$slots = @$this->request->post['slots'];
				$locationid = @$this->request->post['locationid'];
		
		if(mb_strlen($cod) < 2 || mb_strlen($cod) > 32) {
			$result = "Код должен содержать от 2 до 32 символов!";
		}
        elseif(mb_strlen($uses) < 1 || mb_strlen($uses) > 100000) {
            $result = "Введите количество использований от 1 до 100000!";
        }
        elseif(mb_strlen($days) < 1 || mb_strlen($days) > 999) {
            $result = "Введите количество дней от 1 до 999!";
        }
        elseif(mb_strlen($slots) < 1 || mb_strlen($slots) > 1000) {
            $result = "Введите количество рублей от 1 до 1000!";
        }
		 
		return $result;
	}
}
?>
