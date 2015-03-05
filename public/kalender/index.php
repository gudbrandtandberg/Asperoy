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
<script>
	var eventJSON = <?php echo $kalenderController->getAllEventsAsJson();?>;
//    var eventJSON = {};
	var bruker = "<?php echo $_SESSION["brukernavn"]; ?>";
</script>
<script src="/js/kalender.js"></script>

<!--her begynner innholdet-->

<div id='calendar'></div>

<div id="nyeventinfoformdiv">
	<label id="titlelabel">test</label>
	<form id="eventform">
		<label for="title">Hva skjer da?</label>
		<br>
		<input id="eventtitleinput" type="text" name="title">
	</form>
</div>

<?php
    renderFooter();
?>