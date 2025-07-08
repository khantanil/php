<?php
session_start();
require 'partials/connection.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: login.php");
  exit;
}

$name = $_SESSION['name'];
$userEmail = $_SESSION['email'];

$message = '';

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old = $_POST['oldpassword'];
  $new = $_POST['newpassword'];

  // 1. Fetch user by session email
  $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
  $stmt->bind_param("s", $userEmail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // 2. Verify old password
    if (password_verify($old, $user['password'])) {
      $newHashed = password_hash($new, PASSWORD_DEFAULT);

      // 3. Update password
      $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
      $update->bind_param("ss", $newHashed, $userEmail);

      if ($update->execute()) {
        $_SESSION['flash_message'] = "<div class='alert alert-success'>Password updated successfully!</div>";
      } else {
        $_SESSION['flash_message'] = "<div class='alert alert-danger'>Error updating password. Try again.</div>";
      }
    } else {
      $_SESSION['flash_message'] = "<div class='alert alert-warning'>Old password is incorrect.</div>";
    }
  } else {
    $_SESSION['flash_message'] = "<div class='alert alert-danger'>User not found.</div>";
  }

  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php require 'partials/nav.php'; ?>

  <div class="container-fluid">
    <div class="row mt-2">
      <div class="col text-end">
        <a href="logout.php" class="btn px-2 btn-danger mb-1">Logout</a>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-center shadow">
          <div class="card-body">

            <?php
            if (isset($_SESSION['flash_message'])) {
                echo $_SESSION['flash_message'];
                unset($_SESSION['flash_message']);
            }
            ?>

            <h3 class="card-title text-success">Welcome, <?php echo htmlspecialchars($name); ?>!</h3>
            <p class="card-text">Your Email is : <?php echo htmlspecialchars($userEmail); ?></p>
            <div class="mb-3 ">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Change Password</label>
            </div>
            <form action="" method="post" id="updateform">
              <div class="mb-3" id="checkinputs">
                <div class="row ">
                  <div class="col-md-6">
                    <label for="oldpassword" class="form-label">Old Password:</label>
                    <input type="password" class="form-control checkinput" id="oldpassword" name="oldpassword" required>
                  </div>
                  <div class="col-md-6">
                    <label for="newpassword" class="form-label">New Password:</label>
                    <input type="password" class="form-control checkinput" id="newpassword" name="newpassword" required>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <button type="submit" id="updatebtn" class="btn btn-primary">Update Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#checkinputs,#updatebtn').hide();
      $('#exampleCheck1').click(function() {
        $('#checkinputs,#updatebtn').toggle(2000);
      });
      setTimeout(function() {
        $('.alert').fadeOut('slow');
      }, 3000);
    });
  </script>
</body>

</html>