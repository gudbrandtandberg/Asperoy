<?php
if (!isset($_SESSION))
{
	session_start();
}
?>

<link href='external/fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
<link href='external/fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='styles/kalenderStyle.css' rel="stylesheet"/>
<script src='external/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='external/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script>
	var eventJSON = <?php echo json_decode(file_get_contents("model/events.json"))?>;
	var bruker = "<?php echo $_SESSION["brukernavn"]; ?>";
</script>
<script src="js/kalender.js"></script>

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