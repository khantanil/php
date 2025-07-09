<?php
$severname = "localhost";
$username = "root"; 
$password = "root";
$dbname = "test";

$conn = mysqli_connect($severname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}

?>