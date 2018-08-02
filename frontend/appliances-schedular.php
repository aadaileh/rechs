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



  <script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script>

<script>
$(document).ready(function(){
    $("#stand-by-button").click(function(){


        $.post("/inc/appliances-save.php",
          {
            standBy: document.getElementById("stand-by-button").checked,
            city: "Duckburg"
          },
        
        function(data, status){
          //alert("Data: " + data + "\nStatus: " + status);
          $("#stand-by-button-response").text(data);
        });


    });
});
</script>

</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="float:left; width: 33%; padding-left: 5px;">
  <div class="panel panel-primary">
    <div class="panel-heading"><strong>Node 1: <a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Refrigerator</a></strong></div>
    <div class="panel-body">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float: right;"><span style="font-weight: bold; font-size: 12pt;">+</span></button>



<div class="container">


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new schedular</h4>
        </div>
        <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-6">
              
                  From:<div class="form-group">
                      <div class='input-group date' id='datetimepicker6'>
                          <input type='text' class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>

            </div>
            <div class="col-sm-6">
                  To:<div class="form-group">
                      <div class='input-group date' id='datetimepicker7'>
                          <input type='text' class="form-control" />
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                  </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              
                  Repeat:
                  <div style="padding: 0px 0px 0px 20px;">
                    <label class="checkbox"><input type="checkbox" value="monday">Every Monday</label>
                    <label class="checkbox"><input type="checkbox" value="tuesday">Every Tuesday</label>
                    <label class="checkbox"><input type="checkbox" value="wednesday">Every Wednesday</label>
                    <label class="checkbox"><input type="checkbox" value="thursday">Every Thursday</label>
                    <label class="checkbox"><input type="checkbox" value="friday">Every Friday</label>
                    <label class="checkbox"><input type="checkbox" value="saturday">Every Saturday</label>
                    <label class="checkbox"><input type="checkbox" value="sunday">Every Sunday</label>
                  </div>
            </div>
          </div>



          </div>

              </div>          

        </div>

      </div>
      
    </div>
  </div>



<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>








    </div>
  </div>
</div>



</body>
</html>
