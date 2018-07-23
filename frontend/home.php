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

  //Refrigerator
  // $kwh_data = $library->makeCurl ("/measurments/kwh/appliance/3/group-by/all", "GET");
  // $kwh_measurmentArray = Array();
  // $kwh_datesArray = Array();
  // $kwh_allTogetherArray = Array();
  // foreach ($kwh_data as $kwh_key => $kwh_value) {
  //   array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
  //   array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  // }
  // $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  // $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  // $kwh_Arrays = $kwh_allTogetherArray;

  $watts_data = $library->makeCurl ("/measurments/watts/appliance/3/group-by/all", "GET");
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


  //TV
  // $tv_kwh_data = $library->makeCurl ("/measurments/kwh/appliance/2/group-by/hour", "GET");
  // $tv_kwh_measurmentArray = Array();
  // $tv_kwh_datesArray = Array();
  // $tv_kwh_allTogetherArray = Array();
  // foreach ($tv_kwh_data as $tv_kwh_key => $tv_kwh_value) {
  //   array_push($tv_kwh_measurmentArray, $tv_kwh_value->avgmeasurment);
  //   array_push($tv_kwh_datesArray, $tv_kwh_value->concatedDateTime);
  // }
  // $tv_kwh_allTogetherArray["measurment"] = $tv_kwh_measurmentArray;
  // $tv_kwh_allTogetherArray["dates"] = $tv_kwh_datesArray;
  // $tv_kwh_Arrays = $tv_kwh_allTogetherArray;

  $tv_watts_data = $library->makeCurl ("/measurments/watts/appliance/2/group-by/hour", "GET");
  $tv_watts_measurmentArray = Array();
  $tv_watts_datesArray = Array();
  $tv_watts_allTogetherArray = Array();
  foreach ($tv_watts_data as $tv_watts_key => $tv_watts_value) {
    array_push($tv_watts_measurmentArray, $tv_watts_value->avgmeasurment);
    array_push($tv_watts_datesArray, $tv_watts_value->concatedDateTime);
  }
  $tv_watts_allTogetherArray["measurment"] = $tv_watts_measurmentArray;
  $tv_watts_allTogetherArray["dates"] = $tv_watts_datesArray;
  $tv_watts_Arrays = $tv_watts_allTogetherArray;


  //LAMP
  // $lamp_kwh_data = $library->makeCurl ("/measurments/kwh/appliance/1/group-by/hour", "GET");
  // $lamp_kwh_measurmentArray = Array();
  // $lamp_kwh_datesArray = Array();
  // $lamp_kwh_allTogetherArray = Array();
  // foreach ($lamp_kwh_data as $lamp_kwh_key => $lamp_kwh_value) {
  //   array_push($lamp_kwh_measurmentArray, $lamp_kwh_value->avgmeasurment);
  //   array_push($lamp_kwh_datesArray, $lamp_kwh_value->concatedDateTime);
  // }
  // $lamp_kwh_allTogetherArray["measurment"] = $lamp_kwh_measurmentArray;
  // $lamp_kwh_allTogetherArray["dates"] = $lamp_kwh_datesArray;
  // $lamp_kwh_Arrays = $lamp_kwh_allTogetherArray;

  $lamp_watts_data = $library->makeCurl ("/measurments/watts/appliance/1/group-by/hour", "GET");
  $lamp_watts_measurmentArray = Array();
  $lamp_watts_datesArray = Array();
  $lamp_watts_allTogetherArray = Array();
  foreach ($lamp_watts_data as $lamp_watts_key => $lamp_watts_value) {
    array_push($lamp_watts_measurmentArray, $lamp_watts_value->avgmeasurment);
    array_push($lamp_watts_datesArray, $lamp_watts_value->concatedDateTime);
  }
  $lamp_watts_allTogetherArray["measurment"] = $lamp_watts_measurmentArray;
  $lamp_watts_allTogetherArray["dates"] = $lamp_watts_datesArray;
  $lamp_watts_Arrays = $lamp_watts_allTogetherArray;

  // echo "<pre>kwh_Arrays:";
  // print_r($kwh_Arrays);
  // echo "</pre>";
  // echo "<pre>watts_Arrays:";
  // print_r($watts_Arrays);
  // echo "</pre>";
  // echo "<pre>amps_Arrays:";
  // print_r($amps_Arrays);
  // echo "</pre>";

  // echo "<pre>tv_kwh_Arrays:";
  // print_r($tv_kwh_Arrays);
  // echo "</pre>";
  // echo "<pre>tv_watts_Arrays:";
  // print_r($tv_watts_Arrays);
  // echo "</pre>";
  // echo "<pre>tv_amps_Arrays:";
  // print_r($tv_amps_Arrays);
  // echo "</pre>";

  // echo "<pre>lamp_kwh_Arrays:";
  // print_r($lamp_kwh_Arrays);
  // echo "</pre>";
  // echo "<pre>lamp_watts_Arrays:";
  // print_r($lamp_watts_Arrays);
  // echo "</pre>";
  // echo "<pre>lamp_amps_Arrays:";
  // print_r($lamp_amps_Arrays);
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
  #customized-home-panel{
    width: 100%;
    padding: 5px;
  }
  </style>
</head>
<body>

<?php include("inc/cgi/top-nav.php");?>


  <div class="row">
    <div class="col-sm-6">

      <div style="" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong data-toggle="tooltip" title="Bosch Model 1234 Extra">Node 1: Refrigerator</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsFrigerator"></canvas></div>
          </div>
        </div>
      </div>

      <div style="" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong>Node 2: TV</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsTv"></canvas></div>
          </div>
        </div>
      </div>

      <div style="" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong>Node 3: Lamp</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsLamp"></canvas></div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6">

      <div style="float:left;" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><a href="energy-provider-optimizer.php" data-toggle="tooltip" title="Energy Provider Optimizer" style="color:white;">
            <strong>EPO</strong> (<strong>E</strong>nergy <strong>P</strong>rovider <strong>O</strong>ptimizer)</a>
          </div>
          <div class="panel-body">
            First time visited:<br>
            Click <a href="/energy-provider-optimizer.php">here</a> to activate the Energy Provider Optimizer.<br><br>

            View shown after activating the EPO (Energy Provider Optimizer):<br>
            Searching for proper Energy Provider has revelaed the following result(s):<br>
            1. XYZ Energy Provider<br>

            Your current annual Electricity costs are XXX€. Once you switch to the suggested XYZ Energy Provider, you can save up to XX% of your costs. This means XX€ less annualy.
            <br><br>
          </div>
        </div>
      </div>

      <div style="float:left;" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Appliance Exchange Suggester">
            <strong>ARS</strong> (<strong>A</strong>ppliance <strong>R</strong>eplacement <strong>S</strong>uggester)</span>
          </div>
          <div class="panel-body">
            Based on the calculated energy consumption, RECHS can make following suggestions:<br/><br/>
            <strong>Node #1: (Refrigerator):</strong><br/>
            Lorem ipsum dolor amet
            <br><br>

            <strong>Node #2: (TV):</strong><br/>
            Lorem ipsum dolor amet
            <br><br>

            <strong>Node #3: (Lamp):</strong><br/>
            Lorem ipsum dolor amet
            <br><br>
          </div>
        </div>
      </div>

      <div style="float:right; clear: right;" id="customized-home-panel">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="A module defines the standby values and completely switch off the appliance when not needed"><strong>SH</strong> (<strong>S</strong>tandby <strong>H</strong>unter)</span></div>
          <div class="panel-body">
            
            Based on the calculated standby energy consumption and behaviour, RECHS has ascertained the following facts:<br/><br/>
            <strong>Node #1: (Refrigerator):</strong><br/>
            <strong style="color:red;">Standby is turned off.</strong> No tracking, neither suggestions are made. To turn it on, please refer to <a href="/appliances-overview.php">Appliances overview module</a>
            <br><br>

            <strong>Node #2: (TV):</strong><br/>
            Lorem ipsum dolor amet
            <br><br>

            <strong>Node #3: (Lamp):</strong><br/>
            Lorem ipsum dolor amet
            <br><br>
          </div>
        </div>
      </div>

    </div>
  </div>














  <script>
    var configWattsFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
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

    
    var configWattsTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $tv_watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$tv_watts_Arrays["measurment"]);?>],
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hours'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };

    
    var configWattsLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $lamp_watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$lamp_watts_Arrays["measurment"]);?>],
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hours'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };

    window.onload = function() {
      var ctxWattsFrigerator = document.getElementById('canvasWattsFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsFrigerator, configWattsFrigerator);

      var ctxWattsTv = document.getElementById('canvasWattsTv').getContext('2d');
      window.myLine = new Chart(ctxWattsTv, configWattsTv);

      var ctxWattsLamp = document.getElementById('canvasWattsLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsLamp, configWattsLamp);
    };
  </script>

</body>
</html>
