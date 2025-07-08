<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $photo = $_POST['photo'];

    // First, delete the image file (if it exists)
    $filePath = __DIR__ . "/uploads/" . $photo;
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Now delete the record from database
    $stmt = $conn->prepare("DELETE FROM usersdetail WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Record deleted successfully.";
    } else {
        $_SESSION['success'] = "Error deleting record.";
    }

    $stmt->close();
}

header("Location: index.php");
exit;
?>
