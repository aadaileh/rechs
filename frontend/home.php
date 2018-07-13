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
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>


  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>
  <style>
  canvas{
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>
</head>
<body>

<?php include("inc/top-nav.php");?>

  <div style="width:31%;"><canvas id="canvasKwh"></canvas></div>
  <div style="width:31%;"><canvas id="canvasWatts"></canvas></div>
  <div style="width:50%;"><canvas id="canvasAmper"></canvas></div>

  <script>
    var configKwh = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwhArrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwhArrays["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Node Nr. 3 Consumption Development (3 Months)'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Days'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Measurment'
            }
          }]
        }
      }
    };

    var configWatts = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwhArrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$wattsArrays["measurment"]);?>],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: ''
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Days'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Measurment'
            }
          }]
        }
      }
    };

    var configAmper = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwhArrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$ampsArrays["measurment"]);?>],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: ''
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Days'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Measurment'
            }
          }]
        }
      }
    };

    window.onload = function() {
      var ctxKwh = document.getElementById('canvasKwh').getContext('2d');
      window.myLine = new Chart(ctxKwh, configKwh);

      var ctxAmper = document.getElementById('canvasAmper').getContext('2d');
      window.myLine = new Chart(ctxAmper, configAmper);

      var ctxWatts = document.getElementById('canvasWatts').getContext('2d');
      window.myLine = new Chart(ctxWatts, configWatts);
    };
  </script>

</body>
</html>
