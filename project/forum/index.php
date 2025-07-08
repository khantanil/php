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
<style>
    .carousel-inner img {
        width: 100%;
        height: 635px;
        object-fit: cover;
    }

    .carousel-inner h5,
    .carousel-inner p {
        color: black;
        font-weight: bold;
    }

    /* Responsive height for mobile devices */
    @media (max-width: 768px) {
        .carousel-inner img {
            height: 300px;
        }
    }

    @media (max-width: 480px) {
        .carousel-inner img {
            height: 200px;
        }
    }
</style>

<body>

    <?php include 'partials/connection.php'; ?>
    <?php include 'partials/header.php'; ?>


    <!-- Slider -->
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/python.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/js.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/c.avif" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Category Container -->
    <div class="container">
        <h1 class="text-center my-3">iDiscuss Browse-Categories</h1>
        <div class="row">

            <!-- Fetch all the categorie from db -->
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {

                $categoryId = $row['category_id'];
                $categoryName = $row['category_name'];
                $categoryDesc = $row['category_description'];
                // Generate image from Unsplash based on category name
                $imageUrl = "https://picsum.photos/seed/" . urlencode($categoryName) . "/500/400";
                echo
                '<div class="col-md-4 d-flex justify-content-center my-3">
                        <div class="card" style="width: 18rem;">
                            <img src="' . $imageUrl . '" class="card-img-top img-fluid" alt="' . $categoryName . '">
                            <div class="card-body">
                                <h5 class="card-title"><a href="thred-list.php?catid=' . $categoryId . '">' . $categoryName . '</a></h5>
                                <p class="card-text">' . substr($categoryDesc, 0, 80) . ' ...</p>
                                <a href="thred-list.php?catid=' . $categoryId . '" class="btn btn-primary">View Thread</a>
                            </div>
                        </div>
                    </div>';
            }
            ?>

        </div>
    </div>


    <?php include 'partials/footer.php'; ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#signupSuccessAlert,#successAlert, #errorAlert, #loginSuccessAlert').fadeOut('slow');
            }, 3000);
        });
    </script>


</body>

</html>