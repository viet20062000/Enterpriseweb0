<?php
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/OAuth.php";
require "PHPMailer/src/POP3.php";
require "PHPMailer/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;


function sendMail($title, $content, $nTo, $mTo){
    $nFrom = 'System';
    $mFrom = 'tt3044206@gmail.com';  //dia chi email cua ban 
    $mPass = 'q!@#$5678';  //mat khau email cua ban
    $mail             = new PHPMailer(true);
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 587;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo($mFrom, 'Localhost');
    $mail->SMTPOptions = array(

    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
);
    $mail->Subject = $title;
    $mail->Body    = $body;
    
    if(!$mail->send()) { 
    echo '<p>Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'</p>';
} else { 
    echo '<p>Message has been sent.</p>'; 
} 
}
