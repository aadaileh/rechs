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
    id = $(e.relatedTarget).data('button');
  }
});

//Handle editing schedules
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
    $.post("/inc/cgi/appliances-schedular-save.php",
    {
      id: id,
      createdBy: document.getElementById("createdBy").value,
      begin: document.getElementById("date-time-picker-field1").value,
      end: document.getElementById("date-time-picker-field2").value,
      switchOptionEveryDay: document.getElementById("switchOptionEveryDay").checked,
      switchOptionEveryMonday: document.getElementById("switchOptionEveryMonday").checked,
      switchOptionEveryTuesday: document.getElementById("switchOptionEveryTuesday").checked,
      switchOptionEveryWednesday: document.getElementById("switchOptionEveryWednesday").checked,
      switchOptionEveryThursday: document.getElementById("switchOptionEveryThursday").checked,
      switchOptionEveryFriday: document.getElementById("switchOptionEveryFriday").checked,
      switchOptionEverySaturday: document.getElementById("switchOptionEverySaturday").checked,
      switchOptionEverySunday: document.getElementById("switchOptionEverySunday").checked
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
  $("#addNewSchedularModal").modal('hide');
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
