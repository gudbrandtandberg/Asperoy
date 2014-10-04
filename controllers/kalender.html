<!DOCTYPE html>
<html>
<head>
	<title>Asperøy - kallender</title>
	<meta charset='utf-8'/>
	<link href='../fullcalendar-2.1.1/fullcalendar.css' rel='stylesheet' />
	<link href='../fullcalendar-2.1.1/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='../fullcalendar-2.1.1/lib/moment.min.js'></script>
	<script src='../fullcalendar-2.1.1/fullcalendar.min.js'></script>
	<script>
		$(document).ready(function() {
		    
		    /* leser lagrede hendelser fra json filen og rendrer hendelsene */
		    
		    $.getJSON('../model/kalender_hendelser/events.json', function(event_data){
			$.each(event_data, function(index, event){
			    $('#calendar').fullCalendar('renderEvent', event, true);
			    
			});
		    });
		    
		
		    $('#calendar').fullCalendar({
			height: 650,
			defaultDate: '2015-05-01',
			events: [],
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			
			select: function(start, end) { // her må også hendelsen skrives til events.json filen.
			    
			    var title = prompt('Legg til hendelse:', 'her kommer jeg'); //må finne ny måte å gjøre dette på; prompt() er stygg
			    var eventData;
				
			    if (title) {
				eventData = {
				    title: title,
				    start: start,
				    end: end
				};                
				$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
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
</head>

<body>
	<div id='calendar'></div>
</body>

</html>