<?php
    //Denne her skal opprette et nytt directory i /images/bilder og i bilder.xml
    $albumnavn = $_GET["albumnavn"];
    
    //Åhh, dette er et lite helvete å komme til bunns i.. Må årne med permissions.
    //Apache kjører som brukeren _www, så vi må tillate _www å lage directories.
    //mkdir("/resources/bilder/".$albumnavn, 0777, true);
    
    //XML-greier:
    
?>

<div class='col-xs-6 col-md-3'>
    <a class="tommel" href="<?=$albumnavn;?>">
        <div class="tommelbildebeholder" style="background-image: url('http://www.casa-candy.com/preload-images/default-placeholder.png');"></div>
        <div class="tommelcaption"><?=$albumnavn;?></div>
    </a>
</div>