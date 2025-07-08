<?php

echo "Example of setting and getting cookies in PHP:\n";

setcookie("user", "Anil", time() + 86400, "/"); // 86400 = 1 day
if(isset($_COOKIE["user"])) {
    echo "Cookie 'user' is set!<br>";
    echo "Value: " . $_COOKIE["user"] . "<br>";
} else {
    echo "Cookie 'user' is not set!<br>";
}

?>