<?php
include 'includes/config.php';
include 'inc_functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

   <div class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>register now</h3>

         <div class="user-container">
            <div class="column">
               <a class="active" href="student_register.php">Student</a>
            </div>
            <div class="column">
               <a href="tutor_register.php">Tutor</a>
            </div>
         </div>


         <?php
         if (isset($_GET['msg'])) { ?>
            <p class="success-message">
               <?php echo $_GET['msg']; ?>
            </p>
            <?php
         }
         ?>
         <?php
         if (isset($_GET['error'])) { ?>
            <p class="error-message">
               <?php echo $_GET['error']; ?>
            </p>
            <?php
         }
         ?>

         <input type="text" name="firstname" placeholder="enter firstname" class="box" required>
         <input type="text" name="lastname" placeholder="enter lastname" class="box" required>
         <input type="text" name="username" placeholder="enter username" class="box" required>
         <input type="email" name="email" placeholder="enter email" class="box" required>
         <input type="text" placeholder="DOB" name="dob" class="box" onfocus="(this.type='date')" required>

         <div class="password-container">
            <input type="password" name="password" id="id_password" placeholder="enter password" class="box" required>
            <i class="far fa-eye" id="togglePassword" style="margin-left: -30px;margin-top: 9px;cursor: pointer;"></i>
         </div>


         <div class="password_required">
            <ul>
               <li class="lowercase"><span></span>One Lowercase Letter</li>
               <li class="capital"><span></span>One Capital Letter</li>
               <li class="number"><span></span>One Number</li>
               <li class="special-characters"><span></span>One Special Character</li>
               <li class="eight-characters"><span></span>At Least 8 Character</li>

            </ul>

         </div>

         <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
         <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
         <input type="submit" name="submit" value="register now" class="btn">
         <p>already have an account? <a href="login.php">login now</a></p>
      </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
      crossorigin="anonymous"></script>

   <script src="js/script.js"></script>

</body>

</html>

<?php

if (isset($_POST['submit'])) {
   registerStudent($conn);

}

