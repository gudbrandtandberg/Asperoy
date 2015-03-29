<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
<span class="glyphicon glyphicon-home"></span>
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>

<!-- navbar på toppen av albumoversikten -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"><a href='/bilder/'>&larr; Album</a></td>
        <td class="navitem2"><h3><?=$album["NAVN"];?></h3></td>
        <td class="navitem3"><a href='/hjem/'>Legg til +</a></td>
    </tr>
</table>

<!-- Grid med thumbnails av alle bildene i album -->
<?php foreach ($images as $image): ?>
    <?php $impath = "/resources/bilder/".$album["NAVN"]."/".$image["FIL"]; ?>
    <div class="col-xs-6 col-md-3">
        <a class="tommel" href='<?="/bilder/" . $album["ID"] . "/" . $image["FIL"];?>'>
            <div class="tommelbildebeholder" style="background-image: url('<?=$impath;?>');"></div>
        </a>
    </div>         
<?php endforeach; ?>
