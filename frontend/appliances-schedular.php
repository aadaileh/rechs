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
  $scheduleList["frig"] = $library->makeCurl ("/appliances/3/schedule/list", "GET");
  $scheduleList["tv"] = $library->makeCurl ("/appliances/2/schedule/list", "GET");
  $scheduleList["lamp"] = $library->makeCurl ("/appliances/1/schedule/list", "GET");

  // echo "<pre>scheduleList:\n";
  // print_r($scheduleList);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appliances Schedular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <script type="text/javascript" src="inc/js/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="inc/js/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="inc/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="inc/js/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="inc/js/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
  
  <link rel="stylesheet" href="inc/css/checkboxes-style.css" />
  <script type="text/javascript" src="inc/js/schedule.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

<?php
  foreach ($scheduleList as $key1 => $value1) {
    foreach ($value1 as $key2 => $value2) {
      $id = $value2->id;
?>
    $('#schedule-list-<?=$id;?>').on('change', function(){
      id = document.getElementById("schedule-list-<?=$id;?>").value;      
      if ($('#schedule-list-<?=$id;?>').is(':checked')) {
        $.get("/inc/cgi/appliances-schedular-save.php?action=activate&id=" + <?=$id;?>, function(data, status){
          $("#li-id-<?=$id;?>").css("color", "#080808"); //change the text color to gray
        });

      } else {       
        $.get("/inc/cgi/appliances-schedular-save.php?action=deactivate&id=" + <?=$id;?>, function(data, status){
          $("#li-id-<?=$id;?>").css("color", "#9d9d9d"); //change the text color to black
        });        
      }
      });
<?php
    }
  } 
?>


    });
  </script>

  <!-- bootbox code -->
  <script src="inc/js/bower_components/bootbox.js/bootbox.js"></script>


</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 100%; padding: 0 15px 0 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Applainces Schedular Management</h4>
      It is important to allow scheduling the working times of devices. Following are some examples of real-life conditions:
      <ul>
        <li>Teenagers or kids continuesly play games using gaming servers, desktops, laptops. Using the schedule you can control the time when to start/stop running these devices</li>
        <li>All parental control software does not work properly? This module jsut let you shutdown the Internet completely.</li>
        <li>Going in a vacation. When setting the system to go for a vacation mode, all previousley marked devices will be shut down.</li>
        <li>Disable the unnecessary standby mode in some applinaces.</li>
      </ul>
    </div>
  </div>
</div>


<?php include("inc/html/schedule-frig.html");?>
<?php include("inc/html/schedule-tv.html");?>
<?php include("inc/html/schedule-lamp.html");?>

</body>
</html>
