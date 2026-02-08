<?php
/*
@mrsasha082 для hostinpl.ru
*/

class aaioController extends Controller {
	public function index() {
		$this->load->model('users');
		$this->load->model('invoices');
		$this->load->model('waste');
		
		if($this->request->server['REQUEST_METHOD'] == 'POST') {
			$errorPOST = $this->validatePOST();
			if(!$errorPOST) {
				$ammount = $this->request->post['amount'];
				$invid = $this->request->post['order_id'];
				
				$invoice = $this->invoicesModel->getInvoiceById($invid);
				if($invoice['invoice_status'] == 0) {
					$userid = $invoice['user_id'];
					$user = $this->usersModel->getUserById($userid);
					
					if($ammount > 50){
						$this->usersModel->updateUser($userid, $userData = array('user_promised_pay' => 0));
					}

					$wasteData = array(
						'user_id'		=> $userid,
						'waste_ammount'	=> $ammount,
						'waste_status'	=> 0,
						'waste_usluga'	=> "Пополнение баланса пользователя",
					); 						
					$this->wasteModel->createWaste($wasteData);
					
					$this->usersModel->sendAdmInfo("[Пополнение счёта]\nID пользователя: $userid\nСумма: $ammount ₽\nПлатёжная система: Aaio");
		
					$this->usersModel->upUserBalance($userid, $ammount);
					
					$bonus_percent = $this->config->bonus_percent;
					$getbonus = ($ammount * (1 + $bonus_percent / 100)) - $ammount;
					$this->usersModel->upUserBonuses($userid, $getbonus);

					$this->invoicesModel->updateInvoice($invid, array('invoice_status' => 1, 'invoice_ammount' => $ammount));
					
					return "OK";
				} else {
					return "Уже оплачено";
				}
			} else {
				return "Error: $errorPOST";
			}
		} else {
			return "Error: Invalid request!";
		}
	}
	
	private function validatePOST() {
		$result = null;
		
		$invid = $this->request->post['order_id'];
		$sign = hash('sha256', implode(':', [$this->request->post['merchant_id'], $this->request->post['amount'], $this->request->post['currency'], $this->config->aaio_secret2, $invid]));
		
		if(!$this->invoicesModel->getTotalInvoices(array('invoice_id' => (int)$invid))) {
			$result = "Invalid invoice!";
		}
        elseif(!hash_equals($_POST['sign'], $sign)) {
			$result = "Invalid signature!";
		}
        elseif($this->request->post['currency'] != 'RUB') {
			$result = "Invalid currency!";
		}
		return $result;
	}
}
?>
