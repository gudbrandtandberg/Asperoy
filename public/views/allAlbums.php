<?php
/*
 */
?>

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>
<script type="text/javascript">
    
$(document).ready(function(){
    
    $("#avbrytknapp").click(function(e){
        e.preventDefault();
        $("#modalBubble").css({display: "none"});  
    });

    $("#lagnyknapp").click(function(event){
        event.preventDefault();
 
        var albumnavn = $("#albumnavn").val();
        
        console.log(event);
        
        $.ajax({url: "../api/lagreAlbum.php?albumnavn="+albumnavn,
               success: function(data){
                $("#allealbumbeholder").append(data);
                $("#modalBubble").css({display: "none"}); 
               }
        });
        
    })
    
    $("#nyttalbumlink").click(function(e){
        e.preventDefault();
        $("#modalBubble").css({display: "block"});    
    });
    
});
    
    
</script>
<!--Thumbnail Image View -->

<!-- en navigationbar -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"></td>
        <td class="navitem2"><h3>Album</h3></td>
        <td class="navitem3"><a id="nyttalbumlink" href="#";>Legg til +</a></td>
    </tr>
</table>
<div id="modalBubble" style="display: none;">
    <!--style="display: none;-->
    <form id="albumnavnform">
        <table>
            <th colspan="2" style="text-align: center">
                <label>Albumnavn:</label>
            </th>
            <tbody>
                <tr>
                    <td colspan="2"><input id="albumnavn" type="text" name="albumnavn"></td>
                </tr>
                <tr>
                    <td><input type="button" name="avbryt" value="Avbryt" id="avbrytknapp"></td>
                    <td><input type="button" name="lagnyttalbum" value="Lag album" id="lagnyknapp"></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<!-- grid med thumbnails over alle albumene -->

<div id="allealbumbeholder">
<?php foreach ($album as $a): ?>
    <?php
    $albumnavn = $a["NAVN"];
    $albumid = $a["ID"];
    $coverphotopath = "/resources/bilder/".$albumnavn."/".$a->BILDE[0][@FIL];
    ?>
    <div class='col-xs-6 col-md-3 tommel'>
        <a class="tommel" href="<?=$albumid;?>">
            <div class="tommelbildebeholder">
                <img class="tommelbilde" src="<?=$coverphotopath;?>">
            </div>
            <div class="tommelcaption"><?=$albumnavn;?></div>
        </a>
    </div>
<?php endforeach; ?>
</div>