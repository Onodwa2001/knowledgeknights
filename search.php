<?php 

    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: GET, POST");
    // header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");

    // $people = array();

    // if (isset($_POST['data'])) {
    //     $searchResult = json_decode($_POST['data'], true);
    //     $people = $searchResult;
    // }

    session_start();

    $username = '';

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }

    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        header('location: login/login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesheets/style.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
    crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
    crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>

    <script src="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest-maps.css"/>

    <!-- <script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script> -->
    <!-- <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css"/> -->

    <script src="https://kit.fontawesome.com/b85ed99f08.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./login/css/student_dashboard.css">

</head>
<body>
    
    <header>
        <nav>
            <div class="logo">Logo</div>

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

                            <a href="login/login.php" class="sub-menu-link">
                                <img src="login/images/logout.png" alt="">
                                <form action="" method="POST">
                                    <button name="logout">Logout</button>
                                </form>
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
    </header>

    <main class="search-main">
        <aside>
            <br/>
            <h3 style="color: white">Filter</h3>
            <br/>
            <div class="filters">
                <select name="AREA" id="area-filter">
                    <option value="">AREA</option>
                    <option value="Mitchelles Plain">MITCHELLES PLAIN</option>
                    <option value="Khayelitsha">KHAYELITSHA</option>
                    <option value="Manenberg">MANENBERG</option>
                    <option value="Kuils River">KUILS RIVER</option>
                    <option value="Philippi">PHILIPPI</option>
                </select> <br/><br/>
                <select name="SUBJECT" id="subject-filter">
                    <option value="">SUBJECT</option>
                    <option value="Mathematics">MATHEMATICS</option>
                    <option value="Life Sciences">LIFE SCIENCES</option>
                    <option value="Accounting">ACCOUNTING</option>
                    <option value="Mathematical Literacy">MATHEMATICAL LITERACY</option>
                    <option value="Physical Sciences">PHYSICAL SCIENCES</option>
                    <option value="Business Studies">BUSINESS STUDIES</option>
                    <option value="Geography">GEOGRAPHY</option>
                    <option value="Information Technology">INFORMATION TECHNOLOGY</option>
                    <option value="Computer Applications Theory">COMPUTER APPLICATIONS THEORY</option>
                    <option value="History">HISTORY</option>
                    <option value="Economics">ECONOMICS</option>
                    <option value="English Home Language">ENGLISH HOME LANGUAGE</option>
                    <option value="English First Additional Language">ENGLISH FIRST ADDITIONAL LANGUAGE</option>
                    <option value="IsiXhosa Home Language">ISIXHOSA HOME LANGUAGE</option>
                    <option value="IsiXhosa First Additional Language">ISIXHOSA FIRST ADDITIONAL LANGUAGE</option>
                    <option value="Afrikaans Home Language">AFRIKAANS HOME LANGUAGE</option>
                    <option value="Afrikaans First Additional Language">AFRIKAANS FIRST ADDITIONAL LANGUAGE</option>
                </select> <br/><br/>
                <select name="PRICE" id="price-filter">
                    <option value="price">PRICE</option>
                    <option value='{"min": 0, "max": 199}'>less than R200/h</option>
                    <option value='{"min": 200, "max": 250}'>R200/h - R250/h</option>
                    <option value='{"min": 250, "max": 300}'>R250/h - R300/h</option>
                </select><br/><br/>

                <button id="filter-btn">Apply Filters</button>
            </div>
        </aside>
        <section class="find">
            <h1 style="font-weight: lighter;">FIND A TUTOR</h1>
            <div class="search-content">
                <div class="map-wrap">
                    <input type="text" name="" placeholder="Who would you like to connect with?" id="person-search-input">
                    <div id="map"></div>
                </div>
                <div class="tutors" id="tutors">
                    
                </div>
            </div>
        </section>

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
    
    <?php include('./script.php'); ?>

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