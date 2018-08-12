<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("inc/cgi/library.php");

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

  $library = new Library();

  //Refrigerator
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/all", "GET"));
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

  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/all", "GET"));
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

  $amps_data = $library->sortArray($library->makeCurl ("/measurments/amps/appliance/3/group-by/all", "GET"));
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


  //TV
  $tv_kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/2/group-by/hour", "GET"));
  $tv_kwh_measurmentArray = Array();
  $tv_kwh_datesArray = Array();
  $tv_kwh_allTogetherArray = Array();
  foreach ($tv_kwh_data as $tv_kwh_key => $tv_kwh_value) {
    array_push($tv_kwh_measurmentArray, $tv_kwh_value->avgmeasurment);
    array_push($tv_kwh_datesArray, $tv_kwh_value->concatedDateTime);
  }
  $tv_kwh_allTogetherArray["measurment"] = $tv_kwh_measurmentArray;
  $tv_kwh_allTogetherArray["dates"] = $tv_kwh_datesArray;
  $tv_kwh_Arrays = $tv_kwh_allTogetherArray;

  $tv_watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/2/group-by/hour", "GET"));
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

  $tv_amps_data = $library->sortArray($library->makeCurl ("/measurments/amps/appliance/2/group-by/hour", "GET"));
  $tv_amps_measurmentArray = Array();
  $tv_amps_datesArray = Array();
  $tv_amps_allTogetherArray = Array();
  foreach ($tv_amps_data as $tv_amps_key => $tv_amps_value) {
    array_push($tv_amps_measurmentArray, $tv_amps_value->avgmeasurment);
    array_push($tv_amps_datesArray, $tv_amps_value->concatedDateTime);
  }
  $tv_amps_allTogetherArray["measurment"] = $tv_amps_measurmentArray;
  $tv_amps_allTogetherArray["dates"] = $tv_amps_datesArray;
  $tv_amps_Arrays = $tv_amps_allTogetherArray;


    //LAMP
  $lamp_kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/1/group-by/hour", "GET"));
  $lamp_kwh_measurmentArray = Array();
  $lamp_kwh_datesArray = Array();
  $lamp_kwh_allTogetherArray = Array();
  foreach ($lamp_kwh_data as $lamp_kwh_key => $lamp_kwh_value) {
    array_push($lamp_kwh_measurmentArray, $lamp_kwh_value->avgmeasurment);
    array_push($lamp_kwh_datesArray, $lamp_kwh_value->concatedDateTime);
  }
  $lamp_kwh_allTogetherArray["measurment"] = $lamp_kwh_measurmentArray;
  $lamp_kwh_allTogetherArray["dates"] = $lamp_kwh_datesArray;
  $lamp_kwh_Arrays = $lamp_kwh_allTogetherArray;

  $lamp_watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/1/group-by/hour", "GET"));
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

  $lamp_amps_data = $library->sortArray($library->makeCurl ("/measurments/amps/appliance/1/group-by/hour", "GET"));
  $lamp_amps_measurmentArray = Array();
  $lamp_amps_datesArray = Array();
  $lamp_amps_allTogetherArray = Array();
  foreach ($lamp_amps_data as $lamp_amps_key => $lamp_amps_value) {
    array_push($lamp_amps_measurmentArray, $lamp_amps_value->avgmeasurment);
    array_push($lamp_amps_datesArray, $lamp_amps_value->concatedDateTime);
  }
  $lamp_amps_allTogetherArray["measurment"] = $lamp_amps_measurmentArray;
  $lamp_amps_allTogetherArray["dates"] = $lamp_amps_datesArray;
  $lamp_amps_Arrays = $lamp_amps_allTogetherArray;


  // //convert kwh_array to tv_kwh_array
  // //convert kwh_array to lamp_kwh_array
  // foreach ($kwh_Arrays["measurment"] as $key => $value) {
  //   $tv_kwh_Arrays["measurment"][] = $library->adjustValue($value, "kwh", "tv");
  //   $lamp_kwh_Arrays["measurment"][] = $library->adjustValue($value, "kwh", "lamp");
  // }
  // $tv_kwh_Arrays["dates"] = $kwh_Arrays["dates"];
  // $lamp_kwh_Arrays["dates"] = $kwh_Arrays["dates"];

  
  // //convert watts_array to tv_watts_array
  // //convert watts_array to lamp_watts_array
  // foreach ($watts_Arrays["measurment"] as $key => $value) {
  //   $tv_watts_Arrays["measurment"][] = $library->adjustValue($value, "watts", "tv");
  //   $lamp_watts_Arrays["measurment"][] = $library->adjustValue($value, "watts", "lamp");
  // }
  // $tv_watts_Arrays["dates"] = $watts_Arrays["dates"];
  // $lamp_watts_Arrays["dates"] = $watts_Arrays["dates"];


  // //convert amps_array to tv_amps_array
  // //convert amps_array to lamp_watts_array
  // foreach ($amps_Arrays["measurment"] as $key => $value) {
  //   $tv_amps_Arrays["measurment"][] = $library->adjustValue($value, "amps", "tv");
  //   $lamp_amps_Arrays["measurment"][] = $library->adjustValue($value, "amps", "lamp");
  // }
  // $tv_amps_Arrays["dates"] = $amps_Arrays["dates"];
  // $lamp_amps_Arrays["dates"] = $amps_Arrays["dates"];

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
  <title>Appliances Detailed Charts</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="inc/css/bootstrap.min.css">
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

<div style="width: 100%; padding: 0 15px 0 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Applainces Schedular Management</h4>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non ligula eget nulla malesuada dignissim eget ut eros. Vivamus fermentum lectus vitae orci hendrerit vehicula. Suspendisse felis ligula, viverra in suscipit et, mattis et augue. Duis accumsan at erat a pulvinar. Mauris venenatis auctor tellus a finibus. Fusce facilisis mi eu libero fermentum rhoncus. Donec elementum lacus quis vestibulum scelerisque. Donec non consectetur nibh, ac consectetur nibh. Morbi at venenatis dui. Donec tincidunt maximus purus, eget mollis mauris suscipit a. Pellentesque porta vehicula nisi fringilla porta. Donec quis felis et nisl vestibulum mattis nec non augue. Donec orci dolor, eleifend at tortor eget, ultrices varius mauris. Suspendisse potenti. Cras hendrerit tellus neque, id sagittis mauris congue commodo.
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 1: <a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Refrigerator</a></strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwhFrigerator"></canvas></div>
      <div><canvas id="canvasWattsFrigerator"></canvas></div>
      <div><canvas id="canvasAmperFrigerator"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 2: TV</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwhTv"></canvas></div>
      <div><canvas id="canvasWattsTv"></canvas></div>
      <div><canvas id="canvasAmperTv"></canvas></div>
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 3: Lamp</strong></div>
    <div class="panel-body">
      <div><canvas id="canvasKwhLamp"></canvas></div>
      <div><canvas id="canvasWattsLamp"></canvas></div>
      <div><canvas id="canvasAmperLamp"></canvas></div>
    </div>
  </div>
</div>


  <script>
    var configKwhFrigerator = {
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
    var configWattsFrigerator = {
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
    var configAmperFrigerator = {
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

    
    var configKwhTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $tv_kwh_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$tv_kwh_Arrays["measurment"]);?>],
          fill: false,
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
    var configWattsTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $tv_watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
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
    var configAmperTv = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $tv_amps_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$tv_amps_Arrays["measurment"]);?>],
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

    
    var configKwhLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $lamp_kwh_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$lamp_kwh_Arrays["measurment"]);?>],
          fill: false,
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
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
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
    var configAmperLamp = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $lamp_amps_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$lamp_amps_Arrays["measurment"]);?>],
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
      var ctxKwhFrigerator = document.getElementById('canvasKwhFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhFrigerator, configKwhFrigerator);
      var ctxAmperFrigerator = document.getElementById('canvasAmperFrigerator').getContext('2d');
      window.myLine = new Chart(ctxAmperFrigerator, configAmperFrigerator);
      var ctxWattsFrigerator = document.getElementById('canvasWattsFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsFrigerator, configWattsFrigerator);

      var ctxKwhTv = document.getElementById('canvasKwhTv').getContext('2d');
      window.myLine = new Chart(ctxKwhTv, configKwhTv);
      var ctxAmperTv = document.getElementById('canvasAmperTv').getContext('2d');
      window.myLine = new Chart(ctxAmperTv, configAmperTv);
      var ctxWattsTv = document.getElementById('canvasWattsTv').getContext('2d');
      window.myLine = new Chart(ctxWattsTv, configWattsTv);

      var ctxKwhLamp = document.getElementById('canvasKwhLamp').getContext('2d');
      window.myLine = new Chart(ctxKwhLamp, configKwhLamp);
      var ctxAmperLamp = document.getElementById('canvasAmperLamp').getContext('2d');
      window.myLine = new Chart(ctxAmperLamp, configAmperLamp);
      var ctxWattsLamp = document.getElementById('canvasWattsLamp').getContext('2d');
      window.myLine = new Chart(ctxWattsLamp, configWattsLamp);
    };
  </script>

</body>
</html>
