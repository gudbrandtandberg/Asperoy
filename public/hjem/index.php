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
<script src="/js/skycons.js"></script>
<script src="/js/jQueryRotate.js"></script>
<script type="text/javascript" src="/js/hjem.js"></script>

<div class="col-xs-12 col-sm-7 side" id="side1">
    <h2>Velkommen til asperøy.no, <?=$_SESSION["brukernavn"];?>!</h2>
    <p>
	Endelig har vi fått oss en egen hjemmeside for beboerne på Asperøy!
	Her burde vi ha en god tekst hvor vi gir en liten opplæring/innføring i siden. Forklare hva aller fanene gjør osv.
	Og så under trenger vi et flott bilde av hele øya i all dens prakt.
	Etter første ukene begynner vi å ha enkle 'siste nytt' greier som man kan scrolle nedover news-feed style. 
    </p>
    <div class="bildecontainer">
	<img class="img-rounded" height="325px" src="/resources/bilder/Sommer 2013/a.jpg">
    </div>
</div>

<div class="col-xs-12 col-sm-5 side" id="side2">
    
    <h3>Kommende hendelser:</h3>
    <table id="kalendertable">
	<?php
	$numberOfEvents = count($eventsInOrder);
	for ($i = 0; $i < ($numberOfEvents < 8 ? $numberOfEvents : 8); $i++): ?>
	    <?php $event = $eventsInOrder[$i]; ?>
	    <tr>
		<td>
		    <h4>
			<small><?=date("d.m", strtotime($event->start));?></small>
		    </h4>
		</td>
		<td>
		    <h4>
			<?=$event->title;?> 
		    </h4>
		</td>
	    </tr>
	<?php endfor; ?>
    </table>
    
    <div id="weather">
	<h3>Været på Asperøya nå:</h3>
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