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
    session_start();
    $nameError = $emailError = $passwordError = $cpasswordError = '';
    $name = $email = $password = $cpassword = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'partials/connection.php';

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $isValid = true;

        // Name validation
        if (empty($name)) {
            $nameError = 'Full name is required.';
            $isValid = false;
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameError = 'Only letters and white space allowed.';
            $isValid = false;
        }

        // Email validation
        if (empty($email)) {
            $emailError = 'Email is required.';
            $isValid = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Invalid email format.';
            $isValid = false;
        }

        // Password validation
        if (empty($password)) {
            $passwordError = 'Password is required.';
            $isValid = false;
        } elseif (strlen($password) < 6) {
            $passwordError = 'Password must be at least 6 characters.';
            $isValid = false;
        }

        // Confirm password validation
        if (empty($cpassword)) {
            $cpasswordError = 'Confirm password is required.';
            $isValid = false;
        } elseif ($password !== $cpassword) {
            $cpasswordError = 'Passwords do not match.';
            $isValid = false;
        }

        // Check email uniqueness and insert if all valid
        if ($isValid) {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $emailError = 'Email already exists.';
                $isValid = false;
            }
            $stmt->close();

            if ($isValid) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $hashedPassword);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Registration successful! Please log in.";
                    header("Location: login.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Registration failed. Try again.";
                }
                $stmt->close();
            }
        }

        $conn->close();
    }
    ?>


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
                ?>

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 text-primary fw-bold">Create an Account</h3>
                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($name); ?>">
                                <small class="text-danger"> <?php echo $nameError; ?></small>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email); ?>">
                                <small class="text-danger"> <?php echo $emailError ?></small>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Choose a strong password" value="<?php echo htmlspecialchars($password); ?>">
                                <small class="text-danger"> <?php echo $passwordError ?></small>
                            </div>

                            <div class="mb-4">
                                <label for="cpassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Repeat your password" value="<?php echo htmlspecialchars($cpassword); ?>">
                                <small class="text-danger"> <?php echo $cpasswordError ?></small>
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