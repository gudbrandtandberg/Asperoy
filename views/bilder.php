<!--
bilder.php

En navbar og et grid med thumbnails.
-->

<?php

    $xmlbilder = simplexml_load_file("model/bilder.xml");    
    $album = $xmlbilder->xpath('//ALBUM');
?>
    
<!-- en navigationbar -->
<table class='navbar'>
    <tr>
        <td class="navitem1"></td>
        <td class="navitem2"><h3>ALBUM</h3></td>
        <td class="navitem3"><a href='index.php'>Legg til +</a></td>
    </tr>
</table>

<!-- grid med thumbnails over alle albumene -->
    
<? foreach ($album as $a): ?>
    <? $albumnavn = $a["NAVN"]; ?>
    <? $albumid = $a["ID"]; ?>
    <? $coverphotopath = "model/bilder/".$albumnavn."/".$a->BILDE[0][@FIL]; ?>
        
    <div class='thumbnail'>
        <a href='index.php?page=albumoversikt&album=<?=$albumid;?>'>
            <img src='<?=$coverphotopath;?>'>
        </a>
        <div class='label'>
            <?=$albumnavn;?>
        </div>
    </div>
    
<?php endforeach; ?>
