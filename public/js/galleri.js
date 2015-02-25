/**
 * Created by eivindbakke on 2/25/15.
 */

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
            lastNesteBilde();
        }
        else if(event.keyCode == 37) {
            lastForrigeBilde();
        }
        else if (event.keyCode == 13) {
            $("#kommentarform").submit(submitkommentar());
        }
    });

    /*
     * submitkommentar()
     *
     * Denne funksjonen skal:
     *   - sende kommentardata med et ajax-kall til lagrekommentar.php
     *   - legge til en ny kommentar i DOM'en
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
                $("#kommentarene").append(data);
            }
        });
    }
});