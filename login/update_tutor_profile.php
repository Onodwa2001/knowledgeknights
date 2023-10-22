<?php

include 'includes/config.php';
include '../admin/inc_functions.php';
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
      $select = mysqli_query(
         $conn,
         "SELECT t1.username ,t1.password, t1.firstName, t1.lastName, t1.dateOfBirth,t1.image,t1.email,
         t2.hourlyRate,t2.qualification,t2.phoneNumber,t2.yearsOfExperience,t3.streetNumber,
         t3.streetName,t3.region,t3.town,t3.city,t3.postalCode
         FROM users AS t1
         INNER JOIN tutor AS t2 ON t1.username = t2.username
         INNER JOIN address AS t3 ON t1.username = t3.username;
         "
      ) or die('query failed');
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
            <p class="error-message">
               <?php echo $_GET['error']; ?>
            </p>
            <?php
         }
         ?>
         <div class="flex">
            <div class="inputBox">
               <!--<span>Username :</span>-->
               <input type="hidden" name="username" value="<?php echo $fetch['username']; ?>" class="box">
               <span>First name :</span>
               <input type="text" name="firstname" value="<?php echo $fetch['firstName']; ?>" class="box"
                  required>
               <span>Last name :</span>
               <input type="text" name="lastname" value="<?php echo $fetch['lastName']; ?>" class="box" required>
               <span>Email address :</span>
               <input type="email" name="email" value="<?php echo $fetch['email']; ?>" class="box" required>
               <span>DOB :</span>
               <input type="date" name="dob" value="<?php echo $fetch['dateOfBirth']; ?>" class="box" required>

               <span>Phone Number :</span>
               <input type="number" name="phoneNo" value="<?php echo $fetch['phoneNumber']; ?>" placeholder="Phone number"
                  class="box" required>

               <span>Hourly Rate :</span>
               <input type="number" name="hourlyRate" value="<?php echo $fetch['hourlyRate']; ?>" placeholder="Hourly rate" class="box" required>
               <span>Teaching Experience :</span>
               <input type="number" name="teachingExperience" value="<?php echo $fetch['yearsOfExperience']; ?>" placeholder="Years of experience" class="box" required>
            </div>


            <div class="inputBox">

            <span>Address:</span>
               <input type="text" name="streetNo" value="<?php echo $fetch['streetNumber']; ?>" placeholder="Street number" class="box">
               <input type="text" name="streetName" value="<?php echo $fetch['streetName']; ?>" placeholder="Street name" class="box">
               <input type="text" name="region" value="<?php echo $fetch['region']; ?>" placeholder="Region" class="box" required>
               <input type="text" name="town" value="<?php echo $fetch['town']; ?>" placeholder="Town" class="box">
               <input type="text" name="city" value="<?php echo $fetch['city']; ?>" placeholder="City" class="box">
               <input type="text" name="postal" value="<?php echo $fetch['postalCode']; ?>" placeholder="Postal Code" class="box" required>


               <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">

               <span>New password :</span>

               <div class="password-container">
                  <input type="password" name="new_pass" id="id_password" placeholder="enter new password" class="box">
                  <i class="far fa-eye" id="togglePassword"
                     style="margin-left: -30px;margin-top: 9px;cursor: pointer;"></i>
               </div>

               <span>Confirm password :</span>

               <div class="password-container">
                  <input type="password" name="confirm_pass" id="id_password" placeholder="confirm new password"
                     class="box">
               </div>

               <span>Update your pic :</span>
               <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box"
                  value="<?php echo $fetch['image']; ?>">
            </div>
         </div>

         <input type="submit" value="update profile" name="update_tutor_profile" class="btn">
         <a href="../index.php" class="delete-btn">go back</a>
      </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
      crossorigin="anonymous"></script>
   <script src="js/script.js"></script>
</body>

</html>

<?php


if (isset($_POST['update_tutor_profile'])) {


   updateTutorDetails($conn);

   updateTutorPassword($conn);

   updateTutorUploadFiles($conn);


}

?>