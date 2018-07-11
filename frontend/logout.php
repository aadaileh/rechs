<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);


echo "<pre>_SESSION:</br>";
print_r($_SESSION);
echo "</pre>";

unset($_SESSION["user"]);
$_SESSION["user"] = null;
header('Location: /login.php');
?>