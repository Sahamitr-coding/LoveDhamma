<?php
  require_once('connect.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
  require 'PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require 'PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
  date_default_timezone_set('Asia/Bangkok');

  if(isset($_POST['submit'])){

    $err = array(
      "name" => "",
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
      "register_e" => "",
    );

    $special_char_space_fault = "* Special character and space is not allowed.";
    $special_character_description = "* Special character is not allowed.";
    $blank_description = "* Please insert information.";
  
    $username_character = '/^[a-z A-Z 0-9 \- \_ ก-ฮ ๐-๙ ฯะัาำิีึืุูเแโใไๅๆ็่้๊๋์์]+$/';

    $name_character = '/^[a-zA-Zก-ฮฯะัาำิีึืุูเแโใไๅๆ็่้๊๋์์]+$/';
    $thai_alphabet = "กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรลวศษสหฬอฮะัาํิ'ฤฦ่้๊๋์ุูเโใไ็";
    $english_alpabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $small_alphabet = '/[a-z]+/';
    $capital_alphabet = '/[A-Z]+/';
    $numeric = '/[0-9]+/';
    //$password_special_character = '/[\- \_]+/';

    $special_character_except_space = "#$%^&*()+=[]';,./{}|:<>?~@";
    $special_character_for_email = "#$%^&*()+=[]';,/{}|:<>?~";
    $special_character_underscore_dash_except_space = "#$%^&*()+=[]';,./{}|:<>?~@-_";
    $thai_digit = "๐๑๒๓๔๕๖๗๘๙";
    //Check firstname and lastname in database.
    if(isset($_POST['name'])){
      $sql_name = $_POST['name'];

      $sql_name = explode(" ", $sql_name);
      if(count($sql_name) == 3){
        $f_name = $sql_name[0];
        $l_name = $sql_name[1]." ".$sql_name[2];
      }else if(count($sql_name) == 2){
        $f_name = $sql_name[0];
        $l_name = $sql_name[1];
      }else if(count($sql_name) == 4){
        $f_name = $sql_name[0];
        $l_name = $sql_name[1]." ".$sql_name[2]." ".$sql_name[3];
      }else{
        $f_name = "";
        $l_name = "";
      }

      $sql = "SELECT * FROM user WHERE name = '$f_name' AND surname = '$l_name'";
      try{
        $result = ($conn->query($sql))->fetch();
        //Check firstname and lastname in database.

        if($result != null){
          $err['name'] = "* This name already exist.";
        }else{
    
          //New name
          if(isset($_POST['name']) && $_POST['name'] != null){

            //Check if has numeric
            //print_r("DIGIT ". preg_match($digit, $_POST['name']));
            $str_name_check = $_POST['name'];
            $str_name_check = explode(" ", $str_name_check);

            //Special char
            $has_special_char = 0;
            for($i = 0; $i < mb_strlen($special_character_underscore_dash_except_space); $i++){
              $char = mb_substr($special_character_underscore_dash_except_space, $i, 1);
              if(mb_strpos($_POST['name'], $char)){
                $has_special_char = 1;
                break;
              }
            }
            //Thai number
            $has_thai_digit = 0;
            for($i = 0; $i < mb_strlen($thai_digit); $i++){
              $char = mb_substr($thai_digit, $i, 1);
              if(mb_strpos($_POST['name'], $char)){
                $has_thai_digit = 1;
                break;
              }
            }

            //Thai alphabet
            $has_thai_alphabet = 0;
            for($i = 0; $i < mb_strlen($thai_alphabet); $i++){
              $char = mb_substr($thai_alphabet, $i, 1);
              if(mb_strpos($_POST['name'], $char)){
                $has_thai_alphabet = 1;
                break;
              }
            }

            //English alphabet
            $has_english_alphabet = 0;
            for($i = 0; $i < mb_strlen($english_alpabet); $i++){
              $char = mb_substr($english_alpabet, $i, 1);
              if(mb_strpos($_POST['name'], $char)){
                $has_english_alphabet = 1;
                break;
              }
            }

            //Blank check
            $has_blank = 0;
            if(mb_strpos($_POST['name'], "  ")){
              $has_blank = 1;
            }

            if($has_special_char){
              $err['name'] = $special_character_description;
            }else if($has_thai_digit || preg_match($numeric, $_POST['name']) || ($has_thai_alphabet && $has_english_alphabet) || $has_blank){

              $err['name'] = "* Invalid input format.";
            }//True
            else{
              $err['name'] = "";
            }
          }//Has no input
          else{
            //print_r("NOINPUT : ");
            $err['name'] = $blank_description;
          }
        }
      }catch(Exception $e){
        print_r($e);
      } 
    }else{
      $err['name'] = $blank_description;
    }

    //National ID check and Passport ID
    if(isset($_POST['code-id'])){
      $sql_code_id = $_POST['code-id'];
      $sql = "SELECT id FROM user WHERE national_id = '$sql_code_id'";
      $id_result = ($conn->query($sql))->fetch();
      //print_r($id_result);

      if($id_result){
        $err['code_id'] = "* National ID or passport ID already exist.";
      }else{  
        //print_r("NO ID IN DATABASE");

        //National ID check
        if(strlen($_POST['code-id']) == 13 || 
           (strlen($_POST['code-id']) <= 9 && strlen($_POST['code-id']) >= 7)){

          //print_r("<br>NEW ID");

          //Check National ID and Passport ID 
          if(strlen($_POST['code-id']) == 13 
            && preg_match('/[0-9]{13}/', $_POST['code-id'])){  

            //print_r("NATIONAL ID CHECK");

            //National ID
            for($j = 0, $sum = 0; $j < 12; $j++){
              $sum += (int)($_POST['code-id']{$j})*(13-$j);
              if((11 - ($sum % 11)) % 10 == (int)($_POST['code-id']{12})){

                //print_r("NATIONAL ID :");

                $err['code_id'] = "";
              }else{

                $err['code_id'] = "* Invalid national ID or passport ID format.";

              }
            }

          }//Passport check
          else if((strlen($_POST['code-id']) <= 9 && strlen($_POST['code-id']) >= 7)
           && preg_match('/([A-Z]{1,2})([0-9]{6,7})/', $_POST['code-id'])){ 

            //print_r("PASSPORT ID");

            $err['code_id'] = "";

          }//Not both
          else{
            $err['code_id'] = "* Invalid national ID or passport ID format.";
          }

        }// Not both
        else{

          $err['code_id'] = "* Invalid national ID or passport ID format.";

        }
      }
    }//Blank
    else{
      $err['code_id'] = $blank_description;
    }

    //File check
    $file = "";
    $file_destination = "";
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
          if($file['size'] < 50000000){
            $newfilename = uniqid('', true).".".$file_ext;
            $file_name_new = $newfilename;
            $file_destination = '\\uploads\\'.$newfilename;
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
      $err['copy_file'] = "* Please add copy national ID or passport ID file.";
    }


    //Username check
    if(isset($_POST['username']) && $_POST['username'] != null){
      $sql_username = $_POST['username'];
      $sql = "SELECT id FROM user WHERE username = '$sql_username'";
      $username_result = ($conn->query($sql))->fetch();

      //Uesrname already in database.
      if($username_result){
        $err['username'] = "* Username already exist.";
      }
      //Check input data
      else{

        //Check special character and space
        if(strpbrk($_POST['username'], $special_character_except_space)
           || strpbrk($_POST['username'], ' ')){

          $err['username'] = "* Special character is not allowed except \"-\" or \"_\".";

        }
        //Check form
        else if(!preg_match($username_character, $_POST['username'])){

          $err['username'] = "* Invalid input format.";
          
        }
        //True form
        else{
          $err['username'] = "";
        }
      }
    }
    //Blank
    else{
      $err['username'] = $blank_description;
    }

    //Password check
    if(isset($_POST['password']) && $_POST['password'] != null){

      //Check special character and space
      if(strpbrk($_POST['password'], $special_character_except_space)
          || strpbrk($_POST['password'], ' ')){

        $err['password'] = "* Special character is not allowed except \"-\" or \"_\".";

      }
      //Password length less than 16
      else if(strlen($_POST['password']) < 16){
        $err['password'] = "* Password length must greater than or equal 16.";
      }
      //Password length >= 16
      else{

        //True form password
        if(preg_match($small_alphabet, $_POST['password']) && preg_match($capital_alphabet, $_POST['password'])
            && preg_match($numeric, $_POST['password'])){

          $err['password'] = "";

        }

        //Invalid form password
        else{

          $err['password'] = "* Password must has a-z, A-Z and 0-9 at lease one character.";

        }
      }
    }
    //Blank
    else{

      $err['password'] = $blank_description;

    }

    //Confirm password
    if(isset($_POST['confirm-password']) && $_POST['confirm-password'] != null){
      //Check special character and space
      if(strpbrk($_POST['confirm-password'], $special_character_except_space)
          || strpbrk($_POST['confirm-password'], ' ')){

        $err['confirm_password'] = "* Special character is not allowed except \"-\" or \"_\".";

      }
      //Check matching with password
      else{
        if($_POST['confirm-password'] === $_POST['password']){

          $err['confirm_password'] = "";

        }
        //Not match
        else{
          $err['confirm_password'] = "* Password does not match.";
        }
      }
    }
    //Blank
    else{
      $err['confirm_password'] = $blank_description;
    }
  
    //Birth data check
    if(isset($_POST['birth-date']) && $_POST['birth-date'] != NULL){

      //Check birth date
      
      $date_now = strtotime("now");
      $date_user = strtotime($_POST['birth-date']);
      $date_should_less_or_equal_than = strtotime("-20 years", $date_now);

      //Age less than 20 years old.
      if($date_user > $date_should_less_or_equal_than){

        $err['birth_date'] = "* You must be 20 years of age or older.";

      }
      //Age greater than or equal 20 years old
      else if($date_user <= $date_should_less_or_equal_than){

        $err['birth_date'] ="";

      }

      //Age is null
      if(!$date_user){

        $err['birth_date'] ="* Invalid birth date.";

      }
    }
    //Blank
    else{

      $err['birth_date'] = "* Please insert date.";

    }
    
    //Answer1 check
    if(isset($_POST['first-answer']) && $_POST['first-answer'] != null){

      //Special character check
      if(strpbrk($_POST['first-answer'], $special_character_except_space)){

        $err['answer_1'] = $special_character_description;

      }
      //True form
      else{

        $err['answer_1'] = "";

      }
    }
    //Blank
    else{
      $err['answer_1'] = $blank_description;
    }

    //Answer2 check
    if(isset($_POST['second-answer']) && $_POST['second-answer'] != null){

      //Special character check
      if(strpbrk($_POST['second-answer'], $special_character_except_space)){

        $err['answer_2'] = $special_character_description;

      }
      //True form
      else{

        $err['answer_2'] = "";

      }
    }
    //Blank
    else{
      $err['answer_2'] = $blank_description;
    }

    //Answer3 check
    if(isset($_POST['third-answer']) && $_POST['third-answer'] != null){

      //Special character check
      if(strpbrk($_POST['third-answer'], $special_character_except_space)){

        $err['answer_3'] = $special_character_description;

      }
      //True form
      else{

        $err['answer_3'] ="";

      }
    }
    //Blank
    else{

      $err['answer_3'] = $blank_description;

    }

    //Email
    if(isset($_POST['email']) && $_POST['email'] != null){

      $str_email = explode("@", $_POST['email']);

      $mail_file = fopen("email_provider.txt", "r");
      $valid_provider = 0;

      //Email provider
      if(strpos(file_get_contents("email_provider.txt"), 
        $str_email[1])){
        $valid_provider = 1;
      }

      fclose($mail_file);

      $sql_email = $_POST['email'];

      //filter special character.
      if(!(strpbrk($special_character_for_email, $str_email[0]) 
        || strpbrk($special_character_for_email, $str_email[1]))){
         $sql = "SELECT id FROM user WHERE email = '$sql_email'";
         $email_result = ($conn->query($sql))->fetch();
      }

      //Check email in database
      if($email_result){

        $err['e-email'] = "* Email already exist.";

      }
      //Check new email
      else{

        //Check special character and space
        if(strpbrk($special_character_for_email, $str_email[0]) 
          || strpbrk($special_character_for_email, $str_email[1])){

          $err['e-email'] = $special_character_description;

        }
        //Check email format
        else{
          if(!$valid_provider){
              $err['e-email'] = "* Invalid email."; 

          }
          //True form
          else{

            $err['e-email'] ="";

          }
        }
      }
    }
    //Blank
    else{

      $err['e-email'] = $blank_description;

    }

    $i = 0;
    foreach ($err as $key => $value) {
      if($value != ""){
        $i++;
      }
    }

    $str_name = $_POST['name'];

    $str_name = explode(" ", $str_name);
    $name = "";
    $surname = "";

    if(count($str_name) == 3){
      $name = $str_name[0];
      $surname = $str_name[1]." ".$str_name[2];
    }else if(count($str_name) == 2){
      $name = $str_name[0];
      $surname = $str_name[1];
    }else if(count($str_name) == 4){
      $name = $str_name[0];
      $surname = $str_name[1]." ".$str_name[2]." ".$str_name[3];
    }

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


    //If no errors occurred.
    if(!$i){
      $mail = new PHPMailer;
      //Tell PHPMailer to use SMTP
      $mail->isSMTP();
      //Enable SMTP debugging
      // 0 = off (for production use)
      // 1 = client messages
      // 2 = client and server messages
      //$mail->SMTPDebug = 3;
      //Set the hostname of the mail server
      $mail->Host = 'smtp-mail.outlook.com';
      //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = 587;
      //Whether to use SMTP authentication
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls';  
      $mail->SMTPOptions = array(
          'ssl' => array(
              'verify_peer' => true,
              'verify_peer_name' => true,
              'allow_self_signed' => true
          )
      );
      //Username to use for SMTP authentication
      $mail->Username = 'wasitthaphon@hotmail.com';
      //Password to use for SMTP authentication
      $mail->Password = 'beer2539';
      //Set who the message is to be sent from
      $mail->CharSet = 'UTF-8';
      $mail->setFrom('wasitthaphon@hotmail.com', 'ชุมชนคนรักธรรมะ');
      $mail->addAddress($email, $username);               // Name is optional
        $mail->Subject = 'Thank you for registration with LoveDhamma';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML("Thank you for registration with LoveDhamma.");
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Thank you for registration with LoveDhamma.';

      if($mail->send()){

        $file_name = $file_name_new;
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_content = file_get_contents($file['tmp_name']);
        $file_content = addslashes($file_content);
      
        //Check Upload file is come from file input form
        if(is_uploaded_file($file['tmp_name'])){

          $doc_path = realpath(dirname(__FILE__));

          //Is upload to directory complete
          if(move_uploaded_file($file['tmp_name'], $doc_path.$file_destination)){

            //no insert content.
            $file_content = 0;

          }

          //Query command
          $sql_str = "INSERT INTO user VALUES (NULL, '$name', '$surname', '$n_id', '$file_name', '$file_type', '$file_size', '$file_content', '$username', '$password', '$birth_date', '$first_q', '$first_a', '$second_q', '$second_a', '$third_q', '$third_a', '$email', 0, 0, 0, 0, 0)";

          //Insert to database success
          if($conn->exec($sql_str)){
            $last_id = $conn->lastInsertId();
            $sql_statement = "INSERT INTO notification VALUES(NULL, 1, $last_id, 0)";
            $conn->exec($sql_statement);
            header("Location: Successful.php");

          }
          //Insert fail.
          else{

            $err['register_e'] = "* Can't register.";

          }

        }
        //Upload file doesnt com from input file form
        else{

          echo "file upload failed.";

        }
      }else{
        $err['register_e'] = "* Can't register.";
      }
    }else{
      $err['register_e'] = "* Can't register.";
    }

  }
  //No POST action
  else{

    $err = array(
      "name" => "",
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
      "register_e" => "",
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
          <?php 
              if(isset($_SESSION['username'])){
                $html_username_tag = "<div><a class=\"btn-link\" href=\"profile.php\">สวัสดีคุณ ".$_SESSION['username']."</a></div>";
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


  <div class="register_container">
    <h3 style="text-align: center; margin-top: 2rem;">Registration</h3><br><br>

    <form id="register_form" class="font-Tri" method="post" enctype="multipart/form-data">

      <!-- Name -->
      <div class="form-group">
        <div class="row">
          <div class="col text-center">
            <label for="name" style="margin-top: 5px;">Name :</label>
          </div>
          <div class="col-9">
            <input type="text" class="form-control row" name="name" id="name" aria-describedby="name-help" autocomplete="off"  >
            <small id="name-help" class="form-text row" style="color: red;">
              <?php
                echo $err['name'];
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
          <label for="first-question">Please select first question.</label>
          <select class="custom-select" id="first-question" name="first-question">

            <!-- insert question here -->
            <option selected value="1">What is the name of your pet?</option>
            <option value="2">What is your favorite color?</option>
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
          <label for="second-question">Please select second question.</label>
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
          <label for="third-question">Please select third question.</label>
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
        <input type="checkbox" name="accept-agreement" value="1" id="accept-agreement" required> I agree <a href="#openModal" style="text-decoration:"offne;">agreement.</a>
        <br>
        <br>
        <small id="register-help" class="form-text" style="color: red;">
          <?php
            echo $err['register_e'];
          ?>
        </small>
        
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

  <footer id="footer" class="text-center" style="margin-top: 3rem;">
    <div class="font-color1"> Copyright &copy; <span class="font-s1">ชุมชน คนชอบปฏิบัติธรรม</span> </div>
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