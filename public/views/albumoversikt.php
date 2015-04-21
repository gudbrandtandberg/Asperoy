<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>

<script type="text/javascript">
    $(document).ready(function(){
        
        var album = "<?=$album["NAVN"];?>";
        
        document.getElementById("files").addEventListener("change", handleFileSelect, false);
        
        $("#leggtilknapp").click(function(e){
            e.preventDefault();
            document.getElementById("files").click();
            
        });
        
        $("#lastoppknapp").click(function(e){
            
            // går igjennom alleFilene, laster hver fil over i formdata-objekt og
            // sender et ajax-request til lagrebilder.php
            
            var formdata = false;        
            if (window.FormData) {
                formdata = new FormData();
            }
            console.log(alleFiler.length);
            for (var i = 0, f; f = alleFiler[i]; i++) {
                formdata.append("file"+i, f);
            }
            
            if (formdata) {
                $.ajax({
                    url: "/api/lagreBilde.php?album="+album,
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        document.getElementById("respons").innerHTML = res;
                        antallFiler = 0;
                        alleFiler = [];
                        document.getElementById("opplastningstekst").innerHTML = "Opplastning vellykket!";
                    },       
                    error: function(res) {
        
                    }       
                });
            }
                            
            
        });
    
    });
    
    var antallFiler = 0;
    var alleFiler = [];
    
    function handleFileSelect(evt) {
        var files = evt.target.files;
    
        // files is a FileList of File objects.
        for (var i = 0, f; f = files[i]; i++) {
            // Only process image files.
            if (!f.type.match('image.*')) {
              continue;
            }
            antallFiler++;
            alleFiler.push(f);
        }
        
        $("#leggtilfelt").css({display: "block"});
        if (antallFiler > 1) {
            document.getElementById("opplastningstekst").innerHTML = "Du har valgt <b>"+antallFiler+"</b> bilder";
        } else {
            document.getElementById("opplastningstekst").innerHTML = "Du har valgt <b>"+antallFiler+"</b> bilde";
        }
    }
    
    function loadFile(f){
        //console.log(f.target.result);
        //console.log(f.target.size);
    }
  
</script>

<!-- navbar på toppen av albumoversikten -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"><a href='/bilder/'>&larr; Album</a></td>
        <td class="navitem2"><h3><?=$album["NAVN"];?></h3></td>
        <td class="navitem3">
            <form enctype="multipart/form-data">
                <a id="leggtilknapp" href='#'>Legg til +</a>
                <div style="display: none;"><input id="files" type="file" name="files[]" multiple /></div>
            </form>
        </td>
    </tr>
</table>

<div id="respons"></div>
<div id="leggtilfelt" style="display: none;">
    <span id="opplastningstekst"></span>
    <button class="btn btn-default" id="lastoppknapp">Last opp bilder</button>
</div>

<!-- Grid med thumbnails av alle bildene i album -->
<?php foreach ($images as $image): ?>
    <?php $impath = "/resources/bilder/".$album["NAVN"]."/".$image["FIL"]; ?>
    <div class="col-xs-6 col-md-3">
        <a class="tommel" href='<?="/bilder/" . $album["ID"] . "/" . $image["FIL"];?>'>
            <div class="tommelbildebeholder" style="background-image: url('<?=$impath;?>');"></div>
        </a>
    </div>         
<?php endforeach; ?>
