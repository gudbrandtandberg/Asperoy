<?php
    if (!isset($_SESSION))
    {
	session_start();
    }
error_reporting(E_ALL);

require_once("../renderHelpers.php");
renderHeaderWithTitle("ASPERØY");
?>

<link href='/js/fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
<link href='/js/fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<!--<link href='/styles/kalenderStyle.css' rel="stylesheet"/>-->
<script src='/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script type="text/javascript">
    $(document).ready(function() {

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
    
</script>

<div class="col-xs-12 col-md-7 side" id="side1">
    <h2>Siste nytt! <small>17.5.2016</small></h2>
    <img width="90%" height="325px" src="/resources/bilder/Sommer 2013/a.jpg">
    <p class="">
	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
    </p>
</div>

<div class="col-xs-12 col-md-5 side" id="side2">
    <div id='calendar'></div>
    
    <div id="weather" class="col">
	<span id="temp" style="height: 23px;"></span>
	<span><canvas id="weathericon" width="23" height="23"></canvas></span>
	<span id="vind"></span>
	<span id="nedbor"></span>
	
    </div>
</div>


<?php
    renderFooter();
?>