<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP & Ajax Serialize Form - Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-header bg-primary text-white text-center">
            <h4>PHP & Ajax Serialize Form</h4>
          </div>
          <div class="card-body">
            <form id="myForm">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control">
                <div class="text-danger small" id="nameError"></div>
              </div>

              <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" id="age" class="form-control">
                <div class="text-danger small" id="ageError"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="Male" id="male">
                  <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="Female" id="female">
                  <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="text-danger small" id="genderError"></div>
              </div>

              <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select name="country" id="country" class="form-select">
                  <option value="">-- Select --</option>
                  <option value="India" selected>India</option>
                  <option value="USA">USA</option>
                  <option value="UK">UK</option>
                </select>
                <div class="text-danger small" id="countryError"></div>
              </div>

              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>

            <div id="message" class="mt-3 fw-bold"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery logic -->
  <script>
    $(document).ready(function () {
      $('#myForm').submit(function (e) {
        e.preventDefault();

        $('.text-danger').text('');
        $('#message').html('');

        let name = $('#name').val().trim();
        let age = $('#age').val().trim();
        let gender = $('input[name="gender"]:checked').val();
        let country = $('#country').val();

        let hasError = false;

        if (name === '') {
          $('#nameError').text('Name is required');
          hasError = true;
        }
        if (age === '') {
          $('#ageError').text('Age is required');
          hasError = true;
        }
        if (!gender) {
          $('#genderError').text('Please select gender');
          hasError = true;
        }
        if (country === '') {
          $('#countryError').text('Please select country');
          hasError = true;
        }

        if (!hasError) {
          let formData = $(this).serialize();
          $.ajax({
            url: 'ajax_seralize_process.php',
            type: 'POST',
            data: formData,
            success: function (response) {
              $('#message').html('<div class="alert alert-success">' + response + '</div>');
              setTimeout(() => $('#message').fadeOut(), 3000);
              $('#myForm')[0].reset();
            },
            error: function () {
              $('#message').html('<div class="alert alert-danger">Error submitting form.</div>');
              setTimeout(() => $('#message').fadeOut(), 3000);
            }
          });
        }
      });
    });
  </script>

</body>
</html>
