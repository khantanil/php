<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer's autoload

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.ethereal.email';  // Ethereal SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'blair.littel79@ethereal.email'; 
    $mail->Password = 'ujv5UkP9hGYKSxjwJy';                
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('blair.littel79@ethereal.email', 'Mailer');
    $mail->addAddress('anilkhant674@gmail.com', 'Anil');     // Change this to where you want to send
    $mail->addReplyTo('info@example.com', 'Information');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email using PHPMailer';
    $mail->Body    = 'This is a <b>test</b> email sent using PHPMailer and Ethereal.......';
    $mail->AltBody = 'This is a test email sent using PHPMailer and Ethereal.';

    $mail->send();
    echo 'Message has been sent!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
