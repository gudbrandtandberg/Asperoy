<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<?php
    $album = $data["album"];  //$data fikk vi tilsendt av render()-kommandoen i index

?>

<div class='navbar'>
    <a class='tilbake' href='index.php?page=bilder'>
        Album
    </a>
    <h3>
        <?=$album;?>
    </h3>
    <a class='leggtil' href='../controller/index.php'>
        Legg til +
    </a>
</div>

<!-- Grid med thumbnails av alle bildene i album -->

<?php

    $xmlbilder = simplexml_load_file("../model/bilder.xml");
    //$images = $xmlbilder->xpath("//ALBUM[@ID='$album']/BILDE");
    $albums = $xmlbilder->ALBUM;
?>
    
<? foreach ($albums as $a): ?>
    <? if ($a["ID"] == $album): ?>  
        <? foreach ($a->children() as $image): ?>         
            <? $impath = "../model/bilder/".$album."/".$image; ?>
                <div class='thumbnail'>
                    <a href='../controller/index.php?page=galleri&album=<?=$a["ID"];?>&bilde=<?=$image;?>'>
                        <img class='bilde' src='<?=$impath;?>'>
                    </a>
                </div>         
        <? endforeach; ?>
    <? endif; ?>
<? endforeach; ?>
