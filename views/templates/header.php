<!--
header.php

Tar seg først av all head som gjelder for alle sidene. Inneholder det mest generelle av javascript
Og visningen av hele headeren, inkl. barn. 

Åpen <div class = innhold> lukkes i footer.php
-->


<html>
    <head>
            <meta charset="utf-8">
            <title><?php echo $title;?></title>
            <link rel="shortcut icon" href="../model/images/asperøyico.ico" type="image/x-icon">
            <link rel="icon" href="../model/images/asperøyico.ico" type="image/x-icon">
            <link rel="stylesheet" href="../style.css"</link>
            <link rel="stylesheet" type="text/css" href="../external/slick/slick.css"/>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
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
                });
            </script>
    </head>

    <body>
            <div id="header">
                    <div id="tittel">ASPERØY</div>
                    <img id="logo" src="../model/images/asperøy_contour.png">
            
                    <div id="meny">
                            <div class="knapp" id="hjem">
                                    <a href="index.php?page=hjem">HJEM</a>
                            </div>
                            <div class="knapp" id="bilder">
                                    <a href="index.php?page=bilder">BILDER</a>
                            </div>
                            <div class="knapp" id="kalender">
                                    <a href="index.php?page=kalender">KALENDER</a>
                            </div>
                            <div class="knapp" id="prosjekter">
                                    <a href="index.php?page=prosjekter">PROSJEKTER</a>
                            </div>
                            <div class="knapp" id="ressurser">
                                    <a href="index.php?page=ressurser">RESSURSER</a>
                            </div>
                    </div>
            
            </div>
            <br>
            <br>
            <div class="innhold">
            