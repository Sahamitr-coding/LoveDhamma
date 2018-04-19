<?php
  require('connect.php');
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
  require 'PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require 'PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';


  date_default_timezone_set('Asia/Bangkok');
  require 'PHPMailer/vendor/autoload.php';

  session_start();
  if(!isset($_POST['a_password']) && !isset($_POST['a_c_password'])){
    if(!isset($_SESSION['username-reset-password'])){
      header("Location: index.php");
    }
  }else{
    if(!isset($_SESSION['username-reset-password'])){
      header("Location: index.php");
    }else{
      $username = $_SESSION['username-reset-password'];
      if($_POST['a_password'] === $_POST['a_c_password']){
        $newpassword = $_POST['a_password'];
        $sql = "SELECT name,surname,email from user WHERE username = '$username'";
        $user_data = ($conn->query($sql))->fetch();
        
        $mail = new PHPMailer;                            // Passing `true` enables exceptions
        //Server settings
        $mail->SMTPDebug = 3;                            // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => true
            )
        );
        $mail->Host = 'smtp-mail.outlook.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'wasitthaphon@hotmail.com';                 // SMTP username
        $mail->Password = 'beer2539';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('wasitthaphon@hotmail.com', 'ชุมชนคนรักธรรมะ');
        $mail->addAddress($user_data['email']);               // Name is optional
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Your password has been reset.';
        $mail->msgHTML('Your password has been reset lately.');
        $mail->AltBody = 'password has been reset.';

        if(!$mail->send()){
          echo 'Email can not be sent.';
        }else{

          $sql = "UPDATE user SET password='$newpassword' WHERE username='$username'";
          $conn->exec($sql);
          $sql = "SELECT * FROM user WHERE username='$username'";
          $user_data = ($conn->query($sql))->fetch();
          $id = $user_data['id'];
          $sql = "INSERT INTO notification VALUES(NULL, 2, $id, 0)";
          $conn->exec($sql);
          echo 'passed';
        }
      }else{
        echo "failed";
      }
    }
  }
  
?>