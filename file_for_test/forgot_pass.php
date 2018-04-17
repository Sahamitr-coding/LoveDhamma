<?php

	require("connect.php");

	if ($_GET['code']) {
		
		$get_username = $_GET['username'];
		$get_code = $_GET['code'];

		$sql = "SELECT * FROM user WHERE username='$get_username'";

		$row = ($conn->query($sql))->fetch();
		$db_code = $row['password'];
		$db_username = $row['username'];
		}
		if ($get_username == $db_username && $get_code == $db_code) {
			
			echo "

			<form action='pass_reset_commplete.php?code=$get_code' method='POST'>
				Enter a new password: <input type='password name='newpass'><br>
				Re=enter your password: <input type='password' name='newpass1'><p>
				<input type='hidden' name='username' value='$db_username'>
				<input type='submit' value='Update Password!'>

			</form>

			";
		}
	if (!$_GET['code']) {

			echo "

				<form action='forgot_pass.php' method='POST'>
					Enter your username: <input type='text' name='username'><p>
					Enter your email: <input type='text' name='email'><p>
					<input type='submit' value='Submit' name='submit'>
				</form>

			";

			if(isset($_POST['submit'])){
				$username = $_POST['username'];
				$email = $_POST['email'];

				$query = mysql_query("SELECT * FORM member WHERE username = '$username' ");
				$numrow = mysql_num_rows($query);

				if ($numrow!=0) {

					while ($row = mysql_fetch_assoc($query)) {

						$db_email = $row['email'];

					}
					if ($email == $db_email) {

						$code = rand(10000,1000000);

						//To
						$to = $db_email;
						$subject = "Password Reset";
						$body = "

							This is an automated email. Please DO NOT reply to this

							Click the link below or paste it into your browser

							http://10.51.100.169/Software_Engineer/Software_Engineer/reset-password.php?code=$code&username=$username

						";

						mysql_query("UPDATE member SET passreset='$code' WHERE username='$username'");

						mail($to, $subject, $body);
						echo "Check your email.";


					}else{

						echo "Email is incorrect.";

					}
				}else{

					echo "That username doesnt exist.";

				}


			}
    }

?>