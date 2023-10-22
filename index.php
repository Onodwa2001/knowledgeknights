<?php 
    session_start();


    $username = '';

    
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        if (isset($_GET['logout'])) {
            unset($username);
            session_destroy();
            header('location: login/login.php');
        }
    }

    // if (!isset($username)) {
    //     header('location: login/login.php');
    // };

    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        session_destroy();
        header('location: login/login.php');
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./stylesheets/style.css">
    <script src="https://kit.fontawesome.com/b85ed99f08.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="./login/css/student_dashboard.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">

                <img style="width:200px; margin-left:100px" src="login/uploaded_img/logo-no-background.png" alt="">
            </div>
           
            <ul>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="index.php?id=<?php echo $_GET['id']; ?>">Home</a></li>
                    <li><a href="about/about.php?id=<?php echo $_GET['id']; ?>">About</a></li>

                    <?php if ($_SESSION['userType'] !== 'Tutor') { ?>
                        <li><a href="search.php?id=<?php echo $_GET['id']; ?>">Find a tutor</a></li>
                    <?php } ?>

                    <li><a href="ContactUs/contact.php?id=<?php echo $_GET['id']; ?>">Contact</a></li>

                    <?php if ($_SESSION['userType'] === 'Tutor') { ?>
                        <li><a href="invites.php?id=<?php echo $_GET['id']; ?>">Invites</a></li>
                    <?php } ?>

                    <li>
                        <?php
                            include('./db_connect/connect.php');

                            // $username = $_SESSION['username'];

                            $select = mysqli_query($connection, "SELECT * FROM `users` WHERE username = '$username'") or die('query failed');
                            if (mysqli_num_rows($select) > 0) {
                                $fetch = mysqli_fetch_assoc($select);
                            }
                            if ($fetch['image'] == '') {
                                echo  '<img onclick="toggleMenu()" class="user-pic" src="login/images/default-avatar.png" >';
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

                            <a href="./login/update_profile.php" class="sub-menu-link">
                                <img src="login/images/profile.png" alt="">
                                <p>Edit Profile</p>
                                <span>></span>

                            </a>

                            <a href="#" class="sub-menu-link">
                                <img src="login/images/setting.png" alt="">
                                <p>Settings & Privacy</p>
                                <span>></span>

                            </a>

                            <a href="#" class="sub-menu-link">
                                <img src="login/images/help.png" alt="">
                                <p>Help & Support</p>
                                <span>></span>

                            </a>

                            <a href="login/login.php" name="logout" class="sub-menu-link">
                                <img src="login/images/logout.png" alt="">
                                <p>Logout</p>
                                <span>></span>

                                <!-- <form action="" method="POST">
                                    <button name="logout">Logout</button>
                                    <span>></span>
                                </form> -->
                            </a>

                            </div>
                        </div>

                    </li>
                <?php } else { ?>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about/about.php">About</a></li>
                    <li><a href="search.php">Find a tutor</a></li>
                    <li><a href="ContactUs/contact.php">Contact</a></li>
                    <li><a href="invites.php">Invites</a></li>
                    <li><a href="login/login.php">Log in</a></li>
                <?php } ?>
                
            </ul>
        </nav>

        <div class="welcome-wrapper">
            <div class="welcome">
                <h1>Knowledge Knights</h1>
                <hr class="line" />
                <p>Level up your Knowledge!</p>
                <div class="get-started">
                    <a href="">GET STARTED</a>
                </div>
            </div>
        </div>
    </header>

    <main>

        <?php 
        
            if (isset($_SESSION['username'])) {
                include('./chat/chatPopup.php');
                include('./chat/sendmessage.php'); 
        ?>

        <div id="popup-trigger">
            <i class="fa-solid fa-comment" style="font-size: 40px;"></i>
        </div>

        <?php } ?>

    </main>

    <footer>

    </footer>

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



    <script>
        if (sessionStorage.getItem('state') === 'open') {
            document.querySelector('.chat').style.display = "block"; 
            document.getElementById("popup-trigger").style.display = "none";
        } else {
            document.querySelector('.chat').style.display = "none"; 
            document.getElementById("popup-trigger").style.display = "block";
        }

        // if clicked on trigger, send a session object with value of open
        document.querySelector('#popup-trigger').addEventListener('click', (e) => {
            sessionStorage.setItem('state', 'open');
            location.reload();
        });

        // if clicked on x, send session object with value of close
        document.querySelector('.close').addEventListener('click', (e) => {
            sessionStorage.setItem('state', 'close');
            location.reload();
        });
    </script>
</body>
</html>