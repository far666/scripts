<?php
	include_once("../config/config.php");
	include_once("../helper/email_helper.php");

	$link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SELECT_DB);
	if ($link->connect_errno) {
		echo "connection fail";
		exit;
	}

	mysqli_set_charset($link,"utf8");

	$sql_keyword = "SELECT * FROM wait_list WHERE status = 0";
	if (!$result = $link->query($sql_keyword)) {
		echo "query fail\n";
		exit;
	}
	
	echo date("Y-m-d H:i:s")."\n";
	while ($row = $result->fetch_assoc()) {
		$sql_movie = "SELECT * FROM eyny_movie WHERE name LIKE '%".$row['keyword']."%' ORDER BY id DESC LIMIT 10";
		if (!$movies = $link->query($sql_movie)) {
			continue;
		}

		$wait_list_id = $row['id'];
		$email = $row['email'];
		while ($movie = $movies->fetch_assoc()) {
			$eyny_movie_id = $movie['id'];
			$sql_record = "SELECT 1 FROM `sent_record` WHERE `eyny_movie_id` = {$eyny_movie_id} and `wait_list_id` = {$wait_list_id} LIMIT 1";

			$record_status = $link->query($sql_record);
			if ($record_status->num_rows > 0) {
				continue;
			}

			$disable_link = "http://" . WEB_HOST . "/welcome/disable_keyword/" . $row['disable_key'];
			$body = " go download link :{$movie['url']}'\n";
			$body .= " if you want to disable this keyword({$row['keyword']}), go disabled link:{$disable_link}";

			//sent email and insert recore
			$email_result = send_email($email, $movie['name'], $body);
			print_r($email_result);
			$insert_result = insert_record($eyny_movie_id, $wait_list_id);
			print_r($insert_result);
		}
	}
	echo "done\n";
	exit;

	function send_email($email = "", $name = "", $body = "") {
		if ($email == "" || $name == "" || $body == "") {
			return false;
		}

		$emails = array($email);
		$subject = "Movie {$name} is fuond!!";

		$result = EmailHelper::send($emails,$subject,$body);
		return $result;
	}

	function insert_record($eyny_movie_id = 0, $wait_list_id = 0) {
		if ($eyny_movie_id == 0 || $wait_list_id == 0) {
			return false;
		}

		$created_at = time();
		$link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_SELECT_DB);
		mysqli_set_charset($link,"utf8");

		$sql = "INSERT INTO sent_record (eyny_movie_id, wait_list_id, status, created_at) VALUES ({$eyny_movie_id}, {$wait_list_id}, 1, {$created_at})";
		if (!$result = $link->query($sql)) {
			echo "sent record query fail";
			exit;
		}
		return $result;
	}
