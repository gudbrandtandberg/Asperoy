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
    
    function renderEmail($name, $data = Array()){
        extract($data);
        return include($name.".php");
    }

    function renderHeaderWithTitle($title) {
        render("views/templates/header", Array("title"=>$title));
    }

    function renderFooter() {
        render("views/templates/footer");
    }
    
    function renderNewsItem($item){
        return 
        '<div class="newsitem">
	    <div class="newsheader col-sm-12">
		<div class="col-sm-1" style="margin-left: 0; padding-left: 0; padding-right: 0; margin-right: 0;">
		    <img src="'.file_get_contents('../resources/images/users/'.$item["creator"]).'"/>
		</div>
		<div class="col-sm-11 newstitle">
		    <h3>
			'.$item["title"].'
		    </h3>
		    <span class="newsdate">'.$item["date"].'</span>
		</div>
	    </div>
		'.wrapParagraphs($item["text"]).'
	</div>';
    }
    
    function wrapParagraphs($text){
        $html = "";
        foreach (explode("\n\n", $text) as $par){
            $html .= "<p>".$par."</p>";
        }
        return $html;
    }
?>