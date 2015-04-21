<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>
<script type="text/javascript" src="/js/JIC.js"></script>
<script type="text/javascript">
    
    var antallFiler = 0;
    var alleFiler = [];
    var alleFilnavn = [];
    
    function dataURItoBlob(dataURI) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);
    
        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    
        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
    
        return new Blob([ia], {type:mimeString});
    }
    function handleFileSelect(evt) {
        var files = evt.target.files;
        
        for (var i = 0, f; f = files[i]; i++) {
            
            if (!f.type.match('image.*')) {
              continue;
            }
            
            var dataURL = "";
            
            if (f.size > 500000) {
                //komprimer
                //MEN DETTE ER FOR DÅRLIG KOMPRESJON.
                //HAR IKKE NØYAKTIG KONTROLL PÅ RESULTATSTR. VIRKER DET SOM.. 
                var img = document.getElementById("tmpimg");
                reader = new FileReader();
                
                reader.onload = function(e){
                    img.src = e.target.result;
                    dataURL = jic.compress(img, 100 - ((600000 / e.target.result.length) * 100)).src;
                    alleFiler.push(dataURItoBlob(dataURL));
                    console.log("original str: " + e.target.result.length);
                    console.log("ny str: " + dataURL.length);
                };
                reader.readAsDataURL(f);
            }
            else {
                reader = new FileReader();
                reader.onload = function(e){
                    dataURL = e.target.result;
                    alleFiler.push(dataURItoBlob(dataURL));
                };
                reader.readAsDataURL(f);   
            }
            alleFilnavn.push(f.name.replaceAll("\\s+",""));
            antallFiler++;
        }
        
        $("#leggtilfelt").css({display: "block"});
        
        if (antallFiler > 1) {
            document.getElementById("opplastningstekst").innerHTML = "Du har valgt <b>"+antallFiler+"</b> bilder";
        } else {
            document.getElementById("opplastningstekst").innerHTML = "Du har valgt <b>"+antallFiler+"</b> bilde";
        }
    }
    
    $(document).ready(function(){
        
        var album = "<?=$album["NAVN"];?>";
        
        document.getElementById("files").addEventListener("change", handleFileSelect, false);
        
        $("#leggtilknapp").click(function(e){
            e.preventDefault();
            document.getElementById("files").click();
            
        });
        
        $("#lastoppknapp").click(function(e){
            
            // går igjennom alleFilene, laster hver blob over i et formdata-objekt og
            // sender et ajax-request til lagrebilder.php
            
            var formdata = false;        
            if (window.FormData) {
                formdata = new FormData();
            }else {
                alert("Kan ikke laste opp bildene fordi du bruker en utdatert nettleser! Skjerpings");
            }
            
            console.log(alleFiler);
            for (var i = 0, f; f = alleFiler[i]; i++) {
                formdata.append("file"+i, f, alleFilnavn[i]);
            }
            
            if (formdata) {
                $.ajax({
                    url: "/api/lagreBilde.php?album="+album,
                    type: "POST",
                    data: formdata,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(tilbakemelding) {
                        
                        console.log($(".col-xs-6:last.col-md-3:last"));
                        
                        antallFiler = 0;
                        alleFiler = [];
                        
                        $(".col-xs-6.col-md-3").last().after(tilbakemelding.html);
                        $("#leggtilfelt").css({display: "none"});
                        
                    },       
                    error: function(res) {
        
                    }       
                });
            }
        });
    });
  
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
                <img style="display: none;" id="tmpimg" src=""/>
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
