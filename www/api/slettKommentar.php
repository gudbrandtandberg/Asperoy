<?php

    $kommentarID = $_POST["kommentarID"];
    
    include("../../BildeController.php");
    
    $bildeController = BildeController::getInstance();    
    $bildeController->deleteComment($kommentarID);
    
    echo $kommentarID;   

?>