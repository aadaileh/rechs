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
  $users = $library->makeCurl ("/users/", "GET");

  // echo "<pre>users:\n";
  // print_r($users);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <script type="text/javascript" src="inc/js/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="inc/js/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="inc/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="inc/css/checkboxes-style.css" />
  <script type="text/javascript" src="inc/js/user-management.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

<?php
  foreach ($users as $key => $value) {
?>
    $('#user-list-<?=$value->id;?>').on('change', function(){
      id = document.getElementById("user-list-<?=$value->id;?>").value;      
      if ($('#user-list-<?=$value->id;?>').is(':checked')) {
        $.get("/inc/cgi/user-save.php?action=activate&id=" + <?=$value->id;?>, function(data, status){
          $("#li-id-<?=$value->id;?>").css("color", "#080808"); //change the text color to gray
        });

      } else {       
        $.get("/inc/cgi/user-save.php?action=deactivate&id=" + <?=$value->id;?>, function(data, status){
          $("#li-id-<?=$value->id;?>").css("color", "#9d9d9d"); //change the text color to black
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

<div style="width: 70%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Users Management</h4>
      Admins can add, update, activate, deactivate and delete householders using this users management section.
    </div>
  </div>
</div>


<div style="width: 70%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong><a href="#" data-toggle="tooltip" title="List of all available users (admins and householders)" style="color:white;">Users List</a></strong>
    </div>
    <div class="panel-body">

      <!-- Button trigger modal -->
      <button data-button="3" value="frig-button-value" id="frig-modal-btn-3" type="button"
      class="btn btn-primary" data-toggle="modal" data-target="#addNewNodeModal" style="float: right;">
      <span style="font-weight: bold; font-size: 12pt;">+</span></button>

      <!-- Button trigger edit -->
      <button data-button="3" value="manage-button-value" id="manage-btn" type="button"
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
                    foreach ($users as $key => $value) {
                      $id = $value->id;
                      $fullName = $value->fullName;
                      $email = $value->email; 
                      $createdTimestamp = $value->createdTimestamp;
                      $updatedTimestamp = $value->updatedTimestamp;
                      $createdBy = $value->createdBy;
                      $username = $value->username;
                      $type = $value->type;
                      $color = $value->active == true ? "#080808" : "#9d9d9d";
                      $checked = $value->active == true ? "checked" : "";
                  ?>
                      <li class="list-group-item frig">
                        <div class="material-switch pull-left frig-edit-minus-icon" style="display: none; padding:5px 5px 55px 0px;vertical-align:middle;">
                            <a href="#" title="Click to delete" data-dismiss="modal" data-button="<?=$value->id;?>" id="user-delete-link-<?=$value->id;?>"
                              data-href="/inc/cgi/user-save.php?action=delete&id=<?=$value->id;?>" data-toggle="modal" data-target="#confirm-delete" class="alert-confirm" <?=$type=="admin"?" style='display:none;'":"";?>>
                              <img src="inc/img/delete.svg" height="20px" width="20px" <?=$type=="admin"?" style='display:none;'":"";?>>
                            </a> 
                            <a href="#" title="Click to edit" data-dismiss="modal" data-button="<?=$value->id;?>" id="user-edit-link-<?=$value->id;?>"
                              data-href="/inc/cgi/user-save.php?action=edit&id=<?=$value->id;?>" data-toggle="modal" data-target="#confirm-edit" class="alert-confirm" <?=$type=="admin"?" style='display:none;'":"";?>>
                              <img src="inc/img/edit.svg" height="20px" width="20px" <?=$type=="admin"?" style='display:none;'":"";?>>
                            </a> 
                        </div>
                          <span id="li-id-<?=$value->id;?>" style="
                          font-weight: 500;
                          font-family: inherit;
                          font-size: 16pt;
                          color: <?=$color;?>;
                          font-stretch: ultra-condensed;
                          "> <?=$fullName;?>
                          <br>
                          <span style="font-size: 9pt;">
                          <?php
                            $date = new DateTime($value->createdTimestamp);
                            echo "Created in: " . $date->format('Y-m-d H:i:s');
                          ?>
                          </span>
                          <br>
                          <span style="font-size: 9pt;">
                          <?="Created by: " . $createdBy;?>
                          </span>                          
                          </span>

                          <div class="material-switch pull-right">
                              <input data-toggle="<?=$value->id;?>" data-button="<?=$value->id;?>" id="user-list-<?=$value->id;?>" name="user-list-<?=$value->id;?>" value="<?=$value->id;?>" type="checkbox" <?=$checked;?> <?=$type=="admin"?" disabled":"";?> />
                              <label for="user-list-<?=$value->id;?>" class="label-success"></label>
                          </div>
                      </li>

                  <?php
                    }
                 ?>

                  </ul>
              </div>
          </div>
      </div>

      <!-- Modal Create new user-->      
      <div class="container">
        <div class="modal fade" id="addNewNodeModal" tabindex="-1" role="dialog" aria-labelledby="addNewNodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="addNewNodeModalLabel" style="font-weight: bold; float: left;">Add new user</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="alert alert-success" role="alert" id="save-response-true" style="display: none;">User saved correctly.</div>
              <div class="alert alert-danger" role="alert" id="save-response-false" style="display: none;">x</div>

              <form action="#" method="post" id="add-new-node-form" name="add-new-node-form ">
                <input type="hidden" name="createdBy" id="createdBy" value="Ahmed Adaileh">
                <input type="hidden" name="type" id="type" value="user">

                <!-- Full name -->
                <div class="form-group">
                  <label for="fullname">Full Name*</label>
                  <input type="text" class="form-control" id="fullname" aria-describedby="fullname_help" placeholder="Enter user's full name" style="width: 400px;">
                  <small id="fullname_help" class="form-text text-muted">The user's full name can be entered here. Ex: Ahmed Al-Adaileh</small>
                </div>

                <!-- Email -->
                <div class="form-group">
                  <label for="email">Email*</label>
                  <input type="email" class="form-control" id="email" aria-describedby="email_help" placeholder="Enter the email" style="width: 400px;">
                  <small id="email_help" class="form-text text-muted">User must have a valid email example@domain.com</small>
                </div>

                <!-- Username -->
                <div class="form-group">
                  <label for="username">Username*</label>
                  <input type="text" class="form-control" id="username" aria-describedby="username_help" placeholder="Enter the username" style="width: 400px;">
                  <small id="username_help" class="form-text text-muted">This will be used for login.</small>
                </div>

                <!-- Password -->
                <div class="form-group">
                  <label for="password">Password*</label>
                  <input type="password" class="form-control" id="password" aria-describedby="password_help" placeholder="Enter the password" style="width: 400px;">
                  <small id="password_help" class="form-text text-muted">This will be used for login.</small>
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
      </div>
      <!-- Modal End -->

    </div>
  </div>
</div>


</body>
</html>
