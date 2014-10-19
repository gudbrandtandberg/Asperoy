<!--
Funksjon som spytter ut siden i $name med optional parametere fra $data.
-->

<?php
    function render($name, $data = Array()){
        
        extract($data);
        include("views/".$name.".php");
        
    }
?>