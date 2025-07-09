<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery $.get() Example</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <h2>Example of $.get()</h2>
    <form id="myForm">
        Name : <input type="text" name="name" id="nameInput" placeholder="Enter your name"> <br><br>
        Age : <input type="number" name="age" min="0" max="120" id="age" placeholder="age"> <br><br>
        <button type="submit" id="greetBtn">Greet</button>
    </form>
    <p id="result" style="font-weight: bold; color: green;"></p>


    <script>
        $(document).ready(function() {
            $('#myForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                let name = $('#nameInput').val();
                let age = $('#age').val();

                if (name === "" && age === "") {
                    $('#result').text("Please enter your name and age.");
                    return;
                } else if (name === "") {
                    $('#result').text("Please enter your name.");
                    return;
                } else if (age === "") {
                    $('#result').text("Please enter your age.");
                    return;
                }

                let formData = $(this).serialize(); // Now it's correct, 'this' refers to form

                $.get("greet_get.php", formData, function(data) {
                    $('#result').text(data);
                });
            });
        });
    </script>
</body>

</html>