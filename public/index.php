<?php
if(!isset($_SESSION)) {
	session_start(); 		// nødvendig for å ha tilgang til $_SESSION variablen
}
ob_start(); //hvorfor må vi egentlig drive med sånn derre output buffering..?

include('../external/logger/Logger.php');
Logger::configure('../loggerConfig.xml');
$logger = Logger::getLogger("main");

//toggle denne for å vise/skjule feil
ini_set('display_errors', 1);

?>

    <!--
    index.php

    Fungerer som en controller som dirigerer brukeren til den siden han/hun vil.
    Hvis brukeren er logget inn går vi til hjemmesiden. Hvis ikke går vi til innlogging.
    Ellers brukes også denne siden til å dirigere basert på hva som finnes i $_GET variablen.
    Kaller render-funksjonen som er fra helpers.php. render tar inn en optional array med
    data til siden som skal rendres (for eksempel tittel). Denne arrayen har render() funksjonen
    tilgang til via en variabel $data.
    -->

<?php
require_once("renderHelpers.php");

// Avbryt og vis countdown.php hvis det er før releasedate
date_default_timezone_set("Europe/Oslo");
$today = time();
$releaseDate = strtotime("1/1/2015 12:00:00");

if (($releaseDate - $today) > 0){

    render("views/templates/simple_header", Array("title"=>"ASPERØY"));
    render("views/countdown");
    render("views/templates/footer", Array("title"=>"ASPERØY"));

}

// Ellers diriger til siden som skal vises
else {
    $requestURI = explode("/", $_SERVER["REQUEST_URI"]);
    $fullphpdir = getcwd();

    if (isset($_GET["logoff"])){
        $_SESSION["loggedIn"] = null;
    }

    if (isset($_GET["page"]) && $_GET["page"] == "nybruker"){
        render($fullphpdir . "/views/nybruker");
    }

    else {

        if (isset($_SESSION["loggedIn"])){ //redirect to homepage

            $page = null;
            $subNavigation = [];

            try {
		//NOTICE: UNDEFINED OFFSET: 3
                $page = $requestURI[3] ? $requestURI[3] : "hjem";
		//NOTICE: UNDEFINED OFFSET: 4
                $subNavigation = $requestURI[4] ? array_slice($requestURI, 4, count($requestURI) - 1) : null;
            } catch (Exception $e) {
                $logger->info("Something went wrong in the explosion, here's the output: " . $e->getMessage());
            }

            switch ($page){
                case "hjem":
                    renderHeaderWithTitle("ASPERØY");
                    render($fullphpdir . "/views/hjem");
                    break;

                case "bilder":
                    renderHeaderWithTitle("ASPERØY - BILDER");

                    if ($subNavigation[1]) {
                        $bildeNavn = $subNavigation[1];
                        $albumNavn = $subNavigation[0];

                        render($fullphpdir . "/views/galleri", Array("album" => $albumNavn, "bilde" => $bildeNavn));

                    } else if ($subNavigation[0]) {
                        $albumNavn = $subNavigation[0];

                        render($fullphpdir . "/views/albumoversikt", Array("album" => $albumNavn));

                    } else {
                        render($fullphpdir . "/views/bilder");
                    }
                    break;

                case "kalender":
                    renderHeaderWithTitle("ASPERØY - KALENDER");
                    render($fullphpdir . "/views/kalender");
                    break;

                case "prosjekter":
                    renderHeaderWithTitle("ASPERØY - PROSJEKTER");
                    render($fullphpdir . "/views/prosjekter");
                    break;

                case "ressurser":
                    renderHeaderWithTitle("ASPERØY - RESSURSER");
                    render($fullphpdir . "/views/ressurser");
                    break;
            }
            render($fullphpdir . "/views/templates/footer");
        }

        else {
            header("Location: /login/");
//            render($fullphpdir . "/views/login");

        }
    }
}
?>