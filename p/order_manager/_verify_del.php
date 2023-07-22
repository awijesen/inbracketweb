<?php
session_start();
if(!isset($_POST['id'])) {
    echo "selectorder";
} else{
    echo "available";
}