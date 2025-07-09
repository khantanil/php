<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "First Web";?></title>
</head>
<body>
    <?php 
    echo "Hello, World! This is my first PHP script.";

    // Variable example Variables are case sensitive
    $name = "Anil";
    $age = 25;
    echo "<br>My name is " . $name . " and I am " . $age . " years old.";


    
    // Datatype example
    $isStudent = true; // Boolean
    $height = 5.9; // Float
    echo "<br>Am I a student? " . ($isStudent ? "Yes" : "No") . ". My height is " . $height . " feet.";
    
    $marks = 85;  // Integer
    echo "<br>I scored " . $marks . " marks in the exam.";

    $course = "Web Development";    // String
    echo "<br>I am learning " . $course . ".";

    $colors = array("Red", "Green", "Blue"); // Array
    echo "<br>My favorite color is " . $colors[0] . ".";

    $middleName = null;   // Null
    echo "<br>My middle name is " . ($middleName ?? "not set") . ".";

    
    ?>
</body>
</html>