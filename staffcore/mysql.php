<?php

require_once("configs/config.php");

$servername = MYSQL_HOST;
$username = MYSQL_USERNAME;
$password = MYSQL_PASSWORD;
$dbname = MYSQL_DATABASE;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
