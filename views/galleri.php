<!--
galleri.php


-->

<?php

    $album = $data['album'];
    $image = $data['bilde'];

    $impath = "../model/bilder/".$album."/".$image;
    
    $xmlbilder = simplexml_load_file("../model/bilder.xml");    
    
    $next = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']/following-sibling::BILDE");
    $nextImage = $next[0]["FIL"];
    
    $prev = $xmlbilder->xpath("//ALBUM[@ID='{$album}']/BILDE[@FIL='{$image}']/preceding-sibling::BILDE");
    $prevImage = end($prev)["FIL"];
    
    
    
?>

<script type="text/javascript">
    $(document).ready(function(){
	$("#neste").click(function(){
	    if ("<?=$nextImage;?>" != "") {
            $.get("../controller/index.php", {page: "galleri", album: "<?=$album;?>", bilde: "<?=$nextImage;?>"},
		function(data) {
		    $("body").html(data);
		});
	    }
        });
	$("#forrige").click(function(){
	    if ("<?=$prevImage;?>" != "") {
            $.get("../controller/index.php", {page: "galleri", album: "<?=$album;?>", bilde: "<?=$prevImage;?>"},
		function(data) {
		    
		    $("body").html(data);
		    
		});
	    }
        });
	document.addEventListener('keyup', function(event) {
	    
	    if(event.keyCode == 39) {
		if ("<?=$nextImage;?>" != "") {
		    alert("neste");
		    $.get("../controller/index.php", {page: "galleri", album: "<?=$album;?>", bilde: "<?=$nextImage;?>"},
			function(data) {
			    
			    event.stopPropagation();
			    $("body").html(data);

		    });
		}
	    }
	    else if(event.keyCode == 37) {
		alert("forrige");
		if ("<?=$prevImage;?>" != "") {
		    $.get("../controller/index.php", {page: "galleri", album: "<?=$album;?>", bilde: "<?=$prevImage;?>"},
			function(data) {
			    event.stopPropagation();
			    $("body").html(data);
		    });
		}
	    }
	    
	});
    });
      
</script>

<!-- navbar -->
<div class='navbar'>
<span id='forrige' class='tilbake'>forrige</span>
<span id='neste' class='leggtil'>neste</span>
</div>

<!-- galleri (bilde & kommentarvisningstedet) -->
<div class="galleri">
    <div class='bilde'>
	<img src='<?=$impath;?><? $image;?>'>
    </div>
    
    <!-- for each kommentar as k -->
    <div class='kommentar'>
	    Dette er en kommentar. 
    </div>
    <div class='kommentar'>
        Dette er en kommentar til. Å for et bilde! 
    </div>
    
    <div class='kommentarfelt'>
	<form>
	    Navn:
	    <input type='textfield'>
	    <input type='submit' method='post' action='nyKommentar.php'>
	</form>
    </div>
   
</div>
