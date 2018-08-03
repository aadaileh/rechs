<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

switch ($_POST["standBy"]) {
  case 'true':
    echo "Stand-by Mode is turned ON".implode(",", $_POST);
    break;
  
  case 'false':
    echo "Stand-by Mode is turned OFF";
    break;

  default:
    echo "No status defined. Something went wrong!!";
    break;
}


?>