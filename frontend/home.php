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
  canvas{
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>
</head>
<body>

<?php include("inc/top-nav.php");?>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 1: <a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Refrigerator</a></strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwh1"></canvas></div>
      <div><canvas id="canvasWatts1"></canvas></div>
      <div><canvas id="canvasAmper1"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 2: TV</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwh2"></canvas></div>
      <div><canvas id="canvasWatts2"></canvas></div>
      <div><canvas id="canvasAmper2"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 3: Lamp</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwh3"></canvas></div>
      <div><canvas id="canvasWatts3"></canvas></div>
      <div><canvas id="canvasAmper3"></canvas></div>
    </div>
  </div>
</div>


  <script>
    var configKwh1 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configWatts1 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configAmper1 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };

    
    var configKwh2 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configWatts2 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configAmper2 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };

    
    var configKwh3 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configWatts3 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configAmper3 = {
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
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Days'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };

    window.onload = function() {
      var ctxKwh1 = document.getElementById('canvasKwh1').getContext('2d');
      window.myLine = new Chart(ctxKwh1, configKwh1);
      var ctxAmper1 = document.getElementById('canvasAmper1').getContext('2d');
      window.myLine = new Chart(ctxAmper1, configAmper1);
      var ctxWatts1 = document.getElementById('canvasWatts1').getContext('2d');
      window.myLine = new Chart(ctxWatts1, configWatts1);

      var ctxKwh2 = document.getElementById('canvasKwh2').getContext('2d');
      window.myLine = new Chart(ctxKwh2, configKwh2);
      var ctxAmper2 = document.getElementById('canvasAmper2').getContext('2d');
      window.myLine = new Chart(ctxAmper2, configAmper2);
      var ctxWatts2 = document.getElementById('canvasWatts2').getContext('2d');
      window.myLine = new Chart(ctxWatts2, configWatts2);

      var ctxKwh3 = document.getElementById('canvasKwh3').getContext('2d');
      window.myLine = new Chart(ctxKwh3, configKwh3);
      var ctxAmper3 = document.getElementById('canvasAmper3').getContext('2d');
      window.myLine = new Chart(ctxAmper3, configAmper3);
      var ctxWatts3 = document.getElementById('canvasWatts3').getContext('2d');
      window.myLine = new Chart(ctxWatts3, configWatts3);
    };
  </script>

</body>
</html>
