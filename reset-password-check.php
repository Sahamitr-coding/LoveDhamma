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
        
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        //Server settings
        //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'wasitthaphon@gmail.com';                 // SMTP username
        $mail->Password = 'wasit96beer';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('saharuthi_j@kkumail.com', 'LoveDhamma admin');
        $mail->addAddress($user_data['email']);               // Name is optional

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Your password has been reset.';
        $mail->Body    = '<b>Your password has been reset lately.</b>';
        $mail->AltBody = 'password has been reset.';

        if(!$mail->send()){
          echo 'Email can not be sent.';
        }else{

          $sql = "UPDATE user SET password='$newpassword' WHERE username='$username'";
          $conn->exec($sql);
          echo 'passed';
        }
      }else{
        echo "failed";
      }
    }
  }
  
?>