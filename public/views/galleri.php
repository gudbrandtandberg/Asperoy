<!--
galleri.php

Skjermen er delt i to div'er; en med bilde og navting og en med kommentarer/kommentarfelt.
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>
<script type="text/javascript">

    //Diverse variabler som er satt av php og må derfor vaere i en php fil
    var bruker = "<?= $brukerNavn;?>";
    var albumId = "<?=$album["ID"];?>";
    var bilde = "<?=$image;?>";
    var nextImage = "<?=$nextImage;?>";
    var prevImage = "<?=$prevImage;?>";

</script>
<!-- Resten av js'en er her: -->
<script src="/js/galleri.js"></script>

<div class="col-xs-12 col-md-8 bildeboks">
    
    <!-- tittel -->
    <h4 id="albumtittel">
	<a href='<?="/bilder/".$album["ID"]?>'>&larr; <?=$album["NAVN"];?></a>
    </h4>
    
    <!-- Selve bildet -->
    <div class="bildecontainer" id="bildecontainer">
	<!--<span id="helper"></span>  Dette var en rar hack -->
	    <img class="bilde" src="<?=$impath;?>" id="selvebildet" onload="resizeToMax(this.id);" style="display: none;">
    </div>
    
    <!-- navigation -->
    <table class='bildenav'>
	<tr>
	    <td class="navitem1"><a id='forrige' class="navitems" href='<?="/bilder/" . $album["ID"] . "/" . $prevImage;?>'>forrige</a></td>
	    <td class="navitem3"><a id='neste' class="navitems" href='<?="/bilder/" . $album["ID"] . "/" . $nextImage;?>'>neste</a></td>
	</tr>
    </table>
</div>

<!-- Kommentarer -->
<div class="col-xs-12 col-md-4 kommentarboks" id="kommentarboks">
    
    <div class="kommentarene" id="kommentarene">
	<table class="kommentartabell">
		<?php foreach($kommentarer as $kommentar): ?>
		<tr class="kommentar">
		    <td class="kommentarbilde">
			<img class="profilbilde" src="<?=file_get_contents("../resources/images/users/".$kommentar["NAVN"]);?>" width="50" height="50" alt="Brukerbilde">
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
		<tr id="progress" style="display: none;">
		    <td style="text-align: center;" colspan="2">
			<img id="spinner" src="/resources/images/progress.gif" alt="Kommenterer.." width="20">
		    </td>
		</tr>
	    
	</table>
    </div>
	<table class="kommentartabell nykommentartabell">
	    <tr class="nykommentar">
		<form  id="kommentarform" onsubmit="submitkommentar(); return false;">
		<td class="kommentarbilde">
		    <img class="profilbilde" src="<?=file_get_contents("../resources/images/users/" . $_SESSION["brukernavn"]);?>" width="50" height="50" alt="Brukerbilde">
		</td>
		<td class="kommentarinnhold">
		    <textarea id="tekstfelt" form="kommentarform" name="kommentar" placeholder="Skriv en kommentar.." rows="2"></textarea>
		</td>
		</form>
	    </tr>
	</table>
    
</div>