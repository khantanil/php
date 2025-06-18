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

    <?php include 'partials/connection.php'; ?>
    <?php include 'partials/header.php'; ?>

    <?php
    $id = $_GET['catid']; // Get the category ID from the URL in the main file
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
    ?>



    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);
            $th_title = mysqli_real_escape_string($conn, $th_title);
            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);
            $th_desc = mysqli_real_escape_string($conn, $th_desc);

            $id = $_GET['catid'];
            $user_id = $_POST['sno'];

            $sql2 = "INSERT INTO `thread` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) 
                 VALUES ('$th_title', '$th_desc', '$id', '$user_id', current_timestamp())";

            $result = mysqli_query($conn, $sql2);
            if ($result) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <strong>Success!</strong> Your question has been posted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                <strong>Oops!</strong> There was an error posting your question. Please try again later.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        } else {
            // user tried to submit without logging in
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" id="errorAlert">
                <strong>Warning!</strong> You must be logged in to post a question.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
        }
    }

    ?>


    <div class="container my-4">
        <div class="px-2 mb-4 bg-light rounded-3">
            <div class="container-fluid py-3">
                <h1 class="display-4">Welcome to <?php echo $catname ?></h1>
                <p class=""> <?php echo $catdesc ?></p>
                <hr class="my-4">
                <p>
                    This is a peer to peer forum .
                    No Spam / Advertising / self-promote in the forums is not allowed.
                    Do not post copyright-infringing material.
                    Do not post <strong>"offensive"</strong> posts, links or images.
                    Do not cross post questions.
                    Remain respectful of other members at all times.
                </p>
                <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
            </div>
        </div>
    </div>


    <?php

    // Check if the user is logged in before allowing them to ask a question

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

        echo '<div class="container">
                <h2 class="my-3">Ask a Question</h2>
                <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <div class="mb-3">
                <label for="title" class="form-label">Question Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter your question title here" required>
             </div>

            <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">

             <div class="mb-3">
                <label for="desc" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Describe your question in detail" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                </form>
             </div>';
    } else {
        echo '<div class="container my-4">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">You are not logged in!</h4>
                    <p>Please log in to ask a question.</p>
           
                </div>
             </div>';
    }
    ?>


    <div class="container my-4 ">
        <h2>Browse Questions</h2>
        <?php
        $id = $_GET['catid']; // Get the category ID from the URL in the main file
        $sql = "SELECT * FROM `thread` WHERE thread_cat_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResults = true;

        while ($row = mysqli_fetch_assoc($result)) {
            $noResults = false;
            $threadid = $row['thread_id'];
            $threadtitle = $row['thread_title'];
            $threaduser = $row['thread_user_id'];
            $treaddescription = $row['thread_desc'];
            $threadtime = $row['timestamp'];
            $threaduserid = $row['thread_user_id'];

            $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$threaduserid'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="d-flex align-items-center my-3">
            <div class="flex-shrink-0">
                <img src="assets/user-icon.webp" width="100" alt="User">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5><a href="thread.php?threadid=' . $threadid . '">' . $threadtitle . '</a></h5>
                <p class="mb-1">' . $treaddescription . '</p>
                <p class="fw-bold my-0 text-muted">Asked by ' . $row2['user_email'] . ' at ' . $threadtime . '</p>
            </div>
        </div>';
        }

        if ($noResults) {
            echo '<div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">No Threads Found</h4>
            <p>Be the first person to ask a question.</p>
          </div>';
        }
        ?>


    </div>





    <?php include 'partials/footer.php'; ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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