<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}


    //Get energy consumption data
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://127.0.0.1:8282/api/measurments/appliance/3",
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_PORT=>"8282",
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_ENCODING=>"",
    CURLOPT_MAXREDIRS=>10,
    CURLOPT_TIMEOUT=>30,
    CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
      "authorization: Basic YXBpdXNlcjpwYXNz",
      "content-type: application/json")
  ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    if ($err) {
    echo "cURL Error #:" . $err;
      $error = "Error while retrieving the data. Try refreshing the page.";
    } else {
    
    $data = json_decode($response);
  }

/*
  echo "<pre>data:";
  print_r($data);
  echo "</pre>";
*/
  $wattsArray = Array();
  $DatesArray = Array();
  foreach ($data as $key => $value) {
    array_push($wattsArray, $value->watts);
    array_push($DatesArray, $value->createdTimestamp);
  }


/*  echo "<pre>wattsArray:";
  print_r($wattsArray);
  echo "</pre>";*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>


  <script src="/Chart.js-master/dist/Chart.bundle.js"></script>
  <script src="/Chart.js-master/samples/utils.js"></script>
  <style>
  canvas{
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
  </style>
</head>
<body>

<?php include("inc/top-nav.php");?>

  <div style="width:75%;">
    <canvas id="canvas"></canvas>
  </div>

  <script>
    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var config = {
      type: 'line',
      data: {
        labels: [<?php echo "'" . implode("', '", $DatesArray) . "'";?>],
        datasets: [{
          label: 'Watt',
          backgroundColor: window.chartColors.red,
          borderColor: window.chartColors.red,
          data: [<?php echo implode(",",$wattsArray);?>],
          fill: false,
        }, {
          label: 'Amper',
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: [],
        }, {
          label: 'Kwh',
          fill: false,
          backgroundColor: window.chartColors.yellow,
          borderColor: window.chartColors.yellow,
          data: [],
        }]
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: 'Node Nr. 3 Consumption Development (3 Months)'
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Months'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Value'
            }
          }]
        }
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('canvas').getContext('2d');
      window.myLine = new Chart(ctx, config);
    };

    document.getElementById('randomizeData').addEventListener('click', function() {
      config.data.datasets.forEach(function(dataset) {
        dataset.data = dataset.data.map(function() {
          return randomScalingFactor();
        });

      });

      window.myLine.update();
    });

    var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
      var colorName = colorNames[config.data.datasets.length % colorNames.length];
      var newColor = window.chartColors[colorName];
      var newDataset = {
        label: 'Dataset ' + config.data.datasets.length,
        backgroundColor: newColor,
        borderColor: newColor,
        data: [],
        fill: false
      };

      for (var index = 0; index < config.data.labels.length; ++index) {
        newDataset.data.push(randomScalingFactor());
      }

      config.data.datasets.push(newDataset);
      window.myLine.update();
    });

    document.getElementById('addData').addEventListener('click', function() {
      if (config.data.datasets.length > 0) {
        var month = MONTHS[config.data.labels.length % MONTHS.length];
        config.data.labels.push(month);

        config.data.datasets.forEach(function(dataset) {
          dataset.data.push(randomScalingFactor());
        });

        window.myLine.update();
      }
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
      config.data.datasets.splice(0, 1);
      window.myLine.update();
    });

    document.getElementById('removeData').addEventListener('click', function() {
      config.data.labels.splice(-1, 1); // remove the label first

      config.data.datasets.forEach(function(dataset) {
        dataset.data.pop();
      });

      window.myLine.update();
    });
  </script>
</body>
</html>
