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

//print_r($_POST);
//print_r($_FILES);

// Getting POST variables
$ny_bruker_navn = $_POST["fornavn"];
$ny_bruker_etternavn = $_POST["etternavn"];
//søren dette funker jo ikke så bra. Kanskje vi skal ha 3 felt: fornavn, etternavn OG brukernavn?
if ($ny_bruker_navn == "Harald"){
    $ny_bruker_navn = $ny_bruker_navn . " L.";
}
$ny_bruker_farge = $_POST["farge"];
$ny_bruker_epost = $_POST["epost"];
$ny_bruker_passord = $_POST["passord"];
$ny_bruker_profilbilde = $_POST["profilbilde"];

// Hashing password
$ny_bruker_hashed_passord = password_hash($ny_bruker_passord, PASSWORD_DEFAULT);

// Checking for existing user
$existing_user = $userController->getUserByName($ny_bruker_navn);

if ($existing_user) {
    echo "\n tar bruker tilbake til /nybruker/ og viser feilmeldingen (men ikke nå, fordi vi vil se på POST)";
    //$_SESSION["feil"] = true;
    //header("Location: /nybruker/");
} else {
//    $additionSuccessful = $userController->addUserWithNamePasswordEmail($ny_bruker_navn, $ny_bruker_hashed_passord, $ny_bruker_epost);
    $additionSuccessful = $userController->addUser($ny_bruker_navn, $ny_bruker_etternavn, $ny_bruker_hashed_passord, $ny_bruker_epost, $ny_bruker_profilbilde, $ny_bruker_farge);
    if ($additionSuccessful) {
        $_SESSION["feil"] = false;
        $_SESSION["loggedIn"] = true;
        $_SESSION["brukernavn"] = $_POST["fornavn"];
        $_SESSION["farge"] = $_POST["farge"];

        header("Location: /");
    }
    else {
        echo "Noe gikk galt i lagringen.. Internal server error?";
    }
}
?>