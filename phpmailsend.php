<?php
/**
 * This example shows making an SMTP connection with authentication.
 */
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Asia/bangkok');
require 'PHPMailer/vendor/autoload.php';
//Create a new PHPMailer instance
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
$mail->setFrom('wasitthaphon@hotmail.com', 'สวัสดี');
//Set an alternative reply-to address
$mail->addAddress('wasitthaphon@gmail.com', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("GG");
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}