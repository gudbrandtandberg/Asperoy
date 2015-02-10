

<?php

    //legger inn en ny kommmentar i bilder.xml
    
    sleep(1); //imiterer treg forbindelse
    
    $kommentar = $_POST["kommentar"];
    $navn = $_POST["navn"];
    $dato = $_POST["dato"];
    $album = $_POST["album"];
    $bilde = $_POST["bilde"];
    
    $xmlbilder = simplexml_load_file("../model/bilder.xml");
    $bilde_node = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$bilde}']");
    $kommentar_node = $bilde_node[0]->addChild("KOMMENTAR", $kommentar);
    $kommentar_node->addAttribute("NAVN", $navn);
    $kommentar_node->addAttribute("DATO", $dato);
    $xmlbilder->asXML("../model/bilder.xml");

?>
<div class="kommentar">
    	<div class="kommentarbilde">
    	    <img src="../resources/images/users/avatar.jpg" width="50" alt="Brukerbilde">
    	</div>
        
    	<div class="kommentarinnhold">
    	    <span class="kommentator"><?=$navn;?></span>
    	    <span class="kommentartekst"><?=$kommentar;?></span>
    	    <div class="kommentarinfo">
    		<span class="dato"><?=$dato;?></span>
    		<a href="like.php">Like</a>
    		<img src="../resources/images/like.jpg" style="display: inline" width="20" alt="Tommel">
    		<span class="numlikes" style="visibility: hidden"></span>
    	    </div>
    	</div>
</div>
<hr>

