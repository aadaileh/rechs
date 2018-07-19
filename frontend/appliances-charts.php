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

<h1>appliances-charts.php</h1>


</body>
</html>
