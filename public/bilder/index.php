<!--
bilder.php

En navbar og et grid med thumbnails.
-->

<?php

    require_once("../renderHelpers.php");
    include_once("../../BildeController.php");
    renderHeaderWithTitle("ASPERØY - BILDER");

    $bildeController = BildeController::getInstance();

    $requestURIArray = explode("/", $_SERVER["REQUEST_URI"]);
    //NOTICE: UNDEFINED OFFSET: 3
    if (strlen($requestURIArray[2]) > 0 && strlen($requestURIArray[3]) > 0) {

        if (!$bildeController->verifyImageInAlbum($requestURIArray[2], $requestURIArray[3])) {
            echo "Det bildet finner vi ikke";
            return;
        }

        $album = $bildeController->getAlbumById($requestURIArray[2]);
        $image = $requestURIArray[3];
        //NOTICE: UNDEFINED VARIABLE FULLDIR
        $impath = $fulldir . "/resources/bilder/" . $album["NAVN"] . "/" . $image;
        $nextImage = $bildeController->getFollowingImageOfImageInAlbum($requestURIArray[2], $requestURIArray[3]);
        $prevImage = $bildeController->getPrecedingImageOfImageInAlbum($requestURIArray[2], $requestURIArray[3]);

        $kommentarer = $bildeController->getCommentsForImageInAlbum($requestURIArray[2], $requestURIArray[3]);
        include("../views/galleri.php");
    } else {
        if (strlen($requestURIArray[2]) > 0) {

            if (!$bildeController->verifyAlbumId($requestURIArray[2])) {
                echo "Det albumet finner vi ikke";
                return;
            }

            $images = $bildeController->getAllImagesInAlbum($requestURIArray[2]);
            $album = $bildeController->getAlbumById($requestURIArray[2]);
            include("../views/albumoversikt.php");
        } else {
            $album = $bildeController->getAllAlbums();
            include("../views/allAlbums.php");
        }
    }
    renderFooter();
?>