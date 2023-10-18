<?php
function insertAlert($query)
{

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Admin has been successfully registered",
            icon: "success",
         }).then(function () {
            window.location = "index.php";
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
            window.location = "index.php";
         });

      </script>

      <?php

   }
}


function applicationAcceptedAlert($query)
{
   $username = $_SESSION['username'];   

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Your application has been approved",
            icon: "success",
         }).then(function () {
            window.location.href = 'http://localhost/tutor/admin/index.php';
         });
      </script>

      <?php

   }
}
function applicationRejectedAlert()
{
   

   
      ?>
      <script>
         swal({
            title: "Success",
            text: "Your application has been rejected",
            icon: "success",
         }).then(function () {
            window.location = "index.php";
         });

      </script>

      <?php

   }

function deleteAdminAlert($query)
{

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Admin has been successfully deleted",
            icon: "success",
         }).then(function () {
            window.location = "index.php";
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


function deleteStudentAlert($query)
{

   if ($query) {
      ?>
      <script>
         swal({
            title: "Success",
            text: "Student has been successfully deleted",
            icon: "success",
         }).then(function () {
            window.location = "index.php";
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

function registerAdmin($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));
   $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $DOB = mysqli_real_escape_string($conn, $_POST['dob']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $userType = "Admin";

   $adminID = mt_rand(1000000, 9999999);

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
      header("location: index.php?error=$error");
      die();

   } elseif ($pass != $cpass) {
      $error = 'confirm password not matched!';
      header("location: index.php?error=$error");
      die();
   } elseif ($image_size > 2000000) {
      $error = 'image size is too large!';
      header("location: index.php?error=$error");
      die();
   } elseif (strlen($pass) < 8 || $uppercase || $lowercase || $number || $specialChars || $whiteSpaces) {
      $error = "Invalid Password";
      header("location: index.php?error=$error");
      die();
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: index.php?error=$error");
      die();
   } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $firstname) || (!preg_match("/^[a-zA-Z-' ]*$/", $lastname))) {
      $error = "Invalid name format";
      header("location: index.php?error=$error");
      die();
   } else {

      $insert = ("INSERT INTO users (username, password,firstName, lastName, dateOfBirth , email,image, userType) 
      values('$username','$encpass','$firstname','$lastname', '$DOB', '$email' , '$image' , '$userType')") or die('query failed');
      $query = mysqli_query($conn, $insert);

      if ($query == 1) {
         move_uploaded_file($image_tmp_name, $image_folder);
         if ($query == 1) {
            $insertAdmin = ("INSERT INTO admin (adminID, username) values('$adminID','$username')") or die('query failed');
            $query = mysqli_query($conn, $insertAdmin);
            insertAlert($query);

         }

      }

   }
}


function deleteAdmin($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $deleteAdmin = "DELETE FROM users WHERE username = '$username'";

   $deleteAdmin1 = "DELETE FROM admin WHERE username = '$username'";

   $deleteQuery = mysqli_query($conn, $deleteAdmin);

   $deleteQuery1 = mysqli_query($conn, $deleteAdmin1);



   if ($deleteQuery === TRUE && $deleteQuery1 === TRUE) {

      deleteAdminAlert($deleteQuery);

   } else {
      echo "Error deleting data: " . $conn->error;
   }
}

function deleteStudent($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $deleteStudent = "DELETE FROM users WHERE username = '$username'";

   $deleteStudent1 = "DELETE FROM student WHERE username = '$username'";

   $deleteQuery = mysqli_query($conn, $deleteStudent);

   $deleteQuery1 = mysqli_query($conn, $deleteStudent1);



   if ($deleteQuery === TRUE && $deleteQuery1 === TRUE) {

      deleteAdminAlert($deleteQuery);

   } else {
      echo "Error deleting data: " . $conn->error;
   }
}

function deleteTutor($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $deleteTutor = "DELETE FROM users WHERE username = '$username'";

   $deleteTutor1 = "DELETE FROM tutor WHERE username = '$username'";

   $deleteTutor2 = "DELETE FROM address WHERE username = '$username'";

   $deleteTutor3 = "DELETE FROM assign_subject_tutor WHERE username = '$username'";

   $deleteQuery = mysqli_query($conn, $deleteTutor);

   $deleteQuery1 = mysqli_query($conn, $deleteTutor1);

   $deleteQuery2 = mysqli_query($conn, $deleteTutor2);

   $deleteQuery3 = mysqli_query($conn, $deleteTutor3);



   if ($deleteQuery === TRUE && $deleteQuery1 === TRUE && $deleteQuery2 === TRUE && $deleteQuery3 === TRUE) {

      deleteAdminAlert($deleteQuery);

   } else {
      echo "Error deleting data: " . $conn->error;
   }
}


function updateAdminDetails($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $update_email = mysqli_real_escape_string($conn, $_POST['email']);
   $update_firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $update_lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $update_dob = mysqli_real_escape_string($conn, $_POST['dob']);

   if (!filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: index.php?error=$error");
      die();
   } elseif ((!preg_match("/^[a-zA-Z-' ]*$/", $update_firstname)) || (!preg_match("/^[a-zA-Z-' ]*$/", $update_lastname))) {
      $error = 'Invalid name';
      header("location: index.php?error=$error");
      die();
   } else {
      $update = ("UPDATE `users` SET  firstName = '$update_firstname' , lastName = '$update_lastname'  , email = '$update_email', dateOfBirth = '$update_dob' WHERE username = '$username'") or die('query failed');

      $query = mysqli_query($conn, $update);

      updateAlert($query);

   }
}


function updateStudentPassword($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $update_pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['cpassword']));

   $hashPassword = password_hash($confirm_pass, PASSWORD_DEFAULT);

   if (!empty($update_pass)  || !empty($confirm_pass)) {
      if ($update_pass != $confirm_pass) {
         $error = 'Invalid password';
         header("location: index.php?error=$error");
         die();
      } else {

         $update_pass_query = ("UPDATE `users` SET password = '$hashPassword' WHERE username = '$username'") or die('query failed');

         $query = mysqli_query($conn, $update_pass_query);

         updateAlert($query);

      }
   }

}



function updateStudentProfileImage($conn)
{
   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $error = 'Image is too large';
         header("location: index.php?error=$error");
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




function updateStudentDetails($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $update_email = mysqli_real_escape_string($conn, $_POST['email']);
   $update_firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
   $update_lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
   $update_dob = mysqli_real_escape_string($conn, $_POST['dob']);
   $update_grade = mysqli_real_escape_string($conn, $_POST['grade']);
  

   if (!filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: index.php?error=$error");
      die();
   } elseif ((!preg_match("/^[a-zA-Z-' ]*$/", $update_firstname)) || (!preg_match("/^[a-zA-Z-' ]*$/", $update_lastname))) {
      $error = 'Invalid name';
      header("location: index.php?error=$error");
      die();
   } else {
      $update = ("UPDATE `users` SET  firstName = '$update_firstname' , lastName = '$update_lastname'  , email = '$update_email', dateOfBirth = '$update_dob' WHERE username = '$username'") or die('query failed');
      $update1 = ("UPDATE `student` SET  gradeID = '$update_grade' WHERE username = '$username'") or die('query failed');

      $updateQuery = mysqli_query($conn, $update);
      $updateQuery1 = mysqli_query($conn, $update1);

      if ($updateQuery === TRUE && $updateQuery1 === TRUE) {
   
         updateAlert($updateQuery);
   
      } else {
         echo "Error deleting data: " . $conn->error;
      }

   }
}


function updateAdminPassword($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $update_pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['cpassword']));

   $hashPassword = password_hash($confirm_pass, PASSWORD_DEFAULT);

   if (!empty($update_pass)  || !empty($confirm_pass)) {
      if ($update_pass != $confirm_pass) {
         $error = 'Invalid password';
         header("location: index.php?error=$error");
         die();
      } else {

         $update_pass_query = ("UPDATE `users` SET password = '$hashPassword' WHERE username = '$username'") or die('query failed');

         $query = mysqli_query($conn, $update_pass_query);

         updateAlert($query);

      }
   }

}



function updateAdminProfileImage($conn)
{
   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $error = 'Image is too large';
         header("location: index.php?error=$error");
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




function updateTutorDetails($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
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

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = 'Invalid email';
      header("location: index.php?error=$error");
      die();
   } elseif ((!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) || (!preg_match("/^[a-zA-Z-' ]*$/", $lastname))) {
      $error = 'Invalid name';
      header("location: index.php?error=$error");
      die();
   } elseif (strlen($phoneNo) < 10 || strlen($phoneNo) > 10 ) {
      $error = "Invalid phone number format";
      header("location: index.php?error=$error");
      die();
   }
   
   else {

      $username = mysqli_real_escape_string($conn, $_POST['username']);

      $updateTutor = ("UPDATE `users` SET  firstName = '$firstname' , lastName = '$lastname'  , email = '$email', dateOfBirth = '$DOB' WHERE username = '$username'") or die('query failed');
   
      $updateTutor1 = ("UPDATE `tutor` SET  phoneNumber = '$phoneNo' , hourlyRate = '$hourlyRate'  , yearsOfExperience = '$yearsOfExperience' WHERE username = '$username'") or die('query failed');

      $updateTutor2 = ("UPDATE `address` SET  streetNumber = '$streetNumber' , streetName = '$streetName'  , region = '$region', town = '$town', city = '$city' ,postalCode = '$postalCode'  WHERE username = '$username'") or die('query failed');
   
      $updateQuery  = mysqli_query($conn, $updateTutor);
   
      $updateQuery1 = mysqli_query($conn, $updateTutor1);

      $updateQuery2  = mysqli_query($conn, $updateTutor2);
   
   
   
      if ($updateQuery === TRUE && $updateQuery1 === TRUE && $updateQuery2 === TRUE) {
   
         updateAlert($updateQuery);
   
      } else {
         echo "Error deleting data: " . $conn->error;
      }

      

   }
}


function updateTutorPassword($conn)
{

   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $update_pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['cpassword']));

   $hashPassword = password_hash($confirm_pass, PASSWORD_DEFAULT);

   if (!empty($update_pass)  || !empty($confirm_pass)) {
      if ($update_pass != $confirm_pass) {
         $error = 'Invalid password';
         header("location: index.php?error=$error");
         die();
      } else {

         $update_pass_query = ("UPDATE `users` SET password = '$hashPassword' WHERE username = '$username'") or die('query failed');

         $query = mysqli_query($conn, $update_pass_query);

         updateAlert($query);

      }
   }

}



function updateTutorUploadFiles($conn)
{
   $username = mysqli_real_escape_string($conn, $_POST['username']);

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/' . $update_image;

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $error = 'Image is too large';
         header("location: index.php?error=$error");
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



?>