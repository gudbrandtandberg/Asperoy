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

    if (isset($_POST["lagnybruker"])) {
        // Getting POST variables
        $ny_bruker_navn = $_POST["brukernavn"];
        $ny_bruker_epost = $_POST["epost"];
        $ny_bruker_passord = $_POST["passord"];

        // Hashing password
	
        $ny_bruker_hashed_passord = password_hash($ny_bruker_passord, PASSWORD_DEFAULT);


        // Getting users xml
        $users_XML = simplexml_load_file("model/users.xml");
        $users_node = $users_XML->xpath("//USERS");

        // Checking for existing user with that name
	// her sier den også 'notice: undefined offset: 0' sjekk om ikke tom.
        $existing_user_name = $users_XML->xpath("//USER[@NAVN='{$ny_bruker_navn}']")[0]["NAVN"];

        if ($existing_user_name) {
            echo "Det finnes en bruker med det navnet. Ta et annet!";
        } else {
            // Saving new user
            $new_user_xml_node = $users_node[0]->addChild("USER");
            $new_user_xml_node->addAttribute("NAVN", $ny_bruker_navn);
            $new_user_xml_node->addAttribute("PASSORD", $ny_bruker_hashed_passord);
            $new_user_xml_node->addAttribute("EPOST", $ny_bruker_epost);

            $users_XML->asXML("model/users.xml");
        }
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