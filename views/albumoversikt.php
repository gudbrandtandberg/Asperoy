<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<?php
    $albumid = $data["album"];  //$data fikk vi tilsendt av render()-kommandoen i index

    $xmlbilder = simplexml_load_file("model/bilder.xml");  
    $images = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']/BILDE");
    $albumnavn = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']")[0]["NAVN"];
    
?>

<table class='navbar'>
    <tr>
        <td class="navitem1"><a href='index.php?page=bilder'>Album</a></td>
        <td class="navitem2"><h3><?=$albumnavn;?></h3></td>
        <td class="navitem3"><a href='index.php'>Legg til +</a></td>
    </tr>
</table>

<!-- Grid med thumbnails av alle bildene i album -->

<?php foreach ($images as $image): ?>
            <?php $impath = "resources/bilder/".$albumnavn."/".$image["FIL"]; ?>
                <div class='thumbnail'>
                    <a href='index.php?page=galleri&album=<?=$albumid;?>&bilde=<?=$image["FIL"];?>'>
                        <img class='bilde' src='<?=$impath;?>'>
                    </a>
                </div>         
<?php endforeach; ?>
