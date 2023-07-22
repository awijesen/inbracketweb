<?php
session_start();
require(__DIR__.'/../../dbconnect/db.php');
 
//$BarcodeSearch = $_GET['st_id'];
$tennentid = htmlspecialchars($_POST['u']);

if($tennentid == '') {
    echo "Invalidentries";
} else {

$sql = "SELECT * FROM INB_USERMASTER WHERE tenent_id =?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $tennentid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results = $row["tenent_domain"];
   
    // if(password_verify($pword, $pwd)){
    //     $_SESSION['fnmae'] = $row["fname"];
    //     $_SESSION['LNAME'] = $row["lname"];
    //     $_SESSION['UCODE'] = $row["UserCode"];
        
    //     $_SESSION['LOGGED'] = 'Logged';
    //     echo $row["tenent_domain"];
    // } else {
    //     echo "Invalidpassword";
    // }
}
echo $results;
} else {
    echo "Nonefound";
}

mysqli_close($conn);
}
?>
