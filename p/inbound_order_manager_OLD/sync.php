<?php
require __DIR__ . '/lib/Database.php';
require __DIR__ . '/lib/MyApi.php';

                $show_logs = false; 
                $api = new MyApi($db, $show_logs);
                $response = $api->getSalesOrder();
      
            // echo "hello world";
            ?>