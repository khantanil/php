<?php

$json = '{"name":"Alice","age":25,"is_admin":"true"}';

$data = json_decode($json); // `true` gives associative array
// echo $data['name']; // Alice

foreach ($data as $key => $value) {
    echo "<br>$key: $value\n";
}
?>