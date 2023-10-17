<?php

require_once('../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    if(empty($email)){
       
        $error= 'Email field is required';
        header("location: ../password_assistance.php?error=$error");
        die();
    }else{
        $select =mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $row = mysqli_fetch_assoc($select);

        $length = 35;
        $token = bin2hex(random_bytes($length));
       
        $created = time();
        $expires = strtotime("5 minutes", $created);
        $url = "http://localhost/tutor/login/password_reset.php?token=$token&email=$email";
        
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'youngkillian0308@gmail.com';                     
            $mail->Password   = 'ifgf msyh dpnt jlyc';                              
            $mail->SMTPSecure = 'ssl';            
            $mail->Port       = 465;                                   

            //Recipients
            $mail->From = 'youngkillian0308@gmail.com'; 
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);                                 
            $mail->Subject = 'Reset Password Link';
            $body = '<b>Click on the link below to reset your password &nbsp;</b> </br>';
            $body .= '<span>&nbsp;Link expires in 5 mins</span>';
            $body .= '<a href="'.$url.'">&nbsp;Click here</a>';
            $mail->Body = $body;

            if ($mail->send()) {
                $sql = "UPDATE users SET expiryDate = '$expires', token = '$token' WHERE email = '$email'";
                $query = mysqli_query($conn, $sql);

            if($query){
                $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                if(mysqli_num_rows($select) > 0){
                    $row = mysqli_fetch_assoc($select);
                    $msg = "A reset link has been sent to $email";
                    header("location: ../password_assistance.php?msg=$msg");
                    die();
                }

            }else{
                $error = 'Something went wrong';
                header("location: ../password_assistance.php?error= $error");
                die();
            }
        }
        }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>