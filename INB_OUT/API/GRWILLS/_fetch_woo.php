<?php
header("Cache-Control: no-cache");
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://grwills.com.au/wp-json/wc/v2/products?per_page=30',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic Y2tfZTk1ZWJlMzlhNWFkNzdiMTVhZmFmM2RiMzFkMDJlMWY0ODRlZmQ5YTpjc19iNWI3MzllNmQzZTgzMjNhYzViMWY3YjJkNmQ5ZDA3MGQyN2Q2MDQ0',
    'Cookie: PHPSESSID=fmrsnp6nfsf2975b8e6pcvhbo4; tinvwl_wishlists_data_counter=1'
  ),
));

$response = curl_exec($curl);
$status_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

curl_close($curl);
// echo $response;

if ($status_code === 200) {
    //insert
    $response_ = json_decode($response, true);

    foreach ($response_ as $response_new) {
        $name = $response_new['name'];
        $sku = $response_new['sku'];

        echo $sku." - ".$name."<br />";
    }
}
