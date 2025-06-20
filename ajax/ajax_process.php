<?php
if (isset($_POST['name'])) {
    $name = htmlspecialchars($_POST['name']);
    echo "Hello, $name! Your data was received.";
}
?>
