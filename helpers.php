<!--
render(name, data) er pussig nok renderingfunksjonen i siden vår. Den kalles av controlleren (index.php)
når den skal fylle en template og vise den frem.

name: filen som skal vises
data: informasjon som sendes til $name (optional)

-->

<?php
    function render($name, $data = Array()){
        
        extract($data);
        include("views/".$name.".php");
        
    }
?>