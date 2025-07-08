<?php
include 'connection.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);
    $old_photo = $_POST['old_photo'];
    $new_photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];

    // Use old photo if no new one uploaded
    if (empty($new_photo)) {
        $photo = $old_photo;
    } else {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($new_photo, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            die("Invalid file type.");
        }
        $upload_dir = __DIR__ . '/uploads/';
        $photo = basename($new_photo);
        move_uploaded_file($photo_tmp, $upload_dir . $photo);
    }

    $stmt = $conn->prepare("UPDATE usersdetail SET name=?, email=?, description=?, photo=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $description, $photo, $id);
    if ($stmt->execute()) {
        session_start();
        $_SESSION['success'] = "Data updated successfully.";
    } else {
        session_start();
        $_SESSION['error'] = "Update failed.";
    }
    header("Location: index.php");
    exit;
}
?>
