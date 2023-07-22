<?php
session_start();
// Include config file
require('../../dbconnect/db.php');

$t_id = $_SESSION["TID"];
$t_dom = $_SESSION["TDOMAIN"];
// Define variables and initialize with empty values
$fname = htmlspecialchars($_POST['un']);
$lname = htmlspecialchars($_POST['ln']);
$email = htmlspecialchars($_POST['be']);
$ucode = htmlspecialchars(strtoupper($_POST["uc"]));
$platformId = htmlspecialchars($_POST["pi"] . '@inb.com');
$pw = htmlspecialchars($_POST['pw']);
$conpw = htmlspecialchars($_POST['rpw']);
$accs = htmlspecialchars($_POST['accs']);
$active = true;
$warehouse = '0';

if($fname == '') {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>First name required</p>";
} else if($lname == '') {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Last name required</p>";
} else if($ucode == '') {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>User code required</p>";
} else if(strlen($ucode) != 3) {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>User code should be 3 letters</p>";
} else if($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Invalid email</p>";
    // exit;
} else if($accs == 'selectaccess') {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Access level required</p>";
} else if($pw == '') {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Password required</p>";
} else if($conpw == ''){
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Please confirm password</p>";
} else if($pw != $conpw) {
    echo "<p style='color: var(--falcon-red); font-size: 13px;'>Password mismatch</p>";
} else {
    if ($stmt = $conn->prepare("SELECT UserId FROM INB_USERMASTER WHERE UserId = ?")) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $platformId);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            // Username already exists
            echo "<p style='color: var(--falcon-red); font-size: 13px;'>Unable to register platform ID. Try a different</p>";
        } else {
            $api_key = bin2hex(random_bytes(16));
            // Insert new account
            if ($stmt = $conn->prepare('INSERT INTO INB_USERMASTER (fname, lname, UserCode, UserId, pw, api_key, em, ActiveStatus, AssignedWarehouse, tenent_id, tenent_domain, UserRole ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
                // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
                $password = password_hash($pw, PASSWORD_DEFAULT);
                $stmt->bind_param('ssssssssssss', ucfirst($fname), ucfirst($lname), $ucode, $platformId, $password, $api_key, $email, $active, $warehouse , $t_id, $t_dom, $accs );
                $stmt->execute();
                echo "<p style='color:var(--falcon-green); font-size: 13px; margin-top: 6px; font-family: var(--falcon-font-sans-serif)'>New user added</p>";
            } else {
                // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
                echo "<p style='color: var(--falcon-red); font-size: 13px; font-family: var(--falcon-font-sans-serif)'>Error - PREP45SW</p>";
            }
        }
        // $stmt->close();
    } else {
        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
        echo "<p style='color: var(--falcon-red); font-size: 13px; font-family: var(--falcon-font-sans-serif)'>Error - PREP46SW</p>";
    }
    // $conn->close(); 
}


?>

