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

</head>
<body>

<?php include("inc/top-nav.php");?>

<br><br><br><br>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="Refrigerator: Bosch Model ETS 1234"><img src="inc/img/fridge.svg" width="50%"></a>
</div>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="TV: LG Model WS 567"><img src="inc/img/tv.svg" width="50%"></a>
</div>

<div style="float:left; width: 33%; text-align: center;">
  <a href="#" data-toggle="tooltip" title="Lamp: Normal lamp 0.2 Kwh"><img src="inc/img/lamp.svg" width="50%"></a>
</div>


</body>
</html>
