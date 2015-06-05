<?php

    include("../../JSON_CRUD.php");
    extract($_POST);
    
    $items = json_decode(file_get_contents("../../model/newsfeed.json"), $assoc=true);
    
    $index = 0;
    foreach ($items as $item){
        if ($item["id"] == $id){
            break;
        }
        $index++;
    }
    array_splice($items, $index, 1);
    
    file_put_contents("../../model/newsfeed.json", json_encode($items));  

?>