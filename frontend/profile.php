<?php
ini_set('max_execution_time', 300); // 5minutes

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
$user = $library->makeCurl ("/users/" . $_SESSION["user"]->id, "GET");

  // echo "<pre>user:\n";
  // print_r($user);
  // echo "</pre>";

  // echo "<pre>session-user:\n";
  // print_r($_SESSION["user"]);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile: <?=$_SESSION["user"]->fullName;?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="inc/js/jquery.min.js"></script>
  <script src="inc/js/bootstrap.min.js"></script>

  <script src="/Chart.js-master/samples/utils.js"></script>

  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>


  <script>

    $(document).ready(function(){

      //turn to inline mode
      $.fn.editable.defaults.mode = 'inline';

      //Fullname
      $('#fullName').editable({
          validate: function(value) {
            if($.trim(value) == '') return 'This value is required.';
          },
          type: 'text',
          url: '/inc/cgi/profile-save.php',
          pk: 1,
          title: 'Enter Full name',
          params: function(params) {
              var data = {};
              data['purchaseOrderId'] = params.pk;
              data['name'] = params.name;
              data['value'] = params.value;
              data['id'] = <?=$user->id;?>;
              return data;
          },
          success: function(response, newValue) {
            if(response.status == 'error') return response.msg;
          }
      });


      //email
      $('#email').editable({
          validate: function(value) {
              if($.trim(value) == '') return 'This value is required.';
          },
          type: 'text',
          url: '/inc/cgi/profile-save.php',
          pk: 1,
          title: 'Enter Email',
          params: function(params) {
              var data = {};
              data['purchaseOrderId'] = params.pk;
              data['name'] = params.name;
              data['value'] = params.value;
              data['id'] = <?=$user->id;?>;
              return data;
          },
          success: function(response, newValue) {
            if(response.status == 'error') return response.msg;
          }
      });



      // username
      $('#username').editable({
          validate: function(value) {
              if($.trim(value) == '') return 'This value is required.';
          },
          type: 'text',
          url: '/inc/cgi/profile-save.php',
          pk: 1,
          title: 'Enter Email',
          params: function(params) {
              var data = {};
              data['purchaseOrderId'] = params.pk;
              data['name'] = params.name;
              data['value'] = params.value;
              data['id'] = <?=$user->id;?>;
              return data;
          },
          success: function(response, newValue) {
            if(response.status == 'error') return response.msg;
          }
      });

      // password
      $('#password').editable({
          validate: function(value) {
              if($.trim(value) == '') return 'This value is required.';
          },
          type: 'text',
          url: '/inc/cgi/profile-save.php',
          pk: 1,
          title: 'Enter Email',
          params: function(params) {
              var data = {};
              data['purchaseOrderId'] = params.pk;
              data['name'] = params.name;
              data['value'] = params.value;
              data['id'] = <?=$user->id;?>;
              return data;
          },
          success: function(response, newValue) {
            if(response.status == 'error') return response.msg;
          }
      });     

    });

  </script>

</head>
<body>
  <center>

<?php include("inc/cgi/top-nav.php");?>

<div style="width: 50%; padding: 0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h4 style="font-weight: bold;">Profile: <?=$_SESSION["user"]->fullName;?></h4>
    </div>
  </div>
</div>

<div style="width: 50%; padding:0px 15px 0px 7px; ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <strong>Profile Details</strong>
    </div>

      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row"><label for="">Full Name:</label></th>
            <td>
              <a href="#" id="fullName" data-type="text" data-pk="1" data-title="Enter the full name."><?=$user->fullName;?></a>
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="email">Email</label>
            </th>
            <td>
              <a href="#" id="email" data-type="email" data-pk="2" data-title="Enter email address."><?=$user->email;?></a>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="contract_end">Username</label></th>
            <td>
              <a href="#" id="username" data-type="text" data-pk="3" data-title="Enter a username"><?=$user->username;?></a>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="password">Password</label></th>
            <td>
              <a href="#" id="password" data-type="password" data-pk="4" data-title="Enter Password"></a>
            </td>
          </tr>
          </tr>
        </tbody>
      </table>

  </div>
</div>

</center>
</body>
</html>
