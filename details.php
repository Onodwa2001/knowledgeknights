<?php 
    
    session_start();

    $user = array();

    include('./db_connect/connect.php');

    function getDataUsingID() {
        global $connection, $user;
        $id = $_GET['id'];

        $sql = "SELECT * FROM tutor JOIN users ON tutor.username = users.username WHERE users.username = '$id'";
        $result = mysqli_query($connection, $sql);
        $user = mysqli_fetch_assoc($result);
    }

    getDataUsingID(); // function call to get data using id

    function sendInvite() {
        global $connection, $user;

        if (isset($_POST['connect'])) {
            $invited = $user['username'];
            $requester = $_SESSION['username'];

            $sql = "INSERT INTO invites(requester, invited) VALUES('$requester', '$invited')";

            if (!mysqli_query($connection, $sql)) {
                echo 'Error while inserting invite';
            }
        }
    }

    sendInvite();

    function alreadySentInvite() {
        global $connection, $user;
        $invited = $user['username'];
        $invites = array();

        $sql = "SELECT * FROM invites WHERE invited = '$invited'";

        $result = mysqli_query($connection, $sql);
        return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result) : 0;
    }


    function cancelRequest() {
        global $connection, $user;
        $requester = $_SESSION['username'];
        $invited = $user['username'];

        $sql = "DELETE FROM invites WHERE invited = '$invited' AND requester = '$requester'";

        if (!mysqli_query($connection, $sql)) {
            echo 'Error while deleting invite';
        }
    }

    if (isset($_POST['cancel_request'])) {
        cancelRequest();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./stylesheets/style.css">

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

    <script src="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.js"></script>
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/place-search-js/v1.0.0/place-search.css"/>
</head>
<body>

    <header>
        <nav>
            <div class="logo">Logo</div>

            <ul>
                <li><a href="index.php?id=<?php echo $_GET['id']; ?>">Home</a></li>
                <li><a href="about/about.php?id=<?php echo $_GET['id']; ?>">About</a></li>
                <li><a href="search.php?id=<?php echo $_GET['id']; ?>">Find a tutor</a></li>
                <li><a href="ContactUs/contact.php?id=<?php echo $_GET['id']; ?>">Contact</a></li>
                <li><a href="invites.php?id=<?php echo $_GET['id']; ?>">Invites</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <div class="profile-card">
            <img src="./images//<?php echo $user['image']; ?>" alt="Profile Picture" class="profile-picture">
            <h2 class="profile-name"><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></h2>
            <p class="profile-description">Math Tutor</p>

            <!-- TODO -->
            <!-- if not your friend -->

            <?php if (isset($_SESSION['username'])) { ?>
                <?php if (!alreadySentInvite()) { ?>
                    <form method="POST">
                        <button id="connect" name="connect">Connect</button>
                    </form>
                <?php } else if (alreadySentInvite()) { ?>
                    <form method="POST">
                        <button id="request-sent" name="request_sent">Request Sent</button>
                        <button id="cancel-request" name="cancel_request">Cancel Request</button>
                    </form>
                <?php } else { ?>
                    You are connected
                <?php } ?>
            <?php } else { ?>
                <a href="login/login.php">Log in to send request</a>
            <?php } ?>
            <!-- else -->
            <!-- <button>Disconnect</button> -->

        </div>

    </main>

    <footer>
        
    </footer>
    
</body>
</html>