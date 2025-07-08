<?php
include 'connection.php';

$name = $email = $subject = $message = "";
$nameError = $emailError = $subjectError = $messageError = "";
$success = "";

if (isset($_GET['success']) && $_GET['success'] == 1) {
  $success = "Your message has been sent successfully!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $subject = trim($_POST["subject"]);
  $message = trim($_POST["message"]);
  $hasError = false;

  if (empty($name) || strlen($name) < 3) {
    $nameError = "Name must be at least 3 characters.";
    $hasError = true;
  }

  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = "Valid email is required.";
    $hasError = true;
  }

  if (empty($subject)) {
    $subjectError = "Subject is required.";
    $hasError = true;
  }

  if (empty($message) || strlen($message) < 5) {
    $messageError = "Message must be at least 5 characters.";
    $hasError = true;
  }

  if (!$hasError) {
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if ($stmt->execute()) {
      header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
      exit;
    } else {
      $messageError = "Something went wrong. Please try again.";
    }
    $stmt->close();
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact - College Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="contact-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <h1 class="sitename">College</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>


          <li><a href="news.php">News</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Contact</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Contact</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-main-wrapper">
          <div class="map-wrapper">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

          <div class="contact-content">
            <div class="contact-cards-container" data-aos="fade-up" data-aos-delay="300">
              <div class="contact-card">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="contact-text">
                  <h4>Location</h4>
                  <p>8721 Broadway Avenue, New York, NY 10023</p>
                </div>
              </div>

              <div class="contact-card">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="contact-text">
                  <h4>Email</h4>
                  <p>info@examplecompany.com</p>
                </div>
              </div>

              <div class="contact-card">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="contact-text">
                  <h4>Call</h4>
                  <p>+1 (212) 555-7890</p>
                </div>
              </div>

              <div class="contact-card">
                <div class="icon-box">
                  <i class="bi bi-clock"></i>
                </div>
                <div class="contact-text">
                  <h4>Open Hours</h4>
                  <p>Monday-Friday: 9AM - 6PM</p>
                </div>
              </div>
            </div>

            <div class="contact-form-container" data-aos="fade-up" data-aos-delay="400">
              <h3>Get in Touch</h3>
              <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua consectetur adipiscing.</p>

              <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($success) ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                  <?php endforeach; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <form method="POST" action="" novalidate>
                <div class="mb-3">
                  <label for="name" class="form-label">Your Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($name) ?>">
                  <?php if (!empty($nameError)): ?>
                    <div class="text-danger"><?= htmlspecialchars($nameError) ?></div>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Your Email</label>
                  <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
                  <?php if (!empty($emailError)): ?>
                    <div class="text-danger"><?= htmlspecialchars($emailError) ?></div>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label for="subject" class="form-label">Subject</label>
                  <input type="text" name="subject" id="subject" class="form-control" value="<?= htmlspecialchars($subject) ?>">
                  <?php if (!empty($subjectError)): ?>
                    <div class="text-danger"><?= htmlspecialchars($subjectError) ?></div>
                  <?php endif; ?>
                </div>

                <div class="mb-3">
                  <label for="message" class="form-label">Message</label>
                  <textarea name="message" id="message" rows="5" class="form-control"><?= htmlspecialchars($message) ?></textarea>
                  <?php if (!empty($messageError)): ?>
                    <div class="text-danger"><?= htmlspecialchars($messageError) ?></div>
                  <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Send Message</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

  </main>

  <?php include 'footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>