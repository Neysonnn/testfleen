<?php
/*
made vk.com/gtmayo69 
tg: @crontabone
thanks for the help @mrsasha_082
*/
class indexController extends Controller {

	public function theme($action = null) {
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
		switch($action) 
		{		
			case "one": 
			{
				if($this->user->getThemeId() == 1) {
					$this->db->query("UPDATE `users` SET `themeid` = '2' WHERE `user_id` = '{$this->user->getId()}'");
							$this->data["status"] = "success";
							$this->data["success"] = "Тема White Io установлена!";
				}
				if($this->user->getThemeId() == 2) {
					$this->db->query("UPDATE `users` SET `themeid` = '1' WHERE `user_id` = '{$this->user->getId()}'");
							$this->data["status"] = "success";
							$this->data["success"] = "Тема Dark Io установлена!";
				
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
