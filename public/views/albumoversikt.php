<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>

<script type="text/javascript">
    $(document).ready(function(){
        
        
        $("#leggtilknapp").click(function(e){
            e.preventDefault();
            $("#leggtilfelt").css({display: "block"});
        });
        
        $("#lastoppknapp").click(function(e){
            alert("nå lastes bildene dine opp!");
        });
    });
</script>

<!-- navbar på toppen av albumoversikten -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"><a href='/bilder/'>&larr; Album</a></td>
        <td class="navitem2"><h3><?=$album["NAVN"];?></h3></td>
        <td class="navitem3"><a id="leggtilknapp" href='#'>Legg til +</a></td>
    </tr>
</table>

<div id="leggtilfelt" style="display: none;">
    <span id="opplastningstekst">Du har valgt <b id="antallbilder">1</b> bilder.</span>
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
