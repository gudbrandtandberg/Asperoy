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
        //style="display: none;"
        $close = "";
        $image = "";
        if ($item["creator"] == $_SESSION["brukernavn"]){
            $close='<span data-toggle="tooltip" title="Slett nyhetsartikkel" style="display: none;" class="close slettnewsitem">&times;</span>';
        }
        if (isset($item["image"])){
            $image = '<img class="newsimage" src="/resources/images/news/'.$item["image"].'" />';
        }
        
        return 
        '<div class="newsitem" id="'.$item["id"].'">
	    <div class="newsheader col-xs-12">
                <div style="float: left;">
		    <img src="'.file_get_contents('../resources/images/users/'.$item["creator"]).'"/>
		</div>
		<div style="float: left;" class="newstitle">
		    <h3>
			'.$item["title"].'
		    
                    </h3>
                    
		    <span class="newsdate">'.$item["date"].'</span>
		</div>'.$close.'
	    </div>
		'.wrapParagraphs($item["text"]).$image.'
	</div>';
    }
    
    function wrapParagraphs($text){
        $html = "";
        foreach (explode("\n\n", $text) as $par){
            $html .= "<p>".$par."</p>";
        }
        return $html;
    }
    
    function renderComment($kommentar, $dato, $navn, $id){
        $close = "";
        if ($navn == $_SESSION["brukernavn"]){
            $close = '<span data-toggle="tooltip" class="close slettkommentar" style="display: none;" title="Slett kommentar">&times;</span>';
        }
        return
        '<tr class="kommentar" id="'.$id.'">
            <td class="kommentarbilde">
                <img class="profilbilde" src="'.file_get_contents("../resources/images/users/".$navn).'" width="50" height="50" alt="Brukerbilde">
            </td>
            
            <td class="kommentarinnhold">
                <span class="kommentator">'.$navn.'</span>
                <span class="kommentartekst">'.$kommentar.'</span>
                <div class="kommentarinfo">
                    <span class="dato">'.$dato.'</span>
                    '.$close.'
                </div>
            </td>
        </tr>';
    }
?>