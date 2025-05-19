<?php
require 'constants.php';
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'curious_chronicles';
$dbConnection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if(mysqli_errno($dbConnection)){
    die(mysqli_error($dbConnection));
}
