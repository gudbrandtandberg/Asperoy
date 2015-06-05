<?php
if (!isset($_SESSION)){
session_start();
}
    //legger inn en ny kommmentar i bilder.xml
    extract($_POST);
    $id = uniqid();
    
    $dato = str_replace("/", ".", $dato);
    
    include_once("../../BildeController.php");
    include_once("../renderHelpers.php");
    $bildeController = BildeController::getInstance();
    $bildeController->addCommentToImageInAlbum($kommentar, $dato, $navn, $bilde, $album, $id);

    echo renderComment($kommentar, $dato, $navn, $id);
    
    //lagre kommentarkreasjonen som en newsfeeditem og sende epost til alle følgere
    
?>
