<!--
galleri.php

http://localhost/Asperøy/controller/index.php?page=galleri&album=Sommer2012&bilde=
-->

<?php
    $album = $data['album'];
    $image = $data['bilde'];
    $impath = "../model/bilder/".$album."/".$image;

?>

<!-- navbar -->
<div class='navbar'>

</div>

<!-- galleri (bilde & kommentarvisningstedet) -->
<div class="galleri">
    <div class='bilde'>
	<img src='<?=$impath;?><? $image;?>'>
    </div>
    
    <!-- for each kommentar as k -->
    <div class='kommentar'>
	    Dette er en kommentar. 
    </div>
    <div class='kommentar'>
        Dette er en kommentar til. Å for et bilde! 
    </div>
    
    <div class='kommentarfelt'>
	<form>
	    Navn:
	    <input type='textfield'>
	    <input type='submit' method='post' action='nyKommentar.php'>
	</form>
    </div>
   
</div>
