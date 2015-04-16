<!--
galleri.php

Skjermen er delt i to div'er; en med bilde og navting og en med kommentarer/kommentarfelt.
-->

<?php
include_once("../../UserController.php");
$userController = UserController::getInstance();
?>

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>
<script type="text/javascript">

//    Diverse variabler som er satt av php og maa derfor vaere i en php fil
    var bruker = "<?= $brukerNavn;?>";
    var albumId = "<?=$album["ID"];?>";
    var bilde = "<?=$image;?>";
    var nextImage = "<?=$nextImage;?>";
    var prevImage = "<?=$prevImage;?>";

</script>
<!-- Resten av js'en er her: -->
<script src="/js/galleri.js"></script>

<div class="col-xs-12 col-md-7 bildeboks">
    
    <!-- tittel -->
    <h4 id="albumtittel">
	<a href='<?="/bilder/".$album["ID"]?>'>&larr; <?=$album["NAVN"];?></a>
    </h4>
    
    <!-- Selve bildet -->
    <div class="bildecontainer">
	<img class="bilde" src="<?=$impath;?>">
    </div>
    
    <!-- navigation -->
    <table class='bildenav'>
	<tr>
	    <td class="navitem1"><a id='forrige' class="navitems" href='<?="/bilder/" . $album["ID"] . "/" . $prevImage;?>'>forrige</a></td>
	    <td class="navitem3"><a id='neste' class="navitems" href='<?="/bilder/" . $album["ID"] . "/" . $nextImage;?>'>neste</a></td>
	</tr>
    </table>
    
</div>

<!-- Kommentarer (nå ved siden av bildene for bedre opplevelse) -->
<div class="col-xs-12 col-md-5 kommentarboks" id="kommentarboks">
    
    <div class="kommentarene" id="kommentarene">
	<table id="kommentartabell">
	    <?php foreach($kommentarer as $kommentar): ?>
	    <tr class="kommentar">
		<td class="kommentarbilde">
		    <img class="profilbilde" src="/resources/images/users/<?=$userController->getUserImage($kommentar["NAVN"]);?>" width="50" height="50" alt="Brukerbilde">
		</td>
		<td class="kommentarinnhold">
		    <span class="kommentator"><?=$kommentar["NAVN"];?></span>
		    <span class="kommentartekst"><?=$kommentar;?></span>
		    <div class="kommentarinfo">
			<span class="dato"><?=$kommentar["DATO"];?></span>
		    </div>
		</td>
	    </tr>
	    <?php endforeach; ?>
	    <!-- mulighet for spinner til slutt -->
	    <tr>
		<td id="progress" style="display: none" colspan="2">
		    <img id="spinner" src="/resources/images/progress.gif" alt="Kommenterer.." width="20">
		</td>
	    </tr>
	</table>
    </div>

    <form  id="kommentarform" onsubmit="submitkommentar(); return false;">
	<table class='kommentarfelt'>
	    <tr>	
		<td class="nykommentarbilde">
		    <img class="profilbilde" src="/resources/images/users/<?=$_SESSION["bilde"];?>" width="50" height="50" alt="Brukerbilde">
		</td>
		<td class="nykommentar">
		    <textarea id="tekstfelt" form="kommentarform" name="kommentar" placeholder="Skriv en kommentar.." rows="2"></textarea>
		</td>
	    </tr>
	</table>
    </form>
</div>