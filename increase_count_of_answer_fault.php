<?php
	require('connect.php');

	if(isset($_POST['username'])){
		$username = $_POST['username'];

		$sql_statement = "SELECT * FROM user WHERE username='$username'";
		try{
			$user_data = ($conn->query($sql_statement))->fetch();
			$sign_in_count = $user_data["sign_in_count"];
			$sign_in_count += 1;
			if($sign_in_count > 3){
				$sql = "UPDATE user SET account_status=1 WHERE username='$username'";
				$conn->exec($sql);
				echo "locked";
			}else{
				$sql = "UPDATE user SET sign_in_count='$sign_in_count' WHERE username='$username'";
				$conn->exec($sql);
				echo "count_fault";
			}
		}catch(Exception $e){
			echo "Found exception: ".$e->getMessage();
		}

	}else{
		echo "go_index";
	}
	
?>