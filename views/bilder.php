<?php

    $xmlbilder = simplexml_load_file("../model/bilder.xml");
    
    $album = $xmlbilder->ALBUM;
    
    // en navigationbar 
    echo "<div class='navbar'>";
    echo "<h3>ALBUM</h3>";
    echo "<a class='leggtil' href='../controller/index.php'>Legg til +</a>";
    echo "</div>";
    
    // grid med thumbnails over alle albumene
    echo "<div class='content'>";
    
    foreach ($album as $a){
        
        $albumnavn = $a["ID"];
        $coverphotopath = "../model/bilder/".$albumnavn."/".$a->BILDE[0];
        
        echo "<div class='thumbnail'>";
        echo "<a href='../controller/index.php?page=albumoversikt&album=$albumnavn'>";
        echo "<img src=$coverphotopath>";
        echo "</a>";
        echo "<div class='label'>";
        echo $a["ID"];
        echo "</div>";
        echo "</div>";
        
    }
    echo "</div>";

?>