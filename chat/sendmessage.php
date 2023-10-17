<?php 

    // include('../db_connect/connect.php');
    include('C:/xampp/htdocs/tutor/db_connect/connect.php');

    // if (!isset($_GET['id'])) {
    //     $_SESSION['identity'] = $_GET['id'];
    //     echo $_SESSION['identity'];
    // }

    
    // $friendID = $_GET['id'];

    if (!isset($_SESSION['identity'])) {
        $_SESSION['identity'] = $_GET['id'];
    } 

    $id = $_GET['id'];

    /**
     * adding the records to the database
     * 
     * @param string $sender -> sender username
     * @param string $receiver -> receiver username
     * @param string $message -> message being sent
     * 
     * @return void
     * 
     */
    function addMessageToTable($sender, $receiver, $message) {
        // Convert special characters to HTML entities so it can be successfully added to database
        $message = htmlspecialchars($message);
        $sender = htmlspecialchars($sender);
        $receiver = htmlspecialchars($receiver);

        $hashed_message = encrypt($message);

        $sqlquery = "INSERT INTO message(message, senderID, receiverID) VALUES ('$hashed_message', '$sender', '$receiver')";

        global $connection;

        if (mysqli_query($connection, $sqlquery)) {
            // success - might add something here later
        } else {
            echo "Error: " . $sqlquery . "<br>" . mysqli_error($connection);
        }
    }

    /**
     * getting the arguments and passing them to the addMessageToConverstaions and addMessageToUnreadMessageTable functions 
     * under the condition that the message has be written and submitted
     * 
     * @return void
     * 
     */


    function sendMessage() {
        $dataFromClient = explode('&(##NdklsajcJLio421eggfkdoolq,dsp&(304-_284772840kkjfncoe*302', $_POST['message']);

        $sender = $_SESSION['username']; // logged in user
        $receiverVar = $dataFromClient[1]; // friend of logged user
        $message = $dataFromClient[0];

        addMessageToTable($sender, $receiverVar, $message);
        // addMessageToUnreadMessagesTable($sender, $receiverVar, $message);
    }


    // call the sendMessage function if someone is logged in
    if (isset($_SESSION['username'])) {
        if (isset($_POST['message'])) {
            sendMessage();
        }
    }

?>