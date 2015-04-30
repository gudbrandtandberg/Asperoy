<?php
if(!isset($_SESSION)) {session_start();}
ob_start();
//
//include('../external/logger/Logger.php');
//Logger::configure('../loggerConfig.xml');
//$logger = Logger::getLogger("main");
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
require_once("renderHelpers.php");

if (isset($_GET["logoff"])){
    $_SESSION["loggedIn"] = null;
}
?>

<!--
index.php

Fungerer som en controller som dirigerer brukeren til den siden han/hun vil.
Hvis brukeren er logget inn går vi til hjemmesiden. Hvis ikke går vi til innlogging.
-->

<?php
// Avbryt og vis countdown.php hvis det er før releasedate
date_default_timezone_set("Europe/Oslo");
$today = time();
$releaseDate = strtotime("5/1/2015 12:00:00");

if (($releaseDate - $today) > 0){

    render("views/templates/simple_header", Array("title"=>"ASPERØY"));
    render("views/countdown");
    render("views/templates/footer", Array("title"=>"ASPERØY"));

}

// Ellers diriger til siden som skal vises
else {

    if (isset($_GET["page"]) && $_GET["page"] == "nybruker"){
	$_SESSION["klarert"] = false;
        header("Location: /nybruker/");
    }
    
    else {
        if (isset($_SESSION["loggedIn"])){ //redirect to homepage
            header("Location: /hjem/");
        } else {
            header("Location: /login/");
        }
    }
}
?>
