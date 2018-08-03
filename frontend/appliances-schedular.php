<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appliances Schedular</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <script type="text/javascript" src="inc/js/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="inc/js/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="inc/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="inc/js/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="inc/js/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />


  <style type="text/css">
.material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}    
  </style>

  <script type="text/javascript">

  //Tooltip
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });

  //check all checkboxes when every-day is checked
  $(document).ready(function(){
    $("#save-changes-btn").click(function(){
      $.post("/inc/cgi/appliances-schedular-save.php",
      {
        // standBy: document.getElementById("stand-by-button").checked,
        // city: "Duckburg"
      },
      function(data, status){
      alert("Data: " + data + "\nStatus: " + status);
      $("#save-response").text(data);
      });
    });
  });

  //Submit Form
  $(document).ready(function(){
    $("#switchOptionEveryDay").click(function(){
      if ($('#switchOptionEveryDay').is(':checked')) {
        $("#switchOptionEveryMonday").prop('checked', true);
        $("#switchOptionEveryTuesday").prop('checked', true);
        $("#switchOptionEveryWednesday").prop('checked', true);
        $("#switchOptionEveryThursday").prop('checked', true);
        $("#switchOptionEveryFriday").prop('checked', true);
        $("#switchOptionEverySaturday").prop('checked', true);
        $("#switchOptionEverySunday").prop('checked', true);
      } else {
        $("#switchOptionEveryMonday").prop('checked', false);
        $("#switchOptionEveryTuesday").prop('checked', false);
        $("#switchOptionEveryWednesday").prop('checked', false);
        $("#switchOptionEveryThursday").prop('checked', false);
        $("#switchOptionEveryFriday").prop('checked', false);
        $("#switchOptionEverySaturday").prop('checked', false);
        $("#switchOptionEverySunday").prop('checked', false);
      }
    });
  });

  //DateTime Picker
  $(function () {
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker({
      useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker1").on("dp.change", function (e) {
      $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker2").on("dp.change", function (e) {
      $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    });
  });
  </script>

</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong>Node 1: <a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Refrigerator</a></strong>
    </div>
    <div class="panel-body">
      

      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;"><span style="font-weight: bold; font-size: 12pt;">+</span></button>


      <div class="container">

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel" style="font-weight: bold; float: left;">Add new schedular</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <!-- 
                  <div class="alert alert-success" role="alert" id="save-response">This is a success alert—check it out!</div>
                  <div class="alert alert-danger" role="alert">This is a danger alert—check it out!</div>
                  -->

                  <form action="#" method="post" id="add-new-schedular" name="add-new-schedular">

                    <div class="row">
                      <div class="col-sm-6">
                        
                            <strong>From:</strong><div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                      </div>
                      <div class="col-sm-6">
                            <strong>To:</strong><div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" />
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
