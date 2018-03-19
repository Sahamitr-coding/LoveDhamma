<?php
  require('connect.php');

  if(isset($_POST['submit'])){

    $err = array(
      "f_name" => "",
      "l_name" => "",
      "code_id" => "",
      "copy_file" => "",
      "username" => "",
      "password" => "",
      "confirm_password" => "",
      "birth_date" => "",
      "answer_1" => "",
      "answer_2" => "",
      "answer_3" => "",
      "e-email" => "",
    );

    $special_char = "* Special character is not allowed.";
    $please_insert_i = "* Please insert information.";
    $illegal_e = "#$%^&*()+=[]';,/{}|:<>?~ ";
    $illegal_no_need_num = "#$%^&*()+=[]';,./{}|:<>?~@ 0123456789๐๑๒๓๔๕๖๗๘๙";
    $illegal_password = "#$%^&*()+=[]';,./{}|:<>?~@ ";
    $illegal_answer = "#$%^&*()+=[]';,./{}|:<>?~@";

    //Check firstname and lastname in database.
    if(isset($_POST['name']) && isset($_POST['surname'])){
      $sql = 'SELECT id FROM user WHERE name = "$_POST[name]" AND surname = "$_POST[surname]"';
      $result = ($conn->query($sql))->fetch();

      //Check firstname and lastname in database.
      if($result){
        $err['f_name'] = "* This first name already exist.";
        $err['l_name'] = "* This last name already exist.";
      }else{

        //Firstname check
        if(isset($_POST['name']) && $_POST['name'] != null){
          if(strpbrk($_POST['name'], $illegal_no_need_num)){
            $err['f_name'] = $special_char;
          }else{
              $err['f_name'] = "";
          }
        }else{
          $err['f_name'] = $please_insert_i;
        }

        //Lastname check
        if(isset($_POST['surname']) && $_POST['surname'] != null){
          if(strpbrk($_POST['surname'], $illegal_no_need_num)){
            $err['l_name'] = $special_char;
          }else{
              $err['l_name'] ="";     
          }
        }else{
          $err['l_name'] = $please_insert_i;
        }
      }
    }else{
      $err['f_name'] = $please_insert_i;
      $err['l_name'] = $please_insert_i;
    }

    //National ID check and Passport ID
    if(isset($_POST['code-id'])){
      $sql = 'SELECT id FROM user WHERE national_id = "$_POST[code-id]"';
      $id_result = ($conn->query($sql))->fetch();

      if($id_result){
        $err['code_id'] = "* This national ID or passport ID already exist.";
      }else{  
        if(strlen($_POST['code-id']) == 13 || strlen($_POST['code-id']) == 9){
          if(strlen($_POST['code-id']) == 13){  //National ID
            for($j = 0, $sum = 0; $j < 12; $j++){
              $sum += (int)($_POST['code-id']{$j})*(13-$j);
              if((11 - ($sum % 11)) % 10 == (int)($_POST['code-id']{12})){
                $err['code_id'] = "";
              }else{
                $err['code_id'] = "* Invalid National ID or Passport ID format.";
              }
            }
          }else if(strlen($_POST['code-id']) == 9 && !preg_match('/[a-zA-Z]{2}[0-9]{7}/', $_POST['code-id'])){  //Passport ID
            $err['code_id'] = "";
          }
        }else{
          $err['code_id'] = "* Invalid National ID or Passport ID format.";
        }
      }
    }else{
      $err['code_id'] = $please_insert_i;
    }

    //File check
    if(isset($_FILES['file']) && $_FILES['file']['name'] != null){
      $file = $_FILES['file'];
      $filename = $file['name'];
      $explode = explode('.', $filename);
      if ($explode != null){
        $file_ext = strtolower(end($explode));
      }
      $file_name_new = "";

      $allowed = array('jpg', 'jpeg', 'png');
      if(in_array($file_ext, $allowed)){
        if($file['error'] === 0){
          if($file['size'] < 5000000){
            $newfilename = uniqid('', true).".".$file_ext;
            $file_name_new = $newfilename;
            $file_destination = 'uploads/'.$newfilename;
            $err['copy_file'] = "";
          }else{
            $err['copy_file'] = "* Too much file size.";
          }
        }else{
          $err['copy_file'] = "* Error occured.";
        }
      }else{
        $err['copy_file'] = "* File extension should be jpg, jpeg or png.";
      }
    }else{
      $err['copy_file'] = "* Please insert copy national id or passport id file.";
    }


    //Username check
    if(isset($_POST['username']) && $_POST['username'] != null){
      $sql = 'SELECT id FROM user WHERE username = "$_POST[username]"';
      $username_result = ($conn->query($sql))->fetch();

      if($username_result){
        $err['username'] = "* This username already exist.";
      }else{
        if(strpbrk($_POST['username'], $illegal_password)){
          $err['username'] = $special_char."except \"-\" or \"_\".";
        }else{
          $err['username'] = "";
        }
      }
    }else{
      $err['username'] = $please_insert_i;
    }

    //Password check
    if(isset($_POST['password']) && $_POST['password'] != null){
      if(strpbrk($_POST['password'], $illegal_password)){
        $err['password'] = $special_char."except \"-\" or \"_\".";
      }else if(strlen($_POST['password']) < 16){
        $err['password'] = "* Password length must more than 15 characters.";
      }else{
        $err['password'] ="";
      }
    }else{
      $err['password'] = $please_insert_i;
    }

    if(isset($_POST['password']) && isset($_POST['confirm-password']) && ($_POST['password'] !== $_POST['confirm-password'])){
      $err['confirm_password'] = "Password doesn't match!.";
    }else if($_POST['confirm-password'] == null){
      $err['confirm_password'] = $please_insert_i;
    }else{
      $err['confirm_password'] = "";
    }
  
    //Birth data check
    if(isset($_POST['birth-date']) && $_POST['birth-date'] != NULL){
      if(strpbrk($_POST['birth-date'], $illegal_e)){
        $err['birth_date'] = "You birth date maybe wrong.";
      }else{
        $date_now = strtotime("now");
        $date_user = strtotime($_POST['birth-date']);
        $date_should_less_or_equal_than = strtotime("-15 years", $date_now);

        if($date_user > $date_should_less_or_equal_than){
          $err['birth_date'] = "* You must be 15 years of age or older.";
        }else{
          $err['birth_date'] ="";
        }
      }
    }else{
      $err['birth_date'] = "* Please insert date.";
    }
    

    //Answer1 check
    if(isset($_POST['first-answer']) && $_POST['first-answer'] != null){
      if(strpbrk($_POST['first-answer'], $illegal_answer)){
        $err['answer_1'] = $special_char;
      }else{
        $err['answer_1'] = "";
      }
    }else{
      $err['answer_1'] = $please_insert_i;
    }

    //Answer2 check
    if(isset($_POST['second-answer']) && $_POST['second-answer'] != null){
      if(strpbrk($_POST['second-answer'], $illegal_answer)){
        $err['answer_2'] = $special_char;
      }else{
        $err['answer_2'] = "";
      }
    }else{
      $err['answer_2'] = $please_insert_i;
    }


    //Answer3 check
    if(isset($_POST['third-answer']) && $_POST['third-answer'] != null){
      if(strpbrk($_POST['third-answer'], $illegal_answer)){
        $err['answer_3'] = $special_char;
      }else{
        $err['answer_3'] ="";
      }
    }else{
      $err['answer_3'] = $please_insert_i;
    }

    //Email
    if(isset($_POST['email']) && $_POST['email'] != null){
      $sql = 'SELECT id FROM user WHERE email = "$_POST[email]"';
      $email_result = ($conn->query($sql))->fetch();

      if($email_result){
        $err['e-email'] = "* This email already exist.";
      }else{
        if(strpbrk($_POST['email'], $illegal_e)){
          $err['e-email'] = $special_char;
        }else{
          if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
              $err['e-email'] = "* Invalid email format."; 
          }else{
            $err['e-email'] ="";
          }
        }
      }
    }else{
      $err['e-email'] = $please_insert_i;
    }

    $i = 0;
    foreach ($err as $key => $value) {
      if($value != ""){
        $i++;
      }
    }

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $n_id = $_POST['code-id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $birth_date = $_POST['birth-date'];

    $first_q = $_POST['first-question'];
    $second_q = $_POST['second-question'];
    $third_q = $_POST['third-question'];

    $first_a = $_POST['first-answer'];
    $second_a = $_POST['second-answer'];
    $third_a = $_POST['third-answer'];

    $email = $_POST['email'];

    if(!$i){
      $to = $email;
      $subject = "Test send email";
      $message = "My Body & My Desctription";
      $header = "From: wasitthaphon@gmail.com"." \r\n".
                "Reply-To: wasitthaphon@gmail.com"." \r\n".
                "X-Mailer: PHP/".phpversion();
      $flag = @mail($to, $subject, $message, $header);

      //Dont forget to set flag!
      if(true){
        $sql_str = "INSERT INTO user VALUES (NULL, '$name', '$surname', '$n_id', '$file_name_new', '$username', '$password', '$birth_date', '$first_q', '$first_a', '$second_q', '$second_a', '$third_q', '$third_a', '$email', 0, 0)";
        $conn->exec($sql_str);
        move_uploaded_file($file['tmp_name'], $file_destination);
        header("Location: Successful.html");
      }
    }

  }else{      //No POST action occure.
    $err = array(
      "f_name" => "",
      "l_name" => "",
      "code_id" => "",
      "copy_file" => "",
      "username" => "",
      "password" => "",
      "confirm_password" =>"",
      "birth_date" => "",
      "answer_1" => "",
      "answer_2" => "",
      "answer_3" => "",
      "e-email" => "",
    );
  }
  //print_r($err);
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
            <div><a class="btn-link" href="#">Sign In</a></div>
            <div><a class="btn-link" href="register.php">Register</a></div>
        </spen>
      </div>
        
    </header>

     <nav id="mainnav">
      <div class="width">
          <ul>
              <li class="dropdown">
                  <button class="dropbtn2"><a href="index.php">Home</a></button>
                  <div class="dropdown-content">
                      <a href="news1.html">News and Announcement</a>

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


  <div class="register_container">
    <h3 style="text-align: center; margin-top: 2rem;">Registration</h3><br><br>

    <form id="register_form" class="font-Tri" method="post" enctype="multipart/form-data">

      <!-- First name -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="name" style="margin-top: 5px;">First name :</label>
          </div>
          <div class="col-9">
            <input type="text" class="form-control row" name="name" id="name" aria-describedby="name-help" autocomplete="off"  >
            <small id="name-help" class="form-text row" style="color: red;">
              <?php
                echo $err['f_name'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Last name -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="surname" style="margin-top: 5px;">Last name :</label>
          </div>
          <div class="col-9">
            <input type="text" class="form-control row" name="surname" id="surname" aria-describedby="surname-help" autocomplete="off">
           <small id="surname-help" class="form-text row" style="color: red;">
             <?php
              echo $err['l_name'];
             ?>
           </small>
         </div>
        </div>
      </div>

      <!-- passport-id or national-id -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="code-id" style="margin-top: 0px;">National ID or<br>passport ID :</label>
          </div>
          <div class="col-9">
            <input type="text" class="form-control row" name="code-id" id="code-id" aria-describedby="code-id-help" autocomplete="off">
            <small id="code-id-help" style="color: red;" class="form-text row">
              <?php
                echo $err['code_id'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Copy national-id or passport-id file -->
      <div class="form-group" style="margin-top: 10px; margin-left: 1.5rem">
        <div class="row">
          <label for="file-upload">Copy national ID or passport ID file :</label>
          <input type="file" name="file" class="form-control-file" id="file-upload" aria-describedby="upload-help"
          >
          <small id="upload-help" class="form-text" style="color: red;">
            <?php
              echo $err['copy_file'];
            ?>
          </small>
        </div>
      </div>


      <!-- username -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="username" style="margin-top: 5px;">Username :</label>
          </div>
          <div class="col-9">
            <input type="text" class="form-control row" name="username" id="username" aria-describedby="username-help" autocomplete="off" >
            <small id="username-help" class="form-text row" style="color: red;">
              <?php
                echo $err['username'];
              ?>
            </small>
          </div>
        </div>
      </div>


      <!-- password -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="password" style="margin-top: 5px;">Password :</label>
          </div>
          <div class="col-9">
            <input type="password" class="form-control row" name="password" id="password" aria-describedby="password-help" autocomplete="off" >
            <small id="password-help" class="form-text row" style="color: red;">
              <?php
                echo $err['password'];
              ?>
            </small>
          </div>
        </div>
      </div>

       <!-- Confirm password -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="confirm-password" style="margin-top: 5px;">Confirm password :</label>
          </div>
          <div class="col-9">
            <input type="password" class="form-control row" name="confirm-password" id="confirm-password" aria-describedby="confirm-password-help" autocomplete="off" >
            <small id="confirm-password-help" class="form-text row" style="color: red;">
              <?php
                echo $err['confirm_password'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- Birth date -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="birth-date" style="margin-top: 5px">Birth date :</label>
          </div>
          <div class="col-9">
            <input type="date" class="form-control row" name="birth-date" id="birth-date" aria-describedby="birth-date-help" placeholder="birth date" autocomplete="off" >
            <small id="birth-date-help" class="form-text row" style="color: red;">
              <?php
                echo $err['birth_date'];
              ?>
            </small>
          </div>
        </div>
      </div>

      <!-- First question -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="first-question">Please select one question</label>
          <select class="custom-select" id="first-question" name="first-question">

            <!-- insert question here -->
            <option selected value="1">What is the name of your pet?</option>
            <option value="2">What is the name of your pet?</option>
            <option value="3">What is your best friend’s name?</option>
            <option value="4">What is your favorite song?</option>
            <option value="5">What is your favorite singer?</option>
          </select>
        </div>

        <!-- First answer -->
        <div class="col-6">
          <label for="first-answer">Answer</label>
          <input type="text" class="form-control" name="first-answer" id="first-answer" autocomplete="off" >
        </div>
        <small id="first-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_1'];
          ?>
        </small>
      </div>

      <!-- Second question and answer -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="second-question">Please select one question</label>
          <select class="custom-select" id="second-question" name="second-question">

            <!-- insert question here -->
            <option selected value="6">What is your favorite movie?</option>
            <option value="7">What is your favorite super hero?</option>
            <option value="8">What is your dream career?</option>
            <option value="9">What is your hometown?</option>
            <option value="10">What is your high school’s name?</option>

          </select>
        </div>

        <!-- Second answer -->
        <div class="col-6">
          <label for="second-answer">Answer</label>
          <input type="text" class="form-control" name="second-answer" id="second-answer" autocomplete="off" >
        </div>
        <small id="second-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_2'];
          ?>
        </small>
      </div>

      <!-- Third question -->
      <div class="form-row form-group">
        <div class="col-6">
          <label for="third-question">Please select one question</label>
          <select class="custom-select" id="third-question" name="third-question">

            <!-- insert question here -->
            <option selected value="11">What is your favorite brand?</option>
            <option value="12">What is your favorite sport?</option>
            <option value="13">What is your favorite hobby?</option>
            <option value="14">What is your favorite season?</option>
            <option value="15">What is your favorite subject?</option>

          </select>
        </div>

        <!-- Third answer -->
        <div class="col-6">
          <label for="third-answer">Answer</label>
          <input type="text" class="form-control" name="third-answer" id="third-answer" autocomplete="off" >
        </div>
        <small id="third-question-answer-help" class="form-text" style="color: red;">
          <?php
            echo $err['answer_3'];
          ?>
        </small>
      </div>

      <!-- email -->
      <div class="form-group" style="margin-top: 20px;">
        <div class="row">
          <div class="col text-center">
            <label for="email" style="margin-top: 5px;">Email :</label>
          </div>
          <div class="col-9">
            <input type="email" class="form-control row" name="email" id="email" aria-describedby="email-help" autocomplete="off" >
            <small id="email-help" style="color: red;" class="form-text row" >
              <?php
                echo $err['e-email'];
              ?>
            </small>
          </div>
        </div>
      </div>



      <center>
        <!-- Agreement -->
        <input type="checkbox" name="accept-agreement" value="1" id="accept-agreement" required> I agree <a href="#openModal" style="text-decoration:"offne;">agreement.<a>
        <br><br>
        <button id="submit" class="btn btn-primary" name="submit">Register</button>
      </center>
    </form>
  </div>

  <div id="openModal" class="modalDialog">
    <div>
      <a href="#close" title="Close" class="close_modal">X</a>
      <h2>Agreement</h2>
         <p>Policy of Dharma initiative lovers</p>
          <p>&nbsp;&nbsp;&nbsp;This forum is established for people who interested in Dharma. Registration to this forum is free. We do insist that you abide by the rules and policy detailed below. I you agree to the terms, please check ‘I agree’ box below. If you would like to cancel the registration, click cancel to return to the forums index.</p>
      <ol>
        <li>Do not post any massage, content and news that against or allusion royal family, prophet and religion.</li>
        <li>Do not post any massage, content and news that are obscene, vulgar, sexually-oriented hateful, threating and otherwise violative of any law.</li>
        <li>Do not post any massage, content and news that are about marketing.</li>
        <li>You must be 15 years of age or older to register.</li>
        <li>You have to use your real information to register.</li>
        <li>Administrators can delete or edit your massage, content or news.</li>
        <li>Administration can deny or approve your request’s registration.</li>
      </ol>
    </div>
  </div>

  <footer id="footer" class="text-center" style="margin-top: 3rem;">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
    <div class="font-color1"> saharuthi_j@kkumail.com </div>
  </footer>
  <!-- Script -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="offnymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="offnymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>