<?php

    $xmlbilder = simplexml_load_file("../model/bilder.xml");
    
    $album = $xmlbilder->ALBUM;
    
    // en navigationbar 
    echo "<div class='bildertittel'><h3> ALBUM </h3><a class='leggtil' href='../controller/index.php'>Legg til</a></div>";
    
    // grid med thumbnails over alle albumene
    echo "<div id='album'>";
    foreach ($album as $a){
        
        $albumnavn = $a["ID"];
        $coverphotopath = "../model/bilder/".$albumnavn."/".$a->BILDE[0];
        
        echo "<div class='albumboks'>";
        echo "  <img class='albumbilde' src=$coverphotopath>";
        echo "  <a href='../controller/index.php?page=albumoversikt&album=$albumnavn'>$albumnavn</a>";
        echo "</div>";
        
    }
    echo "</div>";

?>