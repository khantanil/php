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
                <p><b>Posted by : Anil</b></p>
            </div>
        </div>
    </div>


    <div class="container my-4 ">
        <h2 class="mx-3">Discussion</h2>
       

       
    </div>





    <?php include 'partials/footer.php'; ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>