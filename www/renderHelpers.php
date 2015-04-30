<?php
  
    /*
     * render(name, data) er pussig nok renderingfunksjonen i siden vår. Den kalles av controlleren (index.php)
     * når den skal fylle en template og vise den frem.
    
     * name: filen som skal vises
     * data: informasjon som sendes til $name (optional)
     * 
     */

    function render($name, $data = Array()){
        
        extract($data);
        include($name.".php");
        
    }

    function renderHeaderWithTitle($title) {
        render("views/templates/header", Array("title"=>$title));
    }

    function renderFooter() {
        render("views/templates/footer");
    }
?>