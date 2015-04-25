<?php
if (!isset($_SESSION)){
session_start();
}
    //legger inn en ny kommmentar i bilder.xml
    $kommentar = $_POST["kommentar"];
    $navn = $_POST["navn"];
    $dato = $_POST["dato"];
    $album = $_POST["album"];
    $bilde = $_POST["bilde"];

    include_once("../../BildeController.php");
    $bildeController = BildeController::getInstance();
    $bildeController->addCommentToImageInAlbum($kommentar, $dato, $navn, $bilde, $album);

?>
<tr class="kommentar">
    	<td class="kommentarbilde">
    	    <img class="profilbilde" src="<?=file_get_contents("../resources/images/users/".$navn);?>" width="50" height="50" alt="Brukerbilde">
    	</td>
        
    	<td class="kommentarinnhold">
    	    <span class="kommentator"><?=$navn;?></span>
    	    <span class="kommentartekst"><?=$kommentar;?></span>
    	    <div class="kommentarinfo">
    		<span class="dato"><?=$dato;?></span>
    	    </div>
    	</td>
</tr>