<?php 

$a = 10;
$b = 20;

if($a >= 10 && $b == 20) {
    echo "a is greater than b";
} else {
    echo "<br>a is not greater than b";
}

// Using if-else statement
$age = 14;

if($age >= 18) {
    echo "<br>You can drink alcohol.";
} elseif($age>=10) {
    echo "<br>You can't drink alcohol.";
} else {
    echo "<br>You are too young to drink alcohol.";
}

// Nested if statement
$a = 13;

if ($a > 10) {
  echo "Above 10";
  if ($a > 20) {
    echo " and also above 20";
  } else {
    echo " but not above 20";
  }
}


$day = "Saturday";

switch ($day) {
    case "Monday":
        echo "<br>Today is Monday";
        break;
    case "Tuesday":
        echo "<br>Today is Tuesday";
        break;
    case "Wednesday":
        echo "<br>Today is Wednesday";
        break;
    case "Thursday":
        echo "<br>Today is Thursday";
        break;
    case "Friday":
        echo "<br>Today is Friday";
        break;
    case "Saturday":
        echo "<br>Today is Saturday";
        break;
    case "Sunday":
        echo "<br>Today is Sunday";
        break;
    default:
        echo "<br>Invalid day";
}

?>