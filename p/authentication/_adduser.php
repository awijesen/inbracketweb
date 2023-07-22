<?php
// Include config file
require('../../dbconnect/db.php');

// Define variables and initialize with empty values
$fname = $_POST['fn'];
$lname = $_POST['ln'];
$email = $_POST['em'];
$pw = htmlspecialchars($_POST['pw']);
$conpw = htmlspecialchars($_POST['pwtwo']);

// $fname = 'john';
// $lname = 'carter';
// $email = 'konas@gmail.com';
// $pw = '123456';
// $conpw = '123456';
$pin = '2221';

if($fname == '') {
    echo "First name required";
} else if($lname == '') {
    echo "Last name required";
} else if($email == '') {
    echo "Email required";
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email";
} else if($pw == '') {
    echo "Password required";
} else if($conpw == ''){
    echo "Please confirm password";
} else if($pw != $conpw) {
    echo "Password mismatch!";
} else {
    if ($stmt = $conn->prepare("SELECT em FROM INB_USERMASTER WHERE em = ?")) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            // Username already exists
            echo "Unable to register your email!";
        } else {
            $api_key = bin2hex(random_bytes(16));
            // Insert new account
            if ($stmt = $conn->prepare('INSERT INTO INB_USERMASTER (fname, lname, em, pw, api_key, UserId ) VALUES (?, ?, ?, ?, ?, ?)')) {
                // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                $password = password_hash($pw, PASSWORD_DEFAULT);
                $stmt->bind_param('ssssss', $fname, $lname, $email, $password, $api_key, $email);
                $stmt->execute();
                echo 'You have successfully registered';
            } else {
                // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
                echo 'Could not prepare statement!';
            }
        }
        // $stmt->close();
    } else {
        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
        echo 'Could not prepare statement!';
    }
    // $conn->close(); 
}


?>