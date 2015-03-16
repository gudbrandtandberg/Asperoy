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

<div id='calendar'>

<div id="nyeventinfoformdiv">
	<label id="titlelabel" class="oldevent"></label>
    <div class="creator">
        <a href="#" id="deleteanchor" class="oldevent creator">Slett</a>
        <a href="#" id="editanchor" class="oldevent creator">Rediger</a>
    </div>
	<form id="eventform" class="newevent">
		<input id="eventtitleinput" type="text" name="title">
	</form>
</div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

<?php
    renderFooter();
?>