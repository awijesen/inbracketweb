<?php   
session_start();
 
$mainPath = $_POST['data_so'];
$_REQUEST['data'] = 'https://remote.grwills.com.au/iws/index.php?link='.$mainPath;
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test2.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } 
    // else {    
    
        //default data
        // echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        // QRcode::png('www.google.com', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    // }    
        
    //display generated file
    echo '<img style="height: 25mm; width: 25mm; margin-left: 2mm; margin-top: 2mm;" src="pages/shipping_labels/phpqrcode/'.$PNG_WEB_DIR.basename($filename).'" />';  
    
   