<?php 


    // $_SESSION['username'] = 'Viggo2001'; 
    $_SESSION['role'] = 'student';

    include('./db_connect/connect.php');

    function getAllMyFriends() {
        global $connection;
        $friends = array();

        $loggedUser = $_SESSION['username']; // logged in user

        $sql = "SELECT DISTINCT users.username, users.firstName, users.lastName FROM connections 
        JOIN users ON users.username = connections.username1 OR users.username = connections.username2
        JOIN message
        WHERE connections.username1 = '$loggedUser' OR connections.username2 = '$loggedUser' ORDER BY message.time DESC";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($friends, $row);
            }
        }

        return $friends;
    }

    $friends = getAllMyFriends();

?>

<style>
    .chat {
        width: 500px;
        position: fixed;
        right: 50px;
        bottom: 0;
        box-shadow: 0 10px 14px 0 rgba(0, 0, 0, 0.2);
    }

    .chat .close {
        width: fit-content;
        margin-left: auto;
        margin-right: right;
        cursor: pointer;
    }

    .chat i {
        font-size: 26px;
    }

    .chatPart {
        background-color: white;
        border-radius: 8px;
    }

    .popup-wrapper {
        display: flex;
    }

    .friends-wrap {
        background-color: white;
        width: 180px;
        border-radius: 8px 0 0 8px;
    }

    .friend {
        padding: 15px;
        border-bottom: solid gray 1px;
    }

    .heading {
        padding: 24px 0 24px 10px;
        border-bottom: solid gray 1px;
    }

    .friends a {
        text-decoration: none;
    }

    .friend {
        cursor: pointer;
        color: black;
    }

</style>

<div class="chat">
    <div class="close"><i class="fa-solid fa-square-xmark"></i></div>
    
    <div class="popup-wrapper">
        <div class="friends-wrap">
            <div class="heading">
                <h3>Friends</h3>
            </div>

            <div class="friends">
                <?php foreach($friends as $friend) { 
                        if ($friend['username'] != $_SESSION['username']) {
                ?>
                    <a href="?id=<?php echo $friend['username']; ?>"><div class="friend"><?php echo $friend['firstName']; ?></div></a>
                <?php }} ?>
            </div>
        </div>
        <div class="chatPart" id="chatPart">
            <?php 
                include('chatroom.php');
            ?>
        </div>
    </div>
    
</div>