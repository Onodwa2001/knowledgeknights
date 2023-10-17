<?php
include 'includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">


</head>

<body>

   <div class="form-container">

      <form action="includes/verify.php" method="post" enctype="multipart/form-data">
         <h3>login now</h3>
         <?php
            if (isset($_GET['msg'])) { ?>
                <p class="success-message"><?php echo $_GET['msg']; ?></p>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['error'])) { ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php
            }
            ?>
         <input type="email" name="email" placeholder="enter email" class="box" required>

         <div class="password-container">
            <input type="password" name="password" id="id_password" placeholder="enter password" class="box" required>
            <i class="far fa-eye" id="togglePassword" style="margin-left: -30px; cursor: pointer;"></i>

         </div>

         <p style="text-align:left; font-size: 16px; margin-top: 0px;"><a href="password_assistance.php">Forgot password?</a></p>
         <input type="submit" name="submit" value="login now" class="btn">
         <p>don't have an account? <a href="student_register.php">register now</a></p>

      </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
   <script src="js/script.js"></script>
   
</body>

</html>