<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$insert = false;
$update = false;
$delete = false;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle insert request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['desc']) && !isset($_POST['update']) && !isset($_POST['delete'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
    
    $stmt = $conn->prepare("INSERT INTO notes (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $desc);
    
    if ($stmt->execute()) {
        $insert = true;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $sno = filter_input(INPUT_POST, 'snoEdit', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'titleEdit', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'descEdit', FILTER_SANITIZE_STRING);
    
    $stmt = $conn->prepare("UPDATE notes SET title = ?, description = ? WHERE sno = ?");
    $stmt->bind_param("ssi", $title, $desc, $sno);
    
    if ($stmt->execute()) {
        $update = true;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $sno = filter_input(INPUT_POST, 'snoDelete', FILTER_SANITIZE_NUMBER_INT);
    
    $stmt = $conn->prepare("DELETE FROM notes WHERE sno = ?");
    $stmt->bind_param("i", $sno);
    
    if ($stmt->execute()) {
        $delete = true;
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    <title>CRUD APP</title>
</head>
<body>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="index.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="titleEdit" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" required>
                        </div>
                        <div class="mb-3">
                            <label for="descEdit" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descEdit" name="descEdit" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="update">Update Note</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this note? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="post" action="index.php">
                        <input type="hidden" name="snoDelete" id="snoDeleteInput">
                        <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="../images/cover.png" alt="Logo" width="90" height="49" class="d-inline-block align-text-top rounded">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            New record added successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            Note updated successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            Note deleted successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if (isset($error)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="failedAlert">
            ' . htmlspecialchars($error) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <div class="container mb-3">
        <h2 class="mt-3 text-center">Add a Note</h2>
        <form class="mt-3" action="index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3" placeholder="Enter note here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM notes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <th scope='row'>" . $counter . "</th>
                            <td>" . htmlspecialchars($row['title']) . "</td>
                            <td>" . htmlspecialchars($row['description']) . "</td>
                            <td>
                                <button class='btn btn-sm btn-primary px-3 editbtn' 
                                    data-sno='" . $row['sno'] . "'
                                    data-title='" . htmlspecialchars($row['title'], ENT_QUOTES) . "'
                                    data-desc='" . htmlspecialchars($row['description'], ENT_QUOTES) . "'>Edit</button>
                                <button class='btn btn-sm btn-danger deletebtn' data-sno='" . $row['sno'] . "'>Delete</button>
                            </td>
                        </tr>";
                        $counter++;
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            setTimeout(function() {
                $('.alert').alert('close');
            }, 2000);

            $('.editbtn').on('click', function() {
                var sno = $(this).data('sno');
                var title = $(this).data('title');
                var desc = $(this).data('desc');

                $('#snoEdit').val(sno);
                $('#titleEdit').val(title);
                $('#descEdit').val(desc);

                var modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            });

            $('.deletebtn').on('click', function() {
                var sno = $(this).data('sno');
                $('#snoDeleteInput').val(sno);

                var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });
        });
    </script>
</body>
</html>