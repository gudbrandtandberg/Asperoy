<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/11/15
 * Time: 12:37 AM
 */


if (!isset($_SESSION))
{
    session_start();
}
require_once("../renderHelpers.php");
require_once("../../UserController.php");
$userController = UserController::getInstance();

// Getting POST variables
$ny_bruker_navn = $_POST["brukernavn"];
$ny_bruker_epost = $_POST["epost"];
$ny_bruker_passord = $_POST["passord"];

// Hashing password
$ny_bruker_hashed_passord = password_hash($ny_bruker_passord, PASSWORD_DEFAULT);


// Checking for existing user
$existing_user = $userController->getUserByName($ny_bruker_navn);

if ($existing_user) {
    echo "Det finnes en bruker med det navnet. Ta et annet!";
} else {
    $additionSuccessful = $userController->addUserWithNamePasswordEmail($ny_bruker_navn, $ny_bruker_hashed_passord, $ny_bruker_epost);
    if ($additionSuccessful) {
        $_SESSION["loggedIn"] = true;
        $_SESSION["brukernavn"] = $_POST["brukernavn"];

        header("Location: /");
    }
}
?>