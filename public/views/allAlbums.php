<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/25/15
 * Time: 1:11 PM
 */
?>

<!--Thumbnail Image View -->

<!-- en navigationbar -->
<table class='navbar'>
    <tr>
        <td class="navitem1"></td>
        <td class="navitem2"><h3>ALLE ALBUM</h3></td>
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
    <div class='thumbnail'>
        <a href='<?=$albumid;?>'>
            <img src='<?=$coverphotopath;?>'>
        </a>
        <div class='label'>
            <?=$albumnavn;?>
        </div>
    </div>
<?php endforeach; ?>

<!--Thumbnail Image View End-->