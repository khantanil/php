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

    <?php
    $id = $_GET['catid']; // Get the category ID from the URL in the main file
    $sql = "SELECT * FROM `categories` WHERE category_id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $catname = $row['category_name'];
    $catdesc = $row['category_description'];
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
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </div>
        </div>
    </div>


    <div class="container my-4 ">
        <h2>Browse Questions</h2>
        <?php
        $id = $_GET['catid']; // Get the category ID from the URL in the main file
        $sql = "SELECT * FROM `thread` WHERE thread_cat_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResults = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResults = false;
            // This will fetch the data from the database
            $threadid = $row['thread_id'];
            $threadtitle = $row['thread_title'];
            $threaduser = $row['thread_user_id'];
            $treaddescription = $row['thread_desc'];

            echo '<div class="d-flex align-items-center my-3 ">
            <div class="flex-shrink-0">
                <img src="user-icon.webp" width="100x" alt="...">
            </div>
            <div class="flex-grow-1 ms-3">
                <h5><a href="thread.php?threadid=' . $id . '">' . $threadtitle . '</a></h5>' . $treaddescription . '
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
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Leave a comment here" id="decs" name="desc" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Elaborate your concern</label>
            </div>
            <button type="submit" class="btn btn-primary my-2 px-3">Submit</button>
        </form>

    </div>





    <?php include 'partials/footer.php'; ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>