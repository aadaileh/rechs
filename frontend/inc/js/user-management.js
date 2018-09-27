//Tooltip
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

//Remove all messages when modal button clicked
$(window).on('hide.bs.modal', function (e) {
  $("#save-response-true").hide();
  $("#save-response-false").hide();

  $("#frig-modal-btn").click(function(){
    var clickedButtonValue = document.getElementById("frig-modal-btn").value;
  })
});


//Actions when hide modal
$(window).on('hide.bs.modal', function (e) {
  $("#save-response-true").hide();
  $("#save-response-false").hide();
});

var id = null;

//Actions when show modal
$(window).on('show.bs.modal', function (e) {
  var $activeElement = $(document.activeElement);
  if ($activeElement.is('[data-toggle], [data-dismiss]')) {
    initial_id = document.activeElement.id;
    //alert("initial_id: " + initial_id);
    var idArray = initial_id.split("-");
    id = idArray[idArray.length - 1];
    //alert("id: " + id);
  }

});

//Handle editing users
$(document).ready(function(){
  $("#manage-btn").click(function(){
    //alert("manage button is clicked");
    //$(".list-group-item.frig").css('padding-left', '4px');
    $(".material-switch.pull-left.frig-edit-minus-icon").fadeToggle();
  });
});

//Submit form
$(document).ready(function(){
  $("#save-changes-btn").click(function(){
    $.post("/inc/cgi/user-save.php",
    {
      id: id,
      createdBy: document.getElementById("createdBy").value,
      fullName: document.getElementById("fullname").value,
      email: document.getElementById("email").value,
      username: document.getElementById("username").value,
      password: document.getElementById("password").value,
      type: document.getElementById("type").value,
      active: true
    },
    function(data, status){
    //alert("Data: " + data + "\nStatus: " + status);
    if (data == "true") {
      $("#save-response-true").show();
      $("#save-response-false").hide();
      location.reload();
      window.setTimeout(hide_popup, 1000);
    } else {
      $("#save-response-false").html(data);
      $("#save-response-false").show();
      $("#save-response-true").hide();
    }

    });
  });
});

function hide_popup(){
  $("#addNewUserModal").modal('hide');
};

$(document).on("click", ".alert-confirm", function(e) {
  bootbox.confirm({
      title: "Confirm delete",
      message: "<strong>Do you really want to delete this entry?</strong>",
      buttons: {
          confirm: {
              label: 'Yes',
              className: 'btn-success'
          },
          cancel: {
              label: 'No',
              className: 'btn-danger'
          }
      },
      callback: function (result) {
        //alert(result);
        if(result == true) {
          success(id);
        }
      }
  });
});


function success(user_id) {
  //alert("user_id: " + user_id);
  user_id_final = user_id.replace("user-delete-link-", "");
  //alert("user_id(final): " + user_id_final);

  $.ajax({
    url: "/inc/cgi/user-save.php",
    type: "GET",
    data: {
      id: user_id_final,
      action: 'delete'
    },
    success: function(response) {
      //alert("response: " + response);
      //Do Something
      location.reload();
    },
    error: function(xhr) {
      //Do Something to handle error
      //alert("error: " + xhr);
    }
  });
  }
