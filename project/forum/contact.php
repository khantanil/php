<?php
// session_start();
include 'partials/connection.php'; // Make sure this connects $conn

$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $alert = '<div class="alert alert-success alert-dismissible fade show my-2" role="alert" id="contactAlert">
                Thank you! Your message has been submitted.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        } else {
            $alert = '<div class="alert alert-danger alert-dismissible fade show my-2" role="alert" id="contactAlert">
                Something went wrong. Please try again later.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
        mysqli_stmt_close($stmt);
    } else {
        $alert = '<div class="alert alert-danger">Error preparing statement.</div>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - iDiscuss Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <!-- Contact Section -->
    <section class="py-2     bg-light">
        <div class="container">
            <div class="text-center mb-2">
                <h1 class="fw-bold text-success">Contact Us</h1>
                <p class="text-muted">We'd love to hear from you. Send us your questions, feedback, or just say hello!</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <?php if (!empty($alert)) echo $alert; ?>
                            <form action="contact.php" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Your full name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="you@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-bold">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required placeholder="What's this about?">
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label fw-bold">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="2" required placeholder="Write your message here..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success ">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#contactAlert').fadeOut('slow');
            }, 3000); // 3 seconds
        });
    </script>

</body>

</html>