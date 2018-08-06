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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
    $("#stand-by-button").click(function(){


        $.post("/inc/cgi/appliances-save.php",
          {
            standBy: document.getElementById("stand-by-button").checked,
            city: "Duckburg"
          },
        
        function(data, status){
          alert("Data: " + data + "\nStatus: " + status);
          $("#stand-by-button-response").text(data);
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
              <td>Annual Energy consumption:</td>
              <td><?php echo $refrigerator->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy consumption (in Watts):</td>
              <td><?php echo $refrigerator->hourlyEnergyConsumption; ?> Watt</td>
            </tr> 
            <tr>
              <td>Energy Efficient Class:</td>
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

        <br/>

        <table class="table table-striped" id="theTable">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>         
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox"
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
                <div id="stand-by-button-response">Stand-by Mode is turned OFF</div>
              </td>
            </tr>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox">
                  <span class="slider round"></span>
                </label>
              </td>
              <td>On/off Function</td>
            </tr>           
          </tbody>
        </table>

    </div>
  </div>
</div>

<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8; text-align: center;">
      <a href="#" data-toggle="tooltip" title="TV: <?php echo $tv->label; ?>"><img src="inc/img/tv.svg" width="50%"></a>
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

        <table class="table table-striped" id="theTable">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>            
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox"
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
                <div id="stand-by-button-response">Stand-by Mode is turned OFF</div>
              </td>
            </tr>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox">
                  <span class="slider round"></span>
                </label>
              </td>
              <td>On/off Function</td>
            </tr>           
          </tbody>
        </table>


    </div>
  </div>
</div>

<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8;text-align: center;">
      <a href="#" data-toggle="tooltip" title="Lamp: <?php echo $lamp->label; ?>"><img src="inc/img/lamp.svg" width="50%"></a>
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

        <table class="table table-striped" id="theTable">
          <thead>
            <th colspan="2">
              Appliance commands:
            </th>
          </thead>
          <tbody>            
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox"
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
                <div id="stand-by-button-response">Stand-by Mode is turned OFF</div>
              </td>
            </tr>
            <tr>
              <td>
                <label class="switch">
                  <input id="stand-by-button" type="checkbox"
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
          </tbody>
        </table>   

    </div>
  </div>
</div>

</body>
</html>
