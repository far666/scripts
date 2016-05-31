<?php

	include_once("../config/config.php");
	include("../helper/email_helper.php");
	if ($disable_key = $_GET['key']) {
		$link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SELECT_DB);
		if ($link->connect_errno) {
			redirect("mysql connect fail ,erron :{$link->connect_errno}");
		}

		mysqli_set_charset($link,"utf8");

		$sql = "SELECT * FROM `wait_list` WHERE `disable_key` = '{$disable_key}' and `status` = '0' LIMIT 1";
		if ($result = $link->query($sql)) {
			if ($result->num_rows > 0 ) {
				$update = "UPDATE `wait_list` SET `status` = 1 WHERE `disable_key` = '{$disable_key}' and `status` = '0'";

				if ($result = $link->query($update)) {
					echo "您已成功取消追蹤!<br>";
				} else {
					echo "系統出錯! 請聯絡管理員!";
				}
			} else {
				echo "已經取消追蹤!<br>";
			}
		} else {
			echo "系統出錯! 請聯絡管理員!";
		}
	} else {
		echo "錯誤的追蹤碼!";
	}

	echo "<a href='http://" . WEB_HOST . "'>首頁</a>";
	exit;
