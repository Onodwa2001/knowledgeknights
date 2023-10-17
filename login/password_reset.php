
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>

   <!-- custom css file link  -->
   
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 

</head>

<body>
<div class="form-container">
     
       <form action="includes/reset.php" method="post" enctype="multipart/form-data">
           <h3>Reset Password</h3>

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

           <p>Create a new password.</p>
           <div class="inputBox">
               <input type="text" name="token" hidden value="<?php echo $_GET['token']?>">
               <input type="email" name="email" hidden value="<?php echo $_GET['email']?>" >
               <span>New Password</span>
               <div class="password-container">
                  <input type="password" name="new_pass" id="id_password" placeholder="enter new password" class="box">
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

               <span>Confirm Password</span>
               <div class="password-container">
                  <input type="password" name="confirm_pass"  placeholder="confirm new password" class="box">
               </div>
            </div>
         <input type="submit" value="Reset Password" name="submit" class="btn">
       </form>

   </div>
   <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

   <script src="js/script.js"></script>
</body>

</html>