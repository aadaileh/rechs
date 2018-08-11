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


  echo "<pre>_GET:\n";
  print_r($_GET);
  echo "</pre>";

  echo "<pre>_POST:\n";
  print_r($_POST);
  echo "</pre>";

//exit();

//when GET is set
if(isset($_GET) && count($_GET)>0) {

	if($_GET["action"] == "delete") {
		$verb = "DELETE";
	} else {
		$verb = "PUT";
	}

	$library = new Library();
	$data = $library->makeCurl ("/appliances/schedule/" . $_GET["id"] . "/" . $_GET["action"], $verb);

	echo "<pre>data:\n";
	print_r($data);
	echo "</pre>";

	if(isset($data->error) && !empty($data->error)) {
		echo "Something went wrong while activating the schedule id [".$_GET["id"]."]. <br/><small>Error: [" . $data->message . "]</small>";
	} else {
		echo "true";
	}
	exit();

}

// if(empty($_POST["begin"]) && empty($_POST["end"])) {
// 	echo "Both dates are empty. Either 'start' or 'end' date must be defined.";
// 	exit();
// }

  $library = new Library();
  $data = $library->makeCurl ("/appliances/", "POST", $_POST);

  echo "<pre>data:\n";
  print_r($data);
  echo "</pre>";

  if(isset($data->error) && !empty($data->error)) {
  	echo "Something went wrong while saving data. <br/><small>Error: [" . $data->message . "]</small>";
  } else {
  	echo "true";
  }

?>