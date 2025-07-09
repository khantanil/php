<?php
$conn = mysqli_connect("localhost", "root", "", "test");

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];

    // Sanitize and convert to comma-separated string
    $id_list = implode(',', $ids);

    $sql = "DELETE FROM users WHERE id IN ($id_list)";
    if (mysqli_query($conn, $sql)) {
        echo "Selected users deleted successfully.";
    } else {
        echo "Error deleting users: " . mysqli_error($conn);
    }
} else {
    echo "No users selected.";
}
