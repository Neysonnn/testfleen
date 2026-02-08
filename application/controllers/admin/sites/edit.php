<?php
/* @mrsasha082 */
class editController extends Controller {
	public function index($sitesid = null) {
		$this->document->setActiveSection('admin/sites');
		$this->document->setActiveItem('edit');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('sites');
		
		$error = $this->validate($sitesid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/sites/index');
		}
		
		$sites = $this->sitesModel->getSitesById($sitesid);
		$this->data['sites'] = $sites;

		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/sites/edit', $this->data);
	}
	
	public function ajax($sitesid = null) {
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
		
		$this->load->model('sites');
		
		$error = $this->validate($sitesid);
		if($error) {
			$this->data['status'] = "error";
			$this->data['error'] = $error;
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$name = @$this->request->post['name'];
				$url = @$this->request->post['url'];
				$textx = @$this->request->post['textx'];
				$img = @$this->request->post['img'];
				$status = @$this->request->post['status'];
				$price = @$this->request->post['price'];

				$sitesData = array(
					'sites_name'			=> $name,
					'sites_url'			=> $url,
					'sites_status'		=> (int)$status,
					'sites_textx'		=> $textx,
					'sites_img'	     	=> $img,
					'sites_price'	    => $price
				);
				$this->sitesModel->updateSites($sitesid, $sitesData);				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали сайт!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($sitesid = null) {
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('sites');
		
		$error = $this->validate($sitesid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/sites/index');
		}
		
		$this->sitesModel->deleteSites($sitesid);
		
		$this->session->data['success'] = "Вы успешно удалили сайт!";
		$this->response->redirect($this->config->url . 'admin/sites/index');
		return null;
	}
	
	private function validate($sitesid) {
		$result = null;
		
		if(!$this->sitesModel->getTotalSites(array('sites_id' => (int)$sitesid))) {
			$result = "Запрашиваемый сайт не существует!";
		}
		return $result;
	}
	
	private function validatePOST() {
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$name = @$this->request->post['name'];
		$status = @$this->request->post['status'];
		$textx = @$this->request->post['textx'];
		$price = @$this->request->post['price'];
		
		if(mb_strlen($name) < 2 || mb_strlen($name) > 32) {
			$result = "Название сайта должно содержать от 2 до 32 символов!";
		}
		elseif(mb_strlen($textx) < 2 || mb_strlen($textx) > 500) {
			$result = "Описание должно содержать от 2 до 500 символов!";
		}
		elseif($status < 0 || $status > 1) {
			$result = "Укажите допустимый статус!";
		}
		elseif(0 > $price || $price > 5000) {
			$result = "Укажите сумму от 0 до 5000 рублей!";
		}
		return $result;
	}
}
?>
