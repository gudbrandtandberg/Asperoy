<?php
/*
 * hyggelige personlige tittelkommentarer!
 */
?>

<!--Thumbnail Image View -->

<!-- en navigationbar -->
<table class='subnavbar'>
    <tr>
        <td class="navitem1"></td>
        <td class="navitem2"><h3>ALBUM</h3></td>
        <td class="navitem3"><a href='/hjem/'>Legg til +</a></td>
    </tr>
</table>

<!-- grid med thumbnails over alle albumene -->

<?php foreach ($album as $a): ?>
    <?php
    $albumnavn = $a["NAVN"];
    $albumid = $a["ID"];
    $coverphotopath = "/resources/bilder/".$albumnavn."/".$a->BILDE[0][@FIL];
    ?>
    <div class='col-xs-6 col-md-3'>
        <a class="thumbnail" href="<?=$albumid;?>">
            <img src="<?=$coverphotopath;?>">
            <div class="caption"><?=$albumnavn;?></div>
        </a>
    </div>
<?php endforeach; ?>