<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
    
    include('../db_connect/connect.php');

    $data = array();


    if (isset($_POST['name'])) {

        $searchResult = json_decode($_POST['name'], true);

        $subject = $searchResult['subject'];

        $town = array();
        
        if ($searchResult['area'] != '') {
            $town = explode(",", $searchResult['area']);
        } else {
            $town = [''];
        }

        $price = array();

        if ($searchResult['price'] == '') {
            $price = array('min' => 0, 'max' => 0);
        } else {
            $price = array('min' => $searchResult['price']['min'], 'max' => $searchResult['price']['max']);
        }

        $subject = $searchResult['subject'];
        $firstName = '';
        $lastName = '';

        if ($searchResult['personName'] != '') {
            $firstName = explode(" ", $searchResult['personName'])[0];
            $lastName = explode(" ", $searchResult['personName'])[1];
        }


        if ($subject != '') {
            $sql = "SELECT assign_subject_tutor.subject_id, users.username, users.firstName, users.lastName, tutor.hourlyRate, address.* 
                    FROM subject
                    JOIN assign_subject_tutor ON assign_subject_tutor.subject_id = subject.subject_id
                    JOIN users ON assign_subject_tutor.username = users.username 
                    JOIN address ON address.username = users.username
                    JOIN tutor ON users.username = tutor.username
                    WHERE subject.subject_name = '$subject'";

            $result = mysqli_query($connection, $sql);

            // $subjectSQL = "SELECT ";
            // $subjectResult = mysqli_query($connection, $subjectSQL);

            while ($rec = mysqli_fetch_assoc($result)) {
                array_push($data, $rec);
            }

            // echo $searchValue;
            // Set the response header to indicate JSON content
            header('Content-Type: application/json');

            // Encode the data array as JSON
            $jsonData = json_encode($data);
            print_r($jsonData);

        } else if ($town[0] !== '' || $firstName != '' || $lastName != '' || $price['min'] > 0 || $price['max'] > 0) {
            $townValue = $town[0]; // Cape Town
            $min = $price['min']; // 0
            $max = $price['max']; // 199

            $sql = "SELECT users.username, users.firstName, users.lastName, tutor.hourlyRate, address.* 
                    FROM address 
                    JOIN users ON address.username = users.username 
                    JOIN tutor ON users.username = tutor.username";

            
            if ($townValue != '' || $firstName != '' || $lastName != '' 
                || $min > 0 || $max > 0) {
                $sql .= " WHERE";
            }

            if ($townValue != '') {
                $sql .= " address.town LIKE '%$townValue%' OR address.city LIKE '%$townValue%'";

                if ($firstName != '' || $lastName != '') {
                    $sql .= " OR users.firstName LIKE '%$firstName%' OR users.lastName LIKE '%$lastName%'";
                }
                if ($min > 0 || $max > 0) {
                    $sql .= " OR tutor.hourlyRate >= $min AND tutor.hourlyRate <= $max";
                }
            }

            if ($firstName != '' || $lastName != '') {
                $sql .= " users.firstName LIKE '%$firstName%' OR users.lastName LIKE '%$lastName%'";

                if ($townValue != '') {
                    $sql .= " OR address.town LIKE '%$townValue%' OR address.city LIKE '%$townValue%'";
                }

                if ($min > 0 || $max > 0) {
                    $sql .= " OR tutor.hourlyRate >= $min AND tutor.hourlyRate <= $max";
                }
            }
        
            if ($min > 0 || $max > 0) {
                $sql .= " tutor.hourlyRate >= $min AND tutor.hourlyRate <= $max";

                if ($townValue != '') {
                    $sql .= " OR address.town LIKE '%$townValue%' OR address.city LIKE '%$townValue%'";
                }

                if ($firstName != '' || $lastName != '') {
                    $sql .= " OR users.firstName LIKE '%$firstName%' OR users.lastName LIKE '%$lastName%'";
                }
            }

            $result = mysqli_query($connection, $sql);

            // $subjectSQL = "SELECT ";
            // $subjectResult = mysqli_query($connection, $subjectSQL);

            while ($rec = mysqli_fetch_assoc($result)) {
                array_push($data, $rec);
            }
 
            // echo $searchValue;
            // Set the response header to indicate JSON content
            header('Content-Type: application/json');

            // Encode the data array as JSON
            $jsonData = json_encode($data);
            print_r($jsonData);
        } else {
            // echo $searchValue;
            // Set the response header to indicate JSON content
            header('Content-Type: application/json');

            // Encode the data array as JSON
            $jsonData = json_encode([]);
            print_r($jsonData);
        }
    }

?>