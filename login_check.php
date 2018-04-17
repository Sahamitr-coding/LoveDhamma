<?php
	require('connect.php');
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$data_sending_type = $_POST['data_sending_type'];

	$sql_get_user = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
	$get_user = ($conn->query($sql_get_user))->fetch();

	$sql_get_username = "SELECT * FROM user WHERE username = '$username'";
	$get_username = ($conn->query($sql_get_username))->fetch();

	if($get_user && !$get_user['account_status']){
		$_SESSION['user_data'] = $get_user;
		$sql = "UPDATE user SET sign_in_count=0 WHERE username='$username'";
		$conn->exec($sql);
		echo "pass";


	}else if($get_username){
		if($data_sending_type == 'sign_in'){
			$count = $get_username['sign_in_count'];
			$count += 1;
			if($count > 3){
				$sql = "UPDATE user SET account_status=1 WHERE username='$username'";
				$conn->exec($sql);
			}else{
				$sql = "UPDATE user SET sign_in_count='$count' WHERE username='$username'";
				$conn->exec($sql);
			}
		}
		echo "invalid_password";
	}else{
		echo "false";
	}
?>