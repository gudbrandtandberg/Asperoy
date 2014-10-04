<?php
    function render($name, $data = Array()){
        
        extract($data);
        include("views/".$name.".php");
        
    }
?>