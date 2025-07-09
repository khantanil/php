<?php
$servername = 'localhost';
$username = "root";
$password = "";
$database = "test";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = (int) $_POST['age'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];

    if ($name && $age && $gender && $country) {
        $stmt = $conn->prepare("INSERT INTO user (name, age, gender, country) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $age, $gender, $country);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo " Thank you, $name. Your data has been saved.";
        } else {
            echo " Failed to save data.";
        }
        $stmt->close();
    } else {
        echo " Please fill all fields.";
    }

    $conn->close();
} else {
    echo " Invalid request.";
}
?>