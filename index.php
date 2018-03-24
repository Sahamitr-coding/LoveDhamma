<?php
  require('connect.php');
  session_start();  

  $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 10";
  $result = $conn->query($sql);
  $get_result = ($conn->query($sql))->fetchAll();
  

  /*$sql_get_username = "SELECT * FROM user WHERE id = 7";
  $get_username = ($conn->query($sql_get_username))->fetch();
  if($result){
    $_SESSION['username'] = $get_username['username'];
  }*/

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
        <spen class="right">
            <!--<div> <a href="#" class="btn-link" id="sign_in_modal" data-target="#sign_in_modal_show" data-toggle="modal">Sign In</a>-->
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
            <!--</div>
            <div><a class="btn-link" href="register.php">Register</a></div>-->
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
                 /*$timestamp = strtotime($news['date']);
                  $catdate = "&nbsp;&nbsp;&nbsp;&nbsp;".date('d', $timestamp)."-".date('m',$timestamp)."-".(int)(date('Y', $timestamp) + 543);
                  $string .= $catdate;*/
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


  <!-- OLD
   <div class="modal fade" id="sign_in_modal_show" tabindex="-1" role="dialog" aria-labelledby="sign_in_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="margin-right: 15px;">&times;</span></button>
        <h5 id="sign_in_title" class="modal-title text-center" id="sign_in_label">Sign in</h5>

        <div class="text-center" style="margin: 20px 0;">
          <div>Username</div>
          <div><input type="text" id="username" name="username"></div>
          <div>Password</div>
          <div><input type="text" id="password" name="password"></div>
          <div><a href="#">Forget password</a></div>
        </div>
        <div class="text-center" style="margin: 20px 0;">
        NotUSE<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="sign_in_button" class="btn btn-primary">Sign in</button>
        </div>
      </div>
    </div>
  </div>-->
    <footer id="footer" class="text-center">
     <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
     <div class="font-color1"> saharuthi_j@kkumail.com </div>
    </footer>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>-->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script>

    $(function(){
      $("body").on('click', '.load_more', function(){
        var lastid = $(this).attr('data-id');
        var current = $(this);
        //console.log(lastid);
        
        $.post("page.php",{lastId:lastid}, function(data){
            current.closest("li").remove();

            str = data.split("<li>");
            for(var i = 1; i < str.length - 1; i++){
              str[i] = '<li>'+str[i];
              $(".get-data").append(str[i]);
            }
            
            if(str[str.length - 1] > 1){
              $('.load_more').attr('data-id', parseInt(str[str.length-1]));
            }else{
              $('.load_more').remove();
            }
        });
      });
    });

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
  </main>
</body>
</html>