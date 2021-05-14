<?php
session_start();
session_unset();    
session_destroy();
setcookie('username', $username, time() -1, "/");
setcookie('password', $password, time() -1, "/");
header("location: main.php");
?>