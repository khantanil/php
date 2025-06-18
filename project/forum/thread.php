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

    <?php include 'partials/header.php'; ?>
    <?php include 'partials/connection.php'; ?>

    <!-- Fetch thread details based on the thread ID from the URL -->
    <?php
    $id = $_GET['threadid']; // Get the category ID from the URL in the main file
    $sql = "SELECT * FROM `thread` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $threadtitle = $row['thread_title'];
    $threaduser = $row['thread_user_id'];
    $treaddescription = $row['thread_desc'];

    ?>

    <div class="container my-4">
        <div class="px-2 mb-4 bg-light rounded-3">
            <div class="container-fluid py-3">
                <h1 class="display-4"><?php echo $threadtitle ?></h1>
                <p class=""> <?php echo $treaddescription ?></p>
                <hr class="my-4">
                <p>
                    This is a peer to peer forum .
                    No Spam / Advertising / self-promote in the forums is not allowed.
                    Do not post copyright-infringing material.
                    Do not post <strong>"offensive"</strong> posts, links or images.
                    Do not cross post questions.
                    Remain respectful of other members at all times.
                </p>
                <p>Posted by : <b> Anil</b></p>
            </div>
        </div>
    </div>


    <!-- Post a comment section -->
   

  <?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '
    <div class="container px-3 mb-1 ">
        <h2>Post a comment</h2>
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="comment" name="comment" rows="3"></textarea>
                <label for="floatingTextarea2">Type your comment</label>
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



    <!-- Display comments section -->
    <div class="container my-4 ">
        <h2 class="">Discussion</h2>

        <!--Check if the form has been submitted. If the form is submitted, process the comment submission -->
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Insert comment into the database
            $comment = $_POST['comment'];
            $threadid = $_GET['threadid']; // Get the thread ID from the URL
            $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`) VALUES ('$comment', '$threadid')";
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
        ?>

        <!-- Fetch and display comments for the thread  -->
        <?php
        $id = $_GET['threadid']; // Get the thread ID from the URL in the main file
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;

        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;
            $commentdid = $row['comment_id'];
            $commentcontent = $row['comment_content'];
            $comment_date = $row['comment_time'];

            echo '<div class="d-flex align-items-center my-3 ">
                        <div class="flex-shrink-0">
                        <img src="assets/user-icon.webp" width="100x" alt="...">
                        </div>
                            <div class="flex-grow-1 ms-3">
                            <p class="fw-bold my-0">Anonymous User  at ' . $comment_date . ' </p>
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