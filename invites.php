<?php 

    session_start();

    include('./db_connect/connect.php');

    function getAllInvites() {
        global $connection;
        $username = $_SESSION['username'];
        $data = array();

        $sql = "SELECT * FROM invites
                JOIN users ON users.username = invites.requester
                WHERE invited = '$username'";

        $result = mysqli_query($connection, $sql);

        while ($rec = mysqli_fetch_assoc($result)) {
            array_push($data, $rec);
        }

        return $data;
    }

    $currentURL = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $delimiter = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . strtok($_SERVER['REQUEST_URI'], '?');

    function addToConnections($usernameParam) {
        global $connection, $currentURL;

        $username = $_SESSION['username'];
        $username2 = $usernameParam;

        $sql = "INSERT INTO connections(username1, username2) VALUES('$username', '$username2')";

        if (!mysqli_query($connection, $sql)) {
            echo 'error occurred while adding to connections ';
        }
    }

    function deleteInvite($inviter) {
        global $connection;
        $loggedUser = $_SESSION['username'];

        $sql = "DELETE FROM invites WHERE requester = '$inviter' AND invited = '$loggedUser'";

        if (!mysqli_query($connection, $sql)) {
            echo 'error occurred while removing invites ';
        }
    }

    if (isset($_POST['confirm'])) {
        // $inviter = explode($delimiter . '?id=', $currentURL)[1];
        $inviter = $_POST['confirm'];

        deleteInvite($inviter);
        addToConnections($inviter);
        echo '<script>alert("Friend request accepted");</script>';
        echo '<script>location.href = "' . $currentURL . '" </script>';
    } else if (isset($_POST['remove'])) {
        $inviter = $_POST['remove'];

        deleteInvite($inviter);
        echo '<script>location.href = "' . $currentURL . '" </script>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/b85ed99f08.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheets/style.css">
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

        <div class="invites-container">
            <h1>Connection requests</h1>    

            <?php if (sizeof(getAllInvites()) > 0) { ?>
                <?php foreach(getAllInvites() as $invite) { ?>
                    <div class="invite">
                        <img class="invite-image" src="person1.jpg" alt="Person 1">
                        <h3 class="card-name"><?php echo $invite['firstName']; ?></h3>
                        <div class="accept-btn">
                            <form method="POST">
                                <button name="confirm" value="<?php echo $invite['username']; ?>">Confirm</button>
                                <button name="remove" value="<?php echo $invite['username']; ?>">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                No invites yet
            <?php } ?>
            
        </div>

    </main>
    
</body>
</html>