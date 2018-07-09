<?php5
	
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
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">RECHS</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Appliances</a>
          <ul class="dropdown-menu">
            <li><a href="#">Charts</a></li>
            <li><a href="#">Status Panel</a></li>
            <li><a href="#">Schedular</a></li>
          </ul>
        </li>
        <li><a href="#">Node Management</a></li>
        <li><a href="#">User Management</a></li>
        <li><a href="#">Energy Provider Management</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!--
<div class="container">
  <h2>Welcome to <b>RECHS</b> Application</h2><br>
  <p>Project RECHS stands for <b>R</b>eduction of <b>E</b>lectricity <b>C</b>onsumption in <b>H</b>ousehold <b>S</b>ector.</p><br>
  <p>
    It is not a secret that our planet's resources are facing critical challenges and suffering from unfair use. Consequences of depletion of natural resources did start appearing in a way that affects every single soul on this planet. Energy is a key factor in this aspect, because a major part of the damage is caused by using the resources to generate energy in all shapes. All efforts must be concentrated in two main branches: generating energy from clean and renewable resources and reduce the energy consumption. The focus of this project will be on how to reduce the electricity consumption in household's sector.<br><br>
    This document is an attempt to provide a clear understanding of the Project RECHS and how it should assist householders to reduce their electricity consumption and ultimately their energy expenses by replacing their appliances and switching their local energy provider. The focus is drawn on describing these aims and the techniques suggested to achieve them. Technically, the system is based on using Z-Wave compatible plug-ins which will be attached to the household appliances to measure and control them remotely and semi-automatically.
    Risk management plan and project plan are part of this document to provide a clear and transparent view for all stakeholders about the nature and the progress of the project. This should assist project team to achieve high stakeholder engagement and participating.
  </p>
</div>
-->



















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

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form id="loginform" class="form-horizontal" role="form">

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
                                      <a id="btn-login" href="#" class="btn btn-success">Login</a>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        </div>
    </div>

</body>
</html>
