<?php
session_start();

$_SESSION['Cust'] = $_POST["customerName"];
echo $_SESSION['Cust'];