
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

        $loginEmail = $_POST['loginEmail'];
        $loginPassword = $_POST['loginPassword'];

        // Check if user exists
        $sql = "SELECT * FROM `users` WHERE user_email = '$loginEmail'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);   
        if ($numRows == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($loginPassword, $row['user_pass'])) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['userEmail'] = $loginEmail;
                // $signupSuccess = true;
                header("Location: /php/project/forum/index.php?loginSuccess=true");
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Invalid Credentials</h4>
                    <p>The email or password you entered is incorrect. Please try again.</p>
                  </div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">User Not Found</h4>
                <p>No user found with the provided email. Please check your email or sign up.</p>
              </div>';
        }
    }
    ?>






    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
</body>

</html>