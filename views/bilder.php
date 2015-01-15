<!--
bilder.php

En navbar og et grid med thumbnails.
-->

<?php

    $xmlbilder = simplexml_load_file("model/bilder.xml");    
    $album = $xmlbilder->xpath('//ALBUM');
?>

<!-- en navigationbar -->

<div class='navbar'>
    <h3>
        ALBUM
    </h3>
    <a class='leggtil' href='index.php'>
        Legg til +
    </a>
</div>
    
    
<!-- grid med thumbnails over alle albumene -->
    
<? foreach ($album as $a): ?>
    <? $albumnavn = $a["ID"]; ?>
    <? $coverphotopath = "model/bilder/".$albumnavn."/".$a->BILDE[0][@FIL]; ?>
        
    <div class='thumbnail'>
        <a href='index.php?page=albumoversikt&album=<?=$albumnavn;?>'>
            <img src='<?=$coverphotopath;?>'>
        </a>
        <div class='label'>
            <?=$albumnavn;?>
        </div>
    </div>
    
<?php endforeach; ?>
