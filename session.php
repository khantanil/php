<?php
session_start();

// Set session variables
$_SESSION['username'] = 'Anil';
$_SESSION['email'] = 'test123@gmail.com';
echo "Session variables are set.<br>";

// Access session variables
if(isset($_SESSION['username']) && isset($_SESSION['email'])) {
    echo "Username: " . $_SESSION['username'] . "<br>";
    echo "Email: " . $_SESSION['email'] . "<br>";
} else {
    echo "Session variables are not set.<br>";
}

// Unset session variables
session_unset();
session_destroy();


?>