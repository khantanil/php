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
    <title>Forum Website</title>
</head>


<body>

    <?php include 'header.php'; ?>
    <?php

    $signupSuccess = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'connection.php';

        $signupEmail = $_POST['signupEmail'];
        $signupPassword = $_POST['signupPassword'];
        $signupConfirmPassword = $_POST['signupConfirmPassword'];

        // Check if user already exists
        $existSql = "SELECT * FROM `users` WHERE user_email = '$signupEmail'";
        $checkResult = mysqli_query($conn, $existSql);
        $numRows = mysqli_num_rows($checkResult);

        if ($numRows > 0) {
            echo '<div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">User Already Exists</h4>
                <p>The email you entered is already registered. Try logging in or use a different email.</p>
              </div>';
        } elseif ($signupPassword !== $signupConfirmPassword) {
            echo '<div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Password Mismatch</h4>
                <p>Passwords do not match. Please try again.</p>
              </div>';
        } else {
            // Hash the password
            $hashedPassword = password_hash($signupPassword, PASSWORD_DEFAULT);

            // Insert new user
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`,`timestamp`) VALUES ('$signupEmail', '$hashedPassword',current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: /php/project/forum/index.php?signupSuccess=true");
                exit();
                echo '<div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Registration Successful</h4>
                    <p>You can now log in with your credentials.</p>
                  </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Registration Failed</h4>
                    <p>There was an error processing your registration. Please try again later.</p>
                  </div>';
            }
        }
    }
    ?>






    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Auto-dismiss success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').fadeOut('slow');
            }, 3000);

            // Auto-dismiss error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').fadeOut('slow');
            }, 3000);
        });
    </script>
</body>

</html>