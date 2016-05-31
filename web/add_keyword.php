<?php

	include_once("../config/config.php");
	include("../helper/email_helper.php");
	$msg = "no post !";
	if ($_POST) {
		if (empty($_POST['email']) || empty($_POST['search_keyword'])) {
			redirect("no email or search_keyword");
		}

		$link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SELECT_DB);
		if ($link->connect_errno) {
			redirect("mysql connect fail ,erron :{$link->connect_errno}");
		}

		mysqli_set_charset($link,"utf8");

		$email = $_POST['email'];
		$keyword = $_POST['search_keyword'];
		$disable_key = uniqid();
		$sql_insert = "INSERT INTO wait_list (email, keyword, disable_key, status) VALUES('{$email}', '{$keyword}', '{$disable_key}', 0)";
		if ($link->query($sql_insert)) {
			$msg = "成功加入追蹤清單!!";
			$subject = "您已成功追蹤電影關鍵字 {$keyword} ";
			$body = " 感謝您已成功追蹤電影關鍵字 {$keyword} ! 如欲取消請到: ".WEB_HOST."/disable.php?key=".$disable_key;
			try {
				EmailHelper::send(array($email), $subject, $body);
			} catch (Exception $e) {
				print_r($e);
			}
		} else {
			$msg =  "失敗加入追蹤清單! 請在試一次或聯絡管理員!";
		}
	}

	redirect($msg);

	function redirect($msg = "")
	{
		echo "
		<script>
			alert('{$msg}');
			window.location = './index.php';
		</script>";
	}

