<?php
//header.php
//
//Tar seg først av all head som gjelder for alle sidene. Inneholder det mest generelle av javascript
//Og visningen av hele headeren, inkl. barn.
//
//Åpen <div class = innhold> lukkes i footer.php

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
            <title><?=$title;?></title>
            <link rel="shortcut icon" href="/resources/images/asperøyico.ico" type="image/x-icon">
            <link rel="icon" href="/resources/images/asperøyico.ico" type="image/x-icon">
            <link rel="stylesheet" href="/styles/style.css"</link>
            <link rel="stylesheet" type="text/css" href="/js/slick/slick.css"/>
<!--            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
            <script src="/js/jquery-1.11.1.min.js"></script>

            <script type="text/javascript">
                $(document).ready(function(){
                        
                        //få tilbake animeringen her...
                        
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
                        

	
                        $('#forrige').click(function(){
	   
                        });
                        
                        $("#logut").click(function(e){
                            e.preventDefault();
                            
                            window.location.href = "/?logoff=1";
                            
                        });
                });
            </script>
    </head>

    <body>
        <div id="holder">
            <div id="header">
                    <div id="tittel">ASPERØY</div>
                    <img id="logo" src="http://asperoy/resources/images/asperøy_contour.png">
            
                    <ul id="meny">
                            <li class="knapp" id="hjem">
                                <a href="/hjem/">HJEM</a>
                            </li>
                            <li class="knapp" id="bilder">
                                <a href="/bilder/">BILDER</a>
                            </li>
                            <li class="knapp" id="kalender">
                                <a href="/kalender/">KALENDER</a>
                            </li>
                            <li class="knapp" id="prosjekter">
                                <a href="/prosjekter/">PROSJEKTER</a>
                            </li>
                            <li class="knapp" id="ressurser">
                                <a href="/ressurser/">RESSURSER</a>
                            </li>
                            <li class="knapp" id="logut">
                                <a href="#">LOGG UT</a>
                            </li>
                    </ul>
            </div>
            <div id="innhold">
            