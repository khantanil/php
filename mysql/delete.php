<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully<br>";
}

$sql = "DELETE  FROM contact  WHERE concern = 'Quos voluptates dolo'";
$result = mysqli_query($conn, $sql);

$aff = mysqli_affected_rows($conn);
echo $aff . " record(s) deleted.<br>";

if($result) {
    echo "Record deleted successfully.";
} else {
    $err =  mysqli_error($conn);
    echo "Error deleting record: " .$err;
}


