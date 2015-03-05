

<?php

    //legger inn en ny kommmentar i bilder.xml
    
    sleep(1); //imiterer treg forbindelse
    
    $kommentar = $_POST["kommentar"];
    $navn = $_POST["navn"];
    $dato = $_POST["dato"];
    $album = $_POST["album"];
    $bilde = $_POST["bilde"];

    include_once("../../BildeController.php");
    $bildeController = BildeController::getInstance();

    $bildeController->addCommentToImageInAlbum($kommentar, $dato, $navn, $bilde, $album);

?>
<div class="kommentar">
    	<div class="kommentarbilde">
    	    <img src="<?=$fulldir;?>/resources/images/users/avatar.jpg" width="50" alt="Brukerbilde">
    	</div>
        
    	<div class="kommentarinnhold">
    	    <span class="kommentator"><?=$navn;?></span>
    	    <span class="kommentartekst"><?=$kommentar;?></span>
    	    <div class="kommentarinfo">
    		<span class="dato"><?=$dato;?></span>
    		<a href="like.php">Like</a>
    		<img src="<?=$fulldir;?>/resources/images/like.jpg" style="display: inline" width="20" alt="Tommel">
    		<span class="numlikes" style="visibility: hidden"></span>
    	    </div>
    	</div>
</div>
<hr>

