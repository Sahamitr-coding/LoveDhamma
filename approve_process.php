<?php
	require('connect.php');
	session_start();
	if(isset($_POST['is_approve']) && isset($_POST['id'])){
		$id = $_POST['id'];
		$is_approve = $_POST['is_approve'];
		$sql_stmt = "SELECT * FROM user WHERE id=$id";
		$user_data = ($conn->query($sql_stmt))->fetch();
		if($is_approve == 1 && !$user_data['admin_confirm']){
			$sql_stmt = "UPDATE user SET admin_confirm=1 WHERE id=$id";
			$conn->exec($sql_stmt);
			$sql_stmt = "UPDATE notification SET status=1 WHERE from_code=1 AND from_item_id='$id'";
			$conn->exec($sql_stmt);
		}else if($is_approve == -1){
			$sql_stmt = "DELETE FROM user WHERE id=$id";
			$conn->exec($sql_stmt);
			$sql_stmt = "DELETE FROM notification WHERE from_code=1 AND from_item_id='$id'";
			$conn->exec($sql_stmt);
		}
	}else{
		header("Location: index.php");
	}

?>