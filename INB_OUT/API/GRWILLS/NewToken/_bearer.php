<?php
require(__DIR__.'/../../../../dbconnect/db.php');

$curlx = curl_init();

 curl_setopt_array($curlx, array(
   CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/Bearer',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'GET',
   CURLOPT_POSTFIELDS => 'keys=live&database=GRWillsLive&password=G%26RWills40&Username=Mohanw&Connection-Type=application%2Fx-www-form-urlencoded&grant_type=password',
   CURLOPT_HTTPHEADER => array(
     'Content-Type: application/x-www-form-urlencoded'
   ),
 ));

 $response_X = curl_exec($curlx);
 $status_code_x = curl_getinfo($curlx, CURLINFO_RESPONSE_CODE);
 curl_close($curlx);
 // echo $response;

 if ($status_code_x !== 200) {
   //udpate error new token
   echo "Error - ". $status_code_x;

 } else {
    $response_new = json_decode($response_X , true);
    $token = $response_new['access_token'];

   $sql = "UPDATE INB_CREDS SET INB_TOKEN='".$token."' WHERE id='1'";

   $stmt = $conn->prepare($sql);
   // $stmt->bind_param("s", $search);
   // $search = $findOrder;
   $status = $stmt->execute();
   // $result = $stmt->get_result();

   if ($status === true) {
    //success
     require('../_fetch_products.php');
     // echo json_encode($Response);
   } else {
     echo "Error - PRODFETCH";
   }
 }