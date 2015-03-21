<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<link rel="stylesheet" type="text/css" href="/styles/galleriStyle.css"/>

<table class='subnavbar'>
    <tr>
        <td class="navitem1"><a href='/bilder/'>Album</a></td>
        <td class="navitem2"><h3><?=$album["NAVN"];?></h3></td>
        <td class="navitem3"><a href='/hjem/'>Legg til +</a></td>
    </tr>
</table>

<!-- Grid med thumbnails av alle bildene i album -->

<?php foreach ($images as $image): ?>
    <?php $impath = "/resources/bilder/".$album["NAVN"]."/".$image["FIL"]; ?>
    <div class='col-xs-6 col-md-3 beholder'>
        <a class='tommel' href='<?="/bilder/" . $album["ID"] . "/" . $image["FIL"];?>'>
            <img class='tommelbilde' src='<?=$impath;?>'>
        </a>
    </div>         
<?php endforeach; ?>
