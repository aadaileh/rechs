<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>RECHS - Home</title>
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

<?php include("inc/top-nav.php");?>


  <div class="panel panel-primary" style="width: 33%;">
    <div class="panel-heading"><strong>Icons</strong></div>
    <div class="panel-body">
      <div>Icons made by <a href="https://www.flaticon.com/authors/cursor-creative" title="Cursor Creative" target="_blank">Cursor Creative</a> from <a href="https://www.flaticon.com/" title="Flaticon" target="_blank">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </div>
  </div>


</body>
</html>
