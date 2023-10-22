<?php

require_once('../includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $selectUsers = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($selectUsers);

    $selectTutor = mysqli_query($conn, "SELECT * FROM tutor WHERE email='$email'");
    $row1 = mysqli_fetch_assoc($selectTutor);

    $selectPayment = mysqli_query($conn, "SELECT * FROM payment WHERE email='$email'");
    $row2 = mysqli_fetch_assoc($selectPayment);

    if (!$row || !password_verify($pass, $row['password'])) {
        $error = 'Invalid email or password';
        header("location: ../login.php?error=$error");
        die();

    }
    switch ($row['userType']) {
        case 'Student':
            if ($row['verifiedStatus'] == 'Verified' && mysqli_num_rows($selectUsers) > 0) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['userType'] = $row['userType'];
                $username = $_SESSION['username'];
                header("location: ../../index.php?id=$username");
            } else {
                $otp = mt_rand(100000, 999999);

                $url = "http://localhost/Projects/knowledgeknights/login/otp_verification.php?email=$email";

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
                    $mail->Subject = 'OTP Verification';
                    $body = '<b>Click on the link below to verify otp code &nbsp;</b><br>';


                    $body .= '<span><b>OTP Code:</b></span> &nbsp;' . $otp;

                    $body .= '<br><a href="' . $url . '"> Click here to enter verification code</a>';
                    $mail->Body = $body;

                    if ($mail->send()) {
                        //update database
                        echo '<script>alert("' . $email . '");</script>';

                        $sql = "UPDATE users SET otpCode = $otp WHERE email = '$email'";
                        $query = mysqli_query($conn, $sql);

                        if ($query) {
                            $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

                            if (mysqli_num_rows($select) > 0) {
                                $row = mysqli_fetch_assoc($select);
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['otpCode'] = $row['otpCode'];
                                $_SESSION['userType'] = $row['userType'];
                            }

                            $msg = "A OTP verification code was sent to $email";
                            header("location: ../login.php?msg=$msg");
                            die();
                        } else {
                            $error = 'Something went wrong';
                            header("location: ../login.php?error= $error");
                            die();
                        }
                    }

                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            }
            break;

        case 'Tutor':
            if ($row1['isVerified'] != true || $row2['paymentMade'] != true) {
                $error = 'Tutor account requires admin approval';
                header("location: ../login.php?error=$error");
                die();
            } else {
                $_SESSION['username'] = $row['username'];
                $username = $_SESSION['username'];
                header("location: ../../index.php?id=$username");
            }
            break;

        case 'Admin':
            if ($row['userType'] == 'Admin') {
                $_SESSION['username'] = $row['username'];
                $username = $_SESSION['username'];
                header("location: ../../admin/index.php?id=$username");
            } else {
                $error = 'User is not an admin';
                header("location: ../login.php?error=$error");
                die();
            }
            break;



        default:
            // Handle other user types or conditions here
            break;
    }

}

?>