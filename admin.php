<?php 
  require 'connect.php';
  session_start();

  if(isset($_SESSION['user_data'])){
    if($_SESSION['user_data']['permission']){
      $sql_statement = "SELECT * FROM notification WHERE status=0";
      $notification_item = ($conn->query($sql_statement))->fetchAll();
    }else{
      header("Location: index.php");
    }
  }else{
    header("Location: index.php");
  }

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
                $html_sign_out = "<div><a class=\"btn-link\" href=\"index.php?sign_out\">Sign out</a></div>";

                echo $html_username_tag.$html_sign_out;

              }else{
                $html_sign_in = "<div><a class=\"btn-link\" href=\"#openModal_sign_in\">Sign in</a></div>";
                $html_register = "<div><a class=\"btn-link\" href=\"register.php\">Register</a></div>";

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
                  <?php 
                    if(isset($_SESSION['user_data'])){
                      if($_SESSION['user_data']['permission']){
                        $str = "admin.php";
                      }else{
                        $str = "index.php";
                      }
                    }
                  ?>
                  <button class="dropbtn2"><a href="<?php echo $str;?>">Home</a></button>
              </li>
              <li><a class="dropbtn2" href="manage_user.php">Manage User</a></li>
              
          </ul>
          <div class="clear"></div>
        <div class="clear"></div>
      </div>
    </nav> 
    <!-- end แก้ไข -->

    <!-- Notification -->
    <div class="container">
      <div class="row text-center">
            <div class="col-sm-12 col-sm-offset-3">
              <br>
              <h1 style="color:#0fad00">NOTIFICATION</h1><hr>
                <?php
                  foreach ($notification_item as $item) {

                    $id = $item['from_item_id'];
                    if($item['from_code'] == 1){
                      $sql = "SELECT name, surname FROM user WHERE id='$id'";
                      $result_data = ($conn->query($sql))->fetch();
                      $str = "<h6 class=\"row text_left\">&nbsp;&nbsp;&nbsp;&nbsp".$result_data['name']." ".$result_data['surname']." just registered.</h6>";
                      
                    }else if($item['from_code'] == 2){
                      $sql = "SELECT name, surname FROM user WHERE id='$id'";
                      $result_data = ($conn->query($sql))->fetch();
                      $str = "<h6 class=\"row text_left\">&nbsp;&nbsp;&nbsp;&nbsp".$result_data['name']." ".$result_data['surname']." just reset password.</h6>";
                      
                    }else{
                      $str = "<h6 class=\"row text_left\">&nbsp;&nbsp;&nbsp;&nbsp NOT IN ANY CASES.</h6>";
                    }
                    echo $str;
                  }
                ?>
            </div>
      </div>
    </div>


    <!-- Modal -->
    <div id="openModal_sign_in" class="sign_in_modalDialog">
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
        <center><button  class="sign_in_button" onclick="check()">SIGN IN</button></center>
        <div id="sign_in_button_click"></div>
      </div>
    </div>

    <footer id="footer" class="text-center">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
    <div class="font-color1"> saharuthi_j@kkumail.com </div>
  </footer>
  <!-- Script -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src='js/alternative_function.js'></script>
</body>
</html>