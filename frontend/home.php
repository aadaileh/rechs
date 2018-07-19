<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

include("inc/cgi/library.php");

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

  $library = new Library();

  $kwh_data = $library->makeCurl ("/measurments/kwh/appliance/3", "GET");
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays = $kwh_allTogetherArray;


  $watts_data = $library->makeCurl ("/measurments/watts/appliance/3", "GET");
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays = $watts_allTogetherArray;


  $amps_data = $library->makeCurl ("/measurments/amps/appliance/3", "GET");
  $amps_measurmentArray = Array();
  $amps_datesArray = Array();
  $amps_allTogetherArray = Array();
  foreach ($amps_data as $amps_key => $amps_value) {
    array_push($amps_measurmentArray, $amps_value->avgmeasurment);
    array_push($amps_datesArray, $amps_value->concatedDateTime);
  }
  $amps_allTogetherArray["measurment"] = $amps_measurmentArray;
  $amps_allTogetherArray["dates"] = $amps_datesArray;
  $amps_Arrays = $amps_allTogetherArray;  

  // echo "<pre>kwh_Arrays:";
  // print_r($kwh_Arrays);
  // echo "</pre>";

  // echo "<pre>watts_Arrays:";
  // print_r($watts_Arrays);
  // echo "</pre>";

  // echo "<pre>amps_Arrays:";
  // print_r($amps_Arrays);
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

<?php include("inc/cgi/top-nav.php");?>

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
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $amps_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$amps_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $amps_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$amps_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays["measurment"]);?>],
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
        labels: [<?php echo "'" . implode("', '", $amps_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$amps_Arrays["measurment"]);?>],
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
