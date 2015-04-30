<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/24/15
 * Time: 7:38 PM
 */

include_once('XML_CRUD.php');

class UserController extends XML_CRUD {

    public static function getInstance() {

        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    function __construct() {
        parent::__construct("../../model/users.xml");
    }

    public function verifyUser($userName, $password) {
        $authenticated = false;

        $userNode = $this->getNodeOfTypeByAttribute("USER", "NAVN", $userName);

        if ($userNode) {
            $existingUser = $userNode[0];
            $userPassword = $existingUser["PASSORD"];

            if (!password_verify($password, $userPassword)) {
                $this->logger->info("Autentisering mislyktes med galt passord");
                $authenticated = false;
            } else {
                $this->logger->info("Autentisering vellykket");
                $authenticated = true;
            }
        } else {
            $this->logger->info("Autentisering mislyktes med galt brukernavn");
            $authenticated = false;
        }

        return $authenticated;
    }

    public function getUserByName($userName) {
        $usersWithName = $this->getNodeOfTypeByAttribute("USER", "NAVN", $userName);
        return $usersWithName[0];
    }

    public function addUserWithNamePasswordEmail($userName, $password, $email) {
        $nodeToAddTo = $this->getNodesOfType("USER");
        $additionSuccessful = $this->addChildOfTypeAndContentWithAttributesToNode("USER", NULL, [["NAVN", $userName], ["PASSORD", $password], ["EPOST", $email]], $nodeToAddTo[0]);
        return $additionSuccessful;
    }

    public function addUser($firstName, $lastName, $password, $email, $image, $color) {
        // Forst lagring av bilde som bilde
        $imageArr = explode(';base64,', $image);
        $imgFile = $firstName . "." . explode('/', $imageArr[0])[1];
        file_put_contents("../resources/images/users/" . $imgFile, base64_decode($imageArr[1]));

        // Saa som streng
        file_put_contents("../resources/images/users/" . $firstName, $image);

        $nodeToAddTo = $this->getNodesOfType("USER");
        $additionSuccessful = $this->addChildOfTypeAndContentWithAttributesToNode("USER", NULL, [["NAVN", $firstName], ["FORNAVN", $firstName], ["ETTERNAVN", $lastName], ["PASSORD", $password], ["EMAIL", $email], ["FARGE", $color], ["BILDE", $imgFile]], $nodeToAddTo[0]);
        return $additionSuccessful;
    }

    
    public function setUserColor($userName, $color) {
        $this->updateNodeAttributes("USER", "NAVN", $userName, ["FARGE", $color]);
        return true;        
    }
    
    public function getUserImage($userName) {
        $user = $this->getUserByName($userName);
        return $user["BILDE"];
    }

    public function getUserColor($userName) {
        $user = $this->getUserByName($userName);
        return $user["FARGE"];
    }
}
