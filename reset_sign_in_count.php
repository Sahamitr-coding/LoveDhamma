<?php
	require('connect.php');
	if(isset($_POST['username'])){
		$username = $_POST['username'];
		$sql_statement = "SELECT account_status FROM user WHERE username='$username'";
		$result = ($conn->query($sql_statement))->fetch();
		if(!$result[0])
			$sql_statement = "UPDATE user SET sign_in_count=0 WHERE username='$username'";
			$conn->exec($sql_statement);
		}
	}else{
		header("Location: index.php");
	}

?>