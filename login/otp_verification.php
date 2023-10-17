<?php
    include 'includes/config.php';
    session_start();

    if(isset($_POST["submit"])){
        $otp1 = mysqli_real_escape_string($conn, $_POST['otp1']);
        $otp2 = mysqli_real_escape_string($conn, $_POST['otp2']);
        $otp3 = mysqli_real_escape_string($conn, $_POST['otp3']);
        $otp4 = mysqli_real_escape_string($conn, $_POST['otp4']);
        $otp5 = mysqli_real_escape_string($conn, $_POST['otp5']);
        $otp6 = mysqli_real_escape_string($conn, $_POST['otp6']);
        $username = $_SESSION['username'];
        $sessionOtp = $_SESSION['otpCode'];
        $otpCode = $otp1.$otp2.$otp3.$otp4.$otp5.$otp6;
        
    if(!empty($otpCode)){
        if($otpCode ==  $sessionOtp){
            $select = mysqli_query($conn , "SELECT * FROM users WHERE username = '{$username}' AND otpCode = '{$otpCode}'");
            if(mysqli_num_rows($select) > 0){ 
                $nullOtp = 0;
                $update = mysqli_query($conn , "UPDATE users SET `verifiedStatus` = 'Verified' , `otpCode` = '$nullOtp' WHERE username = '{$username}'");
                if($update){
                    $row = mysqli_fetch_assoc($select);
                
                if($row){
                    $_SESSION['username'] = $row['username'];
                    $username = $_SESSION['username'];
                    $_SESSION['verifiedStatus'] = $row['verifiedStatus'];
                    header("location: ../index.php?id=" . $username);
                    }
                }
            }
    }
    else{
        $error = 'Invalid otp code!!!';
        header("location: otp_verification.php?error=$error");
        }
  } 
} 
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>

    <link rel="stylesheet" href="css/otp_verification.css">
</head>

<body>
    <div class="form-container">
       
        <form action="" method="post" autocomplete="off">
            <h3>Verify Your Account</h3>
            <p>We emailed you the six digit OTP code to your email. Enter the code below to confirm your email address</p>
            
            <?php
            if (isset($_GET['error'])) { ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php
            }
            ?>
            <div class="fields-input">

                <input type="number" name="otp1" class="otp-field"  placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="otp2" class="otp-field"  placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="otp3" class="otp-field"  placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="otp4" class="otp-field" placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="otp5" class="otp-field" placeholder="0" min="0" max="9" required onpaste="false">
                <input type="number" name="otp6" class="otp-field" placeholder="0" min="0" max="9" required onpaste="false">
            </div>
          
           <input type="submit" name="submit" value="Verify Now" class="btn">

        </form>

    </div>
    <script src="js/verify.js"></script>
</body>

</html>