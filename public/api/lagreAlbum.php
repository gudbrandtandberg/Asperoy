
<?php

$albumnavn = $_GET["albumnavn"];

?>
<div class='col-xs-6 col-md-3 tommel'>
    <a class="tommel" href="#">
        <div class="tommelbildebeholder">
            <img class="tommelbilde" src="http://www.casa-candy.com/preload-images/default-placeholder.png">
        </div>
        <div class="tommelcaption"><?=$albumnavn;?></div>
    </a>
</div>