<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'partials/connection.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $update = $conn->prepare("UPDATE users SET reset_token=?, token_expire=? WHERE email=?");
        $update->bind_param("sss", $token, $expires, $email);
        $update->execute();

        
        // Send email via PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Ethereal SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'anilkhant674@gmail.com';
            $mail->Password = 'vxltyxsmanyklsuq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('anilkhant674@gmail.com', 'Anil');
            $mail->addAddress($email); // recipient
            $mail->addReplyTo('anilkhant674@gmail.com', 'Anil');

            $mail->isHTML(true);
            $mail->Subject = 'Reset your Password';
            $link = "http://localhost/php/login/reset-password.php?token=$token";
            $mail->Body    = "Click <a href='$link'>this link</a> to reset your password.";
            $mail->AltBody = "Paste this URL in your browser: $link";

            $mail->send();
            $message = 'A password reset link has been sent to your email.';
        } catch (Exception $e) {
            $message = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $message = "No account found with that email.";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<body class="bg-light">
    
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if ($message) {
                            echo '<div class="alert alert-info alertmsg">' . htmlspecialchars($message) . '</div>';
                        }
                        ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter your email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50">Send Reset Link</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Hide the alert message after 5 seconds
            setTimeout(function() {
                $('.alertmsg').fadeOut('slow');
            }, 2000);
        });
    </script>
</body>

</html>