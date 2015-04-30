/*
 * hjem.js
 * her er all js'en til hjem/index.html, nemlig
 *  - innlasting og tegning av værdata - enten ajax eller sessionStorage
 *  - initialisering av minikalender på hjemmesiden
 */

$(document).ready(function() {
    
    var first = true;
    $("#weather").hide();

    var roterPilBilde = function(grader){
        $("#pilen").rotate(grader-90);
    };
    
    //callback som fyller vær-ruten med responsdata
    var tegnVerdata = function(data){
        if (typeof(sessionStorage !== "undefined") && first) {
            sessionStorage.weatherLoaded = "true";
            sessionStorage.weather = data;  
        }
        var response = $.parseJSON(data);
        
        //tegne vær-ikon
        var skycons = new Skycons({"color": "black"});
        skycons.add("weathericon", Skycons[response.weathertype]);
        skycons.play();
        
        //resten av vær-data
        $("#temp").html(response.temp + "&deg;C");
        $("#vind").html("vind: " + response.windspeed+"m/s");
        $("#nedbor").html("nedbør: " + response.precipitation+"mm");
        roterPilBilde(response.winddir);
        
        //enten fancy intro eller bare dukk opp
        if (first) {
            $("#weather").show(600);
        }
        else {
            $("#weather").css({display: "block"});
        }
    };
    
    //last ned værdata fra yr
    if (typeof(sessionStorage !== "undefined")) {
        if (sessionStorage.weatherLoaded) {
            first = false;
            var data = sessionStorage.weather;		
            tegnVerdata(data);
        }
        else{
            $.ajax({url: "/api/hentVerdata.php",
                type: "POST",
                success: tegnVerdata,
                dataType: "text"
            });
        }
    }
});
