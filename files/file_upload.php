<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Example of file upload</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">Choose a file:</label>
        <input type="file" name="filetoupload" id="file" required> <br>
        <input type="submit" value="Upload File">
    </form>

    <?php

    

        if(isset($_FILES['filetoupload'])){

            echo "<pre>";
            print_r($_FILES['filetoupload']);   
            echo "</pre>";
            
            $file_name = $_FILES['filetoupload']['name'];
            echo "File Name: " . $file_name . "<br>";
            
            $file_type = $_FILES['filetoupload']['type'];
            echo "File Type: " . $file_type . "<br>";
            
            $file_size = $_FILES['filetoupload']['size'];
            echo "File Size: " . $file_size . " bytes<br>";
            
            $file_tmp_name = $_FILES['filetoupload']['tmp_name'];
            echo "Temporary File Name: " . $file_tmp_name . "<br><br>";
            


            // Go up one level to reach 'php/' from 'php/files/'
            $upload_dir = dirname(__DIR__) . '/uploads/';


            // Create uploads folder in current directory if it doesn't exist
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);  // create directory
            }

            $destination = $upload_dir . $file_name;    

            if (move_uploaded_file($file_tmp_name, $destination)) {
                echo "File uploaded successfully to 'uploads/' directory.<br>";
            } else {
                echo "Failed to upload file.<br>";
            }

        }
    ?>
</body>
</html>