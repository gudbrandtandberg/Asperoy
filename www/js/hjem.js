/*
 * hjem.js
 * her er all js'en til hjem/index.html, nemlig
 *  - innlasting og tegning av værdata - enten ajax eller sessionStorage
 *  - lagring av søppelplukking
 */

$(document).ready(function() {
    
    //Søppelpollinnsending
    $(".soppelknapp").click(function(e){
        if(confirm("Er du helt sikker på det?!")){
       $.ajax({
        url: "/api/soppelPoll.php",
        dataType: "text",
        success: function(data){
            value = JSON.parse(data); //teit at jeg ikke klarer å få json direkte..
            if (value.success) {
                $(".soppelbilder").append('<img src="'+ value.imageurl + '" class="soppelbilde" width="55" />');//bruke dataurl bilde her..
            }
        },
        error: function(error){
            alert("Dy lyver! (neida, noe gikk bare galt..)");
            //alert(error);
        }
       });
        }
    });
    
    // auto adjust the height of
    $('#tacontainer').on('keyup', 'textarea', function (e){
        $(this).css('height', 'auto' );
        $(this).height(this.scrollHeight);
    });
    $('#tacontainer').find('textarea').keyup();
    
    //Create newsitem stuff
    $("#leggtilbilde").click(function(e){
        $("#bildefil").click();
    })
    
    $("#innleggknapp").click(function(e){
        e.preventDefault();
        alert("Denne funksjonaliteten er ikke helt klar ennå. Vi jobber med saken, og om ikke så altfor lenge kan du selv forfatte innlegg på forsiden :)");
        return false;
    });
    
    $("#lastoppnews").click(function(){
        
        $(this).html("Laster opp <img src='/resources/images/progress-cleargreen.gif' />");
        
        $.ajax({
           url: "/api/lagreNewsFeed.php",
           success: function(data){
            $('#createnewsmodal').modal('hide');
            $(this).html("Last opp");
           },
           error: function(error){
            $(this).html("Last opp");
           }
        });
        
    })
    
});
