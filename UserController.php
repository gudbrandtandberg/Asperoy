<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/24/15
 * Time: 7:38 PM
 */

include('XML_CRUD.php');

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
}