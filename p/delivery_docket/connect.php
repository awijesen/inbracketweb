<?php
    $servername ="GRW-SQL";
    $username="vision";
    $password="vision";
    $database="GRWillsVision";
    $connectionInfo = array( "Database"=>"GRWillsVision", "UID"=>$username, "PWD"=>$password);
    $link = sqlsrv_connect ($servername, $connectionInfo);
    
    if (!$link) {
      die("Connection failed: " . sqlsrv_errors());
    }
?>