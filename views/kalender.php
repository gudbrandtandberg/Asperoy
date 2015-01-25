<?php
if (!isset($_SESSION))
{
	session_start();
}
?>

<link href='external/fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
<link href='external/fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='external/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='external/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script>
	var eventJSON = <?php echo json_decode(file_get_contents("model/events.json"))?>;
	$(document).ready(function() {

		/* javascript får tilgang til brukernavn. Ikke den beste måten å
		 sende data mellom php og js, men det virker væffal...*/

		var bruker = "<?php echo $_SESSION["brukernavn"]; ?>";

		/*events: {
		 url: 'php/get-events.php',
		 error: function() {
		 $('#script-warning').show();
		 }
		 },*/

		$('#calendar').fullCalendar({
			height: 500,
			defaultDate: '2015-05-01',
			events: eventJSON,
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,

			select: function(start, end) { // her må også hendelsen skrives til events.json filen.

//				var title = prompt('Legg til hendelse:', 'her kommer jeg'); //må finne ny måte å gjøre dette på; prompt() er stygg
				var title = "Ny event!!";
				var eventData;

				if (title) {
					eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

					eventJSON.push(eventData);
					var tmp = JSON.stringify(eventJSON);


					$.ajax({
						type: "POST",
						url: "nyEvent.php",
						data: {"nyEvent": tmp},
						success: function(message) {
							console.log(message);
						}
					});
				}
				$('#calendar').fullCalendar('unselect');
			},
		});
	});

</script>
<style>
	body {
		margin: 0px 0px;
		padding: 0;
		font-family: Helvetica, sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
<!--her begynner innholdet-->

<div id='calendar'></div>
