<?php
session_start();
include 'partials/connection.php';

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Forum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/php/project/forum/about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Top Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

                            $sql = "SELECT category_name, category_id FROM categories LIMIT 5";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<li><a class="dropdown-item" href="thred-list.php?catid='.$row['category_id'].'">' . $row['category_name'] . '</a></li>';
                        }

                           
                          
                       echo '</ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="contact.php">Contact</a>
                    </li>
                </ul> ';

                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<form class="d-flex" >
                    <p class="text-white mb-0 mx-2">Welcome '. $_SESSION['userEmail'] .'</p>
                    <a href="/php/project/forum/partials/logout.php" class="btn btn-outline-success  w-50 fw-bold">Logout</a>
                </form>';
                } else {
                    echo ' 
                <div class="my-2">
                    <button class="btn btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
                </div>';
                }
               

    echo' </div>
        </div>
    </nav>';
           

    include 'signupModal.php';
    include 'loginModal.php';

// Check if signup was successful
if (isset($_SESSION['signupSuccess']) && $_SESSION['signupSuccess'] == true) {
    echo '<div id="loginSuccessAlert" class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Registration successfull!</strong> Now you can logging in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['signupSuccess']);
} elseif (isset($_GET['signupSuccess']) && $_GET['signupSuccess'] == 'false') {
    if ($_GET['error'] == 'exists') {
        echo '<div id="errorAlert" class="alert alert-warning alert-dismissible fade show my-0" role="alert">
                <strong>Warning!</strong> This username is already registered.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } elseif ($_GET['error'] == 'password') {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> Passwords do not match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> Something went wrong. Try again later.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}



// Check if login was successful
if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess'] == 'true') {
    echo '<div id="loginSuccessAlert" class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You are now logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    unset($_SESSION['loginSuccess']);
}
if (isset($_GET['loginSuccess']) && $_GET['loginSuccess'] == 'false') {
    if ($_GET['error'] == 'invalid') {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Error!</strong> Invalid password. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } elseif ($_GET['error'] == 'notfound') {
        echo '<div id="errorAlert" class="alert alert-warning alert-dismissible fade show my-0" role="alert">
                <strong>Warning!</strong> Username not registered.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}



 
?>