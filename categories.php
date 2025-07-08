<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: auth-login.php');
    exit;
}


// Handle form submission for adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_category'])) {
    $name = trim($_POST['category_name']);
    $errors = [];

    if (empty($name)) {
        $errors[] = "Category name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Category name must be at least 3 characters long.";
    }

    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

    if (empty($errors)) {
        $check = $conn->prepare("SELECT id FROM categories WHERE name = ? OR slug = ?");
        $check->bind_param("ss", $name, $slug);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $_SESSION['error'] = "Category with this name already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $slug);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Category added successfully!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $_SESSION['error'] = "Database error: " . $stmt->error;
            }
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}



// Fetch categories for display
$categories = [];
$result = $conn->query("SELECT * FROM categories ORDER BY id ");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}



// Handle updating a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $id = intval($_POST['edit_id']);
    $name = trim($_POST['edit_name']);

    if (empty($name) || strlen($name) < 3) {
        $_SESSION['error'] = "Invalid category name.";
    } else {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

        // Check for duplicate name or slug (excluding current category ID)
        $check = $conn->prepare("SELECT id FROM categories WHERE (name = ? OR slug = ?) AND id != ?");
        $check->bind_param("ssi", $name, $slug, $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $_SESSION['error'] = "Category with this name or slug already exists.";
        } else {
            $stmt = $conn->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
            $stmt->bind_param("ssi", $name, $slug, $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Category updated successfully!";
            } else {
                $_SESSION['error'] = "Error updating category: " . $stmt->error;
            }
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}



// Handle deletion of a category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Check if the category exists
    $check = $conn->prepare("SELECT id FROM categories WHERE id = ?");
    $check->bind_param("i", $delete_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Delete the category
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Category deleted successfully!";
        } else {
            $_SESSION['error'] = "Database error: " . $stmt->error;
        }
    } else {
        $_SESSION['error'] = "Category not found.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
    
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
                            <li class="menu-item">
                                <a href="categories.php" class="menu-link">
                                    <div data-i18n="Categories">Categories</div>
                                </a>
                            </li>
                             <li class="menu-item">
                                <a href="tags.php" class="menu-link">
                                    <div data-i18n="Tags">Tags</div>
                                </a>
                            </li>
                             <li class="menu-item">
                                <a href="contact-detail.php" class="menu-link">
                                    <div data-i18n="Contact">Contact</div>
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
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y ">

                        <div class="text-end mb-3">
                            <form action="" method="post">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    Add Category
                                </button>
                            </form>
                        </div>
                    </div>


                    <!-- Add Category Modal -->
                    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="" method="POST" id="categoryForm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="category_name" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" name="category_name" id="category_name">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="save_category" class="btn btn-primary">Save Category</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Fetch and display categories -->
                    <?php if (!empty($categories)): ?>
                        <div class="row text-center justify-content-center mt-0">
                            <div class="col-md-12">
                                <div class="card mx-4">
                                    <h5 class="card-header ">All Categories</h5>
                                    <div class="table-responsive table-striped">
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Category Name</th>
                                                    <th>Slug</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <?php foreach ($categories as $cat): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($cat['id']) ?></td>
                                                        <td><?= htmlspecialchars($cat['name']) ?></td>
                                                        <td><?= htmlspecialchars($cat['slug']) ?></td>
                                                        <td><?= htmlspecialchars($cat['created_at']) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?= $cat['id'] ?>">Edit</button>
                                                            <form method="post" action="" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete this category?');">
                                                                <input type="hidden" name="delete_id" value="<?= $cat['id'] ?>">
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mx-4">No categories found.</div>
                    <?php endif; ?>

                    <!-- Edit Category Modal -->
                    <?php foreach ($categories as $cat): ?>
                        <div class="modal fade" id="editCategoryModal<?= $cat['id'] ?>" tabindex="-1" aria-labelledby="editCategoryLabel<?= $cat['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="post" action="">
                                    <input type="hidden" name="edit_id" value="<?= $cat['id'] ?>">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryLabel<?= $cat['id'] ?>">Edit Category</h5> 
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_name_<?= $cat['id'] ?>" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="edit_name_<?= $cat['id'] ?>" name="edit_name" value="<?= htmlspecialchars($cat['name']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update_category" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>



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
        <div class="layout-overlay layout-menu-toggle">


        </div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
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






</body>

</html>