<?php
    require_once("../renderHelpers.php");
    require_once("../../KalenderController.php");
    renderHeaderWithTitle("ASPERØY - KALENDER");
    $kalenderController = KalenderController::getInstance();

?>

<link href='/js/fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
<link href='/js/fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='/styles/kalenderStyle.css' rel="stylesheet"/>
<script src='/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script type="text/javascript">

    var eventJSON = <?=$kalenderController->getAllEventsAsJsonSorted(false);?>;
    var bruker = "<?=$_SESSION["brukernavn"];?>";
    var brukerFarge = "<?=$_SESSION["farge"];?>";
</script>
<script src="/js/kalender.js"></script>

<!--her begynner innholdet-->

<div id='calendar'>
    <div id="eventoverlay">
        <div class="eventcontent">
            <label>Hva som skjer:</label>
	    <span id="closeoverlay" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            <input id="titleinput" class="title eventedit" autofocus/>
            <br/>
            <label>Beskrivelse:</label>
            <textarea id="descriptioninput" class="description eventedit"></textarea>
            <br/>
            <label>Laget av:</label>
            <label id="eventcreator" class="creator eventdesc"></label>
            <br/>
            <button id="createbutton" class="btn btn-success">Lagre ny hendelse</button>
            <div class="editbuttons">
                <button id="savebutton" class="editbuttons btn btn-success">Lagre</button>
                <button id="deletebutton" class="editbuttons btn btn-danger">Slett</button>
            </div>
        </div>
    </div>
</div>

<?php
    renderFooter();
?>
