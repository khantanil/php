<?php


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
    <?php require 'partials/nav.php'; ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        require 'partials/connection.php';

        $email = $_POST['email'];
        $password = $_POST['password'];
        $exists = false;
        // Check if the email exists
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row['full_name'];
                header("location: welcome.php");
            } else {
                echo '<div class="alert alert-danger fade show" role="alert">
                    Invalid Password!
                  </div>';
            }
        } else {
            echo '<div class="alert alert-danger fade show" role="alert">
                Email not found!
              </div>';
        }
    }
    ?>

    <?php
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
        echo '<div class="alert alert-success text-center" role="alert">
            You have been logged out successfully!
          </div>';
    }
    ?>


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 text-success">Welcome Back to Login</h3>
                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-decoration-none">Forgot Password?</a>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Login</button>
                            </div>

                            <p class="text-center mt-3 mb-0">
                                Don't have an account? <a href="register.php" class="text-decoration-none fw-bold">Register</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>

</html>