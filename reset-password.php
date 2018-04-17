<?php
  require('connect.php');
  session_start();  
?>

<!DOCTYPE html>
<html>
<head>
  <title>ชุมชน คนชอบปฏิบัติธรรม</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="css/main.css" rel="stylesheet">
  <link href="css/bootstrap-grid.css" rel="stylesheet">
  <link href="css/bootstrap-reboot.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Pattaya" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="css/carousel.css" rel="stylesheet" type="text/css" >
  <link href="css/CSS_Reset.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">
</head>
<body class="Backg-body">

  <main role="main">
   <!-- แก้ไข -->
<header class="header_Bg body_reset">
			<div class="navbar-header width">
        <img class="img left" src="img/Logo1.png" alt="Logo1">
        <spen class="right">
            <?php 
            if(isset($_SESSION['user_data'])){
              $html_username_tag = "<div><a id=\"open_username\" class=\"btn-link\" href=\"profile.php\">สวัสดีคุณ ".$_SESSION['user_data']['username']."</a></div>";
              $html_sign_out = "<div><a id=\"sign_out\" class=\"btn-link\" href=\"index.php?sign_out\">Sign out</a></div>";

              echo $html_username_tag.$html_sign_out;

            }else{
              $html_sign_in = "<div><a id=\"open_the_modal\" class=\"btn-link\" href=\"#openModal_sign_in\">Sign in</a></div>";
              $html_register = "<div><a id=\"go_to_register_page\" class=\"btn-link\" href=\"register.php\">Register</a></div>";

              echo $html_sign_in.$html_register;
            }
          ?>
        </spen>
			</div>
				
		</header>

     <nav id="mainnav">
      <div class="width">
          <ul>
              <li class="dropdown">
                  <button class="dropbtn2"><a href="index.php">Home</a></button>
                  <div class="dropdown-content">
                      <a href="#">News and Announcement</a>

                  </div>

              </li>
              <li><a class="dropbtn2" href="#">Knowledge sources</a></li>
              <li><a class="dropbtn2" href="#">Events</a></li>
              <li><a class="dropbtn2" href="#">About us</a></li>
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
    <!-- end แก้ไข -->
   <div style="text-align: center;">
       <form>
           <br>
            <h1>Reset Password</h1>
            <hr>

            <div class="text-center">
              <span id="reset-password-description"></span>
            </div>

            <label for="psw"><b>New Password</b></label><br>
           <input id="password" class="input_reset" type="password" placeholder="Enter Password" name="psw" autocomplete="off" required><br>
            <label for="psw-repeat"><b>Confirm Password</b></label><br>
            <input id="confirm_Password" class="input_reset" type="password" placeholder="Confirm Password" name="psw-repeat" autocomplete="off" required> <br>
            <button id="ResetPassword" type="resetpassword" class="btn btn-secondary" >  Reset  </button><br><br>
        </form>
     </div>  

       <!-- Modal -->
<div id="openModal_sign_in" class="openModal_sign_in sign_in_modalDialog">
  <div>
    <a href="#sign_in_close" title="sign_in_close" class="sign_in_close">X</a>
    <h2>Sign in</h2>
    <div class="text-center">
      <span id="sign-in-description"></span>
    </div>
    <div id="text_left" class="sign_in_container">
      <label for="username-sign-in"><b>Username</b></label>
      <input type="text" autocomplete="off" name="username-sign-in" id="username-sign-in">
      <span id="username-description"></span>
      <br><br>
      <label for="password-sign-in"><b>Password</b></label>
      <input type="password" autocomplete="off" name="password-sign-in" id="password-sign-in">
      <span id="password-description"></span>
      <br>
      <a href="#" id="forget_password">Forget Password</a><br>
    </div>
    <body onLoad="ChangeCaptcha()">
    <center><input type="text" id="randomfield" disabled></center>
    <center>
      <script>
        function ChangeCaptcha() {
          var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
          var string_length = 6;
          var ChangeCaptcha = '';

          for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            ChangeCaptcha += chars.substring(rnum,rnum+1);
          }
          document.getElementById('randomfield').value = ChangeCaptcha;
        }
        function check() {
          var description = "* Please enter username and password correctly.";
          var username = $('#username-sign-in').val();
          var password = $('#password-sign-in').val();
          var captcha = $('#CaptchaEnter').val();
          if(document.getElementById('CaptchaEnter').value == document.getElementById('randomfield').value ) {
            document.getElementById('sign_in_button_click').click();
          }
          else {
            if(username != '' || password != '' || captcha != ''){
              $('#sign-in-description').text(description);
              document.getElementById('sign-in-description').style.color = "red";
              ChangeCaptcha();
            }
          }
        }
        </script>
    </center>
    <center><input id="CaptchaEnter" size="20" maxlength="6"><center><br>
    <center><span id="captcha-description"></span></center>
    <center><button id="captcha-confirm-button" class="sign_in_button" onclick="check()">SIGN IN</button></center>
    <div id="sign_in_button_click"></div>
  </div>
</div>  

    <footer id="footer" class="text-center">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม </span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>       
    </footer>
    <!-- Script -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
      /* When the user clicks on the button, 
      toggle between hiding and showing the dropdown content */
      function myFunction() {
          document.getElementById("myDropdown").classList.toggle("show");
      }

      // Close the dropdown if the user clicks outside of it
      window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

          var dropdowns = document.getElementsByClassName("dropdown-content");
          var i;
          for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      }

      $('#username-sign-in').on('click', function(e){
        e.preventDefault();
        $('#sign-in-description').text('');
        $('#username-sign-in').val('');
      });

      $('#password-sign-in').on('click', function(e){
        e.preventDefault();
        $('#sign-in-description').text('');
        $('#password-sign-in').val('');
      });

      $('#CaptchaEnter').on('click', function(e){
        e.preventDefault();
        $('#CaptchaEnter').val('');
        $('#captcha-description').text('');
      });


     $('#forget_password').on('click', function(e){
      e.preventDefault();
      var username = $('#username-sign-in').val();
      var password = $('#password-sign-in').val();
      var description = "* Please enter username and password correctly.";
      if(username != ''){
        $.ajax({
          url: 'login_check.php',
          data: {username:username, password:password, data_sending_type:"forget_pwd"},
          type: 'POST',
          success: function(value){
            console.log(value);
            if(value == 'invalid_password' || value == 'pass'){
              window.location.href = "Question.php?username=" + username;
            }else{
              $('#sign-in-description').text(description);
              document.getElementById('sign-in-description').style.color = "red";
              ChangeCaptcha();
            }
          }
        });
      }
    });

      $('#ResetPassword').on('click', function(e){
        e.preventDefault();
        var password = $('#password').val();
        var c_password = $('#confirm_Password').val();
        var pattern = /^[a-z A-Z 0-9 \- \_]+$/;
        var small_alphabet = /[a-z]/g;
        var capital_alphabet = /[A-Z]/g;
        var numeric = /[0-9]/g;
        //var password_special_character = /[\- \_]/g;

        document.getElementById('reset-password-description').style.color = "red";
        if(password != c_password){
          $('#reset-password-description').text("* Password and confirm password does not match.");

        }else if(password.length < 16 || c_password.length < 16){
          $('#reset-password-description').text("* Password length less than 16 characters.");
          
        }else if(!pattern.test(password) || !pattern.test(c_password)){
          $('#reset-password-description').text("* Special character is not allowed.");
        }else if(!password.match(small_alphabet) || !password.match(capital_alphabet) || !password.match(numeric)){
          $('#reset-password-description').text("* Invalid password format.");
        }else{
          $.ajax({
            url:'reset-password-check.php',
            data:{a_password:password ,a_c_password:c_password},
            type: 'POST',
            success: function(value){
              console.log("value :" + value);
              if(value.includes('passed')){
                window.location.href = "index.php#openModal_sign_in";
              }else{
                $('#reset-password-description').text('Can not send data to your email.');
              }
            }
          });
        }

      });

    </script>
  </main>
</body>
</html>