<?php
if (!isset($_SESSION))
{
    session_start();
}
require_once("../renderHelpers.php");
require_once("../../UserController.php");
$userController = UserController::getInstance();

// Getting POST variables
$ny_bruker_navn = $_POST["fornavn"];
$ny_bruker_etternavn = $_POST["etternavn"];

if ($ny_bruker_navn == "Harald"){
    if ($ny_bruker_etternavn == "Tandberg"){
        $ny_bruker_navn = $ny_bruker_navn . " T.";
    }else {
        $ny_bruker_navn = $ny_bruker_navn . " L.";
    }
}

$mailMeld = "Det er blitt laget en ny bruker ved navn ".$ny_bruker_navn;
mail("gudbrandduff@gmail.com", "Ny bruker", $mailMeld);
mail("eivindmbakke@gmail.com", "Ny bruker", $mailMeld);

$ny_bruker_farge = $_POST["farge"];
$ny_bruker_epost = $_POST["epost"];
$ny_bruker_passord = $_POST["passord"];
$ny_bruker_profilbilde = $_POST["profilbilde"];

// Hashing password
$ny_bruker_hashed_passord = password_hash($ny_bruker_passord, PASSWORD_DEFAULT);
// Checking for existing user
$existing_user = $userController->getUserByName($ny_bruker_navn);
if ($existing_user) {
    $_SESSION["feil"] = true;
    $_SESSION["klarert"] = true; //for å komme forbi quizen
    header("Location: /nybruker/");
} else {
    $additionSuccessful = $userController->addUser($ny_bruker_navn, $ny_bruker_etternavn, $ny_bruker_hashed_passord, $ny_bruker_epost, $ny_bruker_profilbilde, $ny_bruker_farge);
    if ($additionSuccessful) {
        $user = $userController->getUserByName($ny_bruker_navn);
        $_SESSION["feil"] = false;
        $_SESSION["klarert"] = true;
        $_SESSION["loggedIn"] = true;
        $_SESSION["brukernavn"] = (string)$user["NAVN"];
        $_SESSION["farge"] = (string)$user["FARGE"];
        $_SESSION["bilde"] = (string)$user["BILDE"];

        header("Location: /");
    }
    else {
        echo "Noe gikk galt i lagringen.. Internal server error?";
    }
}
?>
