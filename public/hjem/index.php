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
<script src='/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script src="/js/skycons.js"></script>
<script src="/js/jQueryRotate.js"></script>
<script type="text/javascript" src="/js/hjem.js"></script>

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
	<canvas id="weathericon" width="30" height="30"></canvas>
	<span id="vind"></span>
	<!--<canvas id="vindpil" width="30" height="30"></canvas>-->
	<span><img src="/resources/images/pil2.png" width="30" id="pilen"></span>
	<span id="nedbor"></span>
	
    </div>
</div>

<?php
    renderFooter();
?>