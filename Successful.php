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
        <!-- เพิ่ม --> <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">
</head>
<body class="Backg-body">

  <main role="main">
   <!-- แก้ไข -->
<header class="header_Bg">
      <div class="navbar-header width">
        <img class="img left" src="img/Logo1.png" alt="Logo1">
        <spen class="right">
            <?php 
              if(isset($_SESSION['user_data'])){
                $html_username_tag = "<div><a class=\"btn-link\" href=\"profile.php\">สวัสดีคุณ ".$_SESSION['user_data']['username']."</a></div>";
                $html_sign_out = "<div><a class=\"btn-link\" href=\"index_disable_captcha.php?sign_out\">Sign out</a></div>";

                echo $html_username_tag.$html_sign_out;

              }else{
                $html_sign_in = "<div><a class=\"btn-link\" href=\"#openModal_sign_in\">Sign in</a></div>";
                $html_register = "<div><a class=\"btn-link\" href=\"register_disable_captcha.php\">Register</a></div>";

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

    <div class="container">
      <div class="row text-center">
            <div class="col-sm-12 col-sm-offset-3">
            <br><br> <h1 style="color:#0fad00">Successful</h1>
            <img src="Img/Check.png" width="150" height="150">
            
            <p style="font-size:20px;color:#5C5C5C;">Thank you for your registration.<br> 
            Please verify your email and wait for approval adminstrator.</p>
      
        <br><br>
            </div>
            
      </div>
    </div>


    <!-- Modal -->
    <div id="openModal_sign_in" class="sign_in_modalDialog">
      <div>
        <a href="#sign_in_close" title="sign_in_close" class="sign_in_close">X</a>
        <h2>Login</h2>
        <div id="text_left" class="sign_in_container">
          <label for="username-sign-in"><b>Username</b></label>
          <input type="text" autocomplete="off" name="username-sign-in" id="username-sign-in">
          <span id="username-description"></span>
          <br><br>
          <label for="password-sign-in"><b>Password</b></label>
          <input type="password" autocomplete="off" name="password-sign-in" id="password-sign-in">
          <span id="password-description"></span>
          <br>
          <a href="#" id="text_right">Forgot Password</a><br>
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
              if(document.getElementById('CaptchaEnter').value == document.getElementById('randomfield').value ) {
                document.getElementById('sign_in_button_click').click();
              }
              else {
                $('#captcha-description').text('* Invalid captcha');
                document.getElementById('captcha-description').style.color = "red";
                ChangeCaptcha();
              }
            }
            </script>
        </center>
        <center><input id="CaptchaEnter" size="20" maxlength="6"><center><br>
        <center><span id="captcha-description"></span></center>
        <center><button  class="sign_in_button" onclick="check()">SIGN IN</button></center>
        <div id="sign_in_button_click"></div>
      </div>
    </div>

    <footer id="footer" class="text-center" style="margin-top: 3rem;">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
    <div class="font-color1"> saharuthi_j@kkumail.com </div>
  </footer>
  <!-- Script -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
  <script>
    $('#username-sign-in').on('click', function(e){
      e.preventDefault();
      $('#username-description').text('');
      $('#username-sign-in').val('');
    });

    $('#password-sign-in').on('click', function(e){
      e.preventDefault();
      $('#password-description').text('');
      $('#password-sign-in').val('');
    });

    $('#CaptchaEnter').on('click', function(e){
      e.preventDefault();
      $('#CaptchaEnter').val('');
      $('#captcha-description').text('');
    });

    $('#sign_in_button_click').on('click', function(e){

      e.preventDefault();
      var username = $('#username-sign-in').val();
      var password = $('#password-sign-in').val();
      

      var pattern = /^[a-z A-Z 0-9 \- \_ ก-ฮ ๐-๙ ฯะัาำิีึืุูเแโใไๅๆ็่้๊๋์]+$/;
      var password_pattern = /^[\#\$\%\^\&\*\(\)\+\=\[\]\'\;\,.\/\{\}\|\:\<\>\?\~\@]+$/;
      if(username == '' || password == ''){
        if(username == ''){
          $('#username-description').text('* Please insert username.');
          document.getElementById('username-description').style.color = "red";
        }

        if(password == ''){
          $('#password-description').text('* Please insert password.');
          document.getElementById('password-description').style.color = "red";
        }

        ChangeCaptcha();

      }else if(!pattern.test(username) || password_pattern.test(password)){
        if(!pattern.test(username)){
          $('#username-description').text('* Special character is not allowed.');
          document.getElementById('username-description').style.color = "red";
        }

        if(password_pattern.test(password)){
          $('#password-description').text('* Special character is not allowed.');
          document.getElementById('password-description').style.color = "red";
        }

        ChangeCaptcha();

      }else{
        $.ajax({
          url: 'login_check.php',
          data: {username:username, password:password},
          type: 'POST',
          success: function(value){
            if(value == 'false'){

              $('#password-description').text('* Invalid username and password.');
              document.getElementById('password-description').style.color = "red";

              ChangeCaptcha();

            }else if(value == 'invalid_password'){
              $('#password-description').text('* Invalid username or password.');
              document.getElementById('password-description').style.color = "red";

              ChangeCaptcha();

            }else if(value == 'pass'){
              window.location.href = "index.php";
            }
          }
        });
      }
    });
  </script>
</body>
</html>