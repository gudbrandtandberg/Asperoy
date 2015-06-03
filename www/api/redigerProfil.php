<?php
    if (!isset($_SESSION)){session_start();}
    
    require_once("../../UserController.php");
    $userController = UserController::getInstance();
    
    $firstName = $_SESSION["brukernavn"];
    $image = $_POST["profilbilde"];
    $farge = $_POST["farge"];
    
    $success = false;

    if ($image && $image != ""){
        //lagre bilde
        $success = file_put_contents("../resources/images/users/" . $firstName, $image);
    }
    if ($farge && $farge != "") {
        //lagre farge
        $success = $userController->setUserColor($firstName, $farge);
        $_SESSION["farge"] = $farge;
    }
    echo $success;
?>