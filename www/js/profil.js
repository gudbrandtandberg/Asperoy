
var lastSelected = "";
var userColor = "#A9BAD4"; //default

function OnCustomColorChanged(selectedColor, selectedColorTitle, colorPickerIndex) {

    //kalles hver gang ny farge velges
    lastSelected.css({border: "solid 0px #000000"});
    $("b.selected").css({border: "solid 1px #000000"});
    lastSelected = $("b.selected");
    userColor = rgbToHex(selectedColor);
    $("#farge").val(userColor);
    
}

function rgbToHex(rgbString) {
    var rgb = rgbString.match(/[0-9]+/g);
    var r = 1 * rgb[0];
    var g = 1 * rgb[1];
    var b = 1 * rgb[2];
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

// kvadratet som man laster opp fra
var uploadSquare = {
    x: 91.5,
    y: 25,
    w: 150,
    h: 150
};

function submitEndringer(e){
        
    $("#tick").hide();
    
    var c = document.getElementById("redigeringscanvas");
    var ctx = c.getContext("2d");
    
    if ($("#profilbildeimg").attr("src") == "") {    
	$("#profilebildestreng").val("");
	if ($("#farge").val() == "") {
	    alert("Du må hvertfall velge ny farge ELLER nytt profilbilde!");
	    return false;
	}
	$("#lagreendringerknapp").html("Lagrer... <img src='/resources/images/progress.gif' width='20' height='20' />");
    }
    else {
	var brukerBilde = ctx.getImageData(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
	var uploadCanvas = document.getElementById("uploadcanvas");
	var uploadContext = uploadCanvas.getContext("2d");
	uploadContext.putImageData(brukerBilde, 0, 0);
	var brukerBildeStreng = uploadCanvas.toDataURL();
	
	$("#profilebildestreng").val(brukerBildeStreng);
    }
    
    //ajaxSubmit fungerer supert! Kan kalle ajax, men fremdeles bruke formobjektet som det er.
    $("#redigerprofilform").ajaxSubmit({success: function(data){
	    if (data.trim()) {
		$("#lagreendringerknapp").html("Lagre endringer");
		$("#lagreendringerknapp").on("click", submitEndringer);
		if ($("#profilebildestreng").val() != "") {
		    $("#profilbilderunding").attr("src", brukerBildeStreng);
		}
		$("#tick").show();
	    }
	    else {
		alert("Det oppsto en feil..");
	    }
	   }});
    
    return true;
    }

$(document).ready(function(){
    
    $("#lagreendringerknapp").click(submitEndringer);
    
    //colorpicker init
    $("b.selected").css({border: "none"});
    lastSelected = $("b.selected");
    
    // canvas init
    canvasEditInit(uploadSquare);
//    var c = document.getElementById("redigeringscanvas");
//    var ctx = c.getContext("2d");
});
