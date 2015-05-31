<?php
    /*
     * sendEmail()
     * sender html-formatert epost til brukerene
     *
     * args-eksempel:
     *  - $to = "allUsers"
     *  - $message = "Harald T. kommenterte på et bilde", "link til bilde"
     *  - $message = "Marian laget et nytt album", "link til albumet"
     *  - "...?"
     */

    function sendEmail($args) {
    
        require("www/renderHelpers.php");
    
        $content = Array("message" => "Her er brødteksten",
                         "title" => "Oppdatering!");
                         
        $message = renderEmail("email", $content);
    
        $to = 'gudbrandduff@gmail.com';
        $subject = 'Tester HTML-epost';
        $headers = "From: gudbrandduff@gmail.com\r\n";
        $headers .= "CC: eivindmbakke@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        mail($to, $subject, $message, $headers);
    }
?>