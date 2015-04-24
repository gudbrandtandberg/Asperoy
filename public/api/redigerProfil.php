<?php
    if (!isset($_SESSION)){session_start();}
    ob_start();
    
    require_once("../../UserController.php");
    $userController = UserController::getInstance();
    
    $firstName = $_SESSION["brukernavn"];
    $image = $_POST["profilbilde"];
    $farge = $_POST["farge"];
    
    if ($farge == "" and $image != ""){
        file_put_contents("../resources/images/users/" . $firstName, $image);
        $_SESSION["profilendret"] = true;
        header("Location: /profil/");
    }
    if ($image == "" and $farge != ""){
        //lagre farge!
        $_SESSION["profilendret"] = true;
        $userController->setUserColor($firstName, $farge);
        $_SESSION["farge"] = $farge;
        header("Location: /profil/");
    }
    if ($farge != "" and $image != "") {
        file_put_contents("../resources/images/users/" . $firstName, $image);
        //lagre farge!
        
        $userController->setUserColor($firstName, $farge);
        $_SESSION["farge"] = $farge;
        
        $_SESSION["profilendret"] = true;
        header("Location: /profil/");
    }
?>