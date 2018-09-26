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

  $lowestWatts = $library->makeCurl ("/measurments/watts/lowest", "GET", null);
  foreach ($lowestWatts as $key => $value) {

    if($value[2]->systemName == "stand_lamp") {
       $lamp->lowestWatts = $value[1];
    }
  
    if($value[2]->systemName == "lg_smart_tv") {
       $tv->lowestWatts = $value[1];
    }
  
    if($value[2]->systemName == "refrigerator") {
       $refrigerator->lowestWatts = $value[1];
    }
     
  }

  $oldestLatestCreatedTimestamp = $library->makeCurl ("/measurments/created-timestamp/latest-oldest", "GET", null);
  foreach ($oldestLatestCreatedTimestamp as $key => $value) {

    if($value[3]->systemName == "stand_lamp") {
       $lamp->oldestCreatedTimestamp = $value[1];
       $lamp->latestCreatedTimestamp = $value[2];
    }
  
    if($value[3]->systemName == "lg_smart_tv") {
       $tv->oldestCreatedTimestamp = $value[1];
       $tv->latestCreatedTimestamp = $value[2];
    }
  
    if($value[3]->systemName == "refrigerator") {
       $refrigerator->oldestCreatedTimestamp = $value[1];
       $refrigerator->latestCreatedTimestamp = $value[2];
    }
     
  }

// echo "<pre>refrigerator:\n";
// print_r($refrigerator);
// echo "</pre>";

// echo "<pre>tv:\n";
// print_r($tv);
// echo "</pre>";

// echo "<pre>lamp:\n";
// print_r($lamp);
// echo "</pre>";

?>

 

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Appliances Overview</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="inc/css/switch.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>

  <script>

    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    });   


    $(document).ready(function(){
        $("#stand-by-button-frig").add("#stand-by-duration-button-frig").click(function(){

          if (document.getElementById("stand-by-button-frig").checked) {
            $("#stand-by-duration-frig").fadeIn(700);
            $standbyDurationSpan = document.getElementById("standby_duration_frig").value;
          } else {
            $("#stand-by-duration-frig").fadeOut(700);
            $standbyDurationSpan = document.getElementById("standby_duration_frig").value = 0;
          }
            alert("call save.php");
            $.post("/inc/cgi/appliances-save.php",
              {
                flag: "standby",
                id: document.getElementById("stand-by-button-frig").value,
                standbyDurationSpan: $standbyDurationSpan,
                standByStatus: document.getElementById("stand-by-button-frig").checked
              },
            function(data, status){
              //alert("Data(frig): " + data + "\nStatus: " + status);
              //$("#stand-by-button-frig-response").text(data);
              $("#alert-success-frig").fadeIn();
              setTimeout(function() {$("#alert-success-frig").fadeOut('blind');}, 2000);
            });
        });

        $("#stand-by-button-tv").add("#stand-by-duration-button-tv").click(function(){
            if (document.getElementById("stand-by-button-tv").checked) {
              $("#stand-by-duration-tv").fadeIn(700);
              $standbyDurationSpan = document.getElementById("standby_duration_tv").value;
            } else {
              $("#stand-by-duration-tv").fadeOut(700);
              $standbyDurationSpan = document.getElementById("standby_duration_tv").value = 0;
            }
            $.post("/inc/cgi/appliances-save.php",
              {
                flag: "standby",
                id: document.getElementById("stand-by-button-tv").value,
                standbyDurationSpan: $standbyDurationSpan,
                standByStatus: document.getElementById("stand-by-button-tv").checked
              },
            function(data, status){
              //alert("Data(tv): " + data + "\nStatus: " + status);
              //$("#stand-by-button-tv-response").text(data);
              $("#alert-success-tv").fadeIn();
              setTimeout(function() {$("#alert-success-tv").fadeOut('blind');}, 2000);
            });
        });

        $("#stand-by-button-lamp").add("#stand-by-duration-button-lamp").click(function(){
            if (document.getElementById("stand-by-button-lamp").checked) {
              $("#stand-by-duration-lamp").fadeIn(700);
              $standbyDurationSpan = document.getElementById("standby_duration_lamp").value;
            } else {
              $("#stand-by-duration-lamp").fadeOut(700);
              $standbyDurationSpan = document.getElementById("standby_duration_lamp").value = 0;
            }
            $.post("/inc/cgi/appliances-save.php",
              {
                flag: "standby",
                id: document.getElementById("stand-by-button-lamp").value,
                standbyDurationSpan: $standbyDurationSpan,
                standByStatus: document.getElementById("stand-by-button-lamp").checked
              },
            function(data, status){
              //alert("Data(lamp): " + data + "\nStatus: " + status);
              //$("#stand-by-button-lamp-response").text(data);
              $("#alert-success-lamp").fadeIn();
              setTimeout(function() {$("#alert-success-lamp").fadeOut('blind');}, 2000);
            });
        });
    });

    //<!-- bootbox code -->
    $(document).on("click", ".alert-confirm", function(e) {

      //var $activeElement = $(document.activeElement);
      var initial_id = this.id;
      var idArray = initial_id.split("-");
      var id = idArray[idArray.length - 1];

      var checked = this.checked;
      var action = "";
      if(checked == true) {
        action = "turnon";
      } else {
        action = "turnoff";
      }

      //alert("action: " + action);

      bootbox.confirm({
          title: "Confirm Switch Appliance ON/OFF",
          message: "<strong>Do you really want to switch this appliance ON/OFF?</strong>",
          buttons: {
              confirm: {
                  label: 'Yes',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'No',
                  className: 'btn-danger'
              }
          },
          callback: function (result) {
            //alert(result);
            switchAppliance(action, id);
          }
      });
    });

    function switchAppliance(action, appliance_id) {
      //alert("action: " + action + ", " + "appliance_id: " + appliance_id);

      $.ajax({
        url: "/inc/cgi/appliances-save.php",
        type: "GET",
        data: {
          id: appliance_id,
          action: action
        },
        success: function(response) {
          //alert("response: " + response);
          //Do Something
          //location.reload();
        },
        error: function(xhr) {
          //Do Something to handle error
          alert("error: " + xhr);
        }
      });
      }

    //Do something when opening a Modal
    $(document).ready(function(){

      $('#editFrigModal').on('hidden.bs.modal', function(e) {
        $(this).find('#edit-frig-form')[0].reset();
        $('#save-response-true-1').hide();
        $('#save-response-false-1').hide();

        $('#save-response-true-2').hide();
        $('#save-response-false-2').hide();

        $('#save-response-true-3').hide();
        $('#save-response-false-3').hide();        
      });

    }); 

    //<!-- Update Applinace's Date -->
    $(document).ready(function(){
      $("#edit-appliance-save-1, #edit-appliance-save-2, #edit-appliance-save-3").click(function(){

        //alert("this.name:" + this.name);

        var form_name = "";
        if(this.name == "1") {form_name = "edit-lamp-form";} 
        else if (this.name == "2") {form_name = "edit-tv-form";} 
        else if (this.name == "3") {form_name = "edit-frig-form";}

        $.post("/inc/cgi/appliances-save.php",
        {
          id: this.name,
          createdBy: document.getElementById("createdBy").value,
          label: document.getElementById(form_name).elements.namedItem("appliance_label").value,
          annualEnergyConsumption: document.getElementById(form_name).elements.namedItem("appliance_energy_consumption_kwh").value,
          hourlyEnergyConsumption: document.getElementById(form_name).elements.namedItem("appliance_energy_consumption_watts").value,
          energyEfficientClass: document.getElementById(form_name).elements.namedItem("energy_efficient_class").value,
          size: document.getElementById(form_name).elements.namedItem("size").value,
          externalLink: document.getElementById(form_name).elements.namedItem("external_link").value
        },
        function(data, status){
          //alert("Data: " + data + "\nStatus: " + status);
          if (data == "true") {
            $("#save-response-true-1").show();
            $("#save-response-false-1").hide();

            $("#save-response-true-2").show();
            $("#save-response-false-2").hide();
            
            $("#save-response-true-3").show();
            $("#save-response-false-3").hide();
            window.setTimeout(hide_popup, 9000);
            setTimeout(function(){location.reload();}, 2000);
            
          } else {
            $("#save-response-false-1").html(data);
            $("#save-response-false-1").show();
            $("#save-response-true-1").hide();

            $("#save-response-false-2").html(data);
            $("#save-response-false-2").show();
            $("#save-response-true-2").hide();

            $("#save-response-false-3").html(data);
            $("#save-response-false-3").show();
            $("#save-response-true-3").hide();
          }
        });
      
      });
    });

    function hide_popup(){
       $("#editFrigModal").modal('hide');
    };


</script>

  <!-- bootbox code -->
  <script src="inc/js/bower_components/bootbox.js/bootbox.js"></script>

  <!-- eBay Search Scripts -->
  <script src="inc/js/ebay_search.js"></script>  

<style type="text/css">
  .modal-dialog-large {
     width: 65%;
     margin: auto;
     margin-top: 50px;
  }

  .loader-frig,.loader-tv,.loader-lamp,.loader{
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  #theTable td {
     vertical-align: middle;
  }

  #appliance {
    float:left; 
    width: 33%; 
    padding: 0px 10px 0px 10px;
  }

  #panel-body {
    #padding: 5px;
  }
</style>

</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 100%; padding: 0 22px 0 11px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Applainces Overview</h4>
      <ul>
        <li>View all available appliances' data</li>
        <li>See the status of the collected energy consumption data, with date</li>
        <li>Edit appliances</li>
        <li>Manage the standby modus, including the "standby duration (in seconds)"</li>
        <li>Switch nodes/appliances ON/OFF</li>
      </ul>
    </div>
  </div>
</div>

<!-- frig -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8;text-align: center;">
      <a href="#" title="Frig: <?php echo $refrigerator->label; ?>" data-button="3" id="frig-modal-3" data-toggle="modal" data-target="#editFrigModal"><img src="inc/img/fridge.svg" width="50%"></a>
    </div>
    <div class="panel-body" id="panel-body">
      <!-- BODY -->

        <table class="table table-striped" id="theTable">
          <thead>
            <th colspan="2">Appliance Details:</th>
          </thead>
          <tbody>
            <tr>
              <td>Retrieving data status:</td>
              <td>
                <?php

                $d1 = new DateTime($refrigerator->latestCreatedTimestamp);
                $latest_measured_date = $d1->format('Y-m-d H:i:s');
                $now = date('Y-m-d H:i:s');
                $yesterday = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($now)));

                  if ( $yesterday < $latest_measured_date && $latest_measured_date < $now ) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
                </td>
            </tr>
            <tr>
              <td>Last retrieving data's date:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($refrigerator->latestCreatedTimestamp)); ?></td>
            </tr>
            <tr>
              <td>Label:</td>
              <td><?=trim($refrigerator->externalLink) != '' ? '<a href="' . $refrigerator->externalLink . '">' . $refrigerator->label . '</a>' : $refrigerator->label; ?></td>
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
              <td>lowest watts detected:</td>
              <td><?php echo $refrigerator->lowestWatts; ?> (Watts)</td>
            </tr>
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($refrigerator->createdTimestamp)); ?></td>
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
                  <input id="stand-by-button-onoff-frig-3" type="checkbox" value="onoff-frig" class="alert-confirm">
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

        <div class="panel panel-default" id="stand-by-duration-frig" 
        <?php
          if($refrigerator->standByStatus != 1) {
            echo 'style="display: none;"';
          }
        ?>
        >
          <div class="panel-body">
            <div class="alert alert-success" id="alert-success-frig" style="display: none;">
              <strong>Success!</strong> Standby duration saved correctlly.
            </div>
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="standby_duration_frig" type="number" name="standby_duration_frig" style="width: 80px;"value="<?=$refrigerator->standbyDurationSpan;?>">
                <button type="button" class="btn btn-primary" id="stand-by-duration-button-frig">Save</button>
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>

        <div class="panel panel-default" id="search-frig">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
                <center>
                  <button type="button" class="btn btn-danger" id="search-appliance-button-frig" data-toggle="modal" data-target="#searchFrigModal">Search For Alternative Products in eBay</button>
                </center>
                <br><small class="form-text text-muted">Clicking this search button takes the enetered appliance's data and search in the external <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API for alternatives appliances. Results will be shown in a modal.</small>
            </div>
          </div>
        </div>

    </div>
  </div>

  <!-- Modal edit Frig -->
  <div class="container">
    <div class="modal fade" id="editFrigModal" tabindex="-1" role="dialog" aria-labelledby="editFrigModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="editFrigModalLabel" style="font-weight: bold; float: left;">Edit Appliance Data (Frig)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="save-response-true-3" style="display: none;">Appliance data saved correctly.</div>
            <div class="alert alert-danger" role="alert" id="save-response-false-3" style="display: none;">x</div>

            <form action="#" method="post" id="edit-frig-form" name="edit-frig-form">
              <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">

              <!-- Appliance label -->
              <div class="form-group">
                <label for="appliance_label">Appliance Label *</label>
                <input value="<?php echo $refrigerator->label;?>" type="text" class="form-control" id="appliance_label" aria-describedby="appliance_label_help" placeholder="Enter Appliance Name, Label, .." style="width: 400px;">
                <small id="appliance_label_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>

              <!-- External link -->
              <div class="form-group">
                <label for="external_link">External link</label>
                <input value="<?php echo $refrigerator->externalLink;?>" type="text" class="form-control" id="external_link" aria-describedby="external_link_help" placeholder="http://www.example.com/appliance.html" style="width: 400px;">
                <small id="external_link_help" class="form-text text-muted">Copy/paste the external link of this applinace (if available).</small>
              </div>              

              <!-- Annual Energy consumption (kwh) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_kwh">Annual Energy consumption (kwh) *</label>
                <input value="<?php echo $refrigerator->annualEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_kwh" aria-describedby="appliance_energy_consumption_kwh_help" placeholder="Enter the Annual Energy consumption in kwh" style="width: 200px;">
              </div>

              <!-- Energy consumption (Watts) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_watts">Energy consumption (Watts) *</label>
                <input value="<?php echo $refrigerator->hourlyEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_watts" aria-describedby="appliance_energy_consumption_watts_help" placeholder="Enter the energy consumption in watts" style="width: 200px;">
              </div>

              <!-- Energy Efficient Class -->
              <div class="form-group">
                <label for="energy_efficient_class">Energy Efficient Class *</label>
                <select class="form-control" id="energy_efficient_class" aria-describedby="energy_efficient_class_help" style="width: 200px;">
                  <option value="A+++" <?php echo $refrigerator->energyEfficientClass == "A+++"?"selected":"";?>>A+++</option>
                  <option value="A++" <?php echo $refrigerator->energyEfficientClass == "A++"?"selected":"";?>>A++</option>
                  <option value="A+" <?php echo $refrigerator->energyEfficientClass == "A+"?"selected":"";?>>A+</option>
                  <option value="A" <?php echo $refrigerator->energyEfficientClass == "A"?"selected":"";?>>A</option>
                  <option value="B" <?php echo $refrigerator->energyEfficientClass == "B"?"selected":"";?>>B</option>
                  <option value="C" <?php echo $refrigerator->energyEfficientClass == "C"?"selected":"";?>>C</option>
                  <option value="D" <?php echo $refrigerator->energyEfficientClass == "D"?"selected":"";?>>D</option>
                </select>
                <small id="energy_efficient_class_help" class="form-text text-muted">Choosing the Energy Efficiency Class is essential.</small>
              </div>

              <!-- Size -->
              <div class="form-group">
                <label for="size">Size <span id="size_unit_span">(in <?php echo $refrigerator->sizeUnit;?>) *</span></label>
                <input value="<?php echo $refrigerator->size;?>" type="number" class="form-control" id="size" name="size" aria-describedby="size_help" placeholder="Enter the size of the appliance" style="width: 200px;">
                <small id="size_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-3" name="3">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>

  <!-- Modal Search Frig -->
  <div class="container">
    <div class="modal fade" id="searchFrigModal" tabindex="-1" role="dialog" aria-labelledby="searchFrigModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-large" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="searchFrigModalLabel" style="font-weight: bold; float: left;">Search Alternative Appliance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="search-response-true-3" style="display: none;"></div>
            <div class="alert alert-danger" role="alert" id="search-response-false-3" style="display: none;"></div>

            <center><div class="loader" id="loader-frig" style="display: none;"></div></center>

            <div class="list-group" id="frig-search-results"></div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-3" name="3">Save changes</button>
            <br><br><span style="float: left;">Powered By <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>  

</div>



<!-- tv -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8; text-align: center;">
      <a href="#" title="Tv: <?php echo $tv->label; ?>" data-button="3" id="tv-modal-2" data-toggle="modal" data-target="#editTvModal"><img src="inc/img/tv.svg" width="50%"></a>
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
              <td>Retrieving data status:</td>
              <td>
                <?php

                $d1 = new DateTime($tv->latestCreatedTimestamp);
                $latest_measured_date = $d1->format('Y-m-d H:i:s');
                $now = date('Y-m-d H:i:s');
                $yesterday = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($now)));

                  if ( $yesterday < $latest_measured_date && $latest_measured_date < $now ) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
                </td>
            </tr>
            <tr>
              <td>Last retrieving data's date:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($tv->latestCreatedTimestamp)); ?></td>
            </tr>
            <tr>
              <td>Label:</td>
              <td><?=trim($tv->externalLink) != '' ? '<a href="' . $tv->externalLink . '">' . $tv->label . '</a>' : $tv->label; ?></td>
            </tr>  
            <tr>
              <td>Annual&nbsp;Energy&nbsp;consumption:</td>
              <td><?php echo $tv->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy&nbsp;consumption&nbsp;(in Watts):</td>
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
              <td>lowest watts detected:</td>
              <td><?php echo $tv->lowestWatts; ?> (Watts)</td>
            </tr>
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($tv->createdTimestamp)); ?></td>
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
                  <input id="stand-by-button-onoff-tv-2" type="checkbox" class="alert-confirm">
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

        <div class="panel panel-default" id="stand-by-duration-tv"
        <?php
          if($tv->standByStatus != 1) {
            echo 'style="display: none;"';
          }
        ?>
        >
          <div class="panel-body">
            <div class="alert alert-success" id="alert-success-tv" style="display: none;">
              <strong>Success!</strong> Standby duration saved correctlly.
            </div>            
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="standby_duration_tv" type="number" name="standby_duration_tv" style="width: 80px;" value="<?=$tv->standbyDurationSpan;?>">
                <button type="button" class="btn btn-primary" id="stand-by-duration-button-tv">Save</button>
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>


        <div class="panel panel-default" id="search-tv">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
                <center>
                  <button type="button" class="btn btn-danger" id="search-appliance-button-tv" data-toggle="modal" data-target="#searchTvModal">Search For Alternative Products in eBay</button>
                </center>
                <br><small class="form-text text-muted">Clicking this search button takes the enetered appliance's data and search in the external <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API for alternatives appliances. Results will be shown in a modal.</small>
            </div>
          </div>
        </div>

    </div>
  </div>

  <!-- Modal edit TV -->
  <div class="container">
    <div class="modal fade" id="editTvModal" tabindex="-1" role="dialog" aria-labelledby="editTvModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="editTvModalLabel" style="font-weight: bold; float: left;">Edit Appliance Data (TV)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="save-response-true-2" style="display: none;">Appliance data saved correctly.</div>
            <div class="alert alert-danger" role="alert" id="save-response-false-2" style="display: none;">x</div>

            <form action="#" method="post" id="edit-tv-form" name="edit-tv-form">
              <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">

              <!-- Appliance label -->
              <div class="form-group">
                <label for="appliance_label">Appliance Label *</label>
                <input value="<?php echo $tv->label;?>" type="text" class="form-control" id="appliance_label" aria-describedby="appliance_label_help" placeholder="Enter Appliance Name, Label, .." style="width: 400px;">
                <small id="appliance_label_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>

              <!-- External link -->
              <div class="form-group">
                <label for="external_link">External link</label>
                <input value="<?php echo $tv->externalLink;?>" type="text" class="form-control" id="external_link" aria-describedby="external_link_help" placeholder="http://www.example.com/appliance.html" style="width: 400px;">
                <small id="external_link_help" class="form-text text-muted">Copy/paste the external link of this applinace (if available).</small>
              </div>              

              <!-- Annual Energy consumption (kwh) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_kwh">Annual Energy consumption (kwh) *</label>
                <input value="<?php echo $tv->annualEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_kwh" aria-describedby="appliance_energy_consumption_kwh_help" placeholder="Enter the Annual Energy consumption in kwh" style="width: 200px;">
              </div>

              <!-- Energy consumption (Watts) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_watts">Energy consumption (Watts) *</label>
                <input value="<?php echo $tv->hourlyEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_watts" aria-describedby="appliance_energy_consumption_watts_help" placeholder="Enter the energy consumption in watts" style="width: 200px;">
              </div>

              <!-- Energy Efficient Class -->
              <div class="form-group">
                <label for="energy_efficient_class">Energy Efficient Class *</label>
                <select class="form-control" id="energy_efficient_class" aria-describedby="energy_efficient_class_help" style="width: 200px;">
                  <option value="A+++" <?php echo $tv->energyEfficientClass == "A+++"?"selected":"";?>>A+++</option>
                  <option value="A++" <?php echo $tv->energyEfficientClass == "A++"?"selected":"";?>>A++</option>
                  <option value="A+" <?php echo $tv->energyEfficientClass == "A+"?"selected":"";?>>A+</option>
                  <option value="A" <?php echo $tv->energyEfficientClass == "A"?"selected":"";?>>A</option>
                  <option value="B" <?php echo $tv->energyEfficientClass == "B"?"selected":"";?>>B</option>
                  <option value="C" <?php echo $tv->energyEfficientClass == "C"?"selected":"";?>>C</option>
                  <option value="D" <?php echo $tv->energyEfficientClass == "D"?"selected":"";?>>D</option>
                </select>
                <small id="energy_efficient_class_help" class="form-text text-muted">Choosing the Energy Efficiency Class is essential.</small>
              </div>

              <!-- Size -->
              <div class="form-group">
                <label for="size">Size <span id="size_unit_span">(in <?php echo $tv->sizeUnit;?>) *</span></label>
                <input value="<?php echo $tv->size;?>" type="number" class="form-control" id="size" name="size" aria-describedby="size_help" placeholder="Enter the size of the appliance" style="width: 200px;">
                <small id="size_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-2" name="2">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>

  <!-- Modal Search TV -->
  <div class="container">
    <div class="modal fade" id="searchTvModal" tabindex="-1" role="dialog" aria-labelledby="searchTvModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-large" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="searchTvModalLabel" style="font-weight: bold; float: left;">Search Alternative Appliance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="search-response-true-2" style="display: none;"></div>
            <div class="alert alert-danger" role="alert" id="search-response-false-2" style="display: none;"></div>

            <center><div class="loader" id="loader-tv" style="display: none;"></div></center>

            <div class="list-group" id="tv-search-results"></div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-2" name="3">Save changes</button>
            <br><br><span style="float: left;">Powered By <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API</span>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <!-- Modal End -->

</div>

<!-- lamp -->
<div id="appliance">
  <div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #dff0d8;text-align: center;">
      <a href="#" title="Lamp: <?php echo $lamp->label; ?>" data-button="1" id="lamp-modal-1" data-toggle="modal" data-target="#editLampModal"><img src="inc/img/lamp.svg" width="50%"></a>
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
              <td>Retrieving data status:</td>
              <td>
                <?php

                $d1 = new DateTime($lamp->latestCreatedTimestamp);
                $latest_measured_date = $d1->format('Y-m-d H:i:s');
                $now = date('Y-m-d H:i:s');
                $yesterday = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($now)));

                  if ( $yesterday < $latest_measured_date && $latest_measured_date < $now ) {
                    echo '<img src="inc/img/check.svg" height="20%">';
                  } else {
                    echo '<img src="inc/img/unchecked.svg" height="20%">';
                  }
                ?>
                </td>
            </tr>
            <tr>
              <td>Last retrieving data's date:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($lamp->latestCreatedTimestamp)); ?></td>
            </tr>            
            <tr>
              <td>Label:</td>
              <td><?=trim($lamp->externalLink) != '' ? '<a href="' . $lamp->externalLink . '">' . $lamp->label . '</a>' : $lamp->label; ?></td>
            </tr>           
            <tr>
              <td>Annual&nbsp;Energy&nbsp;consumption:</td>
              <td><?php echo $lamp->annualEnergyConsumption; ?> Kwh</td>
            </tr>
            <tr>
              <td>Energy&nbsp;consumption&nbsp;(in Watts):</td>
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
              <td>lowest watts detected:</td>
              <td><?php echo $lamp->lowestWatts; ?> (Watts)</td>
            </tr>            
            <tr>
              <td>Added on:</td>
              <td><?php echo date('M/d/Y H:m:s', strtotime($lamp->createdTimestamp)); ?></td>
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
                  <input id="stand-by-button-onoff-lamp-1" type="checkbox" class="alert-confirm">
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

        <div class="panel panel-default" id="stand-by-duration-lamp"
        <?php
          if($lamp->standByStatus != 1) {
            echo 'style="display: none;"';
          }
        ?>
        >
          <div class="panel-body">
            <div class="alert alert-success" id="alert-success-lamp" style="display: none;">
              <strong>Success!</strong> Standby duration saved correctlly.
            </div>            
            <div class="form-group" style="margin-bottom: 0px;">
              <form class="form-inline">
                <label for="focusedInput">Standby duration (seconds):</label>
                <input class="form-control" id="standby_duration_lamp" type="number" name="standby_duration_lamp" style="width: 80px;" value="<?=$lamp->standbyDurationSpan;?>">
                <button type="button" class="btn btn-primary" id="stand-by-duration-button-lamp">Save</button>
                <br><small id="appliance_type_help" class="form-text text-muted"><strong>SDO</strong> (<strong>S</strong>tandby <strong>D</strong>etector and <strong>O</strong>ptimizer) will shut down the appliance when it keeps sending the detected standby energy consumption level for seconds defined in this field.</small>
              </form>
            </div>
          </div>
        </div>

        <div class="panel panel-default" id="search-lamp">
          <div class="panel-body">
            <div class="form-group" style="margin-bottom: 0px;">
                <center>
                  <button type="button" class="btn btn-danger" id="search-appliance-button-lamp" data-toggle="modal" data-target="#searchLampModal">Search For Alternative Products in eBay</button>
                </center>
                <br><small class="form-text text-muted">Clicking this search button takes the enetered appliance's data and search in the external <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API for alternatives appliances. Results will be shown in a modal.</small>
            </div>
          </div>
        </div>        

    </div>
  </div>


  <!-- Modal edit Lamp -->
  <div class="container">
    <div class="modal fade" id="editLampModal" tabindex="-1" role="dialog" aria-labelledby="editLampModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="editLampModalLabel" style="font-weight: bold; float: left;">Edit Appliance Data (Lamp)</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="save-response-true-1" style="display: none;">Appliance data saved correctly.</div>
            <div class="alert alert-danger" role="alert" id="save-response-false-1" style="display: none;">x</div>

            <form action="#" method="post" id="edit-lamp-form" name="edit-lamp-form">
              <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">

              <!-- Appliance label -->
              <div class="form-group">
                <label for="appliance_label">Appliance Label *</label>
                <input value="<?php echo $lamp->label;?>" type="text" class="form-control" id="appliance_label" aria-describedby="appliance_label_help" placeholder="Enter Appliance Name, Label, .." style="width: 400px;">
                <small id="appliance_label_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>

              <!-- External link -->
              <div class="form-group">
                <label for="external_link">External link</label>
                <input value="<?php echo $lamp->externalLink;?>" type="text" class="form-control" id="external_link" aria-describedby="external_link_help" placeholder="http://www.example.com/appliance.html" style="width: 400px;">
                <small id="external_link_help" class="form-text text-muted">Copy/paste the external link of this applinace (if available).</small>
              </div>              

              <!-- Annual Energy consumption (kwh) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_kwh">Annual Energy consumption (kwh) *</label>
                <input value="<?php echo $lamp->annualEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_kwh" aria-describedby="appliance_energy_consumption_kwh_help" placeholder="Enter the Annual Energy consumption in kwh" style="width: 200px;">
              </div>

              <!-- Energy consumption (Watts) -->
              <div class="form-group">
                <label for="appliance_energy_consumption_watts">Energy consumption (Watts) *</label>
                <input value="<?php echo $lamp->hourlyEnergyConsumption;?>" type="number" class="form-control" id="appliance_energy_consumption_watts" aria-describedby="appliance_energy_consumption_watts_help" placeholder="Enter the energy consumption in watts" style="width: 200px;">
              </div>

              <!-- Energy Efficient Class -->
              <div class="form-group">
                <label for="energy_efficient_class">Energy Efficient Class *</label>
                <select class="form-control" id="energy_efficient_class" aria-describedby="energy_efficient_class_help" style="width: 200px;">
                  <option value="unrelevant" <?php echo $lamp->energyEfficientClass == "unrelevant"?"selected":"";?>>Not Available</option>
                  <option value="A+++" <?php echo $lamp->energyEfficientClass == "A+++"?"selected":"";?>>A+++</option>
                  <option value="A++" <?php echo $lamp->energyEfficientClass == "A++"?"selected":"";?>>A++</option>
                  <option value="A+" <?php echo $lamp->energyEfficientClass == "A+"?"selected":"";?>>A+</option>
                  <option value="A" <?php echo $lamp->energyEfficientClass == "A"?"selected":"";?>>A</option>
                  <option value="B" <?php echo $lamp->energyEfficientClass == "B"?"selected":"";?>>B</option>
                  <option value="C" <?php echo $lamp->energyEfficientClass == "C"?"selected":"";?>>C</option>
                  <option value="D" <?php echo $lamp->energyEfficientClass == "D"?"selected":"";?>>D</option>
                </select>
                <small id="energy_efficient_class_help" class="form-text text-muted">Choosing the Energy Efficiency Class is essential.</small>
              </div>

              <!-- Size -->
              <div class="form-group">
                <label for="size">Size <span id="size_unit_span">(in <?php echo $lamp->sizeUnit;?>) *</span></label>
                <input value="<?php echo $lamp->size;?>" type="number" class="form-control" id="size" name="size" aria-describedby="size_help" placeholder="Enter the size of the appliance" style="width: 200px;">
                <small id="size_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-1" name="1">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal End -->
  </div>

  <!-- Modal Search Lamp -->
  <div class="container">
    <div class="modal fade" id="searchLampModal" tabindex="-1" role="dialog" aria-labelledby="searchLampModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-large" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="searchLampModalLabel" style="font-weight: bold; float: left;">Search Alternative Appliance</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="alert alert-success" role="alert" id="search-response-true-1" style="display: none;"></div>
            <div class="alert alert-danger" role="alert" id="search-response-false-1" style="display: none;"></div>

            <center><div class="loader" id="loader-lamp" style="display: none;"></div></center>

            <div class="list-group" id="lamp-search-results"></div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="edit-appliance-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="edit-appliance-save-1" name="3">Save changes</button>
            <br><br><span style="float: left;">Powered By <img src="inc/img/1280px-EBay_logo.svg.png" height="22px" width="40px"> Product Search API</span>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <!-- Modal End -->


</div>

</body>
</html>
