<?php
include("config.php");
include("../libs/PHPMailer/PHPMailerAutoload.php"); //匯入PHPMailer類別       

class EmailHelper {
	static function send ($emails = array(), $subject = "", $body = "") {
		if (empty($emails) || empty($subject) || empty($body)) {
			return "empty parameter";
		}

		$mail= new PHPMailer(); //建立新物件        
		$mail->SMTPDebug = 2;
		$mail->IsSMTP(); //設定使用SMTP方式寄信        
		$mail->SMTPAuth = true; //設定SMTP需要驗證        
		$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
		$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
		$mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
		$mail->CharSet = "big5"; //設定郵件編碼        
		
		$mail->Username = EMAIL_USER_NAME; //設定驗證帳號        
		$mail->Password = EMAIL_PASSWORD; //設定驗證密碼        
		
		$mail->From = EMAIL_FROM; //設定寄件者信箱        
		$mail->FromName = EMAIL_FORM_NAME; //設定寄件者姓名        
		
		$mail->Subject = "=?UTF-8?B?".base64_encode($subject)."?="; //設定郵件標題        
		$mail->Body = $body; //設定郵件內容        
		$mail->IsHTML(true); //設定郵件內容為HTML
		
		foreach ($emails as $email) {
			//$mail->AddAddress("nrs666666@gmail.com", "far"); //設定收件者郵件及名稱        
			$mail->AddAddress($email); //設定收件者郵件及名稱        
		}
		
		if(!$mail->Send()) {        
			return "Mailer Error: " . $mail->ErrorInfo;        
		} else {        
			return "Message sent!";    
		}
	}
}
?>
