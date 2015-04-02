    
var riktig = [0, 0, 0, 0, 0]; //"global" variabel

$(document).ready(function(){
    $(".firstFocus").focus(); //første inputfelt får fokus
    $(".tick img").css({"display": "none"});
    $(".tick").css({"width": "15px"});
    $("#ferdigknappen").attr("disabled", "disabled");
    
    
    $("#avbryt").click(function(e){
	window.location.href = "/login/";
    });
    
    $("#lagnybrukerknapp").click(function(e){
	    $("#lagnybrukerform").submit();
    });


});
    
/*
 * check(i, element, blur)
 *
 * hver gang en tast løftes i et svarfelt sjekkes det om det oppgitte
 * svaret er riktig. Et ikon indikerer om svaret er riktig.
 * 'i' sier hvilket spørsmål det dreier seg om,
 * 'element' er en peker til input-elementet som trigget eventen og
 * 'blur' sier at feltet nettop har mistet fokus, i hvilket tilfelle
 * det er passelig med et rødt kryss.
 */
function check(i, element, blur) {
    
    img_element = document.getElementById("tick" + i);
    var answers = ["enschien", "35", "Voss", "Ingrid", "Per"];
	
	if (element.value == answers[i-1]) {
	    $(img_element).css("display", "block");
	    img_element.src = "/resources/images/tick.png";
	    riktig[i-1] = 1;
	}
	else{
	    if (blur && (element.value != "")) {
		$(img_element).css("display", "block");
		img_element.src = "/resources/images/cross.png";
		riktig[i-1] = 0;
	    }
	}

    if (riktig[0] == 1 && riktig[1] == 1 && riktig[2] == 1 && riktig[3] == 1 && riktig[4] == 1) {
	$("#ferdigknappen").removeAttr("disabled");
    }
    else {
	$("#ferdigknappen").attr("disabled", "disabled");
    }
}
    
/*
 * Henter et profilbilde fra brukeren og legger det i canvaset.
 */
/*De to linkene*/
/*http://www.menucool.com/color-picker*/
/*https://css-tricks.com/html5-drag-and-drop-avatar-changer-with-resizing-and-cropping/*/

function openFile(event){
    
    var bildeInput = document.getElementById("bildeinput");
    var imgElement = document.getElementById("profilbildeimg");

    var file = bildeInput.files[0];
    
    //er det egentlig et bilde?
    if (!file.type.match('image.*')) {
        alert("Det må være et jpg bilde!");  //lyver litt
        return;
    }
    
    //laster bildefilen over i et img objekt
    reader = new FileReader();
    reader.onload = function(file) {

        var img = new Image();
        img.src = file.target.result;
        var canvas = document.getElementById("redigeringscanvas"); // fordi vi trenger DOM objektet og kan ikke bruke jQuery objektet
        var context = canvas.getContext("2d");

        var changeRatio = 1;
        if (img.width > canvas.width) {
            changeRatio = canvas.width / img.width;
            img.width = canvas.width;
            img.height = changeRatio * img.height;
        }

        if (img.height > canvas.height) {
            changeRatio = canvas.height / img.height;
            img.height = canvas.height;
            img.width = changeRatio * img.width;
        }
        context.drawImage(img, 0, 0, img.width, img.height);
        context.stroke();

        //var imgElement = document.getElementById("profilbildeimg");
        //imgElement.src = file.target.result;
        //imgElement.style.visibility = "visible";
        //imgElement.style.width = "100px";
        //imgElement.style.height = "100px";
	    };
    reader.readAsDataURL(file);
}
