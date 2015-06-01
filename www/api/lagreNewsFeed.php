<?php
    if (!isset($_SESSION)){session_start();}
    require("../renderHelpers.php");
    
    extract($_POST);
    $date = str_replace("/", ".", $date);
    $newNewsItem = Array("title" => $title, "creator" => $_SESSION["brukernavn"], "date" => $date, "text" => $text);
    addNewsItem($newNewsItem);
    echo renderNewsItem($newNewsItem);
    
    
    //kan kanskje legges et annet sted etterhvert, og evt. bruke JSONcrud
    function addNewsItem($item){
        $items = json_decode(file_get_contents("../../model/newsfeed.json"), $assoc=true);
        array_push($items, $item);
        file_put_contents("../../model/newsfeed.json", json_encode($items));
    }
?>