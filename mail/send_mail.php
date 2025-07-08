<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ;
    $email   = $_POST['email'];
    $message = $_POST['message'];
    $file    = $_FILES['file'];

    $mail = new PHPMailer(true);

    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'anilkhant674@gmail.com';       // Your Gmail
        $mail->Password   = 'vxltyxsmanyklsuq';              // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Set sender & recipient
        $mail->setFrom('anilkhant674@gmail.com', 'Website Contact');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('khantsachin38@gmail.com');

        // Attach file if uploaded successfully
        if ($file && $file['error'] === 0) {
            $mail->addAttachment($file['tmp_name'], $file['name']);
        }

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from $name";
        $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><b>Message:</b><br>$message ";
        $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Email sending failed. Mailer Error: {$mail->ErrorInfo}";
    }
}
