<?php

require_once('../includes/config.php');
include '../inc_functions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

session_start();

if (isset($_POST['acceptApplication'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($select);


    $url = "http://localhost/tutor/pricing/index.php";

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
        $mail->Subject = 'Tutor Application has been approved';
        $body = '<b>Your application has been approved. Please click the link below to complete the payment process. &nbsp;</b><br>';

        $isVerified = 1;
        $verifiedStatus = 'Verified';
    
        $body .= '<br><a href="' . $url . '"> Click here to continue with the payment process</a>';
        $mail->Body = $body;

        if ($mail->send()) {
            //update database
           /* echo '<script>alert("' . $email . '");</script>';*/

            $sql = "UPDATE tutor SET isVerified = '$isVerified' WHERE username = '$username'";
            $query = mysqli_query($conn, $sql);

            $sql2 = "UPDATE users SET verifiedStatus = '$verifiedStatus' WHERE username = '$username'";
            $query2 = mysqli_query($conn, $sql2);

            if ($query && $query2) {
                $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

                if (mysqli_num_rows($select) > 0) {
                    $row = mysqli_fetch_assoc($select);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['userType'] = $row['userType'];
                    applicationAcceptedAlert($query);
                }

                /*$msg = "Your application has been approved. Please continue with the payment process. $email";
                header("location: ../login.php?msg=$msg");
                die();*/
            } else {
                $error = 'Something went wrong';
                header("location: index.php?error= $error");
                die();
            }

            
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>