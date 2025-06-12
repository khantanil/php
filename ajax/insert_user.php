<?php
$conn = mysqli_connect("localhost", "root", "", "test");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_POST['action'] == 'insert') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hash')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>User added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

if ($_POST['action'] == 'fetch') {
    $sql = "SELECT id, full_name, email FROM users";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>
                <thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['full_name']}</td>
                    <td>{$row['email']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='text-danger'>No users found.</div>";
    }
}
?>
