<?php
	require('connect.php');
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql_get_user = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
	$get_user = ($conn->query($sql_get_user))->fetch();

	$sql_get_username = "SELECT username FROM user WHERE username = '$username'";
	$get_username = ($conn->query($sql_get_username))->fetch();


	if($get_user){
		$_SESSION['user_data'] = $get_user;
		echo "pass";
	}else if($get_username){
		echo "invalid_password";
	}else{
		echo "false";
	}
?>