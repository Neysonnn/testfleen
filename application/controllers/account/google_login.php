<?php
class google_loginController extends Controller {
	public function index() {
		if(isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		
		if(isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		}
		
		if(isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 1) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		
		if($this->user->getGoogle_auth() == 1) {
			if($this->user->getGoogle_auth_check() == 1) {  
				$this->session->data['error'] = "Вы уже прошли активацию сессии!";
				$this->response->redirect($this->config->url);
			}
		} else {
			$this->session->data['error'] = "У вас не привязан Google Authenticator!";
			$this->response->redirect($this->config->url);
		}

		$this->data['title'] = $this->config->title;
		$this->data['description'] = $this->config->description;
		$this->data['keywords'] = $this->config->keywords;
		$this->data['logo'] = $this->config->logo;
		$this->data['public'] = $this->config->public;
		$this->data['count'] = $this->config->count;
		$this->data['vk_stat'] = $this->config->vk_stat;
		$this->data['recaptcha'] = $this->config->recaptcha;
		$this->data['vk_app_id'] = $this->config->vk_app_id;
		$this->data['url'] = $this->config->url;
		$this->data['user_email'] = $this->user->getEmail();

		return $this->load->view('account/google_login', $this->data);
	}
	
	public function ajax() {
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

		if($this->user->getGoogle_auth() == 1) {
			if($this->user->getGoogle_auth_check() == 1) {  
				$this->data['status'] = "error";
				$this->data['error'] = "Вы уже прошли активацию сесcии!";
				return json_encode($this->data);
			}
		} else {
	  		$this->data['status'] = "error";
			$this->data['error'] = "У вас не привязан Google Authenticator!";
			return json_encode($this->data);
		}
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->load->model('users');
			$userid = $this->user->getId();
			$user = $this->usersModel->getUserById($userid);
			require_once(ENGINE_DIR . 'libs/GoogleAuthenticator/GoogleAuthenticator.php');
			$ga = new GoogleAuthenticator;
			$code = $ga->getCode($user['user_google_auth_key']);
			if(@$this->request->post['google_auth_code'] != $code) {
				$this->data['status'] = "error";
				$this->data['error'] = "Вы указали неверный код из приложения Google Authenticator!";
				return json_encode($this->data);
			}
			$this->usersModel->updateAuth(array('google_auth_check'	=> 1));
			$this->data['status'] = "success";
			$this->data['success'] = "Вы успешно разблокировали сессию!";	
		}
		return json_encode($this->data);
	}
}
?>