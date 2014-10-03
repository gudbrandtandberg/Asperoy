<?php
	// kjøres når brukeren sender sin første GET request til index.php
	// avgjører om brukeren er logget inn eller ikke.
	
	session_start();
	$loggedIn = $_SESSION["loggedIn"];
	//$loggedIn = false;	
	
	if ($loggedIn){
		// få jQuery til å loade login.php
		echo "<script type='text/javascript'>var loggedIn = true; var brukernavn = ".$_SESSION["brukernavn"].";</script>";
	}
	else{
		//få jQuery til å loade hjem.php
		echo "<script type='text/javascript'>var loggedIn = false;</script>";
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Asperøy</title>
	<link rel="shortcut icon" href="images/asperøyico.ico" type="image/x-icon">
	<link rel="icon" href="images/asperøyico.ico" type="image/x-icon">
	<link rel="stylesheet" href="style.css"</link>
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			if (loggedIn) {
				$("#innhold").load("hjem.php");
			}
			else {
				$("#innhold").load("login.php");
			}
			
			$(".knapp").mouseenter(function(){
				$(this).animate({opacity: 0.25}, 300, function(){});
			});
			$(".knapp").mouseleave(function(){
				$(this).animate({opacity: 1}, 300, function(){});
			});
			$(".knapp").click(function(){
				var skalTil = $(this).attr("id");
				if (skalTil == "kalender" || skalTil == "bilder" || skalTil == "ressurser" || skalTil == "prosjekter") {
					$("#innhold").load(skalTil+".html");
				}
				else{
					
				$("#innhold").load(skalTil+".php");
				}
			});
		});
	</script>
</head>

<body>
	<div id="header">
		<div id="tittel">ASPERØY</div>
		<img id="logo" src="images/asperøy_contour.png">
	
		<div id="meny">
			<div class="knapp" id="hjem">
				HJEM
			</div>
			<div class="knapp" id="bilder">
				BILDER
			</div>
			<div class="knapp" id="kalender">
				KALENDER
			</div>
			<div class="knapp" id="chat">
				CHAT
			</div>
			<div class="knapp" id="prosjekter">
				PROSJEKTER
			</div>
			<div class="knapp" id="ressurser">
				RESSURSER
			</div>
		</div>
	
	</div>
	
	<div id="innhold">
		<!-- Fylles opp dynamisk -->
	</div>
	
</body>
</html>
