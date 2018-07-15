<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}


    function makeCurl ($measurment) {

      $url = "http://127.0.0.1:8282/api/measurments/".$measurment."/appliance/3";

      $curl = curl_init();
      curl_setopt_array(
        $curl, 
        array(
          CURLOPT_URL => $url,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_PORT=>"8282",
          CURLOPT_RETURNTRANSFER=>true,
          CURLOPT_ENCODING=>"",
          CURLOPT_MAXREDIRS=>10,
          CURLOPT_TIMEOUT=>30,
          CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
          CURLOPT_HTTPHEADER => array("authorization: Basic YXBpdXNlcjpwYXNz","content-type: application/json")
        )
      );
      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);
      if ($err) {
      echo "cURL Error #:" . $err;
        $error = "Error while retrieving the: " . $measurment;
      } else {
      $data = json_decode($response);
    }

  // echo "<pre>data:";
  // print_r($data);
  // echo "</pre>";

    $measurmentArray = Array();
    $datesArray = Array();
    $allTogetherArray = Array();
    foreach ($data as $key => $value) {
      array_push($measurmentArray, $value->avgmeasurment);
      array_push($datesArray, $value->concatedDateTime);
    }

    $allTogetherArray["measurment"] = $measurmentArray;
    $allTogetherArray["dates"] = $datesArray;

    return $allTogetherArray;
  }

  $kwhArrays = makeCurl ('kwh');
  $wattsArrays = makeCurl ('watts');
  $ampsArrays = makeCurl ('amps');

  // echo "<pre>kwhArrays:";
  // print_r($kwhArrays);
  // echo "</pre>";

  // echo "<pre>wattsArrays:";
  // print_r($wattsArrays);
  // echo "</pre>";

  // echo "<pre>ampsArrays:";
  // print_r($ampsArrays);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>RECHS - Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>

  <script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script>

  <style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<script>
$(document).ready(function(){
    $("#stand-by-button").click(function(){


        $.post("/inc/appliances-save.php",
          {
            standBy: document.getElementById("stand-by-button").checked,
            city: "Duckburg"
          },
        
        function(data, status){
          //alert("Data: " + data + "\nStatus: " + status);
          $("#stand-by-button-response").text(data);
        });


    });
});
</script>

</head>
<body>

<?php include("inc/top-nav.php");?>

<br><br><br><br>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="Refrigerator: Bosch Model ETS 1234"><img src="inc/img/fridge.svg" width="50%"></a>
  1)On/off Function
  2)Appliance details:
    -Fridge: Type,Energy consumption,size
    -TV: Type, energy consumption, size(in feet)
    -Light: Type, energy consumption, Strength
  3)Activate Stand-by mode: Yes/No
  4)Link to the schedular
  5)

  <label class="switch">Stand-by Mode
    <input id="stand-by-button" type="checkbox">
    <span class="slider round"></span>
  </label>
  <div id="stand-by-button-response" style="color: red;"></div>
</div>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="TV: LG Model WS 567"><img src="inc/img/tv.svg" width="50%"></a>
</div>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="Lamp: Normal lamp 0.2 Kwh"><img src="inc/img/lamp.svg" width="50%"></a>
</div>


</body>
</html>
