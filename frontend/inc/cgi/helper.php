<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

ini_set("memory_limit", "-1");
set_time_limit(0);



function adjustValue($value, $kwh_watt, $to) {

  //frig: 278 Kwh, 157 Watt
  //tv:    96 Kwh,  69 Watt
  //lamp:   6 Kwh,   2 Watt

  switch ($to) {
    case 'tv':
      if($kwh_watt == "kwh") {
        //convert frig kwh to tv
        return $value * (96 / 278);
      }

      if($kwh_watt == "watt") {
        //convert frig watt to tv
        return $value * (69 / 157);
      }      
      break;
    
    case 'lamp':
      if($kwh_watt == "kwh") {
        //convert frig kwh to lamp
        return $value * (6 / 278);
      }

      if($kwh_watt == "watt") {
        //convert frig watt to lamp
        return $value * (2 / 157);
      } 
      break;

  }
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rechs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM measurments where appliance_id=3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "kwh: " . $row["kwh"] . "<br>";
        echo $sql1 = "INSERT INTO measurments_neu (appliance_id, amps, kwh, volts, watts, created_timestamp, updated_timestamp, created_by) VALUES (
        '1', 
        '" . $row["amps"] . "', 
        '" . adjustValue($row["kwh"], "kwh", "lamp") . "',
        '" . $row["volts"] . "',
        '" . adjustValue($row["watts"], "watt", "lamp") . "',
        '" . $row["created_timestamp"] . "',
        '" . $row["updated_timestamp"] . "',
        'patch')";
        if ($conn->query($sql1) === TRUE) {
            //echo "New record created successfully";
        } else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }

echo "<br>";

        echo $sql2 = "INSERT INTO measurments_neu (appliance_id, amps, kwh, volts, watts, created_timestamp, updated_timestamp, created_by) VALUES (
        '2', 
        '" . $row["amps"] . "', 
        '" . adjustValue($row["kwh"], "kwh", "tv") . "',
        '" . $row["volts"] . "',
        '" . adjustValue($row["watts"], "watt", "tv") . "',
        '" . $row["created_timestamp"] . "',
        '" . $row["updated_timestamp"] . "',
        'patch')";

        if ($conn->query($sql2) === TRUE) {
            //echo "New record created successfully";
        } else {
            echo "Error2: " . $sql2 . "<br>" . $conn->error;
        }

        echo "<br><br>";        

    }
} else {
    echo "0 results";
}
$conn->close();



?>