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

  //reset all checkboxes and datepickers
  $('#datetimepicker1').data("DateTimePicker").clear();
  $('#datetimepicker2').data("DateTimePicker").clear();
  $("#switchOptionEveryDay").prop('checked', false);
  $("#switchOptionEveryMonday").prop('checked', false);
  $("#switchOptionEveryTuesday").prop('checked', false);
  $("#switchOptionEveryWednesday").prop('checked', false);
  $("#switchOptionEveryThursday").prop('checked', false);
  $("#switchOptionEveryFriday").prop('checked', false);
  $("#switchOptionEverySaturday").prop('checked', false);
  $("#switchOptionEverySunday").prop('checked', false);
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

//Handle editing nodes
$(document).ready(function(){
  $("#frig-edit-modal-btn").click(function(){
    //alert("frig edit button is clicked");
    //$(".list-group-item.frig").css('padding-left', '4px');
    $(".material-switch.pull-left.frig-edit-minus-icon").fadeToggle();
  });

  $("#tv-edit-modal-btn").click(function(){
    //alert("frig edit button is clicked");
    //$(".list-group-item.frig").css('padding-left', '4px');
    $(".material-switch.pull-left.tv-edit-minus-icon").fadeToggle();
  });

  $("#lamp-edit-modal-btn").click(function(){
    //alert("frig edit button is clicked");
    //$(".list-group-item.frig").css('padding-left', '4px');
    $(".material-switch.pull-left.lamp-edit-minus-icon").fadeToggle();
  });
});

//Submit form
$(document).ready(function(){
  $("#save-changes-btn").click(function(){
    $.post("/inc/cgi/node-save.php",
    {
      id: id,
      createdBy: document.getElementById("createdBy").value,
      type: document.getElementById("appliance_type").value,
      label: document.getElementById("appliance_label").value,
      annualEnergyConsumption: document.getElementById("appliance_energy_consumption_kwh").value,
      hourlyEnergyConsumption: document.getElementById("appliance_energy_consumption_watts").value,
      energyEfficientClass: document.getElementById("energy_efficient_class").value,
      size: document.getElementById("size").value,
      sizeUnit: document.getElementById("size_unit").value
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
  $("#addNewNodeModal").modal('hide');
};

//Set all checked when "every day" is checked
$(document).ready(function(){
  $("#switchOptionEveryDay").click(function(){
    if ($('#switchOptionEveryDay').is(':checked')) {
      $("#switchOptionEveryMonday").prop('checked', true);
      $("#switchOptionEveryTuesday").prop('checked', true);
      $("#switchOptionEveryWednesday").prop('checked', true);
      $("#switchOptionEveryThursday").prop('checked', true);
      $("#switchOptionEveryFriday").prop('checked', true);
      $("#switchOptionEverySaturday").prop('checked', true);
      $("#switchOptionEverySunday").prop('checked', true);
    } else {
      $("#switchOptionEveryMonday").prop('checked', false);
      $("#switchOptionEveryTuesday").prop('checked', false);
      $("#switchOptionEveryWednesday").prop('checked', false);
      $("#switchOptionEveryThursday").prop('checked', false);
      $("#switchOptionEveryFriday").prop('checked', false);
      $("#switchOptionEverySaturday").prop('checked', false);
      $("#switchOptionEverySunday").prop('checked', false);
    }
  });
});

//DateTime Picker
$(function () {
  $('#datetimepicker1').datetimepicker({
    format : 'MM/DD/YYYY HH:mm'
  });
  $('#datetimepicker2').datetimepicker({
    useCurrent: false, //Important! See issue #1075
    format : 'MM/DD/YYYY HH:mm'
  });
  $("#datetimepicker1").on("dp.change", function (e) {
    $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
  });
  $("#datetimepicker2").on("dp.change", function (e) {
    $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
    $('#datetimepicker1').data("DateTimePicker").locale("DE_de");
  });
});

<!-- bootbox code -->
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


function success(node_id) {
  //alert("node_id: " + node_id);
  node_id_final = node_id.replace("frig-edit-link-", "");
  //alert("node_id(final): " + node_id_final);

  $.ajax({
    url: "/inc/cgi/appliances-schedular-save.php",
    type: "GET",
    data: {
      id: node_id_final,
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
