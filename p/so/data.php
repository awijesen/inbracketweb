<?php
if($_POST) {
    require __DIR__ . '/lib/Database.php';
    require __DIR__ . '/lib/MyApi.php';


    $search = $_POST['search']['value'];
    $limit = $_POST['length'];
    $start = $_POST['start'];

    $api = new MyApi($db, false);
    ob_start();
    echo $api->getData($search, $limit, $start);
    $result = ob_get_contents();
    ob_end_clean();
    header('Content-Type: application/json');
    echo $result;
    exit();
}
?>