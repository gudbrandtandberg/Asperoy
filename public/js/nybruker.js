    
var riktig = [0, 0, 0, 0, 0]; //"global" variabel
    
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

// vi maa holde styr paa den orginale bildehoyden og bredden for aa gjore zoom
var originalImgHeight = 0;
var originalImgWidth = 0;

// bildekoordinatene i canvasen, etter at brukeren har flyttet paa det. pga. hvordan flytting regnes ut maa vi ha begge de to under
var imgCoor = {
    x: 0,
    y: 0
};
// bildekoordinatene mens det flyttes paa
var movingImgCoor = {
    x: 0,
    y: 0
};
// koordinatene der brukeren trykker ned for aa flytte bilde maa lagres for aa finne ut hvor mye som er flyttet
var mouseDownCoor = {
    x: 0,
    y: 0
};

// Tegner et bildeobjekt til canvasen, med en valgfrie x og y coordinater
function drawImage(img, x, y) {
    var canvas = document.getElementById("redigeringscanvas"); // fordi vi trenger DOM objektet og kan ikke bruke jQuery objektet
    var context = canvas.getContext("2d");
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.drawImage(img, x ? x : imgCoor.x, y ? y : imgCoor.y, img.width, img.height);
    context.stroke();
}

// Zoomer bildet ved aa legge til en andel av orginal bredden og storrelsen til orginal bredden / storrelsen. Andelen bestemmes av slideren, som brukere kontrollerer
function zoomImage(factor) {
    var img = document.getElementById("profilbildeimg");
    img.width = factor * originalImgWidth + originalImgWidth;
    img.height = factor * originalImgHeight + originalImgHeight;
    drawImage(img, imgCoor.x, imgCoor.y);
}

// hjelpefunksjon for aa finne musposisjonen i canvasen til en event
function getMousePosInCanvas(e) {
    var rect = document.getElementById("redigeringscanvas").getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    };
}

// Forbereder et bilde til visning fra en url strom
function prepareAndDrawImage(file) {
    var img = document.getElementById("profilbildeimg");
    var canvas = document.getElementById("redigeringscanvas"); // fordi vi trenger DOM objekteter og kan ikke bruke jQuery objektet
    img.src = file.target.result;

    // vi maa finne ut hvordan vi kan faa bildet til aa passe canvasen vaar uten at vi forandrer paa dimensjonene
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

    originalImgHeight = img.height;
    originalImgWidth = img.width;
    drawImage(img);
}

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
    reader.onload = prepareAndDrawImage;
    reader.readAsDataURL(file);
}

$(document).ready(function(){
    $(".firstFocus").focus(); //første inputfelt får fokus
    var slider = $("#slider");
    slider.slider({
        min: 0,
        max: 2,
        step: 0.01,
        slide: function(e, ui) {
            zoomImage(ui.value);
        }
    });
    $(".tick img").css({"display": "none"});
    $(".tick").css({"width": "15px"});
    $("#ferdigknappen").attr("disabled", "disabled");
    var canvas = $('#redigeringscanvas');

    $("#avbryt").click(function(e){
        window.location.href = "/login/";
    });

    $("#lagnybrukerknapp").click(function(e){
        $("#lagnybrukerform").submit();
    });

    var dragging = false;
    canvas.mousedown(function(e) {
        mouseDownCoor.x = getMousePosInCanvas(e).x;
        mouseDownCoor.y = getMousePosInCanvas(e).y;
        dragging = true;
    });

    canvas.mousemove(function(e) {
        if (dragging) {

            // for aa faa til en dra illusjon maa vi ta de gamle bildekoordinatene og legge til forandringen som er gitt av eventen her minus der hvor brukeren trykket ned
            movingImgCoor.x = imgCoor.x + (getMousePosInCanvas(e).x - mouseDownCoor.x);
            movingImgCoor.y = imgCoor.y + (getMousePosInCanvas(e).y - mouseDownCoor.y);
            drawImage(document.getElementById("profilbildeimg"), movingImgCoor.x, movingImgCoor.y);
        }
    });

    canvas.mouseup(function(e) {
        // naa oppdaterer vi bildekoordinatene vaare!
        imgCoor.x = movingImgCoor.x;
        imgCoor.y = movingImgCoor.y;
        dragging = false;
    });
});
