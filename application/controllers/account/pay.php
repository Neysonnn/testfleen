<?php
class payController extends Controller {
	public function index() {
		$this->document->setActiveSection('account');
		$this->document->setActiveItem('pay');
		
		if(!$this->user->isLogged()) {
			$this->session->data['error'] = "Вы не авторизированы!";
			$this->response->redirect($this->config->url . 'account/login');
		}
		if($this->user->getAccessLevel() < 0) {
			$this->session->data['error'] = "У вас нет доступа к данному разделу!";
			$this->response->redirect($this->config->url);
		}
		$this->load->model('users');
		$freekassa = $this->config->freekassa;
        $yandexkassa = $this->config->yandexkassa;
		$this->data['freekassa'] = $freekassa;
        $this->data['yandexkassa'] = $yandexkassa;
		$this->data['aaio'] = $this->config->aaio;
		$this->getChild(array('common/header', 'common/footer'));
		return $this->load->view('account/pay', $this->data);
	}
	
	public function aaio() {
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
    
    $this->load->model('invoices');

    if($this->request->server['REQUEST_METHOD'] == 'POST') {
        if($this->config->aaio == 1) {
            $errorPOST = $this->validatePOST();
            if(!$errorPOST) {
                $ammount = number_format(round(floatval($this->request->post['ammount']), 2, PHP_ROUND_HALF_DOWN), 2, '.', '');
                $userid = $this->user->getId();
                
                $invoiceData = array(
                    'user_id' => $userid,
                    'invoice_ammount' => $ammount,
                    'invoice_status' => 0,
                    'system' => "Aaio"
                );
                $invid = $this->invoicesModel->createInvoice($invoiceData);

                $desc = 'Invoice №' . $invid; // Описание платежа
                $sign = hash('sha256', implode(':', [$this->config->aaio_id, $ammount, 'RUB', $this->config->aaio_secret1, $invid]));

                $url = "https://aaio.so/merchant/pay";
                $url .= "?merchant_id=" . $this->config->aaio_id;
                $url .= "&order_id=" . $invid;
                $url .= "&amount=" . $ammount;
                $url .= "&currency=RUB";
                $url .= "&desc=" . $desc;
                $url .= "&email=" . $this->user->getEmail();
                $url .= "&sign=" . $sign;
                $url .= "&referal=hostinpl";
                
                $this->data['status'] = "success";
                $this->data['url'] = $url;
            } else {
                $this->data['status'] = "error";
                $this->data['error'] = $errorPOST;
            }
        } else {
            $this->data['status'] = "error";
            $this->data['error'] = "Данная платежная система отключена!";
        }
    }
    return json_encode($this->data);
    }
	
	public function freepay() {
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
		
		$this->load->model('invoices');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($this->config->freekassa == 1) {
				$errorPOST = $this->validatePOST();
				if(!$errorPOST) {
					$ammount = number_format(round(floatval($this->request->post['ammount']), 2, PHP_ROUND_HALF_DOWN), 2, '.', '');
					$ammount = $ammount + 0.01;
					
					$server = $this->config->fk_server;
					$login = $this->config->fk_login;
					$password1 = $this->config->fk_password1;
					
					$userid = $this->user->getId();
					
					$invoiceData = array(
						'user_id'			=> $userid,
						'invoice_ammount'	=> $ammount,
						'invoice_status'	=> 0,
						'system'	        => "Freekassa"
					);
					$invid = $this->invoicesModel->createInvoice($invoiceData);
					
					$signature = md5("$login:$ammount:$password1:RUB:$invid");
					
					$url = "$server";
					/* Параметры: */
					$url .= "?m=$login";
					$url .= "&oa=$ammount";
					$url .= "&o=$invid";
					$url .= "&s=$signature";
					$url .= "&currency=RUB";

					$this->data['status'] = "success";
					$this->data['url'] = $url;
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = $errorPOST;
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Данная платежная система отключена!";
			}
		}
		return json_encode($this->data);
	}
	
	public function yandexkassa() {
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
		
		$this->load->model('invoices');
		$userid = $this->user->getId();
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			if($this->config->yandexkassa == 1) {
				$errorPOST = $this->validatePOST();
				if(!$errorPOST) {
					$ammount = @$this->request->post['ammount'];
					
					$invoiceData = array(
						'user_id'			=> $userid,
						'invoice_ammount'	=> $ammount,
						'invoice_status'	=> 0,
						'system'	        => "Yoomoney"
					);
					$invid = $this->invoicesModel->createInvoice($invoiceData);
					
					$url = "https://yoomoney.ru/quickpay/confirm.xml";
					$url .= "?receiver=".$this->config->yk_login."";
					$url .= "&quickpay-form=shop";
					$url .= "&paymentType=PC";
					$url .= "&paymentType=AC";
					$url .= "&label=$invid";
					$url .= "&successURL=".$this->config->url."account/success";
					$url .= "&targets=Оплата счета ".$invid;
					$url .= "&sum=$ammount";
					
					$this->data['status'] = "success";
					$this->data['url'] = $url;
				} else {
					$this->data['status'] = "error";
					$this->data['error'] = $errorPOST;
				}
			} else {
				$this->data['status'] = "error";
				$this->data['error'] = "Данная платежная система отключена!";
			}
		}

		return json_encode($this->data);
	}
	
	private function validatePOST() {
	
		$this->load->library('validate');
		
		$validateLib = new validateLibrary();
		
		$result = null;
		
		$ammount = @$this->request->post['ammount'];
		if(!$validateLib->money($ammount)) {
			$result = "Укажите сумму пополнения в допустимом формате!";
		}
		elseif(10 > $ammount || $ammount > 5000) {
			$result = "Укажите сумму от 10 до 5000 рублей!";
		}
		return $result;
	}
}
?>
