<?php

    // include('../db_connect/connect.php');
    include('./db_connect/connect.php');

    // require 'C:/xampp/php/vendor/autoload.php';

    // encryption module
    include('./encryption.php');
    @session_start();

    $receiver = '';

    // $_SESSION['username'] = 'Viggo2001';

    function getAllUnreadMessages() {
        global $connection, $unread_messages;

        $current_logged_in_user = $_SESSION['username'];

        $sql = "SELECT * FROM message WHERE receiverID='$current_logged_in_user' AND isRead = 0";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            $unread_messages = array();

            while($row = mysqli_fetch_assoc($result)) {
                array_push($unread_messages, array('id' => $row['messageID'], 'message' => $row["message"], 'senderID' => $row['senderID'], 'receiverID' => $row['receiverID']));
            }

            return $unread_messages;
        } 
        return null;
    }

    $receiver_records = array();

    // echo $_GET['id'];

    unset($_SESSION['friend']);
    if (isset($_SESSION['friend'])) {
        $_GET['id'] = $_SESSION['friend']; // id of the one I am talking to
    }

    // echo $_GET['id'];


    if (isset($_GET['id'])) {
        $receiver = $_GET['id']; // this value will vary depending on who the sender clicks on

        // echo $receiver;

        $unread_messages = getAllUnreadMessages();

        // print_r($un);

        if ($unread_messages != null) {
            foreach ($unread_messages as $message) {
                if ($_SESSION['username'] === $message['receiverID'] && $_GET['id'] === $message['senderID']) {
                    // update message and make it read
                    $id = $message['id'];

                    $sqlquery = "UPDATE message SET isRead = 1 WHERE userID = '$id'";

                    global $connection;

                    if (mysqli_query($connection, $sqlquery)) {
                        // successfully updated
                    } else {
                        echo "Error: " . $sqlquery . "<br>" . mysqli_error($connection);
                    }
                }
            }
        }

        function getRecordsOfReceiver($receiver) {
            global $connection;
    
            $sql = "SELECT * FROM `users` WHERE username = '$receiver'";
    
            $result = mysqli_query($connection, $sql);

            $data = mysqli_fetch_array($result);

            // print_r($data);
    
            return array('image' => $data['image'], 'username' => $data['username'], 'name' => $data['firstName'] . ' ' . $data['lastName']);
        }
        
        $receiver_records = getRecordsOfReceiver($receiver);
        // echo $receiver_records['username'];

    }

    function getAllMessages() {
        global $connection;

        $id = $_SESSION['username'];

        $sql = "SELECT * FROM message WHERE receiverID = '$id' OR senderID = '$id'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            $messages = array();

            while($row = mysqli_fetch_assoc($result)) {
                array_push($messages, array('senderID' => $row["senderID"], 'receiverID' => $row['receiverID'], 'message' => decrypt($row["message"]), 'timestamp' => $row['time']));
            }

            return $messages;
        } 
        return null;
    }

    $placeholder = '';
    $messages = getAllMessages();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        * {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        body {

        }

        .message {
            background-color: rgb(246, 239, 239);
            max-width: 60%;
            width: fit-content;
            padding: 10px 10px 10px 10px;
            margin-top: 10px;
            border-radius: 10px;
            /* color: white; */
        }

        .chat-space::-webkit-scrollbar {
            display: none;
        }

        .message p {
            font-size: 12px;
        }

        .messages {
            padding: 10px;
            min-width: 300px;
        }

        .Them {
            background-color: rgb(246, 239, 239);
            color: black;
        }

        .Me {
            color: white;
            /* background-color: #3b71ca; */
            background-color: rgb(146, 102, 187);
            margin-left: auto;
            margin-right: right;
        }

        .chat-wrap {
            /* width: 600px; */
            margin: auto auto;
        }

        .chat_space {
            height: 400px;
            overflow-y: scroll;
            display: flex;
            flex-direction: column-reverse;
            /* background-color: #ddefff; */
            background-color: #e7d4ed;
        }

        .topbar {
            display: flex;
            /* background-color: #3b71ca; */
            background-color: rgb(146, 102, 187);
            padding: 10px;
            color: white;
            border-radius: 0 8px 8px 0;
        }

        .topbar h3 {
            margin-top: 15px;
            margin-left: 10px;
        }

        #messageFrom {
            width: 100%;
            display: flex;
            padding: 10px 0px 10px 0px;
            position: relative;
        }

        #messageFrom textarea {
            width: 78%;
            border-radius: 8px;
            padding: 10px 10px 10px 10px;
            border: none;
            outline: none;
        }

        #messageFrom button {
            position: absolute;
            padding: 10px;
            border-radius: 8px;
            border: none;
            right: 10px;
        }

        #messageFrom button:hover {
            cursor: pointer;
        }

        .image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .image img {
            object-fit: cover;
            border-radius: 50%;
        }
    </style>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body onload="refreshChat();">
    

    <div class="chat-wrap">
        <a href="details.php?id=<?php echo $receiver_records['username']; ?>" style="text-decoration: none">
            <div class="topbar">
                <div class="image">
                    <img src="uploads/<?php echo $receiver_records['image'] === '' ? '6522516.png' : $receiver_records['image']; ?>" alt="profile picture" height="50px" width="50px" />
                </div>
                <h3 style="font-size: 16px;"><?php echo $receiver_records['name']; ?></h3>
            </div>
        </a>
        
        <div id="chat_space" class="chat_space">
            <div class="messages" id="messages">

                <?php if ($messages > 0) { ?>
                    <?php foreach($messages as $message) : ?>
                        <?php $receiver = $receiver; // string to int conversion ?>
                        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $message['senderID'] && $receiver === $message['receiverID'] 
                        || $receiver === $message['senderID'] && $_SESSION['username'] === $message['receiverID']) { ?>
                            <div class="message <?php 
                                    if ($_SESSION['username'] === $message['senderID']) {
                                        $placeholder = 'Me';
                                    } else {
                                        $placeholder = 'Them';
                                    }

                                    echo $placeholder;
                
                                ?>">
                                <p><?php echo $message['message']; ?></p>
                                <h5 style="font-weight: lighter; font-size: 8px; margin-top: 10px;"><?php echo date('H.i.s A', strtotime($message['timestamp'])); ?></h5>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <p>No messages yet, start a conversation</p>
                <?php } ?>

            </div>
        </div>
        <hr />
        
        <form action="" method="POST" id="messageFrom">
            <textarea name="message2" id="message2" rows="1" placeholder="Say something to <?php echo $receiver_records['name']; ?>"></textarea>
            <button type="submit">Send</button>
        </form>

        <div id="x"></div>
    </div>


    <script type="text/javascript">

        const element = document.getElementById('chat_space');
        
        function refreshChat(){
            $('#messages').load(location.href + " #messages");
        }

        setInterval(function(){
            refreshChat();
        }, 100);

        let destination = location.pathname.split('/')[location.pathname.split('/').length - 1]; // current file the chatroom is being loaded
        let idParam = location.search.split("=")[1];

        let sendViaAjax = () => {
            let inputMessage = document.getElementById('message2').value;

            // send the JSON data via AJAX
            const xhr = new XMLHttpRequest();
            // xhr.open("POST", "chat/sendmessage.php", true);
            xhr.open("POST", destination, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    // Handle the server response
                    console.log(this.responseText);
                }
            };

            // Send the AJAX request with the input data
            const data = "message=" + encodeURIComponent(inputMessage + "&(##NdklsajcJLio421eggfkdoolq,dsp&(304-_284772840kkjfncoe*302" + idParam);
            xhr.send(data);
        }
        

        // send data to PHP using enter key
        document.getElementById("message2").addEventListener("keydown", function(event) {
            // prevent the default form submission behavior
            // event.preventDefault();

            if (event.key === 'Enter') {
                sendViaAjax(); // trigger function
                document.getElementById("message2").value = '';
            }
        });

        // send data to PHP using submit button
        document.getElementById("messageFrom").addEventListener("submit", function(event) {
            // prevent the default form submission behavior
            event.preventDefault();
            sendViaAjax(); // trigger function
            document.getElementById("message2").value = '';
        });


    </script>

</body>
</html>