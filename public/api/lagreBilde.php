<?php
    $album = $_GET["album"];
    $target_dir = "../resources/bilder/".$album."/";
//    print_r($_FILES);
//    echo "Du vil laste opp ".count($_FILES)." filer til ".$album;
    
    //Diverse feilmeldinger som sendes tilbake til albumoversikt
    $tilbakemelding = Array("forstor" => 0, "lastetopp" => 0, "finnes" => 0, "opplastningsfeil" => 0, "lagret" => 0, "html" => "");
    $allehtmlThumbnails = "";
    
    for ($i = 0; $i < count($_FILES); $i++){
        
        $filename = "file".$i; //vilkåerlig navn satt i javascript
        $target_file = $target_dir.basename($_FILES[$filename]["name"]);
        
        $uploadOk = 1;
        
        //check if error (typisk fordi for stor fil for php - bør ikke skje pga kompresjonen)
        if ($_FILES[$filename]["error"]){
            $tilbakemelding["forstor"]++;
            $uploadOk = 0;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $tilbakemelding["finnes"]++;
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk) {
            if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
        
                $tilbakemelding["lastetopp"]++;
                
                // nå er filen flyttet, nå må bare bildet lagres i bilder.xml
                require_once("../../BildeController.php");
                
                $bildeController = BildeController::getInstance();
                if ($bildeController->addImageToAlbum($_FILES[$filename]["name"], $album)){
                    $tilbakemelding["lagret"]++;
                    $filnavn = str_replace(' ', '', $_FILES[$filename]["name"]);
                    $albumID = str_replace(' ', '', $album);
                    $href = "/bilder/" . $albumID . "/" . $_FILES[$filename]["name"];
                    $impath = "/resources/bilder/" . $album . "/" . $_FILES[$filename]["name"];
                    $htmlString = '<div class="col-xs-6 col-md-3"><a class="tommel" href="'.$href.'"><div class="tommelbildebeholder" style="background-image: url('."'".$impath."'".');"></div></a></div>';
                    
                    $allehtmlThumbnails .= $htmlString;
                    
                }
                else {
                    
                }
                
            } else {
                $tilbakemelding["opplastningsfeil"]++;
                
            }
        }
        else {
            
        }
    }
    $tilbakemelding["html"] = $allehtmlThumbnails;
    print(json_encode($tilbakemelding));
?>