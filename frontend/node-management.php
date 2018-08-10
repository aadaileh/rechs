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
  <title>Node Management</title>
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
        $.get("/inc/cgi/appliances-node-save.php?action=activate&id=" + <?=$id;?>, function(data, status){
          $("#li-id-<?=$id;?>").css("color", "#080808"); //change the text color to gray
        });

      } else {       
        $.get("/inc/cgi/appliances-node-save.php?action=deactivate&id=" + <?=$id;?>, function(data, status){
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

<div style="width: 100%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Nodes Management</h4>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non ligula eget nulla malesuada dignissim eget ut eros. Vivamus fermentum lectus vitae orci hendrerit vehicula. Suspendisse felis ligula, viverra in suscipit et, mattis et augue. Duis accumsan at erat a pulvinar. Mauris venenatis auctor tellus a finibus. Fusce facilisis mi eu libero fermentum rhoncus. Donec elementum lacus quis vestibulum scelerisque. Donec non consectetur nibh, ac consectetur nibh. Morbi at venenatis dui. Donec tincidunt maximus purus, eget mollis mauris suscipit a. Pellentesque porta vehicula nisi fringilla porta. Donec quis felis et nisl vestibulum mattis nec non augue. Donec orci dolor, eleifend at tortor eget, ultrices varius mauris. Suspendisse potenti. Cras hendrerit tellus neque, id sagittis mauris congue commodo.
    </div>
  </div>
</div>


<div style="width: 100%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Nodes List</a></strong>
    </div>
    <div class="panel-body">

      <!-- Button trigger modal -->
      <button data-button="3" value="frig-button-value" id="frig-modal-btn-3" type="button"
      class="btn btn-primary" data-toggle="modal" data-target="#addNewNodeModal" style="float: right;">
      <span style="font-weight: bold; font-size: 12pt;">+</span></button>

      <!-- Button trigger edit -->
      <button data-button="3" value="frig-edit-button-value" id="frig-edit-modal-btn" type="button"
      class="btn btn-primary" style="float: left;">
        <span style="font-weight: normal; font-size: 12pt;">Manage</span>
      </button>

       <br/><br/><br/>
      <div class="row">
          <div class="col-xs-12">
              <div class="panel panel-default">
                  <!-- List group -->
                  <ul class="list-group">

                 <?php
                    foreach ($scheduleList["frig"] as $key => $value) {

                      $beginDate = $library->convertString($value->begin);
                      $endDate = $library->convertString($value->end);
                      $checked = $value->active == true ? " checked" : "";
                      $color = $value->active == true ? "#080808" : "#9d9d9d";
                  ?>
                      <li class="list-group-item frig">
                        <div class="material-switch pull-left frig-edit-minus-icon" style="display: none; padding:5px 5px 5px 0px;vertical-align:middle;">
                            <a href="#" title="Click to delete" data-dismiss="modal" data-button="<?=$value->id;?>" id="frig-edit-link-<?=$value->id;?>"
                              data-href="/inc/cgi/appliances-node-save.php?action=delete&id=<?=$value->id;?>" data-toggle="modal" data-target="#confirm-delete" class="alert-confirm">
                              <img src="inc/img/delete.svg" height="20px" width="20px">
                            </a>
                        </div>
                          <span id="li-id-<?=$value->id;?>" style="
                          font-weight: 500;
                          font-family: inherit;
                          font-size: 16pt;
                          color: <?=$color;?>;
                          font-stretch: ultra-condensed;
                          "> <?=$beginDate;?> - <?=$endDate;?>
                          <br>
                          <span style="font-size: 9pt;">
                          Repeat every: <?=str_replace("-", ", ", $value->repeat_every);?>
                          </span>
                          </span>

                          <div class="material-switch pull-right">
                              <input data-toggle="<?=$value->id;?>" data-button="<?=$value->id;?>" id="schedule-list-<?=$value->id;?>" name="schedule-list-<?=$value->id;?>" value="<?=$value->id;?>" type="checkbox" <?=$checked;?>/>
                              <label for="schedule-list-<?=$value->id;?>" class="label-success"></label>
                          </div>
                      </li>

                  <?php
                    }
                 ?>

                  </ul>
              </div>
          </div>
      </div>

      <div class="container">

          <!-- Modal Create new -->
            <div class="modal fade" id="addNewNodeModal" tabindex="-1" role="dialog" aria-labelledby="addNewNodeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="addNewNodeModalLabel" style="font-weight: bold; float: left;">Add new node</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="alert alert-success" role="alert" id="save-response-true" style="display: none;">Node saved correctly.</div>
                  <div class="alert alert-danger" role="alert" id="save-response-false" style="display: none;">x</div>

                  <form action="#" method="post" id="add-new-node-form" name="add-new-node-form ">
                    <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">

                    <div class="row">
                      <div class="col-sm-6">

                            <strong>Appliance Label:</strong><div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" id='appliance-label'/>
                                </div>
                            </div>

                      </div>
                      <div class="col-sm-6">
                            <strong>To:</strong><div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" id='date-time-picker-field2' />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div><small>Leave empty if unlimited</small>
                            </div>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading" style="font-weight: bold;">When to repeat:</div>

                                <!-- List group -->
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Every Day</strong>
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryDay" name="switchOptionEveryDay" value="every-day" type="checkbox"/>
                                            <label for="switchOptionEveryDay" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Monday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryMonday" name="switchOptionEveryMonday" value="monday" type="checkbox"/>
                                            <label for="switchOptionEveryMonday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Tuesday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryTuesday" name="switchOptionEveryTuesday" value="tuesday" type="checkbox"/>
                                            <label for="switchOptionEveryTuesday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Wednesday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryWednesday" name="switchOptionEveryWednesday" value="wednesday" type="checkbox"/>
                                            <label for="switchOptionEveryWednesday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Thursday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryThursday" name="switchOptionEveryThursday" value="thursday" type="checkbox"/>
                                            <label for="switchOptionEveryThursday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Friday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEveryFriday" name="switchOptionEveryFriday" value="friday" type="checkbox"/>
                                            <label for="switchOptionEveryFriday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Saturday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEverySaturday" name="switchOptionEverySaturday" value="saturday" type="checkbox"/>
                                            <label for="switchOptionEverySaturday" class="label-success"></label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        Every Sunday
                                        <div class="material-switch pull-right">
                                            <input id="switchOptionEverySunday" name="switchOptionEverySunday" value="sunday" type="checkbox"/>
                                            <label for="switchOptionEverySunday" class="label-success"></label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                  </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="save-changes-btn">Save changes</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal End -->

        </div>
    </div>
  </div>
</div>


</body>
</html>
