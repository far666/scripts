<?php
	include("email_helper.php");
	
	$emails = array("");
	$subject = "test email";
	$body = "new movie!~";
	
	$result = EmailHelper::send($emails,$subject,$body);
	var_dump($result);
	echo "done";
	exit;
