/**
 * Created by eivindbakke on 2/25/15.
 */

function resizeToMax(id){
        
        myImage = new Image() 
        var img = document.getElementById(id);
        
    
        myImage.src = img.src;
        var container  = document.getElementById("bildecontainer");
        img.style.display = "block";
        
        //DETTE FUNGERER IKKE HELT SOM ØNSKET. MÅ BRUKE OVERFLOW HIDDEN...
        
        if(myImage.width / document.body.clientWidth > myImage.height / document.body.clientHeight){
            img.style.width = "100%";
            if (myImage.height > container.height) {
                img.style.height = "100%";
                img.style.width = "auto";
            }
            else {
                img.style.width = "100%";
            }
            
        } else {
            img.style.height = "100%";   
            if (myImage.width > container.width) {
                img.style.width = "100%";
                img.style.height = "auto";
            }
            else {
                img.style.height = "100%";   
            }
        }
        
    }

$(document).ready(function(){
    
    // ikke vis 'neste' og 'forrige' hvis de ikke finnes
    if (nextImage == "") {
        $("#neste").css("display", "none");
    }
    if (prevImage == "") {
        $("#forrige").css("display", "none");
    }

    $("#neste").click(function(event){
        event.preventDefault();
        lastNesteBilde();
    });
    $("#forrige").click(function(event){
        event.preventDefault();
        lastForrigeBilde();
    });

    function lastNesteBilde() {
        if (nextImage != "") {
            window.location.href = "/bilder/" + albumId + "/" + nextImage;
        }
    }
    function lastForrigeBilde() {
        if (prevImage != "") {
            window.location.href = "/bilder/" + albumId + "/" + prevImage;
        }
    }

    document.addEventListener('keyup', function(event) {
        
        if(event.keyCode == 39) {
            if(!$("#tekstfelt").is(":focus")){
                lastNesteBilde();
            }
        }
        else if(event.keyCode == 37) {
            if(!$("#tekstfelt").is(":focus")){
                lastForrigeBilde();
            }
        }
        else if (event.keyCode == 13) {
            if($("#tekstfelt").is(":focus")){
                
                $("#kommentarform").submit(submitkommentar());
                $("#tekstfelt").val("");
            }
        }
    });

    /*
     * submitkommentar()
     *
     * Denne funksjonen skal:
     *   - sende kommentardata med et ajax-kall til lagrekommentar.php
     *   - legge til en ny kommentar i DOM
     */
    function submitkommentar(){

        $("#progress").css("display", "block");

        $.ajax({url: "/api/lagrekommentar.php",
            data: {kommentar: $("#tekstfelt").val(),
                dato: new Date().toLocaleDateString(),
                album: albumId,
                bilde: bilde,
                navn: bruker},
            type: "POST",
            dataType: "html",
            success: function(data){
                $("#progress").css("display", "none");
                $("#kommentartabell").append(data);
            }
        });
    }
    
    $(".navitems").hover(function(){
        $(this).animate({opacity: 1.0}, 300)
        }, function(){
            $(this).animate({opacity: 0.6}, 300)
        });
    

    
});