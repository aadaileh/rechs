<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(count($_SESSION["user"]) > 0) { 
  header('Location: /home.php');
}


if($_POST) {

   $username = trim(stripslashes($_POST['username']));
   $password = trim(stripslashes($_POST['password']));


  if (!isset($error) && !$error) {

    // verify login
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://localhost:8282/api/authentication/verify",
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{
        \"username\":\"" . $username . "\",
        \"password\":\"" . $password . "\"
      }",
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
      $error = "Username or password is not correct. Please try again or contact the admin.";
  	} else {
  	
    $data = json_decode($response);
    $_SESSION["user"] = $data;

  if ($data != "") {
    //Forward to good page
    header('Location: /home.php');
  } else {
    $error = "Username or password is not correct. Please try again or contact the admin.";
  }
  }
 }
}

//echo $error;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
  
	 $(document).ready(function() {
        if ( '<?php echo $error?>'.length != 0 ) {
        	$('#login-alert').text('<?php echo $error?>');
        	$('#login-alert').show();
        } else {
        	$('#login-alert').hide();
        }
    });

  </script>
</head>
<body>

<?php //include("inc/top-nav.php");?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Login</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
                    </div>

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none;" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginform" class="form-horizontal" role="form" method="post">

                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
                                    </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                                    </div>

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls" style="text-align: right;">
                                      <a id="btn-login" href="#" class="btn btn-success" onClick="$('#loginform').submit()">Login</a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        </div>
    </div>

</body>
</html>
