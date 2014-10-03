<?php
    session_start();
?>

<div id="topptekst">
    <h3>Velkommen til Asperøysiden, <?php echo $_SESSION["brukernavn"];?>!</h3>
        <p>
            En kort liten introtekst :) 
            Hilsen skaperne Gudbrand og Eivind
        </p>
</div>

<div id="karusell">
    <?php  //fyller karusellen dynamisk med karusellbildene 
	$images = scandir("bilder/karusellbilder");
	
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg"){
	        echo "<div><img alt='finnerikke' src=bilder/karusellbilder/".$image."></img></div>";
	    }
	}
    
    ?>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>

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