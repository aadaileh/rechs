<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

//Already logged in?
if(isset($_SESSION) && count($_SESSION["user"]) == 0) {
  echo "user is set in the session";
  header('Location: /login.php');
}

$urlpath = explode("/", $_SERVER["SCRIPT_FILENAME"]);
$scriptName = end($urlpath);

switch ($scriptName) {
  case 'home.php':
    //echo "homeClass";
    $homeClass = 'active ';
    break;
 
   case 'appliances-overview.php':
   case 'appliances-charts.php':
   case 'appliances-status-panel.php':
   case 'appliances-schedular.php':
    //echo 'appliancesClass';
    $appliancesClass = 'active ';
    break;
  
    case 'node-management.php':
    //echo 'nodeManagementClass';
    $nodeManagementClass = 'active ';
    break;
  
    case 'user-management.php':
    //echo 'userManagementClass';
    $userManagementClass = 'active ';
    break;

    case 'energy-provider-management.php':
    //echo 'energyProviderManagementClass';
    $energyProviderManagementClass = 'active ';
    break;   
}

?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.html"><strong>RECHS</strong></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php echo $homeClass;?>"><a href="home.php">Home</a></li>
        <li class="<?php echo $appliancesClass;?>dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Appliances</a>
          <ul class="dropdown-menu">
            <li><a href="appliances-overview.php">Overview</a></li>
            <li><a href="appliances-charts.php">Charts</a></li>
            <li><a href="appliances-status-panel.php">Status Panel</a></li>
            <li><a href="appliances-schedular.php">Schedular</a></li>
          </ul>
        </li>
        <li class="<?php echo $nodeManagementClass;?>"><a href="node-management.php">Node Management</a></li>
        <li class="<?php echo $userManagementClass;?>"><a href="user-management.php">User Management</a></li>
        <li class="<?php echo $energyProviderManagementClass;?>"><a href="energy-provider-management.php">Energy Provider Management</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["user"]->fullName;?></a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <li><a href="accredits.php"><span class="glyphicon"></span> Accredits</a></li>
      </ul>
    </div>
  </div>
</nav>