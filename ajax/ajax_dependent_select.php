<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dependent Dropdown</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

  <h2>PHP Ajax Dependent Select Box</h2>

  <label for="country">Select Country:</label>
  <select id="country">
    <option value="">--Select Country--</option>
   <?php
  include 'connection.php';

  $sql = "SELECT * FROM countries";
  $result = mysqli_query($conn, $sql);

  // Check if query was successful
  if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='{$row['id']}'>{$row['country_name']}</option>";
      }
  } else {
      echo "<option disabled>Error loading countries</option>";
  }
?>
  </select>

  <br><br>

  <label for="state">Select State:</label>
  <select id="state">
    <option value="">--Select State--</option>
  </select>

  <script>
    $(document).ready(function() {
      $('#country').change(function() {
        const countryID = $(this).val();

        if (countryID !== '') {
          $.ajax({
            url: 'ajax_get_states_process.php',
            method: 'POST',
            data: { country_id: countryID },
            success: function(response) {
              $('#state').html(response);
            }
          });
        } else {
          $('#state').html('<option value="">--Select State--</option>');
        }
      });
    });
  </script>

</body>
</html>
