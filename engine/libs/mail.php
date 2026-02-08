<?php
/*
 - https://github.com/PHPMailer/PHPMailer -
*/
class mailLibrary {
	protected $to;
	protected $from;
	protected $sender;
	protected $subject;
	protected $text;
	// -------- Конфиг SMTP --------
	protected $smtp_host = "smtp.mail.ru"; // SMTP Хост (рекомендуем от яндекса либо амазона)
	protected $smtp_user = "admin@fleen-host.ru"; // Логин SMTP пользователя (у яндекса это почтовый ящик)
	protected $smtp_pass = "X51YgZqvfBq886rbBU7w"; // Пароль SMTP пользователя
	protected $smtp_secure = "ssl"; // ssl / tls
	protected $smtp_port = 465; // По умолчанию 25 / 465 / 567	
	// -----------------------------
	
	public function setTo($to) {
		$this->to = $to;
	}
	
	public function setFrom($from) {
		$this->from = $from;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function send() {
		if (!$this->to) {
			exit("Ошибка: Не указан E-Mail получателя!");
		}
		
		if (!$this->from) {
			exit("Ошибка: Не указан E-Mail отправителя!");
		}
		
		if (!$this->sender) {
			exit("Ошибка: Не указано имя отправителя!");
		}
		
		if (!$this->subject) {
			exit("Ошибка: Не указана тема сообщения!");
		}
		
		if (!$this->text) {
			exit("Ошибка: Не указан текст сообщения!");
		}
		
		if (is_array($this->to)) {
			$this->to = implode(',', $this->to);
		}
		
		require_once ENGINE_DIR . 'libs/PHPMailer/PHPMailer.php';
		require_once ENGINE_DIR . 'libs/PHPMailer/SMTP.php';
		require_once ENGINE_DIR . 'libs/PHPMailer/Exception.php';
		$language_dir = ENGINE_DIR . 'libs/PHPMailer/language';
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->Host = $this->smtp_host;
			$mail->SMTPAuth = true;
			$mail->Username = $this->smtp_user;
			$mail->Password = $this->smtp_pass;
			$mail->SMTPSecure = $this->smtp_secure;
			$mail->Port = $this->smtp_port;
			$mail->setFrom($this->from, $this->sender);
			$mail->addAddress($this->to);
			$mail->addReplyTo($this->from, $this->sender);
			$mail->setLanguage('ru', $language_dir);
			$mail->isHTML(true);
			$mail->Subject = $this->subject;
			$mail->Body = $this->text;
			$mail->CharSet = 'UTF-8';
			$mail->Encoding = 'base64';
			$mail->send();

			if ($mail->ErrorInfo) {
				return $mail->ErrorInfo;
			}
		}
		catch (Exception $e) {
			return $mail->ErrorInfo;
		}
	}
}
?>
