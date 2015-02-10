<?php
if(!isset($_SESSION)) {
	session_start(); 		// nødvendig for å ha tilgang til $_SESSION variablen
}
ob_start();				// MÅ komme først
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
require_once("helpers.php");

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
else{
    if (isset($_GET["logoff"])){
        $_SESSION["loggedIn"] = null;
    }

    if (isset($_GET["page"]) && $_GET["page"] == "nybruker"){
        render("views/nybruker");
    }
    else{
        if (isset($_SESSION["loggedIn"])){ //redirect to homepage

            if (isset($_GET["page"])){ //første gang går vi alltid hjem
                $page = $_GET["page"];
            }
            else{
                $page = "hjem";
            }

            switch ($page){
                case "hjem":

                    render("views/templates/header", Array("title"=>"ASPERØY"));
                    render("views/hjem");
                    render("views/templates/footer");
                    break;

                case "bilder":

                    render("views/templates/header", Array("title" => "ASPERØY - BILDER"));
                    render("views/bilder");
                    render("views/templates/footer");
                    break;

                case "albumoversikt":

                    render("views/templates/header", Array("title" => "ASPERØY - BILDER",));
                    render("views/albumoversikt", Array("album" => $_GET["album"]));
                    render("views/templates/footer");
                    break;

                case "galleri":
                    render("views/templates/header", Array("title" => "ASPERØY - BILDER"));
                    render("views/galleri", Array("title" => "ASPREØY - BILDER", "album" => $_GET["album"], "bilde" => $_GET["bilde"]));
                    render("views/templates/footer");
                    break;

                case "kalender":

                    render("views/templates/header", Array("title" => "ASPERØY - KALENDER"));
                    render("views/kalender");
                    render("views/templates/footer");
                    break;

                case "prosjekter":

                    render("views/templates/header", Array("title" => "ASPERØY - PROSJEKTER"));
                    render("views/prosjekter");
                    render("views/templates/footer");
                    break;

                case "ressurser":

                    render("views/templates/header", Array("title" => "ASPERØY - RESSURSER"));
                    render("views/ressurser");
                    render("views/templates/footer");
                    break;
            }
        }

        else{

            render("views/login");

        }
    }
}
?>