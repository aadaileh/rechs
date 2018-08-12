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

  $data = $library->makeCurl ("/appliances/", "GET", null);

  $refrigerator = Array();
  $tv = Array();
  $lamp = Array();

  foreach ($data as $key => $value) {

    if($value->type == "refrigerator") {
       $refrigerator = $value;
    }
  
    if($value->type == "tv") {
      $tv = $value;
    }

    if($value->type == "lamp") {
      $lamp = $value;
    }    
  }

  // echo "<pre>data:\n";
  // print_r($data);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appliances Overview</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="inc/css/bootstrap.min.css">
  <link rel="stylesheet" href="inc/css/switch.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>

  <script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script>
<script>
$(document).ready(function(){
    $("#stand-by-button-frig").click(function(){
      if (document.getElementById("stand-by-button-frig").checked) {
        $("#stand-by-duration-frig").fadeIn(700);
      } else {
        $("#stand-by-duration-frig").fadeOut(700);
      }
        $.post("/inc/cgi/appliances-save.php",
          {
            id: document.getElementById("stand-by-button-frig").value,
            standByStatus: document.getElementById("stand-by-button-frig").checked
          },
        function(data, status){
          //alert("Data(frig): " + data + "\nStatus: " + status);
          //$("#stand-by-button-frig-response").text(data);
        });
    });

    $("#stand-by-button-tv").click(function(){
        if (document.getElementById("stand-by-button-tv").checked) {
          $("#stand-by-duration-tv").fadeIn(700);
        } else {
          $("#stand-by-duration-tv").fadeOut(700);
        }
        $.post("/inc/cgi/appliances-save.php",
          {
            id: document.getElementById("stand-by-button-tv").value,
            standByStatus: document.getElementById("stand-by-button-tv").checked
          },
        function(data, status){
          //alert("Data(tv): " + data + "\nStatus: " + status);
          //$("#stand-by-button-tv-response").text(data);
        });
    });

    $("#stand-by-button-lamp").click(function(){
        if (document.getElementById("stand-by-button-lamp").checked) {
          $("#stand-by-duration-lamp").fadeIn(700);
        } else {
          $("#stand-by-duration-lamp").fadeOut(700);
        }
        $.post("/inc/cgi/appliances-save.php",
          {
            id: document.getElementById("stand-by-button-lamp").value,
            standByStatus: document.getElementById("stand-by-button-lamp").checked
          },
        function(data, status){
          //alert("Data(lamp): " + data + "\nStatus: " + status);
          //$("#stand-by-button-lamp-response").text(data);
        });
    });
});
</script>

<style type="text/css">
  #theTable td {
     vertical-align: middle;
  }

  #appliance {
    float:left; 
    width: 33%; 
    padding: 0px 50px 0px 50px;
  }

  #panel-body {
    #padding: 5px;
  }
</style>

</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 100%; padding: 0 67px 0 50px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Applainces Overview</h4>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non ligula eget nulla malesuada dignissim eget ut eros. Vivamus fermentum lectus vitae orci hendrerit vehicula. Suspendisse felis ligula, viverra in suscipit et, mattis et augue. Duis accumsan at erat a pulvinar. Mauris venenatis auctor tellus a finibus. Fusce facilisis mi eu libero fermentum rhoncus. Donec elementum lacus quis vestibulum scelerisque. Donec non consectetur nibh, ac consectetur nibh. Morbi at venenatis dui. Donec tincidunt maximus purus, eget mollis mauris suscipit a. Pellentesque porta vehicula nisi fringilla porta. Donec quis felis et nisl vestibulum mattis nec non augue. Donec orci dolor, eleifend at tortor eget, ultrices varius mauris. Suspendisse potenti. Cras hendrerit tellus neque, id sagittis mauris congue commodo.
    </div>
  </div>
</div>

<!-- frig -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8;text-align: center;">
      <a href="#" data-toggle="tooltip" title="Refrigerator: <?php echo $refrigerator->label; ?>"><img src="inc/img/fridge.svg" width="50%"></a>
    </div>
    <div class="panel-body" id="panel-body">
      <!-- BODY -->

        <table class="table table-striped" id="theTable">
          <thead>
            <th colspan="2">
              Appliance Details:
            </th>
          </thead>
          <tbody>
            <tr>
              <td>Status:</td>
              <td>
                <?php
                  if($refrigerator->status == 1) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
                </td>
            </tr>
            <tr>
              <td>Label:</td>
              <td><?php echo $refrigerator->label; ?></td>
            </tr> 
            <tr>
              <td>Annual&nbsp;Energy&nbsp;consumption:</td>
              <td><?php echo $refrigerator->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy&nbsp;consumption&nbsp;(in&nbsp;Watts):</td>
              <td><?php echo $refrigerator->hourlyEnergyConsumption; ?> Watt</td>
            </tr> 
            <tr>
              <td>Energy&nbsp;Efficient&nbsp;Class:</td>
              <td><?php echo $refrigerator->energyEfficientClass; ?></td>
            </tr>            
            <tr>
              <td>Size:</td>
              <td><?php echo $refrigerator->size . ' ' . $refrigerator->sizeUnit;; ?></td>
            </tr>
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($refrigerator->createdTimestamp)); ?></td>
            </tr>
            <tr>
              <td>Last successful shake-hands:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($refrigerator->updatedTimestamp)); ?></td>
            </tr>            
          </tbody>
        </table>


        <table class="table table-striped" id="theTable" style="margin-bottom: 0px;">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-onoff-frig" type="checkbox" value="onoff-frig">
                  <span class="slider round"></span>
                </label>
              </td>
              <td>On/off Function</td>
            </tr>             
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-frig" type="checkbox" value="3" 
                    <?php 
                      if ($refrigerator->standByStatus == 1) {
                        echo "checked";
                      }
                    ?>
                  >
                  <span class="slider round"></span>
                </label>
              </td>
              <td>
                <div id="stand-by-button-frig-response">Standby Mode</div>
              </td>
            </tr>         
          </tbody>
        </table>

        <div class="panel panel-default" id="stand-by-duration-frig" style="display: none;">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="focusedInput" type="text" name="standby_duration" style="width: 80px;">
                <button type="button" class="btn btn-primary">Save</button>
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>

<!-- tv -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8; text-align: center;">
      <a href="#" data-toggle="tooltip" title="TV: <?php echo $tv->label; ?>"><img src="inc/img/tv.svg" width="50%"></a>
    </div>
    <div class="panel-body" id="panel-body">

      <!-- BODY -->

        <table class="table table-striped" id="theTable" style="margin-bottom: 0px;">
          <thead>
            <th colspan="2">
              Appliance Details:
            </th>
          </thead>
          <tbody>
            <tr>
              <td>
                Status:
              </td>
              <td>
                <?php
                  if($tv->status == 1) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
              </td>
            </tr>  
            <tr>
              <td>Label:</td>
              <td><?php echo $tv->label; ?></td>
            </tr> 
            <tr>
              <td>Annual Energy consumption:</td>
              <td><?php echo $tv->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy consumption (in Watts):</td>
              <td><?php echo $tv->hourlyEnergyConsumption; ?> Watt</td>
            </tr> 
            <tr>
              <td>Energy Efficient Class:</td>
              <td><?php echo $tv->energyEfficientClass; ?></td>
            </tr>              
            <tr>
              <td>Size:</td>
              <td><?php echo $tv->size . ' ' . $tv->sizeUnit;; ?></td>
            </tr>
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($tv->createdTimestamp)); ?></td>
            </tr>
            <tr>
              <td>Last successful shake-hands:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($tv->updatedTimestamp)); ?></td>
            </tr> 
          </tbody>
        </table>

        <br/>

        <table class="table table-striped" id="theTable" style="margin-bottom: 0px;">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-onoff-tv" type="checkbox">
                  <span class="slider round"></span>
                </label>
              </td>
              <td>On/off Function</td>
            </tr> 
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-tv" type="checkbox" value="2"
                    <?php 
                      if ($tv->standByStatus == 1) {
                        echo "checked";
                      }
                    ?>
                  >
                  <span class="slider round"></span>
                </label>
              </td>
              <td>
                <div id="stand-by-button-tv-response">Standby Mode</div>
              </td>
            </tr>          
          </tbody>
        </table>

        <div class="panel panel-default" id="stand-by-duration-tv" style="display: none;">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="focusedInput" type="text" name="standby_duration" style="width: 80px;">
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>

<!-- lamp -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8;text-align: center;">
      <a href="#" data-toggle="tooltip" title="Lamp: <?php echo $lamp->label; ?>"><img src="inc/img/lamp.svg" width="50%"></a>
    </div>
    <div class="panel-body" id="panel-body">

      <!-- BODY -->
        <table class="table table-striped" id="theTable" style="margin-bottom: 0px;">
          <thead>
            <th colspan="2">
              Appliance Details:
            </th>
          </thead>
          <tbody>
            <tr>
              <td>
                Status:
              </td>
              <td>
                <?php
                  if($lamp->status == 1) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
              </td>
            </tr>             
            <tr>
              <td>Label:</td>
              <td><?php echo $lamp->label; ?></td>
            </tr> 
            <tr>
              <td>Annual Energy consumption:</td>
              <td><?php echo $lamp->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy consumption (in Watts):</td>
              <td><?php echo $lamp->hourlyEnergyConsumption; ?> Watt</td>
            </tr>            
            <tr>
              <td>Energy Efficient Class:</td>
              <td><?php echo $lamp->energyEfficientClass; ?></td>
            </tr>              
            <tr>
              <td>Size:</td>
              <td><?php echo $lamp->size . ' ' . $lamp->sizeUnit;; ?></td>
            </tr>
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($lamp->createdTimestamp)); ?></td>
            </tr>
            <tr>
              <td>Last successful shake-hands:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($lamp->updatedTimestamp)); ?></td>
            </tr> 
          </tbody>
        </table>

        <br/>

        <table class="table table-striped" id="theTable" style="margin-bottom: 0px;">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>  
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-onoff-lamp" type="checkbox"
                    <?php 
                      if ($lamp->standByStatus == 1) {
                        echo "checked";
                      }
                    ?>
                  >
                  <span class="slider round"></span>
                </label>
              </td>
              <td>On/off Function</td>
            </tr>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button-lamp" type="checkbox" value="1"
                    <?php 
                      if ($lamp->standByStatus == 1) {
                        echo "checked";
                      }
                    ?>
                  >
                  <span class="slider round"></span>
                </label>
              </td>
              <td>
                <div id="stand-by-button-lamp-response">Standby Mode</div>
              </td>
            </tr>           
          </tbody>
        </table>   

        <div class="panel panel-default" id="stand-by-duration-lamp" style="display: none;">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="focusedInput" type="text" name="standby_duration" style="width: 80px;">
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>

</body>
</html>
