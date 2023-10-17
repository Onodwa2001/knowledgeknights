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

    $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $row = mysqli_fetch_assoc($select);

    if (!$row || !password_verify($pass, $row['password'])) {
        $error = 'Invalid email or password';
        header("location: ../login.php?error=$error");
        die();
    
    }else if($row && password_verify($pass, $row['password']) && $row['verifiedStatus'] == 'Verified'){
        if(mysqli_num_rows($select) > 0){
            if($row){
                $_SESSION['username'] = $row['username'];
                $_SESSION['userType'] = $row['userType'];
                $username = $_SESSION['username'];
                header("location: ../../index.php?id=" . $username);
            }
        }
       
    }else if($row && password_verify($pass, $row['password']) && $row['verifiedStatus'] == 'Not Verified' && $row['userType']=='Tutor'){
        $error = 'Tutor account requires admin approval';
        header("location: ../login.php?error=$error");
        die();
    

       # TO DO
    }  /*Condition required to allow tutor to log into their dashboard once admin approves there account*/ 
    
    
    
    
    else if($row && password_verify($pass, $row['password']) && $row['verifiedStatus'] == 'Not Verified' && $row['userType'] == 'Student'){
        $otp = mt_rand(100000,999999);
               
        $url = "http://localhost/tutor/login/otp_verification.php?email=$email";
        
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
          $mail->Subject = 'OTP Verification';
          $body = '<b>Click on the link below to verify otp code &nbsp;</b><br>' ;
          
          
          $body .= '<span><b>OTP Code:</b></span> &nbsp;'. $otp;
  
          $body .= '<br><a href="'.$url.'"> Click here to enter verification code</a>';
          $mail->Body = $body;
  
          if ($mail->send()) {
            //update database
            echo '<script>alert("' . $email . '");</script>';

            $sql = "UPDATE users SET otpCode = $otp WHERE email = '$email'";
            $query = mysqli_query($conn, $sql);
             
            if($query){  
                $select = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                  
                if(mysqli_num_rows($select) > 0){
                    $row = mysqli_fetch_assoc($select);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['otpCode'] = $row['otpCode'];
                    $_SESSION['userType'] = $row['userType'];
                }
              
                $msg = "A OTP verification code was sent to $email";
                header("location: ../login.php?msg=$msg");
                die();
            }else{
                $error = 'Something went wrong';
                header("location: ../login.php?error= $error");
                die();
            }
         }

        }catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
  
     } 
    }
?>