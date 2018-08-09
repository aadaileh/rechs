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
  <link rel="stylesheet" href="inc/css/bootstrap.min.css">

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
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non ligula eget nulla malesuada dignissim eget ut eros. Vivamus fermentum lectus vitae orci hendrerit vehicula. Suspendisse felis ligula, viverra in suscipit et, mattis et augue. Duis accumsan at erat a pulvinar. Mauris venenatis auctor tellus a finibus. Fusce facilisis mi eu libero fermentum rhoncus. Donec elementum lacus quis vestibulum scelerisque. Donec non consectetur nibh, ac consectetur nibh. Morbi at venenatis dui. Donec tincidunt maximus purus, eget mollis mauris suscipit a. Pellentesque porta vehicula nisi fringilla porta. Donec quis felis et nisl vestibulum mattis nec non augue. Donec orci dolor, eleifend at tortor eget, ultrices varius mauris. Suspendisse potenti. Cras hendrerit tellus neque, id sagittis mauris congue commodo.
    </div>
  </div>
</div>


<?php include("inc/html/schedule-frig.html");?>
<?php include("inc/html/schedule-tv.html");?>
<?php include("inc/html/schedule-lamp.html");?>

</body>
</html>
