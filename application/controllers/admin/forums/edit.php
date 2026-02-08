<?php
/* @mrsasha082 */
class editController extends Controller {
	public function index($forumsid = null) {
		$this->document->setActiveSection('admin/forums');
		$this->document->setActiveItem('edit');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('forums');
		
		$error = $this->validate($forumsid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/forums/index');
		}
		
		$forums = $this->forumsModel->getForumsById($forumsid);
		$this->data['forums'] = $forums;

		$this->getChild(array('common/admheader', 'common/footer'));
		return $this->load->view('admin/forums/edit', $this->data);
	}
	
	public function ajax($forumsid = null) {
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
		
		$this->load->model('forums');
		
		$error = $this->validate($forumsid);
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

				$forumsData = array(
					'forums_name'		=> $name,
					'forums_url'		=> $url,
					'forums_status'		=> (int)$status,
					'forums_textx'		=> $textx,
					'forums_img'	  	=> $img,
					'forums_price'	    => $price
				);
				$this->forumsModel->updateForums($forumsid, $forumsData);				
				$this->data['status'] = "success";
				$this->data['success'] = "Вы успешно отредактировали стиль для форума!";
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = $errorPOST;
			}
		}

		return json_encode($this->data);
	}
	
	public function delete($forumsid = null) {
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 3) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		$this->load->model('forums');
		
		$error = $this->validate($forumsid);
		if($error) {
			$this->session->data['error'] = $error;
			$this->response->redirect($this->config->url . 'admin/forums/index');
		}
		
		$this->forumsModel->deleteForums($forumsid);
		
		$this->session->data['success'] = "Вы успешно удалили стиль для форума!";
		$this->response->redirect($this->config->url . 'admin/forums/index');
		return null;
	}
	
	private function validate($forumsid) {
		$result = null;
		
		if(!$this->forumsModel->getTotalForums(array('forums_id' => (int)$forumsid))) {
			$result = "Запрашиваемый стиль для форума не существует!";
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
			$result = "Название стиля для форума должно содержать от 2 до 32 символов!";
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
