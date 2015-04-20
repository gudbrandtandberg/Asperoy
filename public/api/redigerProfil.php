<?php
    if (!isset($_SESSION)){session_start();}
    ob_start();
    
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
        header("Location: /profil/");
    }
    if ($farge != "" and $image != "") {
        file_put_contents("../resources/images/users/" . $firstName, $image);
        //lagre farge!
        
        $_SESSION["profilendret"] = true;
        header("Location: /profil/");
    }
?>