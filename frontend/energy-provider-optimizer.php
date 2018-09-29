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

$energyProviderList = $library->makeExternalCurl ("https://developer.nrel.gov/api/alt-fuel-stations/v1.json?fuel_type=E85,ELEC&state=CA&limit=2&api_key=M5Q82v8PbrimvyJ4uSfJclvn50ajRpZCzIXMwGzi&format=JSON", "GET");

  echo "<pre>energyProviderList:";
  print_r($energyProviderList);
  echo "</pre>";
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
        url:'/inc/cgi/energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // contract_begin
      $('#contract_begin').editable({ 
        value: '<?=$energyProvider->contract_begin;?>',
        pk: 2,
        url:'/inc/cgi/energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // contract_end
      $('#contract_end').editable({ 
        value: '<?=$energyProvider->contract_end;?>',
        pk: 3,
        url:'/inc/cgi/energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // unit_price
      $('#unit_price').editable({ 
        value: '<?=$energyProvider->unit_price;?>',
        pk: 4,
        url:'/inc/cgi/energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });

      // total_annual_consumption
      $('#total_annual_consumption').editable({ 
        value: '<?=$energyProvider->total_annual_consumption;?>',
        pk: 5,
        url:'/inc/cgi/energy-provider.php',
        success: function(response, newValue) {
          if(response.status == 'error') return response.msg;
        }
      });
    });

      // Search for energy provider
      $(document).on("click", "#search-energy-provider", function(e) {
        $.ajax({
          url: "/inc/cgi/energy-provider.php",
          type: "GET",
          data: {
            search: true
          },
          success: function(response) {
            //alert("response: " + response);
            //Do Something
            //location.reload();
          },
          error: function(xhr) {
            //Do Something to handle error
            //alert("error: " + xhr);
          }
        });
      });

      $(document).ajaxStart(function(){
        $("#search-results").css("display", "none");
        $("#loader").css("display", "block");
        $('html,body').animate({scrollTop: '+=' + $('#loader').offset().top + 'px'}, 'slow');
      });

      $(document).ajaxComplete(function(){
        $("#search-results").css("display", "block");
        $("#loader").css("display", "none");
        $('html,body').animate({scrollTop: '+=' + $('#search-results').offset().top + 'px'}, 'slow');
      });

  </script>

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
  </style>

</head>
<body><center>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 50%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Energy Provider Optimizer</h4>
      As an additional contribution of Project RECHS, this module gives householder the oppurtunity to switch the energy provider, searching for better one in matters of price, service and overall quality.
    </div>
  </div>
</div>


<div style="width: 50%; padding:0px 15px 0px 7px; ">
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

<div style="width: 50%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="Bosch Model 1234 Extra" style="color:white;">Search for Energy Providers</a></strong>
    </div>
    <div class="panel-body">

      <div class="panel panel-default" id="search-frig">
        <div class="panel-body">
          <div class="form-group" style="margin-bottom: 0px;">
              <center>
                <button type="button" class="btn btn-danger" id="search-energy-provider" data-target="">Search For Alternative Energy Provider in NREL Developer Network</button>
              </center>
              <br><small class="form-text text-muted">Clicking this search button takes the enetered current energy provider's data and search in the external <img src="inc/img/nrel-logo.jpg" height="25px"> NREL Developer Network API for alternatives.</small>
          </div>
        </div>
      </div>

    <div class="list-group" id="search-results" style="display: none;">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody>
      </table>
    </div>


      <div class="alert alert-success" role="alert" id="search-response-true" style="display: none;"></div>
      <div class="alert alert-danger" role="alert" id="search-response-false" style="display: none;"></div>

      <center><div class="loader" id="loader" style="display: none;"></div></center>

            

    </div>
  </div>
</div>
</center>
</body>
</html>
