<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/24/15
 * Time: 8:37 PM
 */
include('XML_CRUD.php');

class BildeController extends XML_CRUD {

    public static function getInstance() {

        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    function __construct() {
        parent::__construct("../../model/bilder.xml");
    }

//    BEGIN ALBUM METHODS
    public function verifyAlbumId($albumId) {
        $album = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $albumId);
        return count($album);
    }

    public function getAllAlbums() {
        $albums = $this->getNodesOfType("ALBUM");
        return $albums;
    }

    public function getAllImagesInAlbum($albumId) {
        $images = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE"]]);
        return $images;
    }

    public function getAlbumById($albumId) {
        $albums = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $albumId);
        return $albums[0]; // Siden $albumId er unik for hvert album kan vi trygt hente den første av de returnerte nodene
    }
//    END ALBUM METHODS

//    BEGIN IMAGE METHODS
    public function verifyImageInAlbum($albumId, $imageFileName) {
        $image = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName]]);
        return count($image);
    }

    public function getPrecedingImageOfImageInAlbum($albumId, $imageFileName) {
        $allPrecedingImages = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName], ["preceding-sibling::BILDE"]]);
        return end($allPrecedingImages)["FIL"];
    }

    public function getFollowingImageOfImageInAlbum($albumId, $imageFileName) {
        $allFollowingImages = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName], ["following-sibling::BILDE"]]);
        return $allFollowingImages[0]["FIL"];
    }

    public function getCommentsForImageInAlbum($albumId, $imageFileName) {
        $comments = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName], ["KOMMENTAR"]]);
        return $comments;
    }

//    END IMAGE METHODS



    public function getAlbumNameForId($albumId) {
        $albums = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $albumId);
        $album = $albums[0];
        return $album["NAVN"];
    }
}