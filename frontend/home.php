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

  //Appliances Statistics
  $stats = $library->makeCurl ("/statistics/appliances", "GET");

  $dates = Array();
  $counter[] = Array();
  foreach ($stats as $key => $value) {
    $dates[] = $value[2];
    $dates[] = $value[3];
    $counter[$value[5]->id] = $value[1];
  }

  $max = max(array_map('strtotime', $dates));
  $min = min(array_map('strtotime', $dates));  
  $maxDate = date('Y-m-j H:i:s', $max);
  $minDate = date('Y-m-j H:i:s', $min);  
  $totalDataSet = number_format(array_sum($counter),0,",",".");;

  //Frig 
  $totalDataSet_frig = number_format($stats[2][1],0,",",".");
  $minDate_frig = new DateTime($stats[2][2]);
  $minDate_frig = $minDate_frig->format('Y-m-d H:i:s');
  $maxDate_frig = new DateTime($stats[2][3]);
  $maxDate_frig = $maxDate_frig->format('Y-m-d H:i:s');
  $averageWatts_frig = number_format($stats[2][4],2,",",".");
  
  //TV
  $totalDataSet_tv = number_format($stats[1][1],0,",",".");
  $minDate_tv = new DateTime($stats[1][2]);
  $minDate_tv = $minDate_tv->format('Y-m-d H:i:s');
  $maxDate_tv = new DateTime($stats[1][3]);
  $maxDate_tv = $maxDate_tv->format('Y-m-d H:i:s');
  $averageWatts_tv = number_format($stats[1][4],2,",",".");

  //Stand lamp 
  $totalDataSet_lamp = number_format($stats[0][1],0,",",".");
  $minDate_lamp = new DateTime($stats[0][2]);
  $minDate_lamp = $minDate_lamp->format('Y-m-d H:i:s');
  $maxDate_lamp = new DateTime($stats[0][3]);
  $maxDate_lamp = $maxDate_lamp->format('Y-m-d H:i:s');
  $averageWatts_lamp = number_format($stats[0][4],2,",",".");

  // echo "<pre>stats:";
  // print_r($stats);
  // echo "</pre>";

  // echo "<pre style='color:red;'>counter:";
  // print_r($counter);
  // echo "</pre>";  

  // echo "<pre style='color:green;'>dates:";
  // print_r($dates);
  // echo "</pre>";

  //Refrigerator (daily)
  $watts_data = $library->makeCurl ("/measurments/watts/appliance/3/group-by/hour", "GET");
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

  // TV (hourly)
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


  // Lamp (Hourly)
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

  //Appliances Statistics
  $stats = $library->makeCurl ("/statistics/appliances", "GET");

  //Appliances Replacement Recommender Statistics
  $appliance_replacement_recommender_stats = $library->makeCurl ("/statistics/appliance-replacement-recommender", "GET");
  // echo "<pre>appliance_replacement_recommender_stats:";
  // print_r($appliance_replacement_recommender_stats);
  // echo "</pre>";

  //Appliances Replacement Recommender Statistics
  $energy_supplier_stats = $library->makeCurl ("/statistics/energy-supplier-optimizer", "GET");
  // echo "<pre>energy_supplier_stats:";
  // print_r($energy_supplier_stats);
  // echo "</pre>";

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>RECHS - Home</title>
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
  </script>

  <style>
  canvas{
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  #customized-home-panel-left{
    padding: 0px 0px 0px 20px;
  }
  #customized-home-panel-right{
    padding: 0px 20px 0px 0px;
  }

  </style>
</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 100%; padding: 0 20px 0 20px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Welcome to RECHS - Reduction of Electricity Consumption in Household Sector</h4>
      Project <strong>RECHS</strong> aims to reduce the household's electricity consumption by suggesting more energy efficient appliances, cut-off electricity consumption based on a defined schedule or based on the measured stand-by status, and switching the energy provider.<br/>
      This page offers a general and summerized statistics of measured appliances, also it does offer a general status overview of all running modules; <strong>ECTR</strong> (<strong>E</strong>lectricity <strong>C</strong>onsumption <strong>T</strong>racker & <strong>R</strong>ecorder), <strong>EPO</strong> (<strong>E</strong>nergy <strong>P</strong>rovider <strong>O</strong>ptimizer), <strong>ARR</strong> (<strong>A</strong>ppliance <strong>R</strong>eplacement <strong>R</strong>ecommender), <strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector & <strong>O</strong>ptimizer) and <strong>Schedular detailes</strong>. It also offers some general information about registered <strong>users</strong> and <strong>nodes</strong>.
    </div>
  </div>
</div>

  <div class="row">
    <div class="col-sm-6">

      <div id="customized-home-panel-left">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong data-toggle="tooltip" title="Bosch Model 1234 Extra">Node 1: Refrigerator</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsFrigerator"></canvas></div>
          </div>
        </div>
      </div>

      <div id="customized-home-panel-left">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong>Node 2: TV</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsTv"></canvas></div>
          </div>
        </div>
      </div>

      <div id="customized-home-panel-left">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong>Node 3: Lamp</strong></div>
          <div class="panel-body">
            <div><canvas id="canvasWattsLamp"></canvas></div>
          </div>
        </div>
      </div>

    </div>
    <div class="col-sm-6">

      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Tracks and records electrictity consumption including Ampers, kwh and Watts">
            <strong>ECTR</strong> (<strong>E</strong>lectricity <strong>C</strong>onsumption <strong>T</strong>racker & <strong>R</strong>ecorder)</span>
          </div>
          <div class="panel-body" style="line-height: 30px;">

            This module started running on <span class="badge badge-secondary" style="font-weight:bold;color:#fff; background-color:#337ab7"><?=$minDate;?></span>. The last record were saved on <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$maxDate;?></span>. During these dates a total of <span class="badge badge-secondary" style="font-weight:bold; font-size: 19pt; color:#fff; background-color:orange"><?=$totalDataSet;?> datasets</span> were collected. 

            <br>

            The <strong>Refrigerator</strong>'s consumption data was tracked between <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$minDate_frig;?></span> and  <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$maxDate_frig;?></span>, a total of <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange; font-size: 13pt;"><?=$totalDataSet_frig;?> datasets</span> have been saved. The average electricity consumption was approximately <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$averageWatts_frig;?> Watts</span>.

            

            The <strong>TV</strong>'s consumption data was tracked between <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$minDate_tv;?></span> and  <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$maxDate_tv;?></span>, a total of <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange; font-size: 13pt;"><?=$totalDataSet_tv;?> datasets</span> were detected and saved. The average electricity consumption was approximately <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$averageWatts_tv;?> Watts</span>.

            

             Finally, the <strong>Stand lamp</strong>'s consumption data was tracked between <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$minDate_lamp;?></span> and  <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7"><?=$maxDate_lamp;?></span>, a total of <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange; font-size: 13pt;"><?=$totalDataSet_lamp;?> datasets</span> were received. The average electricity consumption was approximately <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$averageWatts_lamp;?> Watts</span>.
          </div>
        </div>
      </div>

      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Appliance Replacement Recommender. It tells when to replace an appliance.">
            <strong>ARR</strong> (<strong>A</strong>ppliance <strong>R</strong>eplacement <strong>R</strong>ecommender)</span>
          </div>
          <div class="panel-body">
          Replacing current appliances can be done by using the external <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API. It is designed to search for alternatives for the three sample appliances; Refrigerator, TV and a Stand Lamp. Here are details regarding the latest performed 5 replacement recommendations:

          <ul>
            
          <?php
            
            $items = array_slice($appliance_replacement_recommender_stats, 0, 5);
            
            foreach ($items as $key => $value) {
              $date_creation = new DateTime($value->createdTimestamp);
              $date_creation = $date_creation->format('Y-m-d H:i:s');

              if ($value->applianceType == 'frig') {$applianceType = "Refrigerator";}
              if ($value->applianceType == 'tv') {$applianceType = "TV";}
              if ($value->applianceType == 'lamp') {$applianceType = "Stand Lamp";}

              if ($value->status == "success") {
                echo '<li style="line-height:30px;">On <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $date_creation . '</span> <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->createdBy .'</span> has performed a search to check possibility to replace his <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#8a6d3b">' . $applianceType . '</span>, <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">system run successfully</span> and showed him </span>, <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange">' . $value->amountOfResults . '</span> results.</li>';
              } else {
                echo '<li style="line-height:30px;">On <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $date_creation . '</span> <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->createdBy .'</span> has performed a search to check possibility to replace his <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#8a6d3b">' . $applianceType . '</span>, <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:red">unfortunately the system returned an error :(</span></li>'; 
              }
            }
          ?>
          <li>...</li>
          </ul>

          </div>
        </div>
      </div>

      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="A module defines the standby values and completely switch off the appliance when not needed"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector & <strong>O</strong>ptimizer)</span></div>
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
            <br>
          </div>
        </div>
      </div>


      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><a href="energy-provider-optimizer.php" data-toggle="tooltip" title="Energy Provider Optimizer. Helps owners to switch their energy provider to reduce costs." style="color:white;">
            <strong>ESO</strong> (<strong>E</strong>nergy <strong>S</strong>upplier <strong>O</strong>ptimizer)</a>
          </div>
          <div class="panel-body">
          As an additional feature that assists householders to save some money in their energy budget, this module gives oppurtunity to search for alternative energy supplier. Following is a list of the latest 3 searches performed for this purpose:

          <ul>
            
          <?php
            
            $items = array_slice($energy_supplier_stats, 0, 3);
            
            foreach ($items as $key => $value) {
              $date_creation = new DateTime($value->createdTimestamp);
              $date_creation = $date_creation->format('Y-m-d H:i:s');

              
              echo '<li style="line-height:30px;">On <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $date_creation . '</span> <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->createdBy .'</span> has performed a search for a new energy supplier. System returned, <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange">' . $value->amountOfResults . '</span> results.</li>';
            }
          ?>
          <li>...</li>
          </ul>
          </div>
        </div>
      </div>

      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="A module where a schedule is predefined to switch off/on appliances"><strong>Schedular Details</strong></span></div>
          <div class="panel-body">

            Control whatever is plugged into a Smart Switch 6 via a schedule and ensure that gaming systems and computers aren’t used when they’re not meant to be.<br><br>
            
            First time visited:<br>
            Click <a href="/energy-provider-optimizer.php">here</a> to schedule new job.<br><br>

            View shown after activating the EPO (Energy Provider Optimizer):<br>
            Searching for proper Energy Provider has revelaed the following result(s):<br>
            1. XYZ Energy Provider<br>

            Your current annual Electricity costs are XXX€. Once you switch to the suggested XYZ Energy Provider, you can save up to XX% of your costs. This means XX€ less annualy.

            <br>
          </div>
        </div>
      </div>      
      
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Brief users overview details"><strong>Users Overview</strong></span></div>
          <div class="panel-body">
            X Users are created.<br>
            X Admins are created.<br>
            X of them are active (logged in last 3 days).<br>
            Last successful login done on MM/dd/YYYY at HH:mm:ss<br>
            Last failed login done on MM/dd/YYYY at HH:mm:ss<br>

          </div>
        </div>
      </div>

      <!--
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Brief nodes overview details"><strong>Nodes Overview</strong></span></div>
          <div class="panel-body">
            X Nodes are created.<br>
            X of them are active (logged in last 3 days).<br>
            Last successful data sent done on MM/dd/YYYY at HH:mm:ss<br>
            ...
          </div>
        </div>
      </div>      
      -->
      
    </div>
  </div>














  <script>
    var configWattsFrigerator = {
      type: 'bar',
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

    
    // var configWattsLamp = {
    //   type: 'radar',
    //   data: {
    //     labels: [<?php echo "'" . implode("', '", $lamp_watts_Arrays["dates"]) . "'";?>],
    //     datasets: [{
    //       label: 'Watts',
    //       fill: false,
    //       backgroundColor: window.chartColors.yellow,
    //       borderColor: window.chartColors.yellow,
    //       data: [<?php echo implode(",",$lamp_watts_Arrays["measurment"]);?>],
    //     }]
    //   },
    //   options: {
    //     responsive: true,
    //     title: {display: true, text: ''},
    //     tooltips: {mode: 'index', intersect: false},
    //     hover: {mode: 'nearest', intersect: true},
    //     scales: {
    //       xAxes: [{display: true, scaleLabel: {display: true, labelString: 'Hours'}}],
    //       yAxes: [{display: true, scaleLabel: {display: true, labelString: 'Measurment'}}]
    //     }
    //   }
    // };

    var color = Chart.helpers.color;
    var configWattsLamp = {
      type: 'radar',
      data: {
        labels: [<?php echo "'" . implode("', '", $lamp_watts_Arrays["dates"]) . "'";?>],
        datasets: [{
          label: 'Watts',
          backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
          borderColor: window.chartColors.yellow,
          pointBackgroundColor: window.chartColors.yellow,
          data: [<?php echo implode(",",$lamp_watts_Arrays["measurment"]);?>]
        }]
      },
      options: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: ''
        },
        scale: {
          ticks: {
            beginAtZero: true
          }
        }
      }
    }; 

    window.onload = function() {
      var ctxWattsFrigerator = document.getElementById('canvasWattsFrigerator').getContext('2d');
      window.myLine = new Chart(ctxWattsFrigerator, configWattsFrigerator);

      var ctxWattsTv = document.getElementById('canvasWattsTv').getContext('2d');
      window.myLine = new Chart(ctxWattsTv, configWattsTv);

      // var ctxWattsLamp = document.getElementById('canvasWattsLamp').getContext('2d');
      // window.myLine = new Chart(ctxWattsLamp, configWattsLamp);

      window.myRadar = new Chart(document.getElementById('canvasWattsLamp'), configWattsLamp);

    };
  </script>

</body>
</html>
