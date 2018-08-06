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

$switchOptionEvery = Array();
foreach ($_POST as $key => $value) {
	if(strpos($key, "switchOptionEvery") !== false && strpos($key, "switchOptionEveryDay") === false) {
		if($value == "true") {
			$switchOptionEvery[] = str_replace("switchOptionEvery", "", $key);
		}
	}
}
$_POST["repeat_every"] = implode("-", $switchOptionEvery);

  // echo "<pre>_POST:\n";
  // print_r($_POST);
  // echo "</pre>";

if(empty($_POST["begin"]) && empty($_POST["end"])) {
	echo "Both dates are empty. Either 'start' or 'end' date must be defined.";
	exit();
}

if($_POST["switchOptionEveryDay"] == "false" && 
	$_POST["switchOptionEveryMonday"] == "false" && 
	$_POST["switchOptionEveryTuesday"] == "false" && 
	$_POST["switchOptionEveryWednesday"] == "false" && 
	$_POST["switchOptionEveryThursday"] == "false" && 
	$_POST["switchOptionEveryFriday"] == "false" && 
	$_POST["switchOptionEverySaturday"] == "false" && 
	$_POST["switchOptionEverySunday"] == "false") {
	echo "The field 'repeated every' is not defined. You must choose at least one field";
	exit();
}

  $library = new Library();
  $data = $library->makeCurl ("/appliances/" . $_POST["id"] . "/schedule/add", "POST", $_POST);

  // echo "<pre>data:\n";
  // print_r($data);
  // echo "</pre>";

  if(isset($data->error) && !empty($data->error)) {
  	echo "Something went wrong while saving data. <br/><small>Error: [" . $data->message . "]</small>";
  } else {
  	echo "true";
  }

?>