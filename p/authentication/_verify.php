<?php
session_start();
require(__DIR__ . '/../../dbconnect/db.php');

include(__DIR__ . '/../../timezone/time.php');
date_default_timezone_set('Australia/Darwin');
$actualtime = date("Y-m-d h:i:s", time());

//$BarcodeSearch = $_GET['st_id'];
$uname = htmlspecialchars($_POST['u']);
$pword = htmlspecialchars($_POST['p']);
$cstrong = rand();
$i = 10;
$bytes = openssl_random_pseudo_bytes($i, $cstrong);
$hex   = bin2hex($bytes) . $actualtime;
$device = $_SERVER['HTTP_USER_AGENT'];
$channel = '1';

if ($uname == '' || $pword == '') {
    echo "Invalidentries";
} else {

    $sql = "SELECT * FROM INB_USERMASTER WHERE em =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pwd = $row['pw'];

            if (password_verify($pword, $pwd)) {
               
                    $change = true;
                    $sqlu = "UPDATE INB_USERMASTER set IsLoggedIn=?, LastLoggedIn=?, SessionID=?, LoginChannel=? WHERE em=?";
                    $stmtu = $conn->prepare($sqlu);
                    $stmtu->bind_param('sssss', $change, $actualtime, $hex, $channel, $uname);

                    $statusu = $stmtu->execute();
                    if ($statusu) {
                        $stmtx = $conn->prepare('INSERT INTO INB_LOGGEDIN_DEVICES (UserId, DeviceIdentity, LoggedIn, SessionID, LoginChannel ) VALUES (?, ?, ?, ?, ?)');
                        $stmtx->bind_param('sssss', $uname, $device, $actualtime, $hex, $channel);
                        $stmtx->execute();
                        $resultx = $stmtx->affected_rows;
                        if ($resultx > 0) {
                            $_SESSION['fname'] = $row["fname"];
                            $_SESSION['LNAME'] = $row["lname"];
                            $_SESSION['UCODE'] = $row["UserCode"];
                            $_SESSION['TDOMAIN'] = $row["tenent_domain"];
                            $_SESSION["TID"] = $row["tenent_id"];
                            $_SESSION['LOGGED'] = 'Logged';
                            $_SESSION["ROLE"] = $row["UserRole"];
                            $_SESSION['SSID'] = $hex;
                            $_SESSION["STKM"] = $row["StockTakeMode"];
                        }
                    }
            } else { 
                echo "Invalidpassword";
            }
        }
    } else {
        echo "Nonefound";
    }

    mysqli_close($conn);
}
