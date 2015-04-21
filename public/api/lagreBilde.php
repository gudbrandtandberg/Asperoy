<?php
    $album = $_GET["album"];
    $target_dir = "../resources/bilder/".$album."/";
//    print_r($_FILES);
//    echo "Du vil laste opp ".count($_FILES)." filer til ".$album;
    
    for ($i = 0; $i < count($_FILES); $i++){
        $filename = "file".$i;
        $target_file = $target_dir.basename($_FILES[$filename]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        //check if error
        if ($_FILES[$filename]["error"]){
            echo "filen er nok for stor\n";
            $uploadOk = 0;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Filen finnes\n";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if (!$uploadOk) {
            echo "Noe gikk galt";
        
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
                echo "The file ". basename($_FILES[$filename]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>