<?php
    if (!isset($_SESSION)){session_start();}
    header("Content-type: application/json"); //dette er litt mislykket..
    
    //hent nødvendig data
    $json = json_decode(file_get_contents("../../model/soppelpoll.json"));
    $return = Array("success" => 0, "brukernavn" => "");
    $username = $_SESSION["brukernavn"];
    
    //lagre ny søppelplukker hvis ikke finnes allerede
    if (!in_array($username, $json)){
        array_push($json, $username);
        if (file_put_contents("../../model/soppelpoll.json", json_encode($json))){
            $return["success"] = 1;
            $return["brukernavn"] = $username;
            $return["imageurl"] = file_get_contents("../resources/images/users/".$username);
        }
    }
    
    //send json-info tilbake til hjem.js
    print_r(json_encode($return));
?>