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

if (isset($_GET["ordered"])) {
    header("HTTP/1.1 200");
    echo $kalenderController->getAllEventsAsJsonSorted();
    exit();
}

if (isset($_POST["deleteId"])) {

    try {
        $deleteSuccess = $kalenderController->deleteEventById($_POST["deleteId"], $_SESSION["brukernavn"]);
        header("HTTP/1.1 200 Event Deleted");
        echo $deleteSuccess;
        exit();
    } catch (CRUD_Exception $e) {
        header("HTTP/1.1 404 Event not found");
        exit();
    } catch (AuthException $e) {
        header("HTTP/1.1 403 User not authorized");
        exit();
    } catch (Exception $e) {
        header("HTTP/1.1 500 Delete failed");
        exit();
    }
}
if (isset($_POST["nyEvent"])) {
    $nyEventJSON = $_POST["nyEvent"];
    $newEventObj = json_decode($nyEventJSON);
    $eventJSON = $kalenderController->addEvent($newEventObj->title, $newEventObj->start, $newEventObj->end, $_SESSION["brukernavn"], $_SESSION["farge"], $newEventObj->details);

    if (!$eventJSON) {
        header("HTTP/1.1 500 creation fail");
        exit();
    }
    header("HTTP/1.1 200 Event Created");
    echo $eventJSON;
    exit();
}

if (isset($_POST["oppdatertEvent"])) {
    $oppdatertEventJSON = $_POST["oppdatertEvent"];

    try {
        $updateSuccess = $kalenderController->updateEvent($oppdatertEventJSON, $_SESSION["brukernavn"]);
        header("HTTP/1.1 200 Event Updated");
        echo $updateSuccess;
        exit();
    } catch (CRUD_Exception $e) {
        header("HTTP/1.1 404 Event not found");
        exit();
    } catch (AuthException $e) {
        header("HTTP/1.1 403 User not authorized");
        exit();
    } catch (Exception $e) {
        header("HTTP/1.1 500 Delete failed");
        exit();
    }
}
?>