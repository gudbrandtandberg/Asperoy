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
require_once("../helpers.php");

// Getting POST variables
$ny_bruker_navn = $_POST["brukernavn"];
$ny_bruker_epost = $_POST["epost"];
$ny_bruker_passord = $_POST["passord"];

// Hashing password

$ny_bruker_hashed_passord = password_hash($ny_bruker_passord, PASSWORD_DEFAULT);


// Getting users xml
$users_XML = simplexml_load_file("../model/users.xml");
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

    $users_XML->asXML("../model/users.xml");
    $_SESSION["loggedIn"] = true;
    $_SESSION["brukernavn"] = $_POST["brukernavn"];

    header("Location: /~eivindbakke/Asperoy/");
}
?>