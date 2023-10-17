<?php 

    session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link rel="stylesheet" type="text/css" href="Contact CSS.css">
    <link rel="stylesheet" type="text/css" href="Contact CSS2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <header>
        <nav>
            <div class="logo">Logo</div>

            <ul>
                <li><a href="index.php?id=<?php echo $_GET['id']; ?>">Home</a></li>
                <li><a href="about/about.php?id=<?php echo $_GET['id']; ?>">About</a></li>

                <?php if ($_SESSION['userType'] !== 'Tutor') { ?>
                    <li><a href="search.php?id=<?php echo $_GET['id']; ?>">Find a tutor</a></li>
                <?php } ?>

                <li><a href="ContactUs/contact.php?id=<?php echo $_GET['id']; ?>">Contact</a></li>

                <?php if ($_SESSION['userType'] === 'Tutor') { ?>
                    <li><a href="invites.php?id=<?php echo $_GET['id']; ?>">Invites</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <div class="inner-body">
        <div class="formBox">
            <h2>Contact Us</h2>
            <p>You will hear from us at the earliest!</p>
            <form action="#">
                <div class="nameInp">
                    <i class="fa fa-user icon"></i>
                    <input type="text" placeholder="Full Name" name="name" id="name">

                </div>
                <div class="mailInp">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="mail" id="mail" placeholder="Email">
                </div>
                <div class="phoneInp">
                    <i class="fa-solid fa-phone"></i>
                    <input type="number" name="phone" id="phone" placeholder="Phone" min="100000" max="9999999999">
                </div>
                <div class="queryInp">
                    <textarea name="query" id="query" cols="30" rows="5" placeholder="Any comment or your query"></textarea>
                </div>
                <div class="submitBtn">
                    <button id="btn" onclick="notif()">Send</button>
                </div>
            </form>
            <p class="extra">You can also contact us at +27-60-876-8543</p>
        </div>
    </div>

</body>

<footer>
    <p>&copy; 2023 Knowledge Knights. All rights reserved.</p>
</footer>