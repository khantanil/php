<?php
session_start();
session_unset();
session_destroy();
header("Location: /php/project/forum/index.php");
exit();
