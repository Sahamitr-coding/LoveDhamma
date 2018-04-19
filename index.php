<?php
  require('connect.php');
  session_start();  

  $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 10";
  $result = $conn->query($sql);
  $get_result = ($conn->query($sql))->fetchAll();
  
  if(isset($_GET['sign_out'])){
    session_unset();
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
        <spen class="right" id="link-list">
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
                  <button class="dropbtn"><a href="index.php">Home</a></button>
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
    <section id="main-slider" class="navbar-body no-margin">
    <div id="myCarousel" class=" carousel slide " data-ride="carousel">
        <ol class="carousel-indicators">
          <?php
              $i = 0;
              if($result->rowCount() == 0){
                echo "<li data-target=\"#myCarousel\" data-slide-to=\"0\"></li>";
              }
              while($i < 5 &&  $i < $result->rowCount()){
                if($i == 0)
                  echo "<li data-target=\"#myCarousel\" data-slide-to=\"".$i."\" class=\"active\"></li>";
                else
                  echo "<li data-target=\"#myCarousel\" data-slide-to=\"".$i."\"></li>";
                $i = $i + 1;
              }
          ?>
        </ol>
        <div class="carousel-inner font-Tri">
          <?php
            $num = $result->rowCount() >= 5? 5:$result->rowCount();
            if($num == 0){
              echo 
              "<div class=\"carousel-item active\" >".
                "<img src=\"data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\">".
                "<div class=\"container\">".
                "<div class=\"carousel-caption\">".
                  "<a href=\"#\" >".
                    "<h1>NULL!
                    </h1>
                    </a>
                  </div>
                </div>
              </div>";  
            }
            for ($i = 0; $i < $num; $i++){
              $sql_img = "SELECT name FROM pic WHERE id_news=".$get_result[$i]['id']." AND is_img_slider = 1";
              $img_result = ($conn->query($sql_img)->fetch());
              $active = "";
              if($i == 0){
                $active = "active";
              }
              echo 
              "<div class=\"carousel-item ". $active. " \" >".
                "<img src=\"news-img/". $get_result[$i]['id']."/" .$img_result['name']. "\">".
                "<div class=\"container\">".
                "<div class=\"carousel-caption\">".
                  "<a href=\"news_form.php?id=".$get_result[$i]['id']."\" target=\"_blank\">".
                    "<h1>".$get_result[$i]['title'].
                    "</h1>
                    </a>
                  </div>
                </div>
              </div>";  
            }
          ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" id="previous-slide" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" id="next-slide" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
           </div></section>
       <!-- End slider -->

       <section id="services" class="text-center">
       <div style="max-width: 90%; margin: 0px auto;" class="alert" role="alert">
        <div class="col-sm-6 alert d-block p-2 backg-news font-color1 border-white">
        <p class="font-color3 font-Tri" > <MARQUEE behavior=alternate direction=left scrollAmount=3 width="4%"><font face=Webdings >4</font></MARQUEE><b>News &amp; Announcement</b><MARQUEE behavior=alternate direction=right scrollAmount=3 width="4%"><font face=Webdings>3</font></MARQUEE> </p>
          <ul class="get-data font-Tri text-left no-bullet list_index" id="list-data">
            <?php
              foreach ($result as $news) {
                $string = $news['title'];
                if(strlen($string) > 170){
                  $stringCut = substr($string, 0, 170);
                  $string = $stringCut.'...';
                }
                $string = iconv("UTF-8", "UTF-8//IGNORE", $string);
                echo "<li><a id=\"".$news['id']."\" href=\"news_form.php?id=".$news['id']."\" target=\"_blank\" class=\"font-color4\">". $string."</a></li>";
              }
            ?>
          </ul>
            <div id="for-load-more" class="for_load_more text-right ">
              <a id="load-more" class="load_more font-Tri" style=" font-weight: 800; color: #441701;" data-id=<?php echo end($get_result)['id'];?>> more...</a>
            </div>         
      </div>
     </div>
    </section>

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
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>
    </footer>
    <!-- Script -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='js/alternative_function.js'></script>
  </main>
</body>
</html>