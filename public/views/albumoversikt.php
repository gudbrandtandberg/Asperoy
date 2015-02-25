<!--
albumoversikt.php

Viser thumbails med alle bildene i et album. 
-->

<table class='navbar'>
    <tr>
        <td class="navitem1"><a href='/bilder/'>Album</a></td>
        <td class="navitem2"><h3><?=$album["NAVN"];?></h3></td>
        <td class="navitem3"><a href='/hjem/'>Legg til +</a></td>
    </tr>
</table>

<!-- Grid med thumbnails av alle bildene i album -->

<?php foreach ($images as $image): ?>
            <?php $impath = "/resources/bilder/".$album["NAVN"]."/".$image["FIL"]; ?>
                <div class='thumbnail'>
                    <a href='<?="/bilder/" . $album["ID"] . "/" . $image["FIL"];?>'>
                        <img class='bilde' src='<?=$impath;?>'>
                    </a>
                </div>         
<?php endforeach; ?>
