<?php
$servername = "localhost";
$username = "root"; 
$password ="root";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully<br>";
}

  
?>