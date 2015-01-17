<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<?php
    $album = $data["album"];  //$data fikk vi tilsendt av render()-kommandoen i index

    $xmlbilder = simplexml_load_file("model/bilder.xml");  
    $images = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE");
    
?>

<table class='navbar'>
    <tr>
        <td class="navitem1"><a href='index.php?page=bilder'>Album</a></td>
        <td class="navitem2"><h3><?=$album;?></h3></td>
        <td class="navitem3"><a href='index.php'>Legg til +</a></td>
    </tr>
</table>

<!-- Grid med thumbnails av alle bildene i album -->

<? foreach ($images as $image): ?>
            <? $impath = "model/bilder/".$album."/".$image["FIL"]; ?>
                <div class='thumbnail'>
                    <a href='index.php?page=galleri&album=<?=$album;?>&bilde=<?=$image["FIL"];?>'>
                        <img class='bilde' src='<?=$impath;?>'>
                    </a>
                </div>         
<? endforeach; ?>
