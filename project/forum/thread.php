<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Forum Website</title>
</head>


<body>

    <?php include 'partials/connection.php'; ?>
    <?php include 'partials/header.php'; ?>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `thread` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $threadtitle = $row['thread_title'];
    $threaduser = $row['thread_user_id'];
    $treaddescription = $row['thread_desc'];

    // Get posted-by user email
    $sqlUser = "SELECT user_email FROM users WHERE sno = $threaduser";
    $resultUser = mysqli_query($conn, $sqlUser);
    $userRow = mysqli_fetch_assoc($resultUser);
    $postedBy = $userRow ? $userRow['user_email'] : "Unknown";
    ?>

    <div class="container my-4">
        <div class="px-2 mb-4 bg-light rounded-3">
            <div class="container-fluid py-3">
                <h1 class="display-5"><em><?php echo $threadtitle ?></em></h1>
                <p><?php echo $treaddescription ?></p>
                <hr class="my-4">
                <p>This is a peer to peer forum. Be respectful and follow community guidelines.</p>
                <p>Posted by : <em><?php echo $postedBy; ?></em></p>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        
        echo   '<div class="container px-3 mb-1">
                    <h2>Post a comment</h2>
                    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment" rows="3"></textarea>
                            <label for="floatingTextarea2">Type your comment</label>
                            <input type="hidden" name="sno" value="' . $_SESSION['sno'] . '">
                        </div>
                        <button type="submit" class="btn btn-success my-2 px-3">Post Comment</button>
                    </form>
                </div>';
    } else {
        echo '<div class="container my-4">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">You are not logged in!</h4>
                    <p>Please log in to post a comment.</p>
                </div>
             </div>';
    }
    ?>

    <div class="container my-4">
        <h2>Discussion</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $comment = mysqli_real_escape_string($conn, $comment); // <-- escapes dangerous characters

            $threadid = $_GET['threadid'];
            $sno = $_POST['sno'];

            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment', '$threadid', '$sno')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<div class="alert alert-success" role="alert" id="successAlert">
                        <h4 class="alert-heading">Comment Posted Successfully</h4>
                        <p>Your comment has been posted.</p>
                      </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert" id="errorAlert">
                        <h4 class="alert-heading">Error Posting Comment</h4>
                        <p>There was an error posting your comment. Please try again later.</p>
                      </div>';
            }
        }

        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;

        while ($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $commentcontent = $row['comment_content'];
                $comment_date = $row['comment_time'];
                $commentby = $row['comment_by'];

                $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$commentby'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                $userEmail = $row2 ? $row2['user_email'] : "Anonymous";

            echo '<div class="d-flex align-items-center my-3">
                    <div class="flex-shrink-0">
                        <img src="assets/user-icon.webp" width="100px" alt="user icon">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="fw-bold my-0">' . $userEmail . ' at ' . $comment_date . '</p>
                        <p class="mb-0">' . $commentcontent . '</p>
                    </div>
                 </div>';
        }

        if ($noresult) {
            echo '<div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">No Discussions Found</h4>
                    <p>Be the first person to start a discussion.</p>
                  </div>';
        }
        ?>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(() => $('#successAlert').fadeOut('slow'), 3000);
            setTimeout(() => $('#errorAlert').fadeOut('slow'), 3000);
        });
    </script>
</body>
</html>