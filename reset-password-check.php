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
        
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 3;
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
        //Set an alternative reply-to address
        $mail->addAddress($user_data['email'], $user_data['username']);               // Name is optional
        $mail->Subject = 'Your password has been reset.';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML("Your password has been reset.");
        //Replace the plain text body with one created manually
        $mail->AltBody = 'Your password has been reset.';

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