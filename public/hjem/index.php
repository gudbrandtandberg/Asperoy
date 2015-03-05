<?php
    if (!isset($_SESSION))
    {
	session_start();
    }
error_reporting(E_ALL);

require_once("../renderHelpers.php");
renderHeaderWithTitle("ASPERØY");
?>

<div id="topptekst">
    <h3>Velkommen til Asperøysiden, <?php echo $_SESSION["brukernavn"];?>!</h3>
    <p>
        Her på Asperøy.no kan vi øybeboere dele bilder, planlegge ferier, samle ressurser, etterlyse arbeid,
	planlegge og mye mer. Klikk på lenkene over for å komme i gang. 
    </p>
</div>

<!-- starter karusellen -->
<script type="text/javascript" src="/js/slick/slick.min.js"></script>

<div id="karusell">
    <?php  //fyller karusellen dynamisk med karusellbildene 
	$images = scandir("../resources/bilder/karusellbilder");
	
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg"){
	        echo "<div><img src=/resources/bilder/karusellbilder/".$image."></img></div>";
	    }
	}
    ?>
</div>

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

<?php
    renderFooter();
?>