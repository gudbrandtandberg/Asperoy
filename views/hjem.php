<?php
    session_start();  //for å ha tilgang til brukerinfo
?>

<div id="topptekst">
    <h3>Velkommen til Asperøysiden, <?php echo $_SESSION["brukernavn"];?>!</h3>
    <p>
        Her på Asperøy.no kan vi øybeboere dele bilder, planlegge ferier, samle ressurser, etterlyse arbeid,
	planlegge og mye mer. Klikk på lenkene over for å komme i gang. 
    </p>
</div>

<div id="karusell">
    <?php  //fyller karusellen dynamisk med karusellbildene 
	$images = scandir("model/bilder/karusellbilder");
	
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg"){
	        echo "<div><img src=model/bilder/karusellbilder/".$image."></img></div>";
	    }
	}
    ?>
</div>

<!-- starter karusellen -->
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="external/slick/slick.min.js"></script>

<script type="text/javascript">
    $("#karusell").slick({
	slidesToShow: 3,
        slidesToScroll: 1,
	autoplay: true,
	infinite: true,
	dots: false,
	autoplaySpeed: 3000,
    });    
</script>