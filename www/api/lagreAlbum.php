<?php
    //Her opprettes et nytt directory i /images/bilder og en ny node i bilder.xml
    //resultatet sendes tilbake til allAlbums.php
    
    $album = $_GET["albumnavn"];
    $albumID = str_replace(Array(' ', 'æ', 'ø', 'å', 'Æ', 'Ø', 'Å'), Array('', 'ae', 'oe', 'aa', 'AE', 'OE', 'AA'), $album);    
    
    include_once("../../BildeController.php");
    $bildeController = BildeController::getInstance();

?>   

<?php if (!is_dir("../resources/bilder/".$albumID)):
    mkdir("../resources/bilder/".$albumID, 0777, true); ?>

    <?php if (!$bildeController->addAlbum($album, $albumID)):  //hvorfor er dette motsatt?! ?>
        <div class='col-xs-6 col-md-3'>
            <a class="tommel" href="<?=$albumID;?>">
                <div class="tommelbildebeholder" style="background-image: url('../resources/images/album_placeholder_text.png');"></div>
                <div class="tommelcaption"><?=$album;?></div>
            </a>
        </div>
    <?php endif; ?>
<?php else: ?>FINNES<?php endif;?>
    
<?php

//lagre albumkreasjonen som en newsfeeditem og sende epost til alle følgere


?>