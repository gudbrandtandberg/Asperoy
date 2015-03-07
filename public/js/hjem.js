/*
 * hjem.js
 * her er all js'en til hjem/index.html, nemlig
 *  - innlasting og tegning av værdata - enten ajax eller sessionStorage
 *  - initialisering av minikalender på hjemmesiden
 */

$(document).ready(function() {
    
    var first = true;
    $("#weather").hide();

    var tegnVindPil = function(cmps){
        //peker til canvasområdet
        var c = document.getElementById("vindpil");
        var cxt = c.getContext("2d");
        
        //dimensjoner
        var w = 30;
        var r = w/2;
        var rmin = r-7;

        //kompassvinkel->grader
        var deg = 0;
        if (cmps <= 90) {
            deg = 90-cmps;
        }
        else {
            deg = 450-cmps;
        }
        var rads = deg*Math.PI/180;
        
        //en sirkel
        cxt.lineWidth = 1;
        cxt.beginPath();
        cxt.arc(r, r, rmin, 0, 2*Math.PI, false);
        
        //tegner en pil
        var cs = Math.cos(rads);
        var sn = Math.sin(rads);
        var startx = r*(1-cs);
        var starty = r*(1+sn);
        var endx = r*(1+cs);
        var endy = r*(1-sn);
        cxt.lineWidth = 2;
        cxt.moveTo(startx, starty);
        cxt.lineTo(endx, endy);
        
        //med to fnutter
        vinkel = Math.atan2(endy-starty,endx-startx); //ligger i riktig interval automatisk
        var h=5;
        vinkel1 = vinkel + Math.PI + Math.PI/4;
        var tupp1x = endx + Math.cos(vinkel1)*h;
        var tupp1y = endy + Math.sin(vinkel1)*h;
        
        vinkel2 = vinkel + Math.PI - Math.PI/4;
        var tupp2x = endx + Math.cos(vinkel2)*h;
        var tupp2y = endy + Math.sin(vinkel2)*h;
        
        cxt.lineTo(tupp1x, tupp1y);
        cxt.moveTo(endx, endy);
        cxt.lineTo(tupp2x , tupp2y);

        cxt.stroke();
    }
    
    //callback som fyller vær-ruten med responsdata
    var tegnVerdata = function(data){
        if (typeof(sessionStorage !== "undefined") && first) {
            sessionStorage.weatherLoaded = "true";
            sessionStorage.weather = data;
        }
        var response = $.parseJSON(data);
        
        //tegne vær-ikon
        var skycons = new Skycons({"color": "black"});
        skycons.add("weathericon", Skycons.PARTLY_CLOUDY_DAY);
        skycons.play();
        
        //resten av vær-data
        $("#temp").html(response.temp+"&deg;C");
        $("#vind").html("vind: "+response.windspeed+"m/s");
        $("#nedbor").html("nedbør: "+response.precipitation+"mm");
        tegnVindPil(parseInt(response.windspeed));
        
        //enten fancy intro eller bare dukk opp
        if (first) {
            $("#weather").show(600);
        }
        else {
            $("#weather").css({display: "block"});
        }
    }
    
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
                dataType: "text",
            });
        }
    }
    
    //initialiser minikalender
    $('#calendar').fullCalendar({
        height: 320,
        defaultDate: '2015-05-01',
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        unselectCancel: "#nyeventinfoformdiv",

        select: function(start, end, e, view) { // her må også hendelsen skrives til events.json filen.
            var xPos = e.pageX;
            var yPos = e.pageY;

            nyEvent = new EventForDisplay(null, start, end);

            toggleCreateEventDiv(true, xPos, yPos, nyEvent);
        },

        unselect: function(view, e) {
            toggleCreateEventDiv();
        },

        eventClick: function(event, e, view) {
            var xPos = e.pageX;
            var yPos = e.pageY;

            toggleCreateEventDiv(true, xPos, yPos, event);
        }
    });
});