

<?php

    //legger inn en ny kommmentar i bilder.xml
    
    sleep(5); //imiterer treg forbindelse
    
    $kommentar = $_POST["kommentar"];
    $navn = $_POST["navn"];
    $dato = $_POST["dato"];
    $album = $_POST["album"];
    $bilde = $_POST["bilde"];
    
    $xmlbilder = simplexml_load_file("model/bilder.xml");
    $bilde_node = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$bilde}']");
    $kommentar_node = $bilde_node[0]->addChild("KOMMENTAR", $kommentar);
    $kommentar_node->addAttribute("NAVN", $navn);
    $kommentar_node->addAttribute("DATO", $dato);
    $xmlbilder->asXML("model/bilder.xml");

    //return kommentaren som et js objekt for videre behandling i galleri.php
    $string = json_encode($_POST);
    print($string);

?>