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
        alert("Du kan ikke legge til bilder helt ennå, men vi jobber med saken!");
        //$("#bildefil").click();
    })
    
    $("#lastoppnews").click(function(){
        
        var title = $("#createnewstittel").val();
        var text = $("#createnewstextarea").val();
        
        if (title !== "" && text !== "") {
            $(this).html("Laster opp <img src='/resources/images/progress-cleargreen.gif' />");
            $.ajax({
               url: "/api/lagreNewsFeed.php",
               type: "POST",
               data: {title: title, date: new Date().toLocaleDateString(), text: text},
               success: function(data){
                $("#lastoppnews").html("Last opp");
                $("#createnewstittel").val("");
                $("#createnewstextarea").val("");
                $("#newsfeed").prepend($.parseHTML(data));
                $('#createnewsmodal').modal('hide');
               },
               error: function(error){
                alert("Noe gikk vist galt...");
                $("#lastoppnews").html("Last opp");
               }
            });
        } else {
            alert("Du må nok skrive både tittel og tekst!");
        }
    });
    
    var slettItem = function(e){        
        if (confirm("Er du sikker på at du vil slette denne nyhetssaken?")) {
            id = $(e.target).closest(".newsitem").attr("id");
            $.ajax({
                url: "/api/slettNewsFeed.php",
                type: "POST",
                data: {id: id},
                success: function(data){
                    $("#"+id).remove();
                },
                error: function(error){
                    alert("Vi kunne ikke slette nyhetsartikkelen for deg..");
                }
            })
            
        } else {return;}
    };
    
    $(".slettnewsitem").click(slettItem);
    
});
