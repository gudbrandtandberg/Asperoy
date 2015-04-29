
<?php

    $tilbakemelding = $_GET["tilbakemelding"];
    $tilbakemelding = wordwrap($tilbakemelding, 70, "\r\n"); //ingen linjer lenger enn 70 chars
    $bruker = $_GET["bruker"]; //like greit å hente fra SESSION her?
    
    //funker, men mail tror det er junk..
    $suksess = mail("gudbrandduff@gmail.com", "Tilbakemelding fra ".$bruker." for asperøy.no", $tilbakemelding);
    $suksess = mail("eivind.m.bakke@gmail.com", "Tilbakemelding fra ".$bruker." for asperøy.no", $tilbakemelding);
    
    if ($suksess){
        sleep(1);
        echo "YES";
    } else {
        echo "NO";
    }
    
?>