<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";

// $conn = new mysqli($servername, $username, $password,$dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }else{
//     echo "Connected successfully";
// }

// Check connection
 // Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";



?>