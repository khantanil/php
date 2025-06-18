<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connection.php';

    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];

    $sql = "SELECT * FROM users WHERE user_email = '$loginEmail'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($loginPassword, $row['user_pass'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userEmail'] = $loginEmail;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['loginSuccess'] = true;
            header("Location: /php/project/forum/index.php");
            exit();
        } else {
            header("Location: /php/project/forum/index.php?loginSuccess=false&error=invalid");
            exit();
        }
    } else {
        header("Location: /php/project/forum/index.php?loginSuccess=false&error=notfound");
        exit();
    }

    
}
?>
