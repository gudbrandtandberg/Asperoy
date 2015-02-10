<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 1/26/15
 * Time: 12:20 AM
 */

if (!isset($_SESSION))
{
    session_start();
}
require_once("../helpers.php");

if (!isset($_SESSION["loggedIn"])) {
    echo "Please log in to create new events";
} elseif (!isset($_POST["nyEvent"])) {
    echo "No event passed";
} else {
    $nyEventJSON = $_POST["nyEvent"];

    $eventsJSONstring = json_encode($nyEventJSON);

    file_put_contents("../model/events.json", $eventsJSONstring);

    echo $nyEventJSON;
}
?>