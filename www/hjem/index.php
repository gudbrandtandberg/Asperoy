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
$eventsInOrder = $kalenderController->getAllEventsSorted(true);
?>

<link rel="stylesheet" type="text/css" href="/styles/hjemStyle.css"/>
<script src="/js/skycons.js"></script>
<script src="/js/jQueryRotate.js"></script>
<script type="text/javascript" src="/js/hjem.js"></script>

<div class="col-xs-12 col-sm-7 side" id="side1">
    <h2>Velkommen til asperøy.no, <?=$_SESSION["brukernavn"];?>!</h2>
    
    <p style="margin-top: 15px; font-size: larger;">
	Veldig snart vil dette feltet brukes til beskjeder, nyheter og leserinnlegg.
	Så snart eksamene våre er ferdige vil det være mulig for dere brukerne å skrive egne innlegg her også.
    </p>
    
    <!--
    Et newsitem (brukergenerert) har:
	-tittel
	-dato
	-tekst
	-bilde
	-caption    
    -->
    
    <div id="newsfeed">
	<div class="newsitem">
	    <h3><img src="<?= file_get_contents('../resources/images/users/'.$_SESSION['brukernavn']);?>" width="40px" height="40px"/> Forsommersoppdatering fra Øya <small>25.5.2015</small></h3>
	    <p>
		Synnøve, Alexandra, Nellie, Gudbrand og Per har vært her på øya i fem dager nå. Vi har kost oss og jobbet og kost oss og jobbet. Været har vært deilig og vi gleder oss til nok en veldig fin sommer.
	    </p>
	    <p>
		Om Vaktmesterboligen
	    </p>
	    <p>
		Om grønnsakshagen
	    </p>
	</div>
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
    
    <div class="col-sm-12" id="soppelpoll">
	<div class="row">
	    <div class="col-sm-8 sporsmal">
		Har DU plukket en sekk søppel fra Sydsiden/Søppelbukta?
	    </div>
	    <div class="col-sm-4 soppelknapp">
		<button class="btn btn-success">Ja, det har jeg!</button>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12 soppelbilder">
		<?php
		    $harPlukket = json_decode(file_get_contents("../../model/soppelpoll.json"));
		    foreach ($harPlukket as $user):
		?>
		    <img class="soppelbilde" src="<?=file_get_contents('../resources/images/users/'.$user);?>" width="55px"/>
		    <!--<span>G.T.</span> initialer?-->
		<?php endforeach; ?>
	    </div>
	</div>
    </div>
    
</div>

<?php
    renderFooter();
?>
