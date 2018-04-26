<?php
	require('connect.php');
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];
	$data_sending_type = $_POST['data_sending_type'];
	if($data_sending_type == "sign_in"){
		$sql_get_user = "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND admin_confirm=1";
		$get_user = ($conn->query($sql_get_user))->fetch();

		$sql_get_username = "SELECT * FROM user WHERE username = '$username' AND admin_confirm=1";
		$get_username = ($conn->query($sql_get_username))->fetch();

		if($get_user && !$get_user['account_status']){
			$_SESSION['user_data'] = $get_user;
			$sql = "UPDATE user SET sign_in_count=0 WHERE username='$username'";
			$conn->exec($sql);
			if($get_user['permission'] == 0){
				echo "pass";
			}else if($get_user['permission'] == 1){
				echo "pass_admin";
			}


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
		}else if($get_username['account_status']){
			echo "locked";
		}else{
			echo "false";
		}
	}else if($data_sending_type == "forget_pwd"){
		$sql_stmt = "SELECT * FROM user WHERE username='$username' AND admin_confirm=1";
		$user_data_forget_password = ($conn->query($sql_stmt))->fetch();
		if($user_data_forget_password){
			$_SESSION['user_data_forget_password'] = $user_data_forget_password;
			echo "forget_password_pass";
		}else{
			echo "false";
		}
	}
?>