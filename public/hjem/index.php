<?php
    if (!isset($_SESSION))
    {
	session_start();
    }
error_reporting(E_ALL);

require_once("../renderHelpers.php");
require_once("../../KalenderController.php");
renderHeaderWithTitle("ASPERØY");
$kalenderController = KalenderController::getInstance();
$eventsInOrder = $kalenderController->getAllFutureEventsSorted();
?>

<link rel="stylesheet" type="text/css" href="/styles/hjemStyle.css"/>
<link href='/js/fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
<link href='/js/fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script src="/js/skycons.js"></script>
<script src="/js/jQueryRotate.js"></script>
<script type="text/javascript" src="/js/hjem.js"></script>

<div class="col-xs-12 col-sm-7 side" id="side1">
    <h2>Siste nytt! <small>17.5.2016</small></h2>
    <div class="bildecontainer">
	<img width="90%" class="img-rounded" height="325px" src="/resources/bilder/Sommer 2013/a.jpg">
    </div>
    <p class="tekst">
	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
    </p>
</div>

<div class="col-xs-12 col-sm-5 side" id="side2">
    
    <div id='hjemkalender' class="col">
        <h2>Neste nytt!</h2>
        <table id="kalendertable">
            <?php
            $numberOfEvents = count($eventsInOrder);
            for ($i = 0; $i < ($numberOfEvents < 8 ? $numberOfEvents : 8); $i++) {
                $event = $eventsInOrder[$i];
                echo "<tr><td><h4><small>" . date("d.m", strtotime($event->start)) . "</small></h4></td><td><h4>" . $event->title . "</h4></td></tr>";
            }
            ?>
        </table>
    </div>
    
    <div id="weather" class="col">
	<span id="temp" style="height: 23px;"></span>
	<canvas id="weathericon" width="30" height="30"></canvas>
	<span id="vind"></span>
	<span><img src="/resources/images/pil2.png" width="30" id="pilen"></span>
	<span id="nedbor"></span>
	
    </div>
</div>

<?php
    renderFooter();
?>