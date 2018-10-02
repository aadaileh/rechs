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

//Schedules Statistics
$schedule_stats_lamp = $library->makeCurl ("/appliances/1/schedule/list", "GET");
$schedule_stats_tv = $library->makeCurl ("/appliances/2/schedule/list", "GET");
$schedule_stats_frig = $library->makeCurl ("/appliances/3/schedule/list", "GET");
  // echo "<pre>schedule_stats:";
  // print_r($schedule_stats_lamp);
  // print_r($schedule_stats_tv);
  // print_r($schedule_stats_frig);
  // echo "</pre>";

  $jobsEnd = Array();
  $jobsBegin = Array();
  foreach ($schedule_stats_lamp as $key => $value) {
    
    if ($value->active == 1) {
      $totalActiveJobs = $totalActiveJobs + 1;
      $activeJobs_lamp = $activeJobs_lamp + 1;
      $jobsBegin[] = $value->begin;
    } else {
      $totalInactiveJobs = $totalInactiveJobs + 1;
    }

    $jobsEnd[] = $value->end;
  }
  foreach ($schedule_stats_tv as $key => $value) {
    
    if ($value->active == 1) {
      $totalActiveJobs = $totalActiveJobs + 1;
      $activeJobs_tv = $activeJobs_tv + 1;
      $jobsBegin[] = $value->begin;
    } else {
      $totalInactiveJobs = $totalInactiveJobs + 1;
    }
    
    $jobsEnd[] = $value->end;
  }
  foreach ($schedule_stats_frig as $key => $value) {
  
    if ($value->active == 1) {
      $totalActiveJobs = $totalActiveJobs + 1;
      $activeJobs_frig = $activeJobs_frig + 1;
      $jobsBegin[] = $value->begin;
    } else {
      $totalInactiveJobs = $totalInactiveJobs + 1;
    }

    $jobsEnd[] = $value->end;
  }  
$totalJobs = count($schedule_stats_lamp) + count($schedule_stats_tv) + count($schedule_stats_frig);
  if ($totalActiveJobs == 0) {$totalActiveJobs = "None";}
  if ($activeJobs_frig == 0) {$activeJobs_frig = "0";}
  if ($activeJobs_tv == 0) {$activeJobs_tv = "0";}
  if ($activeJobs_lamp == 0) {$activeJobs_lamp = "0";}
  if ($totalInactiveJobs == 0) {$totalInactiveJobs = "None";}
  if(count($jobsBegin) > 0) {
    $maxBeginDate = max(array_map('strtotime', $jobsBegin));
    $nextJobStartsOn = date('Y-m-j H:i:s', $maxBeginDate);
  } else {
    $nextJobStartsOn = "unavailable";
  }
  if(count($jobsEnd) > 0) {  
    $maxEndDate = max(array_map('strtotime', $jobsEnd));
    $latestJobendedOn = date('Y-m-j H:i:s', $maxEndDate);
  } else {
    $latestJobendedOn = "unavailable";
  }



//Users Statistics
$usersList = $library->makeCurl ("/users/", "GET");
  // echo "<pre>usersList:";
  // print_r($usersList);
  // echo "</pre>";

//SDO
$sdo_appliances = $library->makeCurl ("/appliances/", "GET", null);

  // echo "<pre>sdo_appliances:";
  // print_r($sdo_appliances);
  // echo "</pre>";

  $sdo_frig = Array();
  $sdo_tv = Array();
  $sdo_lamp = Array();  

  $standby_activated_devices = Array();
  $standby_disabled_for_devices = Array();
  foreach ($sdo_appliances as $key => $value) {
    if($value->type == "refrigerator")  {$sdo_frig = $value;}  
    if($value->type == "tv")            {$sdo_tv = $value;}
    if($value->type == "lamp")          {$sdo_lamp = $value;}

    if($value->standByStatus == true) {
      $standby_activated_devices[] = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $value->label . '</span>';

      switch ($value->systemName) {
        case 'stand_lamp':
          $sdo_lamp->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $value->label . '</span>';
          break;
      
        case 'lg_smart_tv':
          $sdo_tv->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $value->label . '</span>';
          break;

        case 'refrigerator':
          $sdo_frig->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $value->label . '</span>';
          break;
      }
    } else {
      $standby_disabled_for_devices[] = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $value->label . '</span>';
      switch ($value->systemName) {
        case 'stand_lamp':
          $sdo_lamp->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $value->label . '</span>';
          break;
      
        case 'lg_smart_tv':
          $sdo_tv->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $value->label . '</span>';
          break;

        case 'refrigerator':
          $sdo_frig->highlighting = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $value->label . '</span>';
          break;
      }
    }
  }

  $sdo_lowestWatts = $library->makeCurl ("/measurments/watts/lowest", "GET", null);
  // echo "<pre>sdo_lowestWatts:";
  // print_r($sdo_lowestWatts);
  // echo "</pre>";
    
  foreach ($sdo_lowestWatts as $key => $value) {
    if($value[2]->systemName == "stand_lamp")   {$sdo_lamp->lowestEnergyConsumption = $value[1];}
    if($value[2]->systemName == "lg_smart_tv")  {$sdo_tv->lowestEnergyConsumption = $value[1];}  
    if($value[2]->systemName == "refrigerator") {$sdo_frig->lowestEnergyConsumption = $value[1];}
  }


  // echo "<pre style='color:red;'>sdo_lamp:";
  // print_r($sdo_lamp);
  // echo "</pre>";

  // echo "<pre style='color:red;'>sdo_tv:";
  // print_r($sdo_tv);
  // echo "</pre>";

  // echo "<pre style='color:red;'>sdo_frig:";
  // print_r($sdo_frig);
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

      <!-- ECTR -->
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

      <!-- ARR -->
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Appliance Replacement Recommender. It tells when to replace an appliance.">
            <a href="appliances-overview.php" data-toggle="tooltip" title="Replace an appliance." style="color:white;">
              <strong>ARR</strong> (<strong>A</strong>ppliance <strong>R</strong>eplacement <strong>R</strong>ecommender)</span>
            </a>
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

      <!-- SDO -->
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="A module defines the standby values and completely switch off the appliance when not needed"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector & <strong>O</strong>ptimizer)</span></div>
          <div class="panel-body">
            
            This module was activated for: <?php echo implode(", ", $standby_activated_devices);?> and disabled for <?php echo implode(", ", $standby_disabled_for_devices);?>. For those appliances that got this module activated for them, following characteristics were collected:

            <ul>

              <?php              
                foreach ($sdo_appliances as $key => $value) {

                  $updatedTimestamp = new DateTime($value->updatedTimestamp);
                  $updatedTimestamp = $updatedTimestamp->format('Y-m-d H:i:s');

                  echo '<li style="line-height:30px;">' . $value->highlighting . ': was last updated on <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $updatedTimestamp . '</span>. The lowest Energy consumption which will be taken in consideration when judging the Standby mode is <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange">' . $value->lowestEnergyConsumption . ' </span> Watts. The entered Standby Duration Span is <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $value->standbyDurationSpan . ' </span> Seconds.</li>';
                }
                
              ?>

            </ul>

          </div>
        </div>
      </div>

      <!-- ESO -->
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <a href="energy-provider-optimizer.php" data-toggle="tooltip" title="Energy Provider Optimizer. Helps owners to switch their energy provider to reduce costs." style="color:white;">
            <strong>ESO</strong> (<strong>E</strong>nergy <strong>S</strong>upplier <strong>O</strong>ptimizer)
            </a>
          </div>
          <div class="panel-body">
          As an additional feature that assists householders to save some money in their energy budget, this module gives oppurtunity to search for alternative energy supplier. Following is a list of the latest 3 searches performed for this purpose:

          <ul>
            
          <?php
            
            $items = array_slice($energy_supplier_stats, 0, 3);
            
            foreach ($items as $key => $value) {
              $date_creation = new DateTime($value->createdTimestamp);
              $date_creation = $date_creation->format('Y-m-d H:i:s');
              
              echo '<li style="line-height:30px;">On <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">' . $date_creation . '</span> <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->createdBy .'</span> has performed a search for a new energy supplier. System returned, <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange">' . $value->amountOfResults . '</span> results.</li>';
            }
          ?>
          <li>...</li>
          </ul>
          </div>
        </div>
      </div>

      <!-- Schedular Details -->
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <a href="appliances-schedular.php" data-toggle="tooltip" title="Cutting off power based on a previous schedule." style="color:white;">
            <span data-toggle="tooltip" title="A module where a schedule is predefined to switch off/on appliances"><strong>Schedular Details</strong></span>
            </a>
          </div>
          <div class="panel-body">

            It controls whatever is plugged into the node (Smart Switch 6) by cutting the power off via a schedule and ensure that gaming systems and computers aren’t used when they’re not meant to be, or prevent running devices when being in a vacation,... Currently there are 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 15pt;"><?=$totalJobs;?></span> jobs,
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 13pt;"><?=$totalActiveJobs;?></span> of them are active, and
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777;"><?=$totalInactiveJobs;?></span> of them are inactive. 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$activeJobs_frig;?></span> for the 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">Refrigerator</span>, 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$activeJobs_tv;?></span> done for the 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">TV</span> and 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16;"><?=$activeJobs_lamp;?></span> made for the 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">Stand Lamp</span>. The latest job finished on 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777"><?=$latestJobendedOn;?></span>. The next time a job starts will be on 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange"><?=$nextJobStartsOn;?></span>

            <br>
          </div>
        </div>
      </div>      
      
      <!-- Users Overview -->
      <div id="customized-home-panel-right">
        <div class="panel panel-primary">
          <div class="panel-heading"><span data-toggle="tooltip" title="Brief users overview details"><strong>Users Overview</strong></span></div>
          <div class="panel-body">

            The admin 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 15pt;"><?=$adminName;?></span> has created 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 15pt;"><?=$totalUsers;?></span> additional users in this application. 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 15pt;"><?=$totalActiveUsers;?></span> of them are active, and 
            <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16; font-size: 15pt;"><?=$totalInactiveUsers;?></span> are inactive. Following a list of these:

          <ul>
            
          <?php
                        
            foreach ($usersList as $key => $value) {
              $date_creation = new DateTime($value->createdTimestamp);
              $date_creation = $date_creation->format('Y-m-d H:i:s');

              $date_last_logged_in = new DateTime($value->lastLoggedInTimestamp);
              $date_last_logged_in = $date_last_logged_in->format('Y-m-d H:i:s');

              if($value->active == 1) {
                $active = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#3ddb16">Active</span>';
              } else {
                $active = '<span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:red">Inactive</span>';
              }
              
              echo '<li style="line-height:30px;">
              <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:orange">' . $value->fullName . '</span> is an  
              <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->type .'</span>. Created by 
              <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $value->createdBy .'</span> He is 
              ' . $active . ' in the system since 
              <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#777">' . $date_creation .'</span>. Last time successfully logged in was on
              <span class="badge badge-secondary" style="font-weight:bold; color:#fff; background-color:#337ab7">' . $date_last_logged_in . '</span></li>';
            }
          ?>
          </ul>

          </div>
        </div>
      </div>
     
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
