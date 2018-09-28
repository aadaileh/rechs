<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}


include("inc/cgi/library.php");
$library = new Library();
$energyProvider = $library->makeCurl ("/energy-provider/", "GET");

  // echo "<pre>energyProvider:\n";
  // print_r($energyProvider);
  // echo "</pre>";
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

  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

  <script>

    $(document).ready(function(){
      //tooltip
      $('[data-toggle="tooltip"]').tooltip(); 

      //turn to inline mode
      $.fn.editable.defaults.mode = 'inline';

      // name
      $('#name').editable({ 
        value: '<?=$energyProvider->name;?>',
        pk: 1,
        url:'/inc/cgi/save-energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // contract_begin
      $('#contract_begin').editable({ 
        value: '<?=$energyProvider->contract_begin;?>',
        pk: 2,
        url:'/inc/cgi/save-energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // contract_end
      $('#contract_end').editable({ 
        value: '<?=$energyProvider->contract_end;?>',
        pk: 3,
        url:'/inc/cgi/save-energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // unit_price
      $('#unit_price').editable({ 
        value: '<?=$energyProvider->unit_price;?>',
        pk: 4,
        url:'/inc/cgi/save-energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // total_annual_consumption
      $('#total_annual_consumption').editable({ 
        value: '<?=$energyProvider->total_annual_consumption;?>',
        pk: 5,
        url:'/inc/cgi/save-energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

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

<div style="width: 75%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Energy Provider Optimizer</h4>
      As an additional contribution of Project RECHS, this module gives householder the oppurtunity to switch the energy provider, searching for better one in matters of price, service and overall quality.
    </div>
  </div>
</div>


<div style="width: 75%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Current Energy Provider Details</a></strong>
    </div>

      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row"><label for="">Energy Provider Name</label></th>
            <td>
              <a href="#" id="name" data-type="text" data-pk="1" data-title="Enter Enter the complete name of your energy provider."></a>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="contract_begin">Contract Begin's Date</label>
            </th>
            <td>
              <a href="#" id="contract_begin" data-type="text" data-pk="2" data-title="Enter Enter the contract's begin date."></a>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="contract_end">Contract End's Date</label></th>
            <td>
              <a href="#" id="contract_end" data-type="text" data-pk="3" data-title="Enter Enter the contract's end date"></a>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="unit_price">Kwh Unit Price (€)</label></th>
            <td>
              <a href="#" id="unit_price" data-type="text" data-pk="4" data-title="Enter Enter the kwh unit price."></a>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="total_annual_consumption">Total Annual Energy consumption (Kwh)</label></th>
            <td>
              <a href="#" id="total_annual_consumption" data-type="text" data-pk="5" data-title="Enter Enter the annual energy consumption."></a>
            </td>
          </tr>
          </tr>
        </tbody>
      </table>

  </div>
</div>

<div style="width: 75%; padding:0px 15px 0px 7px; ">
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
