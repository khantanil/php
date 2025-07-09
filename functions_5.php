<?php

function processMarks($marks){
    $sum = 0;
    foreach($marks as $mark){
        $sum += $mark;
    }
    return $sum;
}

$Anil = [ 90,79,48,99,34];
processMarks($Anil);
echo "Total marks of Anil is : " . processMarks($Anil) . "<br>";

?>