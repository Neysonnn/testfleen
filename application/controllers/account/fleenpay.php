<?php
class fleenpayController extends Controller {
	
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
		
		$this->load->model('invoices');

		if($this->request->server['REQUEST_METHOD'] == 'POST') {
				$errorPOST = $this->validatePOST();
				if(!$errorPOST) {
					$amount = @$this->request->post['ammount'];
					$method = @$this->request->post['method'];

					$login = $this->config->fleenpay_id;
					$password = $this->config->fleenpay_publickey;
					
					$userid = $this->user->getId();
					
					$invoiceData = array(
						'user_id'			=> $userid,
						'invoice_ammount'	=> $amount,
						'invoice_status'	=> 0,
						'system'	        => "fleenpay"
					);
					$invid = $this->invoicesModel->createInvoice($invoiceData);

					$data = [
						'shop_id' => $login,
						'transaction_id' => $invid,
						'amount' => $amount,
						'public_key' => $password,
						'method' => $method
					];

					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, "https://fleenpay.ru/api/pay");
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					$resp = json_decode(curl_exec($curl), true);
					curl_close($curl);

					if($resp['status'] == 'error'){
						$this->data['status'] = 'error';
						$this->data['error'] = $resp['error'];
						return json_encode($this->data);
					}

					$this->data['status'] = "success";
					$this->data['url'] = $resp['success']['url'];
					
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
		
		$amount = @$this->request->post['ammount'];
		if(!$validateLib->money($amount)) {
			$result = "Укажите сумму пополнения в допустимом формате!";
		}
		elseif(10 > $amount || $amount > 5000) {
			$result = "Укажите сумму от 10 до 5000 рублей!";
		}
		return $result;
	}
}
?>