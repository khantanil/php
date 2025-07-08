<?php
session_start();
include 'connection.php';

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Initialize variables and errors
$title = $author = $content = '';
$titleError = $authorError = $contentError = $imageError = $categoryError = $tagError = '';
$categories = $_POST['categories'] ?? [];
$tags = $_POST['tags'] ?? [];
$status = isset($_POST['status']) ? intval($_POST['status']) : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image = $_FILES['image'] ?? null;

    // Validation
    if ($title === '') $titleError = 'Title is required.';
    if ($author === '') $authorError = 'Author is required.';
    if ($content === '') $contentError = 'Content is required.';
    if (empty($categories)) $categoryError = 'Select at least one category.';
    if (empty($tags)) $tagError = 'Select at least one tag.';
    if (!$image || $image['error'] !== 0) {
        $imageError = 'Image is required.';
    } else {
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $imageError = 'Only JPG, JPEG, PNG, GIF allowed.';
        }
    }

    // If no errors
    if (!$titleError && !$authorError && !$contentError && !$imageError && !$categoryError && !$tagError) {
        $uploadPath = 'uploads/' . time() . '_' . basename($image['name']);
        if (!is_dir('uploads')) mkdir('uploads', 0755);

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            // Insert blog with status
            $stmt = $conn->prepare("INSERT INTO blogs (title, author, content, image, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $title, $author, $content, $uploadPath, $status);
            $stmt->execute();
            $blogId = $stmt->insert_id;

            // Insert categories
            $catStmt = $conn->prepare("INSERT INTO blog_categories (blog_id, category_id) VALUES (?, ?)");
            foreach ($categories as $catId) {
                $catStmt->bind_param("ii", $blogId, $catId);
                $catStmt->execute();
            }

            // Insert tags
            $tagStmt = $conn->prepare("INSERT INTO blog_tags (blog_id, tag_id) VALUES (?, ?)");
            foreach ($tags as $tagId) {
                $tagStmt->bind_param("ii", $blogId, $tagId);
                $tagStmt->execute();
            }

            $_SESSION['message'] = "Blog added successfully!";
            header('Location: blog.php');
            exit;
        } else {
            $imageError = "Failed to upload image.";
        }
    }
}
?>





<!doctype html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Materialize - Material Design HTML Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="assets/vendor/libs/swiper/swiper.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="assets/vendor/css/pages/cards-statistics.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/cards-analytics.css" />



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>

    <!-- TinyMCE CDN -->
    <script src="assets/tinymce/tinymce.min.js"></script>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <span style="color: var(--bs-primary)">
                                <svg width="268" height="150" viewBox="0 0 38 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M30.0944 2.22569C29.0511 0.444187 26.7508 -0.172113 24.9566 0.849138C23.1623 1.87039 22.5536 4.14247 23.5969 5.92397L30.5368 17.7743C31.5801 19.5558 33.8804 20.1721 35.6746 19.1509C37.4689 18.1296 38.0776 15.8575 37.0343 14.076L30.0944 2.22569Z"
                                        fill="currentColor" />
                                    <path
                                        d="M30.171 2.22569C29.1277 0.444187 26.8274 -0.172113 25.0332 0.849138C23.2389 1.87039 22.6302 4.14247 23.6735 5.92397L30.6134 17.7743C31.6567 19.5558 33.957 20.1721 35.7512 19.1509C37.5455 18.1296 38.1542 15.8575 37.1109 14.076L30.171 2.22569Z"
                                        fill="url(#paint0_linear_2989_100980)"
                                        fill-opacity="0.4" />
                                    <path
                                        d="M22.9676 2.22569C24.0109 0.444187 26.3112 -0.172113 28.1054 0.849138C29.8996 1.87039 30.5084 4.14247 29.4651 5.92397L22.5251 17.7743C21.4818 19.5558 19.1816 20.1721 17.3873 19.1509C15.5931 18.1296 14.9843 15.8575 16.0276 14.076L22.9676 2.22569Z"
                                        fill="currentColor" />
                                    <path
                                        d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z"
                                        fill="currentColor" />
                                    <path
                                        d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z"
                                        fill="url(#paint1_linear_2989_100980)"
                                        fill-opacity="0.4" />
                                    <path
                                        d="M7.82901 2.22569C8.87231 0.444187 11.1726 -0.172113 12.9668 0.849138C14.7611 1.87039 15.3698 4.14247 14.3265 5.92397L7.38656 17.7743C6.34325 19.5558 4.04298 20.1721 2.24875 19.1509C0.454514 18.1296 -0.154233 15.8575 0.88907 14.076L7.82901 2.22569Z"
                                        fill="currentColor" />
                                    <defs>
                                        <linearGradient
                                            id="paint0_linear_2989_100980"
                                            x1="5.36642"
                                            y1="0.849138"
                                            x2="10.532"
                                            y2="24.104"
                                            gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-opacity="1" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient
                                            id="paint1_linear_2989_100980"
                                            x1="5.19475"
                                            y1="0.849139"
                                            x2="10.3357"
                                            y2="24.1155"
                                            gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-opacity="1" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text fw-semibold ms-2">Materialize</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                                fill-opacity="0.9" />
                            <path
                                d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                                fill-opacity="0.4" />
                        </svg>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item active open">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                            <div data-i18n="Dashboards">Dashboards</div>
                            <div class="badge bg-danger rounded-pill ms-auto">5</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="blog.php" class="menu-link">
                                    <div data-i18n="Blog">Blog</div>
                                </a>
                            </li>


                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'nav.php'; ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y ">
                        <div class="card shadow w-100 text-start mx-auto mt-0">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Add New Blog Post</h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6 mt-2">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Blog Title</label>
                                                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($title) ?>">
                                                <small class="text-danger"><?= $titleError ?></small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author Name</label>
                                                <input type="text" name="author" id="author" class="form-control" value="<?= htmlspecialchars($author) ?>">
                                                <small class="text-danger"><?= $authorError ?></small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Upload Image</label>
                                                <input type="file" name="image" id="image" class="form-control">
                                                <small class="text-danger"><?= $imageError ?></small>
                                            </div>
                                            <?php $status = $_POST['status'] ?? '1'; // Default to Active 
                                            ?>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="1" <?= $status == '1' ? 'selected' : '' ?>>Active</option>
                                                    <option value="0" <?= $status == '0' ? 'selected' : '' ?>>Inactive</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tag" class="form-label">Tags</label>
                                                <select name="tags[]" id="add-tag" class="form-select tagselect2" multiple>
                                                    <option value="">-- Select Tags --</option>
                                                    <?php
                                                    $res = $conn->query("SELECT * FROM tags");
                                                    while ($row = $res->fetch_assoc()) {
                                                        $selected = in_array($row['id'], $tags) ? 'selected' : '';
                                                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <small class="text-danger"><?= $tagError ?></small>

                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6 mt-2">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select name="categories[]" id="add-category" class="form-select select2" multiple>
                                                    <option value="">-- Select Categories --</option>
                                                    <?php
                                                    $res = $conn->query("SELECT * FROM categories");
                                                    while ($row = $res->fetch_assoc()) {
                                                        $selected = in_array($row['id'], $categories) ? 'selected' : '';
                                                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <small class="text-danger"><?= $categoryError ?></small>

                                            </div>

                                            <div class="mb-3">
                                                <label for="content" class="form-label">Content</label>
                                                <textarea name="content" id="content" rows="6" class="form-control"><?= htmlspecialchars($content) ?></textarea>
                                                <small class="text-danger"><?= $contentError ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">Publish Blog</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include 'footer.php'; ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="assets/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select categories",
                allowClear: true
            });
            $('.tagselect2').select2({
                placeholder: "Select tags",
                allowClear: true
            });
        });
    </script>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help charmap quickbars emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media link anchor codesample | ltr rtl',
            menubar: 'file edit view insert format tools table help',
            toolbar_mode: 'sliding',
            height: 300
        });
    </script>


</body>

</html>