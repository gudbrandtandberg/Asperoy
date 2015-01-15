<!--
galleri.php
-->

<?php

    $album = $data['album'];
    $image = $data['bilde'];

    $impath = "model/bilder/".$album."/".$image;
    
    $xmlbilder = simplexml_load_file("model/bilder.xml");    
    
    $next = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']/following-sibling::BILDE");
    $nextImage = $next[0]["FIL"];
    
    $prev = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']/preceding-sibling::BILDE");
    $prevImage = end($prev)["FIL"];
    
    
    
    if (isset($_POST["kommentar"])){
	//insert kommmentar i XML-filen.
	$bilde_element = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']");
	$kommentar_element = $bilde_element[0]->addChild("KOMMENTAR", $_POST["kommentar"]);
	$kommentar_element->addAttribute("NAVN", $_SESSION["brukernavn"]);
	$xmlbilder->asXML("model/bilder.xml");
    }
    
    $kommentarer = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']/KOMMENTAR");
    
    
    
?>

<script type="text/javascript">
    $(document).ready(function(){
	
	    $("#neste").click(function(event){
            event.preventDefault();
            lastNesteBilde();
        });
	    $("#forrige").click(function(event){
            event.preventDefault();
            lastForrigeBilde();
        });

	    document.addEventListener('keyup', function(event) {
	        if(event.keyCode == 39) {
                lastNesteBilde();
            }
	        else if(event.keyCode == 37) {
                lastForrigeBilde();
	        }
	    });

        function lastNesteBilde() {
            if ("<?=$nextImage;?>" != "") {
                window.location.href = 'index.php?page=galleri&album=<?=$album;?>&bilde=<?=$nextImage;?>';
            }
        }
        function lastForrigeBilde() {
            if ("<?=$prevImage;?>" != "") {
                window.location.href = 'index.php?page=galleri&album=<?=$album;?>&bilde=<?=$prevImage;?>';
            }
        }
    });
      
</script>

<!-- navbar -->
<div class='navbar'>
    <a id='forrige' href='.index.php?page=galleri&album=<?=$album;?>&bilde=<?=$prevImage;?>'>
	forrige
    </a>
    <a href='index.php?page=bilder&album=<?=$album;?>' class='tilbakealbum'>
	<?=$album;?>
    </a>
    <a id='neste' href='index.php?page=galleri&album=<?=$album;?>&bilde=<?=$nextImage;?>'>
	neste
    </a>
</div>

<!-- Selve bildet -->
<div class="bildeboks">
    <div class='bilde'>
	<img src='<?=$impath;?><? $image;?>'>
    </div>
</div>

<!-- Kommentarer (nå ved siden av bildene for bedre opplevelse) -->
<div class="kommentarboks">
    <? foreach($kommentarer as $kommentar): ?>
	<div class="kommentar">
	    <div class='kommentator'>
		<?=$kommentar["NAVN"];?> :  
	    </div>    
	    <div class='kommentartekst'>
		<?=$kommentar;?> 
	    </div>
	</div>
	<hr>
    <? endforeach; ?>

    <div class='kommentarfelt'>
	<form  method='post'>
	    <div class='kommentator'>
		<?= $_SESSION["brukernavn"];?>: 
	    </div>
	    <input type='textfield' value='Skriv en kommentar...' name='kommentar'>
	</form>
    </div>
</div>
