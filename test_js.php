<?php
	if(isset($_SESSION['get_user'])){
		print_r($_SESSION['get_user']);
	}

?>

<head>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

</head>
<body>

	<form>
		Username<input type="text" name="username" id="username">
		<br>Password<input type="text" name="password" id="password">
		<span class="show_text"></span>
		<button class="button">send</button>
	</form>

	<script>
		$(function(){
			$('.button').on('click', function(e){
				var username = $('#username').val();
				var password = $('#password').val();
				e.preventDefault();
				if(username != '' && password != ''){
					$.ajax({
						url: 'login_check.php',
						data: {username:username, password:password},
						type: 'POST',
						dataType: 'JSON',
						success: function(value){
							if(!value){
								$('.show_text').text("Valie: " + value);
							}else{
								$('.show_text').text(value['password']);
							}
						}
					});
				}
			});
		});

	</script>
</body>