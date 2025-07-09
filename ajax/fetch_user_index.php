<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Load Data on Button Click</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
  <h3 class="mb-3">User Table</h3>
  
  <button id="loadBtn" class="btn btn-primary mb-3">Load Users</button>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody id="userTableBody">
      <!-- Table starts empty -->
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function () {
    $('#loadBtn').on('click', function () {
      $.ajax({
        url: "fetch_user.php",
        type: "GET",
        success: function (data) {
          $('#userTableBody').html(data);
        }
      });
    });
  });
</script>

</body>
</html>
