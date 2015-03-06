<!--
galleri.php

Skjermen er delt i to div'er; en med bilde og navbar og en med kommentarer.
-->

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

<div class="bildeboks">
    
    <!-- navbar -->
    <table class='subnavbar'>
	<tr>
	    <td class="navitem1"><a id='forrige' href='<?="/bilder/" . $album["ID"] . "/" . $prevImage;?>'>forrige</a></td>
	    <td class="navitem2"><a href='<?="/bilder/" . $album["ID"]?>' class='tilbakealbum'><?=$album["NAVN"];?></a></td>
	    <td class="navitem3"><a id='neste' href='<?="/bilder/" . $album["ID"] . "/" . $nextImage;?>'>neste</a></td>
	</tr>
    </table>
    
    <!-- Selve bildet -->
    <div class='bilde'>
	<img src='<?=$impath;?>'>
    </div>

</div>

<!-- Kommentarer (nå ved siden av bildene for bedre opplevelse) -->
<div class="kommentarboks" id="kommentarboks">
    
    <div id="kommentarene">
	<?php foreach($kommentarer as $kommentar): ?>
	    <div class="kommentar">
		<div class="kommentarbilde">
		    <img src="/resources/images/users/avatar.jpg" width="50" alt="Brukerbilde">
		</div>
		<div class="kommentarinnhold">
		    <span class="kommentator"><?=$kommentar["NAVN"];?></span>
		    <span class="kommentartekst"><?=$kommentar;?></span>
		    <div class="kommentarinfo">
			<span class="dato"><?=$kommentar["DATO"];?></span>
			<a href="like.php">Like</a>
			<img src="/resources/images/like.jpg" style="display: inline" width="20" alt="Tommel">
			<span class="numlikes" style="visibility: hidden"></span>
		    </div>
		</div>
		
	    </div>
	    <hr>
	<?php endforeach; ?>
	<div id="progress" style="display: none">
	    <img src="/resources/images/progress.gif" alt="Kommenterer.." width="20">
	</div>
    </div>

    <div class='kommentarfelt'>
	<form  id="kommentarform" onsubmit="submitkommentar(); return false;">
	    <div class="kommentarbilde">
		<img src="/resources/images/users/avatar.jpg" width="50" alt="Brukerbilde">
		<div class="kommentator"><?= $_SESSION["brukernavn"];?></div>
	    </div>
	    <textarea id="tekstfelt" class="nykommentar" form="kommentarform" name="kommentar" placeholder="Skriv en kommentar.." rows="4"></textarea>
	</form>
    </div>
</div>
