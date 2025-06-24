<?php
session_start();

$nameError = $emailError = $descriptionError = $photoError = "";
$name = $email = $description = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'connection.php';

    // Now safely access POST and FILES
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
    $photo_tmp = isset($_FILES['photo']['tmp_name']) ? $_FILES['photo']['tmp_name'] : '';

    $isValid = true;

    // Validation...
    if (empty($name)) {
        $nameError = "Name is required.";
        $isValid = false;
    }

    if (empty($email)) {
        $emailError = "Email is required.";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
        $isValid = false;
    }

    if (empty($description)) {
        $descriptionError = "Description is required.";
        $isValid = false;
    }

    if (empty($photo)) {
        $photoError = "Please upload a photo.";
        $isValid = false;
    } else {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $photoError = "Only JPG, JPEG, PNG, GIF files are allowed.";
            $isValid = false;
        }
    }

    // Process data if valid
    if ($isValid) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $destination = $upload_dir . basename($photo);
        move_uploaded_file($photo_tmp, $destination);

        $stmt = $conn->prepare("INSERT INTO usersdetail (name, email, description, photo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $description, $photo);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Data inserted successfully.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $_SESSION['error'] = "Error inserting data.";
        }
        $stmt->close();
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>CRUD Example</title>
    <style>
        div.dataTables_filter {
            text-align: right !important;
        }
    </style>
</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="update.php" enctype="multipart/form-data" name="editForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" name="name" id="edit-name">
                        </div>

                        <div class="mb-3">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" name="email" id="edit-email">
                        </div>

                        <div class="mb-3">
                            <label for="edit-description">Description</label>
                            <textarea class="form-control" name="description" id="edit-description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-photo">Change Photo (optional)</label>
                            <input type="file" class="form-control" name="photo" id="edit-photo">
                            <input type="hidden" name="old_photo" id="edit-old-photo">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- insert data -->
    <div class="container mb-5">
        <h2 class="text-center mt-2"> Add New User</h2>
        <div class="row justify-content-center mt-2">
            <div class="">
                <form action="" method="post" enctype="multipart/form-data" name="userForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= htmlspecialchars($name) ?>">
                        <small class="text-danger">
                            <?= $nameError ?>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= htmlspecialchars($email) ?>">
                        <small class="text-danger">
                            <?= $emailError ?>
                        </small>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="description"
                            name="description"><?= htmlspecialchars($description) ?></textarea>
                        <label for="description">Description</label>
                        <small class="text-danger">
                            <?= $descriptionError ?>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="photo">Upload Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                        <small class="text-danger">
                            <?= $photoError ?>
                        </small>
                    </div>

                    <button type="submit" class="btn btn-success">Add User</button>
                </form>
                <?php
                if (isset($_SESSION['success'])) {
                    echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: '" . $_SESSION['success'] . "',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    });
                              </script>";
                    unset($_SESSION['success']);
                }elseif (isset($_SESSION['error'])) {
                    echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: '" . $_SESSION['error'] . "',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    });
                              </script>";
                    unset($_SESSION['error']);
                }
                ?>

            </div>
        </div>
    </div>

    <!-- display data -->
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.no</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'connection.php';
                    $sql = "SELECT * FROM usersdetail";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo  "<tr>
                                <th scope='row'>" . $counter . "</th>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td><img src='uploads/" . htmlspecialchars($row['photo']) . "' alt='Image' width='80' height='60'></td>
                                <td c>
                                    <div class='d-flex gap-2 justify-content-center'> 
                                        <button 
                                            class='btn btn-success  editBtn text-center' 
                                            data-id='" . htmlspecialchars($row["id"]) . "' 
                                            data-name='" . htmlspecialchars($row["name"]) . "' 
                                            data-email='" . htmlspecialchars($row["email"]) . "' 
                                            data-description='" . htmlspecialchars($row["description"]) . "' 
                                            data-photo='" . htmlspecialchars($row["photo"]) . "'
                                            data-bs-toggle='modal' 
                                            data-bs-target='#editModal'>
                                            Edit
                                        </button>

                                        <form method='post' action='delete.php' class='deleteForm' name='deleteForm'>
                                            <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                                            <input type='hidden' name='photo' value='" . htmlspecialchars($row['photo']) . "'>
                                            <button type='submit' class='btn btn-danger '>Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#alertsuccess, #alerterror').fadeOut('slow');
            }, 2000);

            $('#myTable').DataTable({
                responsive: true,
                pageLength: 5
            });

            $('.editBtn').on('click', function() {
                const btn = $(this);
                $('#edit-id').val(btn.data('id'));
                $('#edit-name').val(btn.data('name'));
                $('#edit-email').val(btn.data('email'));
                $('#edit-description').val(btn.data('description'));
                $('#edit-old-photo').val(btn.data('photo'));
            });

            $('.deleteForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This record will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Proceed with form submission
                    }
                });
            });

        });
    </script>

</body>

</html>