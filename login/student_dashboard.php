<?php

include 'includes/config.php';
session_start();
$username = $_SESSION['username'];

if (!isset($username)) {
   header('location:login.php');
};

if (isset($_GET['logout'])) {
   unset($username);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/student_dashboard.css">

</head>
<style>

</style>

<body>
   <div class="hero">
      <nav>

         <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
         </ul>

         <?php
         $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username'") or die('query failed');
         if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
         }
         if ($fetch['image'] == '') {
            echo  '<img onclick="toggleMenu()" class="user-pic" src="images/default-avatar.png" >';
         } else {
            echo '<img onclick="toggleMenu()" class="user-pic"  src="uploaded_img/' . $fetch['image'] . '">';
         }
         ?>
         <div class="sub-menu-wrap" id="subMenu">
            <div class="sub-menu">
               <div class="user-info">
                  <img src="images/user.png" alt="">
                  <h3><?php echo $fetch['firstName']; ?></h3>

               </div>

               <hr>

               <a href="update_profile.php" class="sub-menu-link">
                  <img src="images/profile.png" alt="">
                  <p>Edit Profile</p>
                  <span>></span>

               </a>

               <a href="#" class="sub-menu-link">
                  <img src="images/setting.png" alt="">
                  <p>Settings & Privacy</p>
                  <span>></span>

               </a>

               <a href="#" class="sub-menu-link">
                  <img src="images/help.png" alt="">
                  <p>Help & Support</p>
                  <span>></span>

               </a>

               <a href="login.php" class="sub-menu-link">
                  <img src="images/logout.png" alt="">
                  <p>Logout</p>
                  <span>></span>

               </a>

            </div>
         </div>
      </nav>
   </div>

   <script>
      let subMenu = document.getElementById("subMenu")

      function toggleMenu() {
         subMenu.classList.toggle("open-menu");
      }
   </script>
   <script>
      // Toggle responsive menu
      const toggleMenu = () => {
         const menu = document.querySelector('nav ul');
         menu.classList.toggle('active');
      }

      // Add click event to responsive menu button
      const menuButton = document.querySelector('.menu-button');
      menuButton.addEventListener('click', toggleMenu);
   </script>


</body>

</html>