<?php
    session_start();
?>

<!--
galleri.php

Skjermen er delt i to div'er; en med bilde og navbar og en med kommentarer.
-->

<?php

    // hvilket bilde fra hvilket album som skal vises
    $albumid = $data['album'];
    $image = $data['bilde'];
    
    // finner neste og forrige bilder
    // dette bør kunne gjøres på en bedre måte..
    
    $xmlbilder = simplexml_load_file("model/bilder.xml");    
    
    $albumnavn = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']")[0]["NAVN"];
    $impath = "model/bilder/".$albumnavn."/".$image;
    
    $next = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']/BILDE[@FIL='{$image}']/following-sibling::BILDE");
    $nextImage = $next[0]["FIL"];
    
    $prev = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']/BILDE[@FIL='{$image}']/preceding-sibling::BILDE");
    $prevImage = end($prev)["FIL"];

    // liste med alle kommentarelementene under det aktuelle bildet i xml filen
    $kommentarer = $xmlbilder->xpath("//ALBUM[@ID='{$albumid}']/BILDE[@FIL='{$image}']/KOMMENTAR");
?>

<script type="text/javascript">
    
    var bruker = "<?= $_SESSION["brukernavn"];?>";
    var album = "<?=$data['album'];?>";
    var bilde = "<?=$data['bilde'];?>";
    
    $(document).ready(function(){

	// ikke vis 'neste' og 'forrige' hvis de ikke finnes
	if ("<?=$nextImage;?>" == "") {
	    $("#neste").css("display", "none");
	}
	if ("<?=$prevImage;?>" == "") {
	    $("#forrige").css("display", "none");
	}
	
	$("#neste").click(function(event){
            event.preventDefault();
            lastNesteBilde();
        });
	$("#forrige").click(function(event){
            event.preventDefault();
            lastForrigeBilde();
        });

        function lastNesteBilde() {
            if ("<?=$nextImage;?>" != "") {
                window.location.href = 'index.php?page=galleri&album=<?=$albumid;?>&bilde=<?=$nextImage;?>';
            }
        }
        function lastForrigeBilde() {
            if ("<?=$prevImage;?>" != "") {
                window.location.href = 'index.php?page=galleri&album=<?=$albumid;?>&bilde=<?=$prevImage;?>';
            }
        }
	
	document.addEventListener('keyup', function(event) {
	    if(event.keyCode == 39) {
                lastNesteBilde();
            }
	    else if(event.keyCode == 37) {
                lastForrigeBilde();
	    }
	    else if (event.keyCode == 13) {
		    $("#kommentarform").submit(submitkommentar());
	    }
	});
	
	/*
	 * submitkommentar()
	 *
	 * Denne funksjonen skal:
	 *   - sende kommentardata med et ajax-kall til lagrekommentar.php
	 *   - legge til en ny kommentar i DOM'en
	 */
	function submitkommentar(){
	    
	    $("#progress").css("display", "block");
	    
	    $.ajax({url: "lagrekommentar.php",
		   data: {kommentar: $("#tekstfelt").val(),
			  dato: new Date().toLocaleDateString(),
			  album: "<?=$albumid;?>",
			  bilde: "<?=$image;?>",
			  navn: bruker},
		   type: "POST",
		   dataType: "html",
		   success: function(data){
			$("#progress").css("display", "none");
			$("#kommentarene").append(data);
		   }
	    });
	}
    });
      
</script>

<div class="bildeboks">
    
    <!-- navbar -->
    <table class='navbar'>
	<tr>
	    <td class="navitem1"><a id='forrige' href='.index.php?page=galleri&album=<?=$albumid;?>&bilde=<?=$prevImage;?>'>forrige</a></td>
	    <td class="navitem2"><a href='index.php?page=albumoversikt&album=<?=$albumid;?>' class='tilbakealbum'><?=$albumnavn;?></a></td>
	    <td class="navitem3"><a id='neste' href='index.php?page=galleri&album=<?=$albumid;?>&bilde=<?=$nextImage;?>'>neste</a></td>
	</tr>
    </table>
    
    <!-- Selve bildet -->
    <div class='bilde'>
	<img src='<?=$impath;?>'>
    </div>

</div>

<!-- Kommentarer (nå ved siden av bildene for bedre opplevelse) -->
<div class="kommentarboks" id="kommentarboks">
    
    <div id="kommentarene">
	<? foreach($kommentarer as $kommentar): ?>
	    <div class="kommentar">
		<div class="kommentarbilde">
		    <img src="model/images/users/avatar.jpg" width="50" alt="Brukerbilde">
		</div>
		<div class="kommentarinnhold">
		    <span class="kommentator"><?=$kommentar["NAVN"];?></span>
		    <span class="kommentartekst"><?=$kommentar;?></span>
		    <div class="kommentarinfo">
			<span class="dato"><?=$kommentar["DATO"];?></span>
			<a href="like.php">Like</a>
			<img src="model/images/like.jpg" style="display: inline" width="20" alt="Tommel">
			<span class="numlikes" style="visibility: hidden"></span>
		    </div>
		</div>
		
	    </div>
	    <hr>
	<? endforeach; ?>
	<div id="progress" style="display: none">
	    <img src="model/images/progress.gif" alt="Kommenterer.." width="20">
	</div>
    </div>

    <div class='kommentarfelt'>
	<form  id="kommentarform" onsubmit="submitkommentar(); return false;">
	    <div class="kommentarbilde">
		<img src="model/images/users/avatar.jpg" width="50" alt="Brukerbilde">
		<div class="kommentator"><?= $_SESSION["brukernavn"];?></div>
	    </div>
	    <textarea id="tekstfelt" class="nykommentar" form="kommentarform" name="kommentar" placeholder="Skriv en kommentar.." rows="4"></textarea>
	</form>
    </div>
</div>
