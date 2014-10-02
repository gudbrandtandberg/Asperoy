<div id="topptekst">
    <h3>Velkommen til Asperøysiden, [brukernavn]!</h3>
        <p>
            En kort liten introtekst :) 
            Hilsen skaperne Gudbrand og Eivind
        </p>
</div>

<div id="karusell">
    <?php
	$images = scandir("bilder");
	
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg"){
	        echo "<div><img alt='finnerikke' src=bilder/".$image."></img></div>";
	    }
	}
    
    ?>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="slick/slick.min.js"></script>

<script>
    $('#karusell').slick({
	slidesToShow: 1,
        slidesToScroll: 1,
	autoplay: true,
	infinite: true,
	dots: false,
	autoplaySpeed: 3000,
    });
    
</script>