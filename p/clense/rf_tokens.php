<?php
require(__DIR__.'/dbconnect/db.php');

$sql = "DELETE FROM INB_REFRESH_TOKEN
WHERE EXPIRES_AT < UNIX_TIMESTAMP()";

$stmt = $conn->prepare($sql);
   $status = $stmt->execute();

   if ($status === true) {
        echo "remove_success";
   } else {
     echo "remove_error";
   }
?>