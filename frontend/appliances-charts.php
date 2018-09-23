<?php
ini_set('max_execution_time', 300); // 5minutes
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

  //Refrigerator - kwh - hourly
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/hour", "GET"));
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays["hourly"] = $kwh_allTogetherArray;

  //Refrigerator - kwh - daily
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/day", "GET"));
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays["daily"] = $kwh_allTogetherArray;

  //Refrigerator - kwh - weekly
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/week", "GET"));
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays["weekly"] = $kwh_allTogetherArray;  

  //Refrigerator - kwh - monthly
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/month", "GET"));
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays["monthly"] = $kwh_allTogetherArray; 

  //Refrigerator - kwh - yearly
  $kwh_data = $library->sortArray($library->makeCurl ("/measurments/kwh/appliance/3/group-by/year", "GET"));
  $kwh_measurmentArray = Array();
  $kwh_datesArray = Array();
  $kwh_allTogetherArray = Array();
  foreach ($kwh_data as $kwh_key => $kwh_value) {
    array_push($kwh_measurmentArray, $kwh_value->avgmeasurment);
    array_push($kwh_datesArray, $kwh_value->concatedDateTime);
  }
  $kwh_allTogetherArray["measurment"] = $kwh_measurmentArray;
  $kwh_allTogetherArray["dates"] = $kwh_datesArray;
  $kwh_Arrays["yearly"] = $kwh_allTogetherArray; 



  //Refrigerator - watts - hourly
  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/hour", "GET"));
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays["hourly"] = $watts_allTogetherArray;

  //Refrigerator - watts -daily
  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/day", "GET"));
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays["daily"] = $watts_allTogetherArray;

  //Refrigerator - watts -weekly
  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/week", "GET"));
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays["weekly"] = $watts_allTogetherArray;  

  //Refrigerator - watts -monthly
  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/month", "GET"));
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays["monthly"] = $watts_allTogetherArray; 

  //Refrigerator - watts -yearly
  $watts_data = $library->sortArray($library->makeCurl ("/measurments/watts/appliance/3/group-by/year", "GET"));
  $watts_measurmentArray = Array();
  $watts_datesArray = Array();
  $watts_allTogetherArray = Array();
  foreach ($watts_data as $watts_key => $watts_value) {
    array_push($watts_measurmentArray, $watts_value->avgmeasurment);
    array_push($watts_datesArray, $watts_value->concatedDateTime);
  }
  $watts_allTogetherArray["measurment"] = $watts_measurmentArray;
  $watts_allTogetherArray["dates"] = $watts_datesArray;
  $watts_Arrays["yearly"] = $watts_allTogetherArray;







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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>

  <script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });

    $(document).ready(function(){
      $('.second a').click(function (e) {
        alert("1");
        e.preventDefault()
        $(this).tab('show')
      })  

      $('.second a').on('click', function (e) {
        alert("2");
        var href = $(this).attr('href');
        $('html, body').animate({
        scrollTop: $(href).offset().top
        }, 'slow');
        e.preventDefault();
      });
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
      <h4 style="font-weight: bold;">Applainces Charts Overview</h4>
      Both Kwh and Watts are shown for all three appliances. Every parameter is divided into 5 groups: Hourly, Daily, Weekly, Monthly and Yearly.
    </div>
  </div>
</div>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 1: <a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Refrigerator</a></strong></div>
    <div class="panel-body">

      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#frig-kwh-hours">Hourly</a></li>
        <li><a data-toggle="tab" href="#frig-kwh-days">Daily</a></li>
        <li><a data-toggle="tab" href="#frig-kwh-weeks">Weekly</a></li>
        <li><a data-toggle="tab" href="#frig-kwh-months">Monthly</a></li>
        <li><a data-toggle="tab" href="#frig-kwh-years">Yearly</a></li>
      </ul>
      <div class="tab-content">
        <div id="frig-kwh-hours" class="tab-pane fade in active">
          <h3>Grouping By Hours</h3>
          <div><canvas id="canvasKwhHourlyFrigerator"></canvas></div>
        </div>
        <div id="frig-kwh-days" class="tab-pane fade">
          <h3>Grouping By Days</h3>
          <div><canvas id="canvasKwhDailyFrigerator"></canvas></div>
        </div> 
        <div id="frig-kwh-weeks" class="tab-pane fade">
          <h3>Grouping By Weeks</h3>
          <div><canvas id="canvasKwhWeeklyFrigerator"></canvas></div>
        </div>
        <div id="frig-kwh-months" class="tab-pane fade">
          <h3>Grouping By Months</h3>
          <div><canvas id="canvasKwhMonthlyFrigerator"></canvas></div>
        </div>
        <div id="frig-kwh-years" class="tab-pane fade">
          <h3>Grouping By Years</h3>
          <div><canvas id="canvasKwhYearlyFrigerator"></canvas></div>
        </div> 
      </div>

      <br><br><br><br><br>


      <ul class="nav nav-tabs second">
        <li class="active"><a data-toggle="tab" href="#frig-watts-hours">Hourly</a></li>
        <li><a data-toggle="tab" href="#frig-watts-days">Daily</a></li>
        <li><a data-toggle="tab" href="#frig-watts-weeks">Weekly</a></li>
        <li><a data-toggle="tab" href="#frig-watts-months">Monthly</a></li>
        <li><a data-toggle="tab" href="#frig-watts-years">Yearly</a></li>
      </ul>
      <div class="tab-content">
        <div id="frig-watts-hours" class="tab-pane fade in active">
          <h3>Grouping By Hours</h3>
          <div><canvas id="canvasWattsHourlyFrigerator"></canvas></div>
        </div>
        <div id="frig-watts-days" class="tab-pane fade">
          <h3>Grouping By Days</h3>
          <div><canvas id="canvasWattsDailyFrigerator"></canvas></div>
        </div> 
        <div id="frig-watts-weeks" class="tab-pane fade">
          <h3>Grouping By Weeks</h3>
          <div><canvas id="canvasWattsWeeklyFrigerator"></canvas></div>
        </div>
        <div id="frig-watts-months" class="tab-pane fade">
          <h3>Grouping By Months</h3>
          <div><canvas id="canvasWattsMonthlyFrigerator"></canvas></div>
        </div>
        <div id="frig-watts-years" class="tab-pane fade">
          <h3>Grouping By Years</h3>
          <div><canvas id="canvasWattsYearlyFrigerator"></canvas></div>
        </div> 
      </div>


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
    var configKwhHourlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["hourly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["hourly"]["measurment"]);?>],
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
    var configKwhDailyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["daily"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["daily"]["measurment"]);?>],
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
    var configKwhWeeklyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["weekly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["weekly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Weeks'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configKwhMonthlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["monthly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["monthly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Months'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configKwhYearlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $kwh_Arrays["yearly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Kwh',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$kwh_Arrays["yearly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Years'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };






    var configWattsHourlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["hourly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays["hourly"]["measurment"]);?>],
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
    var configWattsDailyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["daily"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays["daily"]["measurment"]);?>],
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
    var configWattsWeeklyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["weekly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays["weekly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Weeks'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configWattsMonthlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["monthly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays["monthly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Months'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
    var configWattsYearlyFrigerator = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $watts_Arrays["yearly"]["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$watts_Arrays["yearly"]["measurment"]);?>],
          fill: false,
        }]
      },
      options: {
        responsive: true,
        title: {display: true, text: ''},
        tooltips: {mode: 'index', intersect: false},
        hover: {mode: 'nearest', intersect: true},
        scales: {
          xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Years'}}],
          yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
        }
      }
    };
 

    window.onload = function() {

      var ctxKwhHourlyFrigerator = document.getElementById('canvasKwhHourlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhHourlyFrigerator, configKwhHourlyFrigerator);
      var ctxKwhDailyFrigerator = document.getElementById('canvasKwhDailyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhDailyFrigerator, configKwhDailyFrigerator);
      var ctxKwhWeeklyFrigerator = document.getElementById('canvasKwhWeeklyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhWeeklyFrigerator, configKwhWeeklyFrigerator);
      var ctxKwhMonthlyFrigerator = document.getElementById('canvasKwhMonthlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhMonthlyFrigerator, configKwhMonthlyFrigerator);
      var ctxKwhYearlyFrigerator = document.getElementById('canvasKwhYearlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxKwhYearlyFrigerator, configKwhYearlyFrigerator);


      var ctxWattsHourlyFrigerator = document.getElementById('canvasWattsHourlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsHourlyFrigerator, configWattsHourlyFrigerator);
      var ctxWattsDailyFrigerator = document.getElementById('canvasWattsDailyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsDailyFrigerator, configWattsDailyFrigerator);
      var ctxWattsWeeklyFrigerator = document.getElementById('canvasWattsWeeklyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsWeeklyFrigerator, configWattsWeeklyFrigerator);
      var ctxWattsMonthlyFrigerator = document.getElementById('canvasWattsMonthlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsMonthlyFrigerator, configWattsMonthlyFrigerator);
      var ctxWattsYearlyFrigerator = document.getElementById('canvasWattsYearlyFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsYearlyFrigerator, configWattsYearlyFrigerator);


    };
  </script>

</body>
</html>