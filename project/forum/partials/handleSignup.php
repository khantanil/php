
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connection.php';
    
    $signupEmail = $_POST['signupEmail'];
    $signupPassword = $_POST['signupPassword'];
    $signupConfirmPassword = $_POST['signupConfirmPassword'];

    // Check if user already exists
    $existSql = "SELECT * FROM users WHERE user_email = '$signupEmail'";
    $checkResult = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($checkResult);

    if ($numRows > 0) {
        header("Location: /php/project/forum/index.php?signupSuccess=false&error=exists");
        exit();
    } elseif ($signupPassword !== $signupConfirmPassword) {
        header("Location: /php/project/forum/index.php?signupSuccess=false&error=password");
        exit();
    } else {
        $hashedPassword = password_hash($signupPassword, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user_email, user_pass, timestamp) VALUES ('$signupEmail', '$hashedPassword', current_timestamp())";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['signupSuccess'] = true;
            header("Location: /php/project/forum/index.php?signupSuccess=true");
            exit();
        } else {
            header("Location: /php/project/forum/index.php?signupSuccess=false&error=server");
            exit();
        }
    }
}
?>
