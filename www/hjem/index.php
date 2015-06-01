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
<script type="text/javascript" src="/js/hjem.js"></script>

<div class="col-xs-12 col-sm-7 side" id="side1">
    <h2>
	Velkommen til asperøy.no, <?=$_SESSION["brukernavn"];?>!
	<button id="innleggknapp" title="Skriv et leserinnlegg" class="btn btn-info" data-toggle="modal" data-target="#createnewsmodal">
	    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
	</button>
    </h2>
    
    <div id="createnewsmodal" class="modal fade" role="dialog">
	<div class="modal-dialog">
      
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <input id="createnewstittel" type="text" placeholder="Tittel" name="newstittel">
	    </div>
	    
	    <div class="modal-body">
		<div id="tacontainer">
		    <textarea id="createnewstextarea" rows="3" placeholder="Skriv et leserinnlegg" name="newstekst"></textarea>
		</div>
	    </div>
	    
	    <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
		<div style="height:0px; overflow:hidden; display: none;">
		    <input type="file" name="bilde" id="bildefil"/>
		</div>
		<button class="btn btn-default" id="leggtilbilde">Legg ved bilde</button>
		<button class="btn btn-success" id="lastoppnews">Last opp</button>
	    </div>
	  </div>
      
	</div>
      </div>
    
    <div id="newsfeed">
	<div class="newsitem">
	    <div class="newsheader col-sm-12">
		<div class="col-sm-1" style="margin-left: 0; padding-left: 0; padding-right: 0; margin-right: 0;">
		    <img src="<?= file_get_contents('../resources/images/users/Gudbrand');?>"/>
		</div>
		<div class="col-sm-11 newstitle">
		    <h3>
			Forsommersoppdatering fra Øya
		    </h3>
		    <span class="newsdate">25.5.2015</span>
		</div>
	    </div>
	    
	    <p>
		Synnøve, Alexandra, Nellie, Gudbrand og Per har vært her på øya i fem dager nå. Vi har kost oss og jobbet og kost oss og jobbet. Været har vært deilig og vi gleder oss til nok en god sommer.
	    </p>
	    <p>
		Ombyggingen av vaktmesterboligen er i full sving, og det kommer til å bli kjempefint! Veldig gøy å se de store endringene som skjer. Jeg har lagt inn noen nye bilder i albumet <a href="/bilder/Vaktmesterboligen2015">Vaktmesterboligen 2015</a>.
	    </p>
	    <p>
		Gudbrand har gjort en del forarbeid til "Asperøy Frukt- & Grønnsakshage", området er ryddet og alt er klart til å sette i gang arbeidet. Planen for i år er stort sett luking av ugress og steiner samt generell pynting av området. Så skal vi sette opp 8 kasser for planting av nyttevekster neste vår. Foreløpig tenker vi å ha tomater, krydderurter, rabarbra, rødbeter og markjordbær, og vi tar gjerne imot flere forslag. 
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
    
    <div class="col-sm-12" id="soppelpoll">
	<div class="col-sm-12 sporsmal">
	    <div>
		Har DU plukket en sekk søppel fra Sydsiden/Søppelbukta?
	    </div>
	    <div class="btnwrapper">
		<button class="btn btn-success soppelknapp">Ja, det har jeg!</button>
	    </div>
	</div>
	<div class="col-sm-12 soppelbilder">
	    <?php
		$harPlukket = json_decode(file_get_contents("../../model/soppelpoll.json"));
		foreach ($harPlukket as $user):
	    ?>
		<img class="soppelbilde" title="<?=$user;?>" src="<?=file_get_contents('../resources/images/users/'.$user);?>" width="55px"/>
	    <?php endforeach; ?>
	</div>
    </div>
    
</div>

<?php
    renderFooter();
?>
