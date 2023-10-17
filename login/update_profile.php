<?php

include 'includes/config.php';
include 'inc_functions.php';
session_start();
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>
     
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
  
   <div class="update-profile">
      <?php
      $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
         $fetch = mysqli_fetch_assoc($select);
      }
      ?>

      <form action="" method="post" enctype="multipart/form-data">

      
         <?php
         if ($fetch['image'] == '') {
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="uploaded_img/' . $fetch['image'] . '">';
         }
      
         if (isset($_GET['error'])) { ?>
             <p class="error-message"><?php echo $_GET['error']; ?></p>
         <?php
         }
         ?>
         <div class="flex">
            <div class="inputBox">
               <!--<span>Username :</span>-->
               <input type="hidden" name="update_username" value="<?php echo $fetch['username']; ?>" class="box">
               <span>First name :</span>
               <input type="text" name="update_firstname" value="<?php echo $fetch['firstName']; ?>" class="box" required>
               <span>Last name :</span>
               <input type="text" name="update_lastname" value="<?php echo $fetch['lastName']; ?>" class="box" required>
               <span>Email address :</span>
               <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box" required>
               <span>DOB :</span>
               <input type="date" name="update_dob" value="<?php echo $fetch['dateOfBirth']; ?>" class="box" required>
            </div>
            <div class="inputBox">
               <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">

               <span>New password :</span>

               <div class="password-container">
                  <input type="password" name="new_pass" id="id_password" placeholder="enter new password" class="box">
                  <i class="far fa-eye" id="togglePassword" style="margin-left: -30px;margin-top: 9px;cursor: pointer;"></i>
               </div>

               <span>Confirm password :</span>

               <div class="password-container">
                  <input type="password" name="confirm_pass" id="id_password" placeholder="confirm new password" class="box">
               </div>

               <span>Update your pic :</span>
               <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box" value="<?php echo $fetch['image']; ?>" >
            </div>
         </div>
         
         <input type="submit" value="update profile" name="update_profile" class="btn">
         <a href="student_dashboard.php" class="delete-btn">go back</a>
      </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
   <script src="js/script.js"></script>
</body>

</html>

<?php


if (isset($_POST['update_profile'])) {


updateDetails($conn , $username);

updatePassword($conn , $username);

updateProfileImage($conn , $username);


}

?>