<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Register</title>
</head>

<body>
    <?php require 'partials/nav.php'; ?>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        require 'partials/connection.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];


        if ($password != $cpassword) {
            echo '<div class="alert alert-danger fade show" role="alert">
                    Passwords do not match!
                 </div>';
        } else {
            // Check if the email already exists
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);

            if ($num > 0) {
                echo '<div class="alert alert-danger fade show" role="alert">
                        Email already exists!
                      </div>';
            } else {
                // Insert the new user into the database
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hash')";
                if (mysqli_query($conn, $sql)) {
                    echo '<div class="alert alert-success fade show" role="alert">
                            Registration successful, Now you can login!
                         </div>';
                    // Redirect to login page after successful registration
                    // header("Location: login.php");
                } else {
                    echo '<div class="alert alert-danger fade show" role="alert">
                            Error: ' . mysqli_error($conn) . '
                         </div>';
                }
            }
        }
    }
    ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 text-primary fw-bold">Create an Account</h3>
                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Choose a strong password" required>
                            </div>

                            <div class="mb-4">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Repeat your password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>

                            <p class="text-center mt-3 mb-0">
                                Already have an account? <a href="/php/login/login.php" class="text-decoration-none"><b>Login</b></a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fade out alert after 3 seconds
            setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        });
    </script>

</body>

</html>