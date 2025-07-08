<?php 

// While Loop Example
$i = 0;

while($i <= 50){
    echo "The number is: $i <br>";
    if($i ==3)
        break;
    $i+=10;
}


// For Loop Example
for($i = 0; $i <= 10; $i+=2){
     if($i == 6)
        continue;
    echo "The number is: $i <br>";
   
}

?>