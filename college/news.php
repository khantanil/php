<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>News - College Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


</head>

<body class="news-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <h1 class="sitename">College</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>


          <li><a href="news.php">News</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">News</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">News</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- News Hero Section -->
    <section id="news-hero" class="news-hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <!-- Main Content Area -->
          <div class="col-lg-8">


            <!-- Secondary Articles -->
            <div class="row g-4">
              <?php
              include 'connection.php';

              $sql = "SELECT * FROM blogs WHERE status = 1 ORDER BY created_at DESC LIMIT 2";
              $result = $conn->query($sql);

              if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                  // Fetch categories 
                  $blog_id = $row['id'];
                  $cat_sql = "SELECT c.name FROM categories c 
                  JOIN blog_categories bc ON c.id = bc.category_id 
                  WHERE bc.blog_id = $blog_id";
                  $cat_result = $conn->query($cat_sql);
                  $categories = [];
                  while ($cat_row = $cat_result->fetch_assoc()) {
                    $categories[] = $cat_row['name'];
                  }
                  $category = !empty($categories) ? implode(', ', $categories) : "General";
              
                  $date = date("m/d/Y", strtotime($row['created_at']));
              ?>
                  <div class="col-md-6">
                    <article class="secondary-post" data-aos="fade-up">
                      <div class="post-image">
                        <img src="../<?= $row['image'] ?>" alt="Post" class="img-fluid" style="height: 350px; object-fit: contain;">
                      </div>
                      <div class="post-content">
                        <div class="post-meta">
                          <span class="category"><?= htmlspecialchars($category) ?></span>
                          <span class="date"><?= $date ?></span>
                        </div>
                        <h3 class="post-title">
                          <a href="news-details.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
                        </h3>
                        <div class="post-author">
                          <span>by</span>
                          <a href="#" class="text-primary"><?= htmlspecialchars($row['author']) ?></a>
                        </div>
                      </div>
                    </article>
                  </div>
              <?php
                endwhile;
              else:
                echo "<p>No blog posts found.</p>";
              endif;

              $conn->close();
              ?>
            </div>

          </div><!-- End Main Content Area -->

          <!-- Sidebar with Tabs -->
          <div class="col-lg-4">
            <div class="news-tabs" data-aos="fade-up" data-aos-delay="200">
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#top-stories" type="button">Top stories</button>
                </li>

              </ul>

              <div class="tab-content">
                <!-- Top Stories Tab -->
                <div class="tab-pane fade show active" id="top-stories">
                  <?php
                  include 'connection.php';

                  // Fetch latest 4 blogs 
                  $sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 4";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      // Get first category for display 
                      $blog_id = $row['id'];
                      $category = '';
                      $cat_sql = "SELECT c.name FROM categories c 
                                      JOIN blog_categories bc ON c.id = bc.category_id 
                                      WHERE bc.blog_id = $blog_id LIMIT 1";
                      $cat_result = $conn->query($cat_sql);
                      if ($cat_row = $cat_result->fetch_assoc()) {
                        $category = $cat_row['name'];
                      }
                      
                      echo '
                           <article class="tab-post">
                            <div class="row g-0 align-items-center">
                              <div class="col-4">
                                  <img src="' . '../' . htmlspecialchars($row['image']) . '" alt="Post" class="img-fluid" style="height: 100px; object-fit: contain;">
                              </div>
                              <div class="col-8">
                                <div class="post-content">
                                  <span class="category">' . htmlspecialchars($category) . '</span>
                                  <h4 class="post-title">
                                    <a href="news-details.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a>
                                  </h4>
                                  <div class="post-author">by <a href="#">' . htmlspecialchars($row['author']) . '</a></div>
                                </div>
                              </div>
                            </div>
                           </article>';
                    }
                  } else {
                    echo "<p>No top stories found.</p>";
                  }
                  $conn->close();

                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /News Hero Section -->

    <!-- News Posts Section -->
    <section id="news-posts" class="news-posts section">        

      <div class="container">

        <div class="row gy-4">
          <?php
          include 'connection.php';

          $sql = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 6";
          $result = $conn->query($sql);

          if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
              $blog_id = $row['id'];
              $cat_sql = "SELECT c.name FROM categories c 
                  JOIN blog_categories bc ON c.id = bc.category_id 
                  WHERE bc.blog_id = $blog_id";
              $cat_result = $conn->query($cat_sql);
              $categories = [];
              while ($cat_row = $cat_result->fetch_assoc()) {
                $categories[] = $cat_row['name'];
              }
              $category = !empty($categories) ? $categories[0] : "General";

          ?>
              <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <article style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

                  <div class="post-img mb-3">
                    <img src="../<?= $row['image'] ?>" alt="Blog Image" class="img-fluid w-100" style="height: 300px; object-fit: contain; border-radius: 8px;">
                  </div>

                  <div class="d-flex align-items-center mb-2">
                    <span class="category text-muted fw-bold fs-5 fst-italic"><?= htmlspecialchars($category) ?></span>
                  </div>

                  <h5 class="fw-semibold mb-2">
                    <a href="news-details.php?id=<?= $row['id'] ?>" style="text-decoration: none; color: #000;">
                      <?= htmlspecialchars(strlen($row['title']) > 60 ? substr($row['title'], 0, 57) . '...' : $row['title']) ?>
                    </a>
                  </h5>

                  <p class="mb-0 text-muted" style="font-size: 14px;">
                    by <span class="fw-bold text-primary"><?= htmlspecialchars($row['author']) ?></span>
                  </p>

                </article>
              </div>
          <?php
            endwhile;
          else:
            echo "<p>No blog posts found.</p>";
          endif;

          $conn->close();
          ?>
        </div>
        <!-- End recent posts list -->

      </div>

    </section><!-- /News Posts Section -->

    <!-- Pagination 2 Section -->
    <section id="pagination-2" class="pagination-2 section">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
            <li>
              <a href="#" aria-label="Previous page">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Previous</span>
              </a>
            </li>

            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="ellipsis">...</li>
            <li><a href="#">8</a></li>
            <li><a href="#">9</a></li>
            <li><a href="#">10</a></li>

            <li>
              <a href="#" aria-label="Next page">
                <span class="d-none d-sm-inline">Next</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>

    </section><!-- /Pagination 2 Section -->

  </main>

  <?php include 'footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>