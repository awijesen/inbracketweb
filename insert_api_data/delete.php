<?php
$conn = mysqli_connect("localhost", "root","", "INB");

$curl = curl_init();

$headers = [
    "Authorization: Bearer NHq5Fn2PyRp7cJslQ5nXKeA9aV3QPUnCSRA83B4_nlytsp4ia6cYUpIidXQTWZTK5ybFU1WBqvl6mNCOMGl3MMZJf-jEhAB4akT9nFD2ygLRQFRJtHC-1Jk-7q47zFhP-jPHlX3pY35yeivEl8Hkg8enfoxX0aw-TjD8Z5_qr144ghhwU83PUdZ_wx4J-EWaub5x_rjWna8xJv1L5nj0u1GOaSED5fPqOBUhDi23u281yideTGo3uPnybUAtE6cQDezlx7oMgzaBzWZc5b1N1a3UK0lHUHtHMhlCjVUyhMNBAQzryenO3bRMRJN-7dhXtfO8yXH69AJQ_2XB1XQSqQRpDAivCcCPAHyX6-EpFHKOTGgg7hFlAUERESkhmbbZB6WTcUes6-il-K-ECGgeVbB9xOqpKpVfPsl8AxTHMtpM23Tjt4SROk285WrhgsE-Wb1hzVA6Ay2B9TM3jedOUKbVySqeqDR5yYbFqw-DIVOY6_Ivy0hREeyqS_jUqRZOG_dLhEy2yT0J6ZNqUhV0BiJ-osIa8PsATofd8yqlL-bhJ7mbOOGl9G51-QHuAvpAc9EiWz_5AUcKuUrW4-TddTIrHLG8Z0Nu9EE9VZgxMzMGpo-76NpMkTlkUfsqLMOnZKUgtWfQIob1_4XyI_PWosJE7Jf450zzEU2RYQN7o2GUoxteXZppqJ8AOyvIOLVVepMaU4XeSaaLpLsTvfQ_AnkpyHl-wgFVgzi1GFY5B0844qtfmF4TA0s_ADIkCwoXN4Q4Itlf64UMQBUW4TdbL43KTTgueq3irU3MQ4CJQ68y1lmPkDJNyifW8Wd9Zu3ix-DxscUi_riOsk7kDkD5GxrvsXlRKIRLm_-5ABUZ-DHDLpZYk6M_o-RoG85BLsytowRVqm3qH0tUffsqhROZSi_bgw0IB98NNdoQjKj4rl1IEGgBLRwVfAiJp03pKvM6byhxEOzqYIMfj9-iG7fa_viH6NAdWX-iMGqmMDGA1kcrQR7bW2FxuvXQoYfd3jSB3-ncA846viZLTkF8gBiTVs6WNYRx8ybwwEdNixPeHo4RWsM2yoF_5k_cCuezgqzP",
    "refresh_token: dea2b179-8f26-44e4-88d8-c58344eb8c0f"
];
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_SalesOrders',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => $headers,
  CURLOPT_POSTFIELDS => 'grant_type=refresh_token&database=G&RWillsVision&username=MohanW&password=G&RWills90',
));

$filename = curl_exec($curl);

curl_close($curl);

$array = json_decode($filename, true);


// $myarray = new array('D1', 'D5', 'D8');
$str = "";
foreach ($array as $item)
{
    $str .= "'".$item['LineId']. "',";
     echo $str;
}

// $str = rtrim($str, ",");

$query = "DELETE FROM INB_SALES_ORDERS 
             WHERE LineId NOT IN ($str)";


    //$stmtd->close();
    $conn->close(); 

//  echo $response;