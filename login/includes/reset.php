<?php

require_once('../includes/config.php');
if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $token = $_POST["token"];
    $pass = $_POST["new_pass"];
    $cpass = $_POST["confirm_pass"];


    $uppercase = !preg_match('@[A-Z]@', $pass);
    $lowercase = !preg_match('@[a-z]@',  $pass);
    $number    = !preg_match('@[0-9]@',  $pass);
    $specialChars = !preg_match('@[^\w]@',  $pass);
    $whiteSpaces = preg_match("/\s/",  $pass);
    $hashPassword= password_hash($pass, PASSWORD_BCRYPT);

    if(empty($email) || empty($token) || empty($pass) || empty($cpass)){
        $error = 'All fields are required';
        header("location: ../password_reset.php?token=$token&email=$email&error=$error");
        die(); 
    }elseif ($pass != $cpass) {
        $error = 'Passwords do not match';
        header("location: ../password_reset.php?token=$token&email=$email&error=$error");
        die();
    }elseif (strlen($pass) < 8 || $uppercase || $lowercase || $number || $specialChars || $whiteSpaces) {
        $error = 'Invalid Password';

    }else{
   
        $query = "SELECT email , token , expiryDate FROM users WHERE email = ? AND token = ?";
        $stmt = mysqli_prepare($conn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt, 'ss', $email, $token);
        }
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                
                mysqli_stmt_bind_result($stmt, $hashPassword, $expiryDate, $token);
                if(mysqli_stmt_fetch($stmt)){
                 
                    $current_time = time();
                    if($current_time >= $expiryDate){
                        $error = 'Token has expired';
                        header("location: ../reset.php?token=$token&email=$email&error=$error");
                        die();
                    }else{
                        $token = '';
                        $expiryDate = '';
                        $query = "UPDATE users SET password = ?, token = ?, expiryDate = ? WHERE email = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        
                        if($stmt){
                            
                            $newPassword = password_hash($pass, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, 'ssss', $newPassword , $token, $expiryDate, $email);
                            if(mysqli_stmt_execute($stmt)){
                                // redirect to login
                               $msg = 'password successfully reset';
                             
                               header("location: ../login.php?msg=$msg");
                               die();
                               
                                
                            }
                        }
                    }
                }

            }else{
                $error = 'Invalid email or token';
                header("location: ../reset.php?token=$token&email=$email&error=$error");
                die();
            }
        }
    
  }
}
?>