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

echo "<pre>_POST:\n";
print_r($_POST);
echo "</pre>";

echo "<pre>_GET:\n";
print_r($_GET);
echo "</pre>";

exit();


//when GET is set
if(isset($_GET) && count($_GET)>0) {

	$library = new Library();
	$data = $library->makeCurl ("/appliances/" . $_GET["id"] . "/" . $_GET["action"], "PATCH");

	echo "<pre>data(1):\n";
	print_r($data);
	echo "</pre>";

	if(isset($data->error) && !empty($data->error)) {
		echo "Something went wrong while activating the schedule id [".$_GET["id"]."]. <br/><small>Error: [" . $data->message . "]</small>";
	} else {
		echo "true";
	}
	exit();

}




if($_POST["flag"] != "standby") {
	// Check if appliance's data are set and correct
	if($_POST["label"] == "") {$errors[] = "The field 'Label' is empty. Please check and try again";}
	if($_POST["annualEnergyConsumption"] == "") {$errors[] = "The field 'Annual Energy Consumption (kwh)' is empty. Please check and try again";}
	if($_POST["hourlyEnergyConsumption"] == "") {$errors[] = "The field 'Energy consumption (Watts)' is empty. Please check and try again";}
	if($_POST["energyEfficientClass"] == "") {$errors[] = "The field 'Energy Efficient Class' is empty. Please check and try again";}
	if($_POST["size"] == "") {$errors[] = "The field 'Size' is empty. Please check and try again";}

	if (count($errors) > 0 ) {
		echo "Something went wrong while saving data. <br/>";
		echo "<ul>";
		foreach ($errors as $key => $value) {
			echo "<li>" . $value . "</li>";
		}
		echo "</ul>";
		exit();
	}
}

$library = new Library();
$data = $library->makeCurl ("/appliances/" . $_POST["id"], "PUT", $_POST);

echo "<pre>data:\n";
print_r($data);
echo "</pre>";

if(isset($data->error) && !empty($data->error)) {
	echo "Something went wrong while saving data. <br/><small>Error: [" . $data->message . "]</small>";
} else {
	echo "true";//.serialize($_POST);
}

exit();

?>