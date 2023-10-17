<?php

require_once('../includes/config.php');
include '../inc_functions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

session_start();

if (isset($_POST['rejectApplication'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($select);


    $url = "http://localhost/Projects/Admin-Dashboard%20latest%20version/index.php";

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'youngkillian0308@gmail.com';
        $mail->Password = 'ifgf msyh dpnt jlyc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Recipients
        $mail->From = 'youngkillian0308@gmail.com';
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Tutor Application has been rejected';
        $body = '<b>Your application has been rejected. Your application does not meet the requirements. &nbsp;</b><br>';
        $mail->Body = $body;

        if ($mail->send()) {
           
            applicationRejectedAlert();

            echo'Application has been rejected';
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>