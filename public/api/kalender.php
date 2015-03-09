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

require_once("../../KalenderController.php");
$kalenderController = KalenderController::getInstance();

if (!isset($_SESSION["loggedIn"])) {
    header("HTTP/1.1 400 No user logged in");
    exit();
}
if (isset($_POST["deleteId"])) {
    $deleteSuccess = $kalenderController->deleteEventById($_POST["deleteId"], $_SESSION["brukernavn"]);

    if (!$deleteSuccess) {
        header("HTTP/1.1 500 delete fail");
        exit();
    }
    echo $deleteSuccess;
    header("HTTP/1.1 200 Event Deleted");
    exit();
}
if (!isset($_POST["nyEvent"])) {
    header("HTTP/1.1 400 No event passed");
    exit();
} else {
    $nyEventJSON = $_POST["nyEvent"];
    $newEventObj = json_decode($nyEventJSON);
    $eventId = $kalenderController->addEvent($newEventObj->title, $newEventObj->start, $newEventObj->end, $_SESSION["brukernavn"]);
    echo $eventId;
}
?>