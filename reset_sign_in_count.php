<?php
	require('connect.php');
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$sql_statement = "SELECT account_status FROM user WHERE username='$username'";
		$result = ($conn->query($sql_statement))->fetch();
		if(!$result['account_status']){
			$sql_statement = "UPDATE user SET sign_in_count=0 WHERE username='$username'";
			$conn->exec($sql_statement);
		}
		echo "pass";
	}else{
		header("Location: index.php");
	}

?>