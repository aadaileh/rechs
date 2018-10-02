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

// echo "<pre>_POST:\n";
// print_r($_POST);
// echo "</pre>";

  if(isset($_POST) && count($_POST)>0) {

    $library = new Library();
    $data = $library->makeCurl ("/users/", "PUT", $_POST);

    // echo "<pre>data:\n";
    // print_r($data);
    // echo "</pre>";

    if(isset($data->error) && !empty($data->error)) {
    	http_response_code(400);
      echo "Something went wrong while saving data. <br/><small>Error: [" . $data->message . "]</small>";
    } else {
    	http_response_code(200);
    }
  }

?>