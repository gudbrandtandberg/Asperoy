$(document).ready(function(){
    
    $("#lagreendringerknapp").click(submitEndringer);
    
    //colorpicker init
    $("b.selected").css({border: "none"});
    lastSelected = $("b.selected");
    
    // canvas init
    canvasEditInit(uploadSquare);
    var c = document.getElementById("redigeringscanvas");
    var ctx = c.getContext("2d");
});