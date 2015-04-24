<?php
    //Her opprettes et nytt directory i /images/bilder og en ny node i bilder.xml
    //resultatet sendes tilbake til allAlbums.php
    
    $albumnavn = $_GET["albumnavn"];
    //fysj dette er stygt; må da kunne gjøres på en linje!??
    $albumID = str_replace(' ', '', $albumnavn);
    $albumID = str_replace('å', 'aa', $albumID);
    $albumID = str_replace('ø', 'oe', $albumID);
    $albumID = str_replace('æ', 'ae', $albumID);
    $albumID = str_replace('Å', 'AA', $albumID);
    $albumID = str_replace('Æ', 'AE', $albumID);
    $albumID = str_replace('Ø', 'OE', $albumID);
    
    include_once("../../BildeController.php");
    $bildeController = BildeController::getInstance();
?>   

<?php if (!is_dir("../resources/bilder/".$albumnavn)):
    mkdir("../resources/bilder/".$albumnavn, 0777, true); ?>

    <?php if (!$bildeController->addAlbum($albumnavn)):  //hvorfor er dette motsatt?! ?>
        <div class='col-xs-6 col-md-3'>
            <a class="tommel" href="<?=$albumID;?>">
                <div class="tommelbildebeholder" style="background-image: url('../resources/images/album_placeholder_text.png');"></div>
                <div class="tommelcaption"><?=$albumnavn;?></div>
            </a>
        </div>
    <?php endif; ?>
<?php else: ?>FINNES<?php endif;?>
    
    