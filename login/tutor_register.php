<?php
ob_start();
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
   <link rel="stylesheet" href="css/tutor_registration.css">
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

   <div class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>register now</h3>

         <div class="user-container">
            <div class="column">
               <a href="student_register.php">Student</a>
            </div>
            <div class="column">
               <a class="active" href="tutor_register.php">Tutor</a>
            </div>
         </div>
         <?php
            if (isset($_GET['msg'])) { ?>
                <p class="success-message"><?php echo $_GET['msg']; ?></p>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['error'])) { ?>
                <p class="error-message" id="error-message" ><?php echo $_GET['error']; ?></p>
            <?php
            }
            ?>
         <div class="flex-container">
            <input type="text" name="firstname" placeholder="Firstname" class="box" required>
            <input type="text" name="lastname" placeholder="Lastname" class="box" required>
         </div>

         <div class="flex-container">
            <input type="text" name="username" placeholder="Username" class="box" required>
            <input type="email" name="email" placeholder="Email" class="box">
         </div>

         <div class="flex-container">
            <input type="number" name="phoneNo" placeholder="Phone number" class="box" required>

            <input type="text" placeholder="DOB" name="dob" class="box" onfocus="(this.type='date')" required>
         </div>

         <div class="flex-container">
            <input type="text" name="streetNo" placeholder="Street number" class="box">
            <input type="text" name="streetName" placeholder="Street name"
               class="box">
            <input type="text" name="region" placeholder="Region" class="box" required>
         </div>

         <div class="flex-container">
            <input type="text" name="town" placeholder="Town" class="box">
            <input type="text" name="city" placeholder="City"
               class="box">
            <input type="text" name="postal" placeholder="Postal Code" class="box" required>
         </div>

         <div class="flex-container">

            <div class="password-container">
               <input type="password" name="password" id="id_password" placeholder="enter password" class="box"
                  required>
               <i class="far fa-eye" id="togglePassword"
                  style="margin-left: -30px;margin-top: 9px;cursor: pointer;"></i>
            </div>

            <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
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

         <div class="flex-container">
            <input type="number" name="hourlyRate" placeholder="Hourly rate" class="box" required >
            <input type="number" name="teachingExperience" placeholder="Years of experience" class="box" required>
         </div>

         <div class="subjects ">
            <span class="input-heading">Select your subjects:</span>
            <br>
           <select name="subjects[]" class="box js-example-basic-multiple" multiple="multiple" id="subject" required>
               <?php
               $query = "SELECT * FROM subject";
               $query_run = mysqli_query($conn, $query);

               if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $row) {
                     ?>
                     <option value="<?= $row['subject_id']; ?>"><?= $row['subject_name']; ?></option>
                     <?php
                  }
               } else {
                  ?>
                  <option value="">No Record found</option>
                  <?php
               }
               ?>
            </select>
         </div>
         <br>
         <div class="profile-pic">
            <span class="input-heading">Select profile pic:</span>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">

         </div>

         <div class="document-upload">
            <span class="input-heading">Highest educational qualification(*Please upload document in pdf format )</span>
            <input type="file" name="filename" class="box">
         </div>


         <input type="submit" name="submit" value="register now" class="btn">
         <p>already have an account? <a href="login.php">login now</a></p>
      </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script src="js/script.js"></script>


</body>

</html>

<?php
if (isset($_POST['submit'])) {
   registerTutor($conn);
}
?>