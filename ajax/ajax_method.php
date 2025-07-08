<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AJAX Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h2>Send Name using AJAX</h2>
    <form id="myForm">
        <input type="text" name="name" id="name" placeholder="Enter your name">
        <button type="submit">Submit</button>
    </form>
    <div id="result"></div>



<script>
    $(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault(); // Prevent full page reload

            var name = $('#name').val();

            if (name == "") {
                alert('name is required...');
            } else {
                $.ajax({
                    url: 'ajax_process.php',
                    type: 'POST',
                    data: {name: name},
                    success: function(response,status,xhr) {
                        $('#result').html(response);
                        // $('#response').html(status);
                    },
                    // This part only execute if we passed wrong url
                    error: function(xhr,status,response){
                        $('#result').html(response);
                        // alert(status);
                    }
                    
                });
            }

        });
    });
</script>
</body>
</html>

