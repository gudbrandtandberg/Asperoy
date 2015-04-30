/**
 * Created by eivindbakke on 2/25/15.
 */

function resizeToMax(id){
        
        myImage = new Image() 
        var img = document.getElementById(id);
        myImage.src = img.src;
        img.style.display = "inline-block";
        
        if(myImage.width >= myImage.height){
            img.style.width = "100%"; 
        } else {
            img.style.height = "100%";   
        }
    }

$(document).ready(function(){
    
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

        $("#progress").css("display", "table-row");

        $.ajax({url: "/api/lagreKommentar.php",
            data: {kommentar: $("#tekstfelt").val(),
                dato: new Date().toLocaleDateString(),
                album: albumId,
                bilde: bilde,
                navn: bruker},
            type: "POST",
            dataType: "html",
            success: function(data){
                $("#progress").css("display", "none");
                $("#progress").before(data);
            },
            error: function(a, b){
                $("#progress").css("display", "none");
                alert("Noe gikk galt, kommentaren ble ikke lagret");
            }
        });
    }
    
    $(".navitems").hover(function(){
        $(this).animate({opacity: 1.0}, 300)
        }, function(){
            $(this).animate({opacity: 0.6}, 300)
        });

});