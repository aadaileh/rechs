<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

include("library.php");

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

$library = new Library();
$data = $library->makeCurl ("/appliances/" . $_POST["id"], "PUT", $_POST);

// echo "<pre>data:\n";
// print_r($data);
// echo "</pre>";

if(isset($data->error) && !empty($data->error)) {
	echo "Something went wrong while saving data. <br/><small>Error: [" . $data->message . "]</small>";
} else {
	echo "true";
}

exit();

?>