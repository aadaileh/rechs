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
  <title>EOP (Energy Provider Optimizer)</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
  </style>
</head>
<body>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 100%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Energy Provider Optimizer</h4>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non ligula eget nulla malesuada dignissim eget ut eros. Vivamus fermentum lectus vitae orci hendrerit vehicula. Suspendisse felis ligula, viverra in suscipit et, mattis et augue. Duis accumsan at erat a pulvinar. Mauris venenatis auctor tellus a finibus. Fusce facilisis mi eu libero fermentum rhoncus. Donec elementum lacus quis vestibulum scelerisque. Donec non consectetur nibh, ac consectetur nibh. Morbi at venenatis dui. Donec tincidunt maximus purus, eget mollis mauris suscipit a. Pellentesque porta vehicula nisi fringilla porta. Donec quis felis et nisl vestibulum mattis nec non augue. Donec orci dolor, eleifend at tortor eget, ultrices varius mauris. Suspendisse potenti. Cras hendrerit tellus neque, id sagittis mauris congue commodo.
    </div>
  </div>
</div>


<div style="width: 100%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Energy Provider List</a></strong>
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
                  <h4 class="modal-title" id="addNewNodeModalLabel" style="font-weight: bold; float: left;">Add new Energy Provider</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="alert alert-success" role="alert" id="save-response-true" style="display: none;">Energy Provider saved correctly.</div>
                  <div class="alert alert-danger" role="alert" id="save-response-false" style="display: none;">x</div>

                  <form action="#" method="post" id="add-new-energy-provider-form" name="add-new-energy-provider-form">
                    <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">
                    
                    <!-- Energy Provider Name -->
                    <div class="form-group">
                      <label for="energy_provider_name">Energy Provider Name</label>
                      <input type="text" class="form-control" id="energy_provider_name" aria-describedby="energy_provider_name_help" placeholder="Enter Energy Provider Name" style="width: 400px;">
                      <small id="energy_provider_name_help" class="form-text text-muted">Enter the complete name of your energy provider.</small>
                    </div>

                    <!-- Contract Begin Date -->
                    <div class="form-group">
                      <label for="contract_begin_date">Contract Begin's Date</label>
                      <input type="Date" class="form-control" id="contract_begin_date" aria-describedby="contract_begin_date_help" placeholder="Enter Contract Begin Date" style="width: 400px;">
                      <small id="contract_begin_date_help" class="form-text text-muted">Use this field to enter the begin date of your contract</small>
                    </div>

                    <!-- Contract End Date -->
                    <div class="form-group">
                      <label for="contract_end_date">Contract End's Date</label>
                      <input type="Date" class="form-control" id="contract_end_date" aria-describedby="contract_end_date_help" placeholder="Enter Contract End Date" style="width: 400px;">
                      <small id="contract_end_date_help" class="form-text text-muted">Use this field to enter the end date of your contract</small>
                    </div>

                    <!-- kwh unit price -->
                    <div class="form-group">
                      <label for="kwh_unit_price">Kwh Unit Price (€)</label>
                      <input type="number" class="form-control" id="kwh_unit_price" aria-describedby="kwh_unit_price_help" placeholder="Enter the Kwh Unit Price charged by your current Energy Provider in €" style="width: 400px;">
                      <small id="kwh_unit_price_help" class="form-text text-muted">Enter the Kwh Unit Price charged by your current Energy Provider in €</small>
                    </div>

                    <!-- Total Annual Energy consumption (Kwh) -->
                    <div class="form-group">
                      <label for="total_annual_energy_consumption">Total Annual Energy consumption (Kwh)</label>
                      <input type="number" class="form-control" id="total_annual_energy_consumption" aria-describedby="total_annual_energy_consumption_help" placeholder="Enter the total annual energy consumption in Kwh." style="width: 400px;">
                      <small id="total_annual_energy_consumption_help" class="form-text text-muted">Enter the total annual energy consumption in Kwh.</small>
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

<div style="width: 100%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Search for Energy Providers</a></strong>
    </div>
    <div class="panel-body">


      <!-- Button trigger edit -->
      <button data-button="3" value="frig-edit-button-value" id="frig-edit-modal-btn" type="button"
      class="btn btn-primary" style="float: left;">
        <span style="font-weight: normal; font-size: 12pt;">Search for efficient Energy Providers</span>
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


        </div>
    </div>
  </div>
</div>

</body>
</html>
