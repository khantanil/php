<?php
session_start();
include 'connection.php';

$errors = [];

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);
    $category_ids = $_POST['category'] ?? [];
    $tag_ids = $_POST['tag'] ?? [];
    $status = isset($_POST['status']) ? intval($_POST['status']) : 1; 
    $old_photo = $_POST['old_image'];
    $new_photo = $_FILES['image']['name'];
    $photo_tmp = $_FILES['image']['tmp_name'];

    // Validate fields
    if (empty($title)) $errors['title'] = "Title is required.";
    if (empty($author)) $errors['author'] = "Author is required.";
    if (empty($content)) $errors['content'] = "Content is required.";
    if (empty($category_ids)) $errors['category'] = "Please select at least one category.";
    if (empty($tag_ids)) $errors['tag'] = "Please select at least one tag.";

    // Validate image if uploaded
    if (!empty($new_photo)) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($new_photo, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $errors['image'] = "Invalid image format.";
        }
    }

    // If errors, save to session and redirect
    if (!empty($errors)) {
        $_SESSION['update_errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: blog.php#editModal");
        exit;
    }

    // Handle image
    $photo = $old_photo;
    if (!empty($new_photo)) {
        $photo = 'uploads/' . time() . '_' . basename($new_photo);
        move_uploaded_file($photo_tmp, $photo);
    }

    // Update main blog record
    $stmt = $conn->prepare("UPDATE blogs SET title=?, content=?, author=?, image=?, status=? WHERE id=?");
    $stmt->bind_param("ssssii", $title, $content, $author, $photo, $status, $id);
    $stmt->execute();

    // Update categories
    $conn->query("DELETE FROM blog_categories WHERE blog_id = $id");
    $insertCat = $conn->prepare("INSERT INTO blog_categories (blog_id, category_id) VALUES (?, ?)");
    foreach ($category_ids as $cat_id) {
        $insertCat->bind_param("ii", $id, $cat_id);
        $insertCat->execute();
    }

    // Update tags
    $conn->query("DELETE FROM blog_tags WHERE blog_id = $id");
    $insertTag = $conn->prepare("INSERT INTO blog_tags (blog_id, tag_id) VALUES (?, ?)");
    foreach ($tag_ids as $tag_id) {
        $insertTag->bind_param("ii", $id, $tag_id);
        $insertTag->execute();
    }

    $_SESSION['success'] = "Blog updated successfully.";
    header("Location: blog.php");
    exit;
}
?>
