<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>
<script type="text/javascript">
    function lagNyttAlbum(event){
        event.preventDefault();

        var albumnavn = $("#albumnavn").val();            
        $("#lagnyknapp").html("Lager album <img src='/resources/images/progress.gif' width='15' height='15' />");
        
        $.ajax({url: "../api/lagreAlbum.php?albumnavn="+albumnavn,
               success: function(data){
                    $("#lagnyknapp").html("Lag album");
                    $("#lagnyknapp").on("click", lagNyttAlbum);
                    $("#albumnavn").val("");
                    if (data.trim() == "FINNES") {
                        alert("Det finnes allerede et album med det navnet. Velg et annet.");
                    }
                    else {
                        $("#allealbumbeholder").append(data);
                        $("#modalBubble").css({display: "none"});
                    }
               }
        });
    }
    
    $(document).ready(function(){
        
        $("#avbrytknapp").click(function(e){
            e.preventDefault();
            $("#modalBubble").css({display: "none"});  
        });
    
        $("#lagnyknapp").click(lagNyttAlbum);
        
        $("#albumnavn").keyup(function(e) {
            e.preventDefault();
            if (e.which === 13) {
               $("#lagnyknapp").click();
            }
         }); 
        
        $("#nyttalbumlink").click(function(e){
            e.preventDefault();
            $("#modalBubble").css({display: "inline-block"});
            $("#albumnavn").focus();
        });
        
    });
</script>

<!-- en navigationbar -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"></td>
        <td class="navitem2"><h3>Album</h3></td>
        <td class="navitem3"><a id="nyttalbumlink" href="#";>Legg til +</a></td>
    </tr>
</table>

<!-- en i utgangspunktet usynlig modal popup -->
<div id="modalBubble" style="display: none;">
    <span id="avbrytknapp" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
    <label>Albumnavn:</label>
    <input id="albumnavn" type="text" name="albumnavn">
    <button type="button" id="lagnyknapp" class="btn btn-default">Lag album</button>
</div>

<!-- grid med thumbnails av alle albumene -->
<div id="allealbumbeholder">
    <?php foreach ($album as $a): ?>
        <?php
        $albumnavn = $a["NAVN"];
        $albumid = $a["ID"];
        $coverphotopath = "/resources/bilder/".$albumnavn."/".$a->BILDE[0][@FIL];
        if ($coverphotopath == "/resources/bilder/".$albumnavn."/"){ //albumet er tomt
            $coverphotopath = "/resources/images/album_placeholder_text.png";
        }
        ?>
    
        <div class='col-xs-6 col-md-3'>
            <a class="tommel" href="<?=$albumid;?>">
                <div class="tommelbildebeholder" style="background-image: url('<?=$coverphotopath;?>');"></div>
                <div class="tommelcaption"><?=$albumnavn;?></div>
            </a>
        </div>
    <?php endforeach; ?>
</div>