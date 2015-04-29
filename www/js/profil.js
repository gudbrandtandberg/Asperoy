var lastSelected = "";
var userColor = "#A9BAD4"; //default

function OnCustomColorChanged(selectedColor, selectedColorTitle, colorPickerIndex) {

    //kalles hver gang ny farge velges
    lastSelected.css({border: "solid 0px #000000"});
    $("b.selected").css({border: "solid 1px #000000"});
    lastSelected = $("b.selected");
    userColor = rgbToHex(selectedColor);
    $("#farge").val(userColor);
    
};

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

// kvadratet som man laster opp fra
var uploadSquare = {
    x: 91.5,
    y: 25,
    w: 150,
    h: 150
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

    // dette hentet jeg rett fra et annet prosjekt.... vi kan vel snakke om storrelse paa bilde en eller annen gang
    // kom paa at det jo ogsaa kan hende at vi vil gjore kompresjonen naar brukeren er ferdig, ikke med en gang...
    if (file.target.result.length > 550000){ // Using length of url string to check file size. 400 KB is a bit less than a length of 550 000 (about a 4/3 relationship to bytes)
        img.src = jic.compress(img, 100 - ((550000 / file.target.result.length) * 100)).src; // This calculation will bring the file size down to less than 400 KB
        console.log("Original size: " + file.target.result.length + ". Compressed Size: " + img.src.length);
    }

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
    
    $("#lagreendringerknapp").click(function(e){
        
        $("#tick").hide();
        
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
    });
    
    //slider init
    var slider = $("#slider");
    slider.slider({
        min: 0,
        max: 2,
        step: 0.01,
        slide: function(e, ui) {
            zoomImage(ui.value);
        }
    });
    
    //colorpicker init
    $("b.selected").css({border: "none"});
    lastSelected = $("b.selected");
    
    // canvas init
    var c = document.getElementById("redigeringscanvas");
    var ctx = c.getContext("2d");
    ctx.strokeStyle = '#222222';
    ctx.rect(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
    ctx.stroke();

    var canvas = $('#redigeringscanvas');
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