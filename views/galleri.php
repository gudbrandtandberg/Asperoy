<!--
Her har jeg ikke gjort det no særlig bra syns jeg. Prøvde å bruke slick, det kan jo være greit
det i og for seg, men må tenke litt gjennom hvordan kommentarer og alt det skal virke først.. 
Prøv å gå til

http://localhost/Asperøy/controller/index.php?page=galleri&album=Sommer2012

så ser du idéen. Her tenker jeg å gjøre det ganske likt facebook, hva syns du?

Det som er fint med slick er at man kan synkronisere visningen av album og kommentarer. Men det er
kanskje like greit å gjøre det fra scratch. 
-->

<? echo "<div class='bildertittel'><h3> BILDER </h3></div>";?>

<div id="galleri">
    <?php  //fyller karusellen dynamisk med karusellbildene 
	$images = scandir("../model/bilder/".$data['album']);
	
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg" || substr($image, -3)=="JPG" || substr($image, -3)=="jpeg"){
	        echo "<div>";
                echo "<img src=../model/bilder/".$data["album"]."/".$image."></img>";
                echo "</div>";
	    }
	}
    ?>
</div>
<div id="kommentarer">
    <?php  
	
	$images = scandir("../model/bilder/".$data['album']);
        
	foreach ($images as $image){
	    if (substr($image, -3)=="jpg" || substr($image, -3)=="JPG" || substr($image, -3)=="jpeg"){
	        echo "<div class='kommentarfelt'>";
                echo "<p>Kommentar 1</p>";
                echo "<p>Kommentar 2</p>";
                echo "</div>";
            }
	}
    ?>
</div>


<!-- starter karusellen -->
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../external/slick/slick.min.js"></script>

<script type="text/javascript">
    
    $('#galleri').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        asNavFor: '#kommentarer'
    });
    
    $('#kommentarer').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '#galleri',
    });
</script>