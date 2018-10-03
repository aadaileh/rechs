//Search für Refrigerator
$(document).ready(function(){
  $("#search-appliance-button-frig").click(function(){

    $.ajax({
      url: "/inc/cgi/appliances-search.php",
      type: "POST",
      data: {
        flag: "frig",
        type: "kühlschrank",
        MaxPrice: 5000,
        MinPrice: 200,
        categoryId: 71262,
        label: "<?php echo $refrigerator->label; ?>" 
      },
      beforeSend: function() {
        $("#frig-search-results").html("");
        $('#loader-frig').show();
      },
      complete: function(){
        $('#loader-frig').hide();
        $("#search-response-true-3").hide();
        $("#search-response-false-3").hide();            
      },
      success: function(response) {
        //alert("response: " + response);
        console.log(response);
        //$("#search-response-true-3").append(response).fadeIn();

        var results = JSON.parse(response);

        //alert("results: " + results);

        $.each( results, function(key, value) {
            var title = value["title"];
            $("#frig-search-results").append(
              '<a href="'
              + value["viewItemURL"]
              + '" class="list-group-item list-group-item-action" target="_blank"><img src="'
              + value["galleryURL"]
              + '" height="80" width="80" style="padding:5px; border-radius:20%;"><span style="width:450px; display:inline-block;">'
              + title
              + '</span><span class="badge badge-warning badge-pill">'
              + value["sellingStatus"]["currentPrice"]
              + '€</span>'
              + '<span class="badge badge-warning badge-pill">'
              + value["eekStatus"]
              + '</span>'
              + '<span class="badge badge-warning badge-pill">ROI: '
              + value["roi"]
              + '</span>'
              + '<span class="badge badge-warning badge-pill" style="background-color:#ff7f00;">Saving: '
              + value["saving"]
              + ' %</span>'              
              + '</a>');

        });

        //$("#frig-search-results").html(response);
        //Do Something
        //location.reload();
      },
      error: function(xhr) {
        //Do Something to handle error
        //alert("error: " + xhr);
        $("#search-response-false-3").append(xhr).fadeIn();
      }
    });
  });
});


//Search for TV
$(document).ready(function(){
  $("#search-appliance-button-tv").click(function(){

    $.ajax({
      url: "/inc/cgi/appliances-search.php",
      type: "POST",
      data: {
        flag: "tv",
        type: "fernseher",
        MaxPrice: 2000,
        MinPrice: 200,
        categoryId: 11071,
        label: "<?php echo $tv->label; ?>" 
      },
      beforeSend: function() {
        $("#tv-search-results").html("");
        $('#loader-tv').show();
      },
      complete: function(){
        $('#loader-tv').hide();
        $("#search-response-true-2").hide();
        $("#search-response-false-2").hide();            
      },
      success: function(response) {
        //alert("response: " + response);
        console.log(response);
        //$("#search-response-true-3").append(response).fadeIn();

        var results = JSON.parse(response);

        //alert("results: " + results);

        $.each( results, function(key, value) {
            var title = value["title"];
            $("#tv-search-results").append(
              '<a href="'
              + value["viewItemURL"]
              + '" class="list-group-item list-group-item-action" target="_blank"><img src="'
              + value["galleryURL"]
              + '" height="80" width="80" style="padding:5px; border-radius:20%;"><span style="width:450px; display:inline-block;">'
              + title
              + '</span><span class="badge badge-warning badge-pill">'
              + value["sellingStatus"]["currentPrice"]
              + '€</span>'
              + '<span class="badge badge-warning badge-pill">'
              + value["eekStatus"]
              + '</span>'
              + '<span class="badge badge-warning badge-pill">ROI: '
              + value["roi"]
              + '</span>'
              + '<span class="badge badge-warning badge-pill" style="background-color:#ff7f00;">Saving: ' 
              + value["saving"] 
              + ' %</span>'
              + '</a>');

        });

        //$("#frig-search-results").html(response);
        //Do Something
        //location.reload();
      },
      error: function(xhr) {
        //Do Something to handle error
        //alert("error: " + xhr);
        $("#search-response-false-2").append(xhr).fadeIn();
      }
    });
  });
});

//Search for stand lamp 
$(document).ready(function(){
  $("#search-appliance-button-lamp").click(function(){

    $.ajax({
      url: "/inc/cgi/appliances-search.php",
      type: "POST",
      data: {
        flag: "lamp",
        type: "steh,stand,licht",
        MaxPrice: 500,
        MinPrice: 10,
        categoryId: 112581,
        categoryId_2: 174060,
        label: "<?php echo $lamp->label; ?>" 
      },
      beforeSend: function() {
        $("#lamp-search-results").html("");
        $('#loader-lamp').show();
      },
      complete: function(){
        $('#loader-lamp').hide();
        $("#search-response-true-1").hide();
        $("#search-response-false-1").hide();            
      },
      success: function(response) {
        //alert("response: " + response);
        console.log(response);
        //$("#search-response-true-3").append(response).fadeIn();

        var results = JSON.parse(response);

        //alert("results: " + results);

        $.each( results, function(key, value) {
            var title = value["title"];
            $("#lamp-search-results").append(
              '<a href="' 
              + value["viewItemURL"] 
              + '" class="list-group-item list-group-item-action" target="_blank"><img src="' 
              + value["galleryURL"] 
              + '" height="80" width="80" style="padding:5px; border-radius:20%;"><span style="width:450px; display:inline-block;">' 
              + title 
              + '</span><span class="badge badge-warning badge-pill">' 
              + value["sellingStatus"]["currentPrice"] 
              + '€</span>' 
              + '<span class="badge badge-warning badge-pill">' 
              + value["eekStatus"] 
              + '</span>' 
              + '<span class="badge badge-warning badge-pill">ROI: ' 
              + value["roi"] 
              + '</span>' 
              + '<span class="badge badge-warning badge-pill" style="background-color:#ff7f00;">Saving: ' 
              + value["saving"] 
              + ' %</span>'              
              + '</a>'
            );

        });

        //$("#frig-search-results").html(response);
        //Do Something
        //location.reload();
      },
      error: function(xhr) {
        //Do Something to handle error
        //alert("error: " + xhr);
        $("#search-response-false-1").append(xhr).fadeIn();
      }
    });
  });
}); 