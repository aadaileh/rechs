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
  $appliances = $library->makeCurl ("/appliances/", "GET");

  echo "<pre>appliances:\n";
  print_r($appliances);
  echo "</pre>";

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
  <script type="text/javascript" src="inc/js/node-management.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

<?php
  foreach ($appliances as $key => $value) {
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
                    foreach ($appliances as $key => $value) {
                      $id = $value->id;
                      $label = $value->label;
                      $status = $value->status; 
                      $annualEnergyConsumption = $value->annualEnergyConsumption;
                      $hourlyEnergyConsumption = $value->hourlyEnergyConsumption;
                      $size = $value->size;
                      $sizeUnit = $value->sizeUnit;
                      $standByStatus = $value->standByStatus;
                      $systemName = $value->systemName;
                      $type = $value->type;
                      $createdBy = $value->createdBy;
                      $energyEfficientClass = $value->energyEfficientClass;
                      $externalLink = $value->externalLink;
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
                          "> <?=$label;?>
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
                    
                    <!-- Appliance type -->
                    <div class="form-group">
                      <label for="appliance_type">Connected Appliance Type</label>
                      <select class="form-control" id="appliance_type" aria-describedby="appliance_type_help" style="width: 200px;">
                        <option value="frig">Refrigerator</option>
                        <option value="tv">TV</option>
                        <option value="lamp">Stand Lamp</option>
                      </select>
                      <small id="appliance_type_help" class="form-text text-muted">Lorem ipsum dolor amet ...</small>
                    </div>

                    <!-- Appliance label -->
                    <div class="form-group">
                      <label for="appliance_label">Appliance Label</label>
                      <input type="text" class="form-control" id="appliance_label" aria-describedby="appliance_label_help" placeholder="Enter Appliance Name, Label, .." style="width: 400px;">
                      <small id="appliance_label_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <!-- Annual Energy consumption (kwh) -->
                    <div class="form-group">
                      <label for="appliance_energy_consumption_kwh">Annual Energy consumption (kwh)</label>
                      <input type="number" class="form-control" id="appliance_energy_consumption_kwh" aria-describedby="appliance_energy_consumption_kwh_help" placeholder="Enter the Annual Energy consumption in kwh" style="width: 400px;">
                      <small id="appliance_energy_consumption_kwh_help" class="form-text text-muted">Lorem ipsum dolor amet ...</small>
                    </div>

                    <!-- Energy consumption (Watts) -->
                    <div class="form-group">
                      <label for="appliance_energy_consumption_watts">Energy consumption (Watts)</label>
                      <input type="number" class="form-control" id="appliance_energy_consumption_watts" aria-describedby="appliance_energy_consumption_watts_help" placeholder="Enter the energy consumption in watts" style="width: 400px;">
                      <small id="appliance_energy_consumption_watts_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <!-- Energy Efficient Class -->
                    <div class="form-group">
                      <label for="energy_efficient_class">Energy Efficient Class</label>
                      <select class="form-control" id="energy_efficient_class" aria-describedby="energy_efficient_class_help" style="width: 200px;">
                        <option value="A+++">A+++</option>
                        <option value="A++">A++</option>
                        <option value="A+">A+</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                      </select>
                      <small id="energy_efficient_class_help" class="form-text text-muted">Lorem ipsum dolor amet ...</small>
                    </div>

                    <!-- Size -->
                    <div class="form-group">
                      <label for="size">Size <span id="size_unit_span">(in Liter, Inch, Watt depends on the appliancde)</span></label>
                      <input type="number" class="form-control" id="size" aria-describedby="size_help" placeholder="Enter the size of the appliance" style="width: 400px;">
                      <input type="hidden" id="size_unit" value="something" name="size_unit">
                      <small id="size_help" class="form-text text-muted">We'll never share your email with anyone else.</small>
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
