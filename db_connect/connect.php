<?php 

    $hostname = '127.0.0.1'; // specify host domain or IP, i.e. 'localhost' or '127.0.0.1' or server IP 'xxx.xxxx.xxx.xxx'
    $database = 'tutorfinder1'; // specify database name
    $db_user = 'root'; 
    $db_pass = ''; 


    $connection = mysqli_connect("$hostname" , "$db_user" , "$db_pass", "$database");
    
    if (!$connection) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

?>