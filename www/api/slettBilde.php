<?php

    require("../../BildeController.php");

    $bilde = $_GET["bilde"];
    $album = $_GET["album"];
    
    $bildeController = BildeController::getInstance();
    
    $bildeController->deleteImageInAlbum($bilde, $album);
    unlink("../resources/bilder/".$album."/".$bilde);
    
?>