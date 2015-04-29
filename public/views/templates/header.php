<?php
//header.php
//
//Tar seg først av all head som gjelder for alle sidene. Inneholder det mest generelle av javascript
//Og visningen av hele headeren, inkl. barn.
//
//Åpen <div class=containter-fluid> lukkes i footer.php

if (!isset($_SESSION)) {
    session_start(); 		// nødvendig for å ha tilgang til $_SESSION variablen
}
ob_start();				    // MÅ komme først
if (!$_SESSION['loggedIn']) {
    header("Location: /login/");
}
?>

<html>
    <head>
	<meta charset="utf-8">
	<meta name="language" content="norwegian">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title;?></title>
	<link rel="shortcut icon" href="/resources/images/asperøyico.ico" type="image/x-icon"/>
	<link rel="icon" href="/resources/images/asperøyico.ico" type="image/x-icon"/>
	    
	<link rel="stylesheet" type="text/css" href="/styles/bootstrap/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="/styles/style.css"/>
	
	<script src="/js/jquery-1.11.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
	    $(document).ready(function(){
		
		$(".knapp").mouseenter(function(){
		    $(this).animate({
			opacity: 0.5
		    });
		});
		
		$(".knapp").mouseleave(function(){
		    $(this).animate({
			opacity: 1
		    });
		});
		
		$("#logut").click(function(e){
		    e.preventDefault();
		    window.location.href = "/?logoff=1";
		});
		
		$("#support").click(function(e){
		    e.preventDefault(); 
		    window.location.href = "/support/";
		});
		$("#profil").click(function(e){
		    e.preventDefault(); 
		    window.location.href = "/profil/";
		});
	    });
	</script>
    </head>

    <body>
        <div id="wrapper">
            <div id="header">
		
		<h1 id="tittel">ASPERØY</h1>
		<img id="logo" src="/resources/images/asperøy_contour.png"/>
		
		<nav class="navbar-default navbar">
		    <div class="container-fluid">
			<div class="navbar-header">
			    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			      <span class="sr-only">Toggle navigation</span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			    </button>
			</div>
			<div class="navbar navbar-collapse collapse" id="navbar">
			    <ul class="nav navbar-nav">
				<li class="knapp">
				    <a href="/hjem/">HJEM</a>
				</li>
				<li class="knapp">
				    <a href="/bilder/">BILDER</a>
				</li>
				<li class="knapp">
				    <a href="/kalender/">KALENDER</a>
				</li>
				<!--<li class="knapp">
				    <a href="/prosjekter/">PROSJEKTER</a>
				</li>-->
				<li class="knapp">
				    <a href="/ressurser/">RESSURSER</a>
				</li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					<img id="profilbilderunding" height="40px" width="40px" src="<?=file_get_contents("../resources/images/users/" . $_SESSION["brukernavn"]);?>" class="img-circle">
					<span id="navndropdown"><?=$_SESSION["brukernavn"];?></span>
					<span class="caret"></span>
				    </a>
				    <ul class="dropdown-menu" role="menu">
					<li><a href="#" id="profil">PROFIL</a></li>
					<li><a href="#" id="support">SUPPORT</a></li>
					<li><a href="#" id="logut">LOGG UT</a></li>
				    </ul>
				</li>
			    </ul>
			</div>
		    </div>
		</nav>
            </div>
            <div id="innhold" class="container-fluid">
            