<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Example of $_SERVER super global -->
    <!-- <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        Name: <input type="text" name="name" required><br>
        Age: <input type="number" name="age" required><br>
        <input type="submit" value="Submit" name="submit"> <br>
    </form> -->

    <!-- <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $age = $_POST['age'];

        echo "Name: " . htmlspecialchars($name) . "<br>";
        echo "Age: " . htmlspecialchars($age) . "<br>";

    }
    ?> -->

    <!-- Example of $_GET super global -->
    <form action="submit_data.php" method="get">
    <!-- <form action="submit_data.php" method="post"> -->
        Name: <input type="text" name="name" required><br> <br>
        Age: <input type="number" name="age" required><br> <br>
        <input type="submit" value="Submit" name="submit"> <br> <br>
    </form>



</body>

</html>


 // $upload_dir = 'uploads/';
        $upload_dir = dirname(__DIR__) . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);  // Creates directory if it doesn't exist
        }


        if (move_uploaded_file($file_tmp_name, $upload_dir . $file_name)) {
            echo "File uploaded successfully to 'uploads/' directory.<br>";
        } else {
            echo "Failed to upload file.<br>";
        }