<?php
    $album = $_GET["album"];
    $target_dir = "../resources/bilder/".$album."/";
    require_once("../../BildeController.php");
    $bildeController = BildeController::getInstance();
    
    //Diverse feilmeldinger som sendes tilbake til albumoversikt
    $tilbakemelding = Array("forstor" => 0, "lastetopp" => 0, "finnes" => 0,
                            "opplastningsfeil" => 0, "lagret" => 0, "html" => "");
    
    //html'en som skal spyttes ut etter ajax-kallet er ferdig
    $allehtmlThumbnails = "";
    
    for ($i = 0; $i < count($_FILES); $i++){
        
        $filename = "file".$i; //vilkåerlig navn satt i javascript
        $target_file = $target_dir.basename($_FILES[$filename]["name"]);
        
        $uploadOk = true;
        
        //sjekk om for stor fil for php - bør ikke skje pga kompresjonen..
        if ($_FILES[$filename]["error"]){
            $tilbakemelding["forstor"]++;
            continue;
            $uploadOk = false;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $tilbakemelding["finnes"]++;
            continue;
            $uploadOk = false;
        }
        
        //forsøk å laste opp filen
        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
    
            $tilbakemelding["lastetopp"]++;
            
            // nå er filen flyttet, nå må bare bildet lagres i bilder.xml
            if ($bildeController->addImageToAlbum($_FILES[$filename]["name"], $album)){
                //generer html-output
                $tilbakemelding["lagret"]++;
                //$filnavn = str_replace(' ', '', $_FILES[$filename]["name"]);
                $albumID = str_replace(' ', '', $album);
                $href = "/bilder/" . $albumID . "/" . $_FILES[$filename]["name"];
                $impath = "/resources/bilder/" . $album . "/" . $_FILES[$filename]["name"];
                
                $htmlString = '<div class="col-xs-6 col-md-3"><a class="tommel" href="'.$href.'"><div class="tommelbildebeholder" style="background-image: url('."'".$impath."'".');"></div></a></div>';
                
                $allehtmlThumbnails .= $htmlString;
                
            }
            else {
                //håper vi aldri kommer hit!!
            }
            
        } else {
            $tilbakemelding["opplastningsfeil"]++;
        }
    }
    $tilbakemelding["html"] = $allehtmlThumbnails;
    print(json_encode($tilbakemelding));
?>