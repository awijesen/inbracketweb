<?php
header("Cache-Control: no-cache");

echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
$cstrong = rand();
$i = 10;
$bytes = openssl_random_pseudo_bytes($i, $cstrong);
    $hex   = bin2hex($bytes);

    echo "Lengths: Bytes: $i and Hex: " . strlen($hex);
    echo $hex;
    
// $browser = get_browser(null, true);
// print_r($browser);
// // include the Browscap library
// // require_once 'vendor/autoload.php';
// require_once ('./trace/vendor/autoload.php');

// // create a Browscap object
// use BrowscapPHP\Browscap;

// $browscap = new Browscap('./trace/vendor/browscap/browscap-php/src/Cache'); // the cache directory must exist
// // $browscap->doAutoUpdate = false; // disable automatic updates
// // $browscap->doAutoLoad = true; // enable automatic loading

// // get the browser information
// $browser = $browscap->getBrowser();

// // print the browser information
// echo "Browser: " . $browser->Browser . "\n";
// echo "Version: " . $browser->Version . "\n";
// echo "Platform: " . $browser->Platform . "\n";
// echo "Is mobile: " . ($browser->isMobileDevice ? "Yes" : "No") . "\n";