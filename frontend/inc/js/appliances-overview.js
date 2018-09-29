$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); 
});   


$(document).ready(function(){
    $("#stand-by-button-frig").add("#stand-by-duration-button-frig").click(function(){

      if (document.getElementById("stand-by-button-frig").checked) {
        $("#stand-by-duration-frig").fadeIn(700);
        $standbyDurationSpan = document.getElementById("standby_duration_frig").value;
      } else {
        $("#stand-by-duration-frig").fadeOut(700);
        $standbyDurationSpan = document.getElementById("standby_duration_frig").value = 0;
      }
        //alert("call save.php");
        $.post("/inc/cgi/appliances-save.php",
          {
            flag: "standby",
            id: document.getElementById("stand-by-button-frig").value,
            standbyDurationSpan: $standbyDurationSpan,
            standByStatus: document.getElementById("stand-by-button-frig").checked
          },
        function(data, status){
          //alert("Data(frig): " + data + "\nStatus: " + status);
          //$("#stand-by-button-frig-response").text(data);
          $("#alert-success-frig").fadeIn();
          setTimeout(function() {$("#alert-success-frig").fadeOut('blind');}, 2000);
        });
    });

    $("#stand-by-button-tv").add("#stand-by-duration-button-tv").click(function(){
        if (document.getElementById("stand-by-button-tv").checked) {
          $("#stand-by-duration-tv").fadeIn(700);
          $standbyDurationSpan = document.getElementById("standby_duration_tv").value;
        } else {
          $("#stand-by-duration-tv").fadeOut(700);
          $standbyDurationSpan = document.getElementById("standby_duration_tv").value = 0;
        }
        $.post("/inc/cgi/appliances-save.php",
          {
            flag: "standby",
            id: document.getElementById("stand-by-button-tv").value,
            standbyDurationSpan: $standbyDurationSpan,
            standByStatus: document.getElementById("stand-by-button-tv").checked
          },
        function(data, status){
          //alert("Data(tv): " + data + "\nStatus: " + status);
          //$("#stand-by-button-tv-response").text(data);
          $("#alert-success-tv").fadeIn();
          setTimeout(function() {$("#alert-success-tv").fadeOut('blind');}, 2000);
        });
    });

    $("#stand-by-button-lamp").add("#stand-by-duration-button-lamp").click(function(){
        if (document.getElementById("stand-by-button-lamp").checked) {
          $("#stand-by-duration-lamp").fadeIn(700);
          $standbyDurationSpan = document.getElementById("standby_duration_lamp").value;
        } else {
          $("#stand-by-duration-lamp").fadeOut(700);
          $standbyDurationSpan = document.getElementById("standby_duration_lamp").value = 0;
        }
        $.post("/inc/cgi/appliances-save.php",
          {
            flag: "standby",
            id: document.getElementById("stand-by-button-lamp").value,
            standbyDurationSpan: $standbyDurationSpan,
            standByStatus: document.getElementById("stand-by-button-lamp").checked
          },
        function(data, status){
          //alert("Data(lamp): " + data + "\nStatus: " + status);
          //$("#stand-by-button-lamp-response").text(data);
          $("#alert-success-lamp").fadeIn();
          setTimeout(function() {$("#alert-success-lamp").fadeOut('blind');}, 2000);
        });
    });
});

//<!-- bootbox code -->
$(document).on("click", ".alert-confirm", function(e) {

  //var $activeElement = $(document.activeElement);
  var initial_id = this.id;
  var idArray = initial_id.split("-");
  var id = idArray[idArray.length - 1];

  var checked = this.checked;
  var action = "";
  if(checked == true) {
    action = "turnon";
  } else {
    action = "turnoff";
  }

  //alert("action: " + action);

  bootbox.confirm({
      title: "Confirm Switch Appliance ON/OFF",
      message: "<strong>Do you really want to switch this appliance ON/OFF?</strong>",
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
        switchAppliance(action, id);
      }
  });
});

function switchAppliance(action, appliance_id) {
  //alert("action: " + action + ", " + "appliance_id: " + appliance_id);

  $.ajax({
    url: "/inc/cgi/appliances-save.php",
    type: "GET",
    data: {
      id: appliance_id,
      action: action
    },
    success: function(response) {
      //alert("response: " + response);
      //Do Something
      //location.reload();
    },
    error: function(xhr) {
      //Do Something to handle error
      alert("error: " + xhr);
    }
  });
  }

//Do something when opening a Modal
$(document).ready(function(){

  $('#editFrigModal').on('hidden.bs.modal', function(e) {
    $(this).find('#edit-frig-form')[0].reset();
    $('#save-response-true-1').hide();
    $('#save-response-false-1').hide();

    $('#save-response-true-2').hide();
    $('#save-response-false-2').hide();

    $('#save-response-true-3').hide();
    $('#save-response-false-3').hide();        
  });

}); 

//<!-- Update Applinace's Date -->
$(document).ready(function(){
  $("#edit-appliance-save-1, #edit-appliance-save-2, #edit-appliance-save-3").click(function(){

    //alert("this.name:" + this.name);

    var form_name = "";
    if(this.name == "1") {form_name = "edit-lamp-form";} 
    else if (this.name == "2") {form_name = "edit-tv-form";} 
    else if (this.name == "3") {form_name = "edit-frig-form";}

    $.post("/inc/cgi/appliances-save.php",
    {
      id: this.name,
      createdBy: document.getElementById("createdBy").value,
      label: document.getElementById(form_name).elements.namedItem("appliance_label").value,
      annualEnergyConsumption: document.getElementById(form_name).elements.namedItem("appliance_energy_consumption_kwh").value,
      hourlyEnergyConsumption: document.getElementById(form_name).elements.namedItem("appliance_energy_consumption_watts").value,
      energyEfficientClass: document.getElementById(form_name).elements.namedItem("energy_efficient_class").value,
      size: document.getElementById(form_name).elements.namedItem("size").value,
      externalLink: document.getElementById(form_name).elements.namedItem("external_link").value
    },
    function(data, status){
      //alert("Data: " + data + "\nStatus: " + status);
      if (data == "true") {
        $("#save-response-true-1").show();
        $("#save-response-false-1").hide();

        $("#save-response-true-2").show();
        $("#save-response-false-2").hide();
        
        $("#save-response-true-3").show();
        $("#save-response-false-3").hide();
        window.setTimeout(hide_popup, 9000);
        setTimeout(function(){location.reload();}, 2000);
        
      } else {
        $("#save-response-false-1").html(data);
        $("#save-response-false-1").show();
        $("#save-response-true-1").hide();

        $("#save-response-false-2").html(data);
        $("#save-response-false-2").show();
        $("#save-response-true-2").hide();

        $("#save-response-false-3").html(data);
        $("#save-response-false-3").show();
        $("#save-response-true-3").hide();
      }
    });
  
  });
});

function hide_popup(){
   $("#editFrigModal").modal('hide');
};