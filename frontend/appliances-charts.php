<?php
ini_set('max_execution_time', 300); // 5minutes
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

include("inc/cgi/library.php");


$library = new Library();
$watts_Arrays_Frig = $library->getStats (3);
$watts_Arrays_Lamp = $library->getStats (1);
$watts_Arrays_Tv = $library->getStats (2);

// echo "<pre>watts_Arrays_Frig:";
// print_r($watts_Arrays_Frig);
// echo "</pre>";

// echo "<pre>watts_Arrays_Tv:";
// print_r($watts_Arrays_Tv);
// echo "</pre>";

// echo "<pre>watts_Arrays_Lamp:";
// print_r($watts_Arrays_Lamp);
// echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appliances Detailed Charts</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>
  <script type="text/javascript">
// Refrigerator
    var configWattsHourlyFrig = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Frig["hourly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$watts_Arrays_Frig["hourly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hourly'}}]
        }
      }
    };
    var configWattsDailyFrig = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Frig["daily"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.purple,
          borderColor: window.chartColors.purple,
          data: [<?php echo implode(",",$watts_Arrays_Frig["daily"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Daily'}}]
        }
      }
    };
    var configWattsMonthlyFrig = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Frig["monthly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays_Frig["monthly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Monthly'}}]
        }
      }
    };
    var configWattsYearlyFrig = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Frig["yearly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays_Frig["yearly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Yearly'}}]
        }
      }
    };
 

// TV
    var configWattsHourlyTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Tv["hourly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$watts_Arrays_Tv["hourly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hourly'}}]
        }
      }
    };
    var configWattsDailyTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Tv["daily"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.purple,
          borderColor: window.chartColors.purple,
          data: [<?php echo implode(",",$watts_Arrays_Tv["daily"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Daily'}}]
        }
      }
    };
    var configWattsMonthlyTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Tv["monthly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays_Tv["monthly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Monthly'}}]
        }
      }
    };
    var configWattsYearlyTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Tv["yearly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays_Tv["yearly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Yearly'}}]
        }
      }
    };

 

// Lamp
    var configWattsHourlyLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Lamp["hourly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$watts_Arrays_Lamp["hourly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hourly'}}]
        }
      }
    };
    var configWattsDailyLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Lamp["daily"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.purple,
          borderColor: window.chartColors.purple,
          data: [<?php echo implode(",",$watts_Arrays_Lamp["daily"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Daily'}}]
        }
      }
    };
    var configWattsMonthlyLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Lamp["monthly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays_Lamp["monthly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Monthly'}}]
        }
      }
    };
    var configWattsYearlyLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays_Lamp["yearly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [<?php echo implode(",",$watts_Arrays_Lamp["yearly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: ''}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Yearly'}}]
        }
      }
    };

    window.onload = function() {

      //Lamp
      var ctxWattsHourlyLamp = document.getElementById('canvasWattsHourlyLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsHourlyLamp, configWattsHourlyLamp);
      var ctxWattsDailyLamp = document.getElementById('canvasWattsDailyLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsDailyLamp, configWattsDailyLamp);
      var ctxWattsMonthlyLamp = document.getElementById('canvasWattsMonthlyLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsMonthlyLamp, configWattsMonthlyLamp);
      var ctxWattsYearlyLamp = document.getElementById('canvasWattsYearlyLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsYearlyLamp, configWattsYearlyLamp);
      
      //Tv
      var ctxWattsHourlyTv = document.getElementById('canvasWattsHourlyTv').getContext('2d');
      window.myLine = new Chart(ctxWattsHourlyTv, configWattsHourlyTv);
      var ctxWattsDailyTv = document.getElementById('canvasWattsDailyTv').getContext('2d');
      window.myLine = new Chart(ctxWattsDailyTv, configWattsDailyTv);
      var ctxWattsMonthlyTv = document.getElementById('canvasWattsMonthlyTv').getContext('2d');
      window.myLine = new Chart(ctxWattsMonthlyTv, configWattsMonthlyTv);
      var ctxWattsYearlyTv = document.getElementById('canvasWattsYearlyTv').getContext('2d');
      window.myLine = new Chart(ctxWattsYearlyTv, configWattsYearlyTv);

      //Frig
      var ctxWattsHourlyFrig = document.getElementById('canvasWattsHourlyFrig').getContext('2d');
      window.myLine = new Chart(ctxWattsHourlyFrig, configWattsHourlyFrig);
      var ctxWattsDailyFrig = document.getElementById('canvasWattsDailyFrig').getContext('2d');
      window.myLine = new Chart(ctxWattsDailyFrig, configWattsDailyFrig);
      var ctxWattsMonthlyFrig = document.getElementById('canvasWattsMonthlyFrig').getContext('2d');
      window.myLine = new Chart(ctxWattsMonthlyFrig, configWattsMonthlyFrig);
      var ctxWattsYearlyFrig = document.getElementById('canvasWattsYearlyFrig').getContext('2d');
      window.myLine = new Chart(ctxWattsYearlyFrig, configWattsYearlyFrig);      

    };    
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

<div style="width: 100%; padding: 0 15px 0 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Applainces Charts Overview</h4>
      Both Kwh and Watts are shown for all three appliances. Every parameter is divided into 4 groups: 
      <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange;">Hourly</span>,
      <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:purple;">Daily</span>,
      <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:red">Monthly</span> and
      <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:blue;">Yearly</span>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 1: Refrigerator</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasWattsHourlyFrig"></canvas></div>
      <div><canvas id="canvasWattsDailyFrig"></canvas></div>
      <div><canvas id="canvasWattsMonthlyFrig"></canvas></div>
      <div><canvas id="canvasWattsYearlyFrig"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 2: TV</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasWattsHourlyTv"></canvas></div>
      <div><canvas id="canvasWattsDailyTv"></canvas></div>
      <div><canvas id="canvasWattsMonthlyTv"></canvas></div>
      <div><canvas id="canvasWattsYearlyTv"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 3: Lamp</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasWattsHourlyLamp"></canvas></div>
      <div><canvas id="canvasWattsDailyLamp"></canvas></div>
      <div><canvas id="canvasWattsMonthlyLamp"></canvas></div>
      <div><canvas id="canvasWattsYearlyLamp"></canvas></div>
    </div>
  </div>
</div>

</body>
</html>