<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AJAX Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-2">
    <h3 class="mb-2 text-center text-primary">Add User</h3>

    <!-- Form -->
    <form id="userForm">
      <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <!-- Response Message -->
    <div id="responseMsg" class="mt-3"></div>

    <!-- Table Data -->
    <div id="userTable" class="mt-4"></div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $(document).ready(function () {

      loadData();

      $('#userForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
          url: 'insert_user.php',
          type: 'POST',
          data: $(this).serialize() + '&action=insert',
          success: function (res) {
            $('#responseMsg').html(res);
            $('#userForm')[0].reset();
            loadData();
          }
        });
      });

      function loadData() {
        $.ajax({
          url: 'insert_user.php',
          type: 'POST',
          data: { action: 'fetch' },
          success: function (data) {
            $('#userTable').html(data);
          }
        });
      }

    });
  </script>
</body>
</html>
