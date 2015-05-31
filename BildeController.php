<?php

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
    
    public function addAlbum($album, $albumID){
        $nodeToAddTo = $this->getNodesOfType("BILDER");
        $additionSuccessful = $this->addChildOfTypeAndContentWithAttributesToNode("ALBUM", NULL, [["NAVN", $album], ["ID", $albumID]], $nodeToAddTo[0]);
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
        return count($allFollowingImages) > 0 ? $allFollowingImages[0]["FIL"] : NULL;
    }

    public function getCommentsForImageInAlbum($albumId, $imageFileName) {
        $comments = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName], ["KOMMENTAR"]]);
        return $comments;
    }

    public function addCommentToImageInAlbum($commentContent, $date, $username, $imageFileName, $albumId, $commentID) {
        $imageNodeToAddTo = $this->getNodesOfTypeByAttributeAndSubTypes("ALBUM", "ID", $albumId, [["BILDE", "FIL", $imageFileName]]);
        $addedSuccessfully = $this->addChildOfTypeAndContentWithAttributesToNode("KOMMENTAR", $commentContent, [["DATO", $date], ["NAVN", $username], ["ID", $commentID]], $imageNodeToAddTo[0]);
        return $addedSuccessfully;
    }
    
    public function deleteComment($commentID){
        
        $deletedSuccessfully = $this->removeChildOfTypeWithAttributesFromNode("KOMMENTAR", "ID", $commentID);
        
    }
    
    public function addImageToAlbum($image, $album){
        
        $albumNodeToAddTo = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $album);
        $addedSuccessfully = $this->addChildOfTypeAndContentWithAttributesToNode("BILDE", NULL, [["FIL", $image]], $albumNodeToAddTo[0]);
        return $addedSuccessfully;
        
    }

    public function deleteImageInAlbum($image, $album){
        
        //$albumNodeToDeleteFrom = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $album);
        $deletedSuccessfully = $this->removeChildOfTypeWithAttributesFromNode("BILDE", "FIL", $image);
        
    }
    
//    END IMAGE METHODS

    public function getAlbumNameForId($albumId) {
        $albums = $this->getNodeOfTypeByAttribute("ALBUM", "ID", $albumId);
        $album = $albums[0];
        return $album["NAVN"];
    }
}