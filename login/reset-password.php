<?php
require 'partials/connection.php';

use PHPMailer\PHPMailer\PHPMailer;

if (!isset($_GET['token'])) {
    die('Token missing.');
}
$token = $_GET['token'];

// echo "Token is: " . htmlspecialchars($token) . "<br>";

$stmt = $conn->prepare("SELECT id FROM users WHERE reset_token=?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) die('Invalid or expired token.');

$user = $result->fetch_assoc();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    if ($pass !== $cpass) {
        $message = 'Passwords do not match.';
    }elseif (strlen($pass) < 6) {
        $message = 'Password must be at least 6 characters.';

        }
     else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $upd = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, token_expire=NULL WHERE id=?");
        $upd->bind_param("si", $hash, $user['id']);
        if ($upd->execute()) {
            echo "<script>
                    alert('Password has been reset successfully!');
                    window.location.href = 'login.php';
                  </script>";
            exit;
        } else {
            $message = 'Error updating password.';
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Reset Your Password</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                            </div>

                            <div class="mb-3">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Re-enter password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>