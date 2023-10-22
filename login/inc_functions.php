<?php
/*SUCCESS ALERT MESSAGES START*/
function updateAlert($query)
{
   // $username = $_SESSION['username'];

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Information has been successfully updated",
            icon: "success",
         }).then(function () {
            window.location = "http://localhost/Projects/knowledgeknights/index.php?id=".$username;
         });

      </script>

      <?php

   }
}
function paymentAlert($query)
{
   $username = $_SESSION['username'];

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Payment was successful",
            icon: "success",
         }).then(function () {
            let id = '<?php echo $username; ?>';
            window.location.href = "http://localhost/Projects/knowledgeknights/index.php?id=" + id;
         });
      </script>

      <?php

   }
}
function insertAlert($query)
{

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Student has been successfully registered",
            icon: "success",
         }).then(function () {
            window.location = "login.php";
         });

      </script>

      <?php

   } else {

      ?>
      <script>
         swal({
            title: "Failed",
            text: "Data not inserted",
            icon: "error",
         });
      </script>
      <?php

   }
}



function insertTutorAlert()
{


   ?>
   <script>
      swal({
         title: "Success",
         text: "Tutor has been successfully registered",
         icon: "success",
      }).then(function () {
         window.location = "login.php";
      });

   </script>

   <?php


}

/*SUCCESS ALERT MESSAGES END*/

/*UPDATE STUDENT PROFILE START*/
function updateDetails($conn, $username)
{

   #$update_username = mysqli_real_escape_string($conn, $_POST['update_username']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_firstname = mysqli_real_escape_string($conn, $_POST['update_firstname']);
   $update_lastname = mysqli_real_escape_string($conn, $_POST['update_lastname']);
   $update_dob = mysqli_real_escape_string($conn, $_POST['update_dob']);

   if (!filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: update_profile.php?error=$error");
      die();
   } elseif ((!preg_match("/^[a-zA-Z-' ]*$/", $update_firstname)) || (!preg_match("/^[a-zA-Z-' ]*$/", $update_lastname))) {
      $error = 'Invalid name';
      header("location: update_profile.php?error=$error");
      die();
   } else {
      $update = ("UPDATE `users` SET  firstName = '$update_firstname' , lastName = '$update_lastname'  , email = '$update_email', dateOfBirth = '$update_dob' WHERE username = '$username'") or die('query failed');

      $query = mysqli_query($conn, $update);

      updateAlert($query);

   }
}

function updatePassword($conn, $username)
{

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

   $hashPassword = password_hash($confirm_pass, PASSWORD_DEFAULT);

   if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
      if ($new_pass != $confirm_pass) {
         $error = 'Invalid password';
         header("location: update_profile.php?error=$error");
         die();
      } else {

         $update_pass_query = ("UPDATE `users` SET password = '$hashPassword' WHERE username = '$username'") or die('query failed');

         $query = mysqli_query($conn, $update_pass_query);

         updateAlert($query);

      }
   }

}

function updateProfileImage($conn, $username)
{

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $error = 'Image is too large';
         header("location: update_profile.php?error=$error");
         die();
      } else {
         $image_update_query = mysqli_query($conn, "UPDATE `users` SET image = '$update_image' WHERE username = '$username'") or die('query failed');
         if ($image_update_query) {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            updateAlert($image_update_query);
         }

      }
   }

}
/*UPDATE STUDENT PROFILE END*/


/*STUDENT_REGISTER START*/

function registerStudent($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $DOB = mysqli_real_escape_string($conn, $_POST['dob']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $userType = "Student";
   $verifiedStatus = "Not Verified";

   $studentID = mt_rand(1000000, 9999999);
   $grade = $_POST['grade'];

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $encpass = password_hash($pass, PASSWORD_BCRYPT);


   $uppercase = !preg_match('@[A-Z]@', $pass);
   $lowercase = !preg_match('@[a-z]@', $pass);
   $number = !preg_match('@[0-9]@', $pass);
   $specialChars = !preg_match('@[^\w]@', $pass);
   $whiteSpaces = preg_match("/\s/", $pass);
   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


   if (mysqli_num_rows($select) > 0) {
      $error = 'user already exist';
      header("location: student_register.php?error=$error");
      die();

   } elseif ($pass != $cpass) {
      $error = 'confirm password not matched!';
      header("location: student_register.php?error=$error");
      die();
   } elseif ($image_size > 2000000) {
      $error = 'image size is too large!';
      header("location: student_register.php?error=$error");
      die();
   } elseif (strlen($pass) < 8 || $uppercase || $lowercase || $number || $specialChars || $whiteSpaces) {
      $error = "Invalid Password";
      header("location: student_register.php?error=$error");
      die();
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: student_register.php?error=$error");
      die();
   } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstname) || (!preg_match("/^[a-zA-Z-' ]*$/", $lastname))) {
      $error = "Invalid name format";
      header("location: student_register.php?error=$error");
      die();
   } else {
      $insertUser = ("INSERT INTO users (username, password,firstName, lastName, dateOfBirth , email,image, verifiedStatus, userType) 
      values('$username','$encpass','$firstname','$lastname', '$DOB', '$email' , '$image' , '$verifiedStatus' , '$userType')") or die('query failed');

      $query = mysqli_query($conn, $insertUser);

      if ($query == 1) {

         foreach ($grade as $gradeList) {

            $insertStudent = "INSERT INTO student (studentID, username,gradeID) 
            values('$studentID','$username','$gradeList')";

            $query = mysqli_query($conn, $insertStudent);

         }

         if ($query == 1) {
            move_uploaded_file($image_tmp_name, $image_folder);
            insertAlert($query);
            die();
         }
      }

   }
}
/*STUDENT_REGISTER END*/


/*TUTOR REGISTER START*/
function registerTutor($conn)
{
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $DOB = mysqli_real_escape_string($conn, $_POST['dob']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $phoneNo = mysqli_real_escape_string($conn, $_POST['phoneNo']);
   $streetNumber = mysqli_real_escape_string($conn, $_POST['streetNo']);
   $streetName = mysqli_real_escape_string($conn, $_POST['streetName']);
   $region = mysqli_real_escape_string($conn, $_POST['region']);
   $town = mysqli_real_escape_string($conn, $_POST['town']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $postalCode = mysqli_real_escape_string($conn, $_POST['postal']);
   /*$overallRating = 0.0;*/
   $hourlyRate = mysqli_real_escape_string($conn, $_POST['hourlyRate']);
   $yearsOfExperience = mysqli_real_escape_string($conn, $_POST['teachingExperience']);
   $userType = "Tutor";
   $verifiedStatus = "Not Verified";
   $isVerified = 0;

   $subjects = $_POST['subjects'];

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $document = $_FILES['filename']['name'];
   $document_size = $_FILES['filename']['size'];
   $document_tmp_name = $_FILES['filename']['tmp_name'];
   $document_folder = 'uploaded_document/' . $document;

   $encpass = password_hash($pass, PASSWORD_BCRYPT);
   $tutorID = mt_rand(1000000, 9999999);
   $addressID = mt_rand(1000000, 9999999);

   $uppercase = !preg_match('@[A-Z]@', $pass);
   $lowercase = !preg_match('@[a-z]@', $pass);
   $number = !preg_match('@[0-9]@', $pass);
   $specialChars = !preg_match('@[^\w]@', $pass);
   $whiteSpaces = preg_match("/\s/", $pass);
   $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select) > 0) {
      $error = 'user already exist';
      header("location: tutor_register.php?error=$error");
      die();
   } elseif ($pass != $cpass) {
      $error = 'confirm password not matched!';
      header("location: tutor_register.php?error=$error");
      die();


   } elseif (strlen($pass) < 8 || $uppercase || $lowercase || $number || $specialChars || $whiteSpaces) {
      $error = "Invalid Password";
      header("location: tutor_register.php?error=$error");
      die();

   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: tutor_register.php?error=$error");
      die();
   } elseif ($image_size > 2000000) {
      $error = 'image size is too large!';
      header("location: tutor_register.php?error=$error");
      die();
   } elseif ($document_size > 5000000) {
      $error = 'document size is too large!';
      header("location: tutor_register.php?error=$error");
      die();
   } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstname) || (!preg_match("/^[a-zA-Z-' ]*$/", $lastname))) {
      $error = "Invalid field format";
      header("location: tutor_register.php?error=$error");
      die();
   } elseif (strlen($phoneNo) < 10 || strlen($phoneNo) > 10) {
      $error = "Invalid phone number format";
      header("location: tutor_register.php?error=$error");
      die();
   } else {

      $sqlUsers = "INSERT INTO users (username, password,firstName, lastName, dateOfBirth , email,image, verifiedStatus, userType) 
      values('$username','$encpass','$firstname','$lastname', '$DOB', '$email' , '$image' , '$verifiedStatus' , '$userType')";

      $sqlTutor = "INSERT INTO tutor (tutorID, username, phoneNumber , yearsOfExperience, email, hourlyRate, qualification, isVerified) 
      values('$tutorID','$username','$phoneNo','$yearsOfExperience','$email' ,'$hourlyRate', '$document' , '$isVerified')";

      $sqlAddress = "INSERT INTO address(addressID,username, streetNumber,streetName, region , town , city, postalCode)
values('$addressID','$username','$streetNumber','$streetName','$region' , '$town' , '$city', '$postalCode')";




      $query = mysqli_query($conn, $sqlUsers);

      if ($query == 1) {
         $query = mysqli_query($conn, $sqlTutor);


         if ($query == 1) {
            $query = mysqli_query($conn, $sqlAddress);

            if ($query == 1) {

               foreach ($subjects as $subjectList) {

                  $sqlSubject = "INSERT INTO assign_subject_tutor (username,subject_id) 
            values('$username','$subjectList')";

                  $query = mysqli_query($conn, $sqlSubject);

               }

               if ($query == 1) {
                  move_uploaded_file($image_tmp_name, $image_folder);
                  move_uploaded_file($document_tmp_name, $document_folder);
                  insertTutorAlert();
                  die();
               }
            }
         }
      }
   }
}


function makePayment($amount, $conn)
{
   $email = $_SESSION['email'];
   $username = $_SESSION['username'];
   $fee = 320.00;
   $paymentMade = true;

   $sql = "INSERT INTO payment(tutorUsername, amount,email, fee,paymentMade) VALUES('$username', '$amount','$email', '$fee','$paymentMade')";
   //$updatePayment = ("UPDATE `payment` SET paymentMade = $paymentMadeUpdate' WHERE tutorUsername = '$username'") or die('query failed');

   $queryInsert = mysqli_query($conn, $sql);
   //$queryUpdate = mysqli_query($conn, $updatePayment);



   if (!$queryInsert) {
      echo 'error occurred while adding to connections ';
   } else {
      paymentAlert($queryInsert);
   }

   //updateAlert($queryUpdate);

}
