<?php
// DB connection
$conn = mysqli_connect("localhost", "root", "", "test");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch users
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

$output = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['email']}</td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='3' class='text-center'>No users found</td></tr>";
}

echo $output;
?>
