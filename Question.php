<?php
  require('connect.php');
  session_start();
  $questions = array(
    "What is the name of your pet?",
    "What is your favorite color?",
    "What is your best friend’s name?",
    "What is your favorite song?",
    "What is your favorite singer?",
    "What is your favorite movie?",
    "What is your favorite super hero?",
    "What is your dream career?",
    "What is your hometown?",
    "What is your high school’s name?",
    "What is your favorite brand?",
    "What is your favorite sport?",
    "What is your favorite hobby?",
    "What is your favorite season?",
    "What is your favorite subject?",
  );

  $username = $_GET['username'];
  $sql = "SELECT question_1_id, question_2_id, question_3_id, answer_1, answer_2 ,answer_3 FROM user WHERE username='$username'";

  try{
    $data_result = ($conn->query($sql))->fetch();
    if($data_result){
      $_SESSION['username-reset-password'] = $username;
    }
  }catch(Exception $e){
    print_r($e);
  }
?>

<!DOCTYPE html>
<html>
<body>
 <title>ชุมชน คนชอบปฏิบัติธรรม</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="css/main.css" rel="stylesheet">
  <link href="css/bootstrap-grid.css" rel="stylesheet">
  <link href="css/bootstrap-reboot.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Pattaya" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css" type="text/css" />
  <link rel="stylesheet" href="css/forget.css" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link href="css/carousel.css" rel="stylesheet" type="text/css" >
  <link href="https://fonts.googleapis.com/css?family=Maitree|Trirong" rel="stylesheet">  
  <link href="css/forget.css" rel="stylesheet" type="text/css" >
  <link href="css/CSS_Reset.css" rel="stylesheet">
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
      
<!-- เริ่มตรงนี้ อยากให้มันกึ่งกลาง  คำถามที่ 1-3 -->  
<form id="QuestionForm">
    <br>
      <h1>Forget Password</h1>
    <hr>

      <div class="text-center">
        <span id="question-description"></span>
      </div>

      <label id="question1" for="Question1"><b>
        <?php
          echo $questions[$data_result['question_1_id']-1];
        ?>
      </b></label><br>
      <input id="answer1" type="text" placeholder="Answer Question1" name="Question1" class="input_reset" required><br>
      <label id="question2" for="Question2"><b>
        <?php
          echo $questions[$data_result['question_2_id']-1];
        ?>
      </b></label><br>
      <input id="answer2" type="text" placeholder="Answer Question2" name="Question2" class="input_reset" required><br>
      <label id="question3" for="Question3"><b>
        <?php
          echo $questions[$data_result['question_3_id']-1];
        ?>
      </b></label><br>
      <input id="answer3" type="text" placeholder="Answer Question3" name="Question3" class="input_reset" required><br>
      
      <div class="clearfix">  <br>
          <button id="questionSubmit" type="Submit" class="btn btn-secondary">Submit</button>
          
      </div>
  </form>
</div>
    <!-- end qustion -->  
    

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
    
    
  <footer id="footer" class="text-center" style="margin-top: 3rem;">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน ธ.นำธรรมดี </span> </div>
    <div class="font-color1"> saharuthi_j@kkumail.com </div>
  </footer>
  <!-- Script -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
  <script src='js/alternative_function.js'></script>
  <script>
    $('#questionSubmit').on('click', function(e){
      e.preventDefault();
      var description = "* Please enter answer correctly.";
      var answer_1 = $('#answer1').val();
      var answer_2 = $('#answer2').val();
      var answer_3 = $('#answer3').val();
      var username = "<?php echo $username; ?>";
      var answer_1_from_db = "<?php echo $data_result['answer_1']; ?>";
      var answer_2_from_db = "<?php echo $data_result['answer_2']; ?>";
      var answer_3_from_db = "<?php echo $data_result['answer_3']; ?>";
      
      if(answer_1 == answer_1_from_db && answer_2 == answer_2_from_db
        && answer_3 == answer_3_from_db){
        $.ajax({
          url: 'reset_sign_in_count.php',
          data: {username:username},
          type: 'POST',
          success: function(value){
            console.log("Value : " + value);
            window.location.href = 'reset-password.php';
          }
        });
      }else{
        document.getElementById('question-description').style.color = "red";
        $.ajax({
          url: 'increase_count_of_answer_fault.php',
          data: {username:username},
          type: 'POST',
          success: function(value){
            if(value == 'locked'){
              $('#question-description').text("your username has locked. Please contact admin.");
            }else if(value == 'count_fault'){
              $('#question-description').text(description);  
            }else if(value == 'go_index'){
              window.location.href = 'index.php';
            }else if(value.includes('Found exception')){
              $('#question-description').text(value);
            }
          }
        });
      }
    });
  </script>
</body>
</html>
