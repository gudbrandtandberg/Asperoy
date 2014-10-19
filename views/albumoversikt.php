<!--
Litt rotete her. Alle bildene ligger lagret i xml format. Denne siden skal vise thumbnails av alle bildene
et album inneholder. 
-->

<?php

    $album = $data["album"];  //$data fikk vi tilsendt av render()-kommandoen i index
    
    // navbar
    echo "<div class='bildertittel'><a class='tilbake' href='index.php?page=bilder'>Album</a><h3>".$album."</h3><a class='leggtil' href='../controller/index.php'>Legg til</a></div>";

    $xmlbilder = simplexml_load_file("../model/bilder.xml");
    //$images = $xmlbilder->xpath("//ALBUM[@ID='$album']/BILDE");
    $albums = $xmlbilder->ALBUM;
    
    // grid med thumbnails av alle bilder i et album
    echo "<div id='album'>";  //heller ha class="thumbnailgrid" eller no sånt. 
    foreach ($albums as $a){
        if ($a["ID"] == $album){  // tungvindt måte å få frem alle bildene, men du skjønner tegninga.
                                  // burde være mulig å bruke xpath kommandoen på en bedre måte for å
                                  // kun få en liste med de bildene vi vil ha..
            foreach ($a->children() as $image){
                
                $impath = "../model/bilder/".$album."/".$image;
                
                echo "<div class='albumoversiktboks'>";
                echo "  <img class='albumoversiktbilde' src=$impath>";
                // må gjøre bildene klikkbare også.. "<a href='../controller/index.php?page=galleri&album=$albumnavn&bilde=$image'>";
                echo "</div>";
            }
        }
        
    }
    echo "</div>";  



?>