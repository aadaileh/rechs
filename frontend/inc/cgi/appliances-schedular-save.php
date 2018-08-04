<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//sleep(4);
switch ('falsexx') {
  case 'true':
    echo "true";
    break;
  
  case 'false':
    echo "false";
    break;

  default:
    echo serialize($_POST);
    break;
}


?>