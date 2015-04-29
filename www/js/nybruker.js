
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

    context.strokeStyle = '#FFFFFF';
    context.strokeRect(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
    context.strokeStyle = '#000000';
    context.strokeRect(uploadSquare.x - 1, uploadSquare.y - 1, uploadSquare.w + 2, uploadSquare.h + 2);
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
    $("#slider").slider("value", 0);
    originalImgHeight = 0;
    originalImgWidth = 0;

// bildekoordinatene i canvasen, etter at brukeren har flyttet paa det. pga. hvordan flytting regnes ut maa vi ha begge de to under
    imgCoor = {
        x: 0,
        y: 0
    };
// bildekoordinatene mens det flyttes paa
    movingImgCoor = {
        x: 0,
        y: 0
    };
// koordinatene der brukeren trykker ned for aa flytte bilde maa lagres for aa finne ut hvor mye som er flyttet
    mouseDownCoor = {
        x: 0,
        y: 0
    };

    var imageObj = new Image();
    imageObj.src = file.target.result;

    var img = document.getElementById("profilbildeimg");
    var canvas = document.getElementById("redigeringscanvas"); // fordi vi trenger DOM objekteter og kan ikke bruke jQuery objektet
    img.width = imageObj.width;
    img.height = imageObj.height;
    img.src = file.target.result;

    // dette hentet jeg rett fra et annet prosjekt.... vi kan vel snakke om storrelse paa bilde en eller annen gang
    // kom paa at det jo ogsaa kan hende at vi vil gjore kompresjonen naar brukeren er ferdig, ikke med en gang...
    if (file.target.result.length > 550000){ // Using length of url string to check file size. 400 KB is a bit less than a length of 550 000 (about a 4/3 relationship to bytes)
        img.src = jic.compress(img, ((550000 / file.target.result.length) * 100)).src; // This calculation will bring the file size down to less than 400 KB
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
    $(".firstFocus").focus(); //første inputfelt får fokus
    
    //slider init
    var slider = $("#slider");
    slider.slider({
        min: -1,
        max: 2,
        step: 0.01,
        slide: function(e, ui) {
            zoomImage(ui.value);
        }
    });
    
    //colorpicker init
    $("b.selected").css({border: "solid 1px #000000"});
    lastSelected = $("b.selected");
    $("#farge").val("##A9BAD4");
    
    // quiz init
    $(".tick img").css({"display": "none"});
    $(".tick").css({"width": "15px"});
    $("#ferdigknappen").attr("disabled", "disabled");
    
    // canvas init
    var c = document.getElementById("redigeringscanvas");
    var ctx = c.getContext("2d");
    ctx.strokeStyle = '#FFFFFF';
    ctx.strokeRect(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
    ctx.strokeStyle = '#000000';
    ctx.strokeRect(uploadSquare.x - 1, uploadSquare.y - 1, uploadSquare.w + 2, uploadSquare.h + 2);

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
    
    //håndter knappeklikk/formsubmission
    $("#avbryt").click(function(e){
        window.location.href = "/login/";
    });
    
    $("#termscond").click(function(e){
	e.preventDefault();
	$("#termspopup").css({display: "block"});
    });
    
    $("#okjegharlest").click(function(){
	$("#termspopup").css({display: "none"});
    });
    
    $("#lagnybrukerknapp").click(function(e){
        $("#lagnybrukerform").submit();
    });

    $("#lagnybrukerform").submit(function(e){
	e.preventDefault();

	//alle feltene må minst være fyllt ut.
	if (($("#fornavn").val() == "") ||
	    ($("#etternavn").val() == "") ||
	    ($("#epost").val() == "") ||
	    ($("#passord").val() == "")) {
	    alert("Du må fylle inn alle feltene helt riktig");
	    return false;
	}
	
	if (!($("#godtatt").is(':checked'))) {
	    alert("du må godta brukeravtalen!");
	    return false;
	}
	
	if ($("#profilbildeimg").attr("src") == "") {

	    var drit_i_bilde = confirm("Du har ikke valgt et profilbilde. Hvis du ikke ønsker å gjøre dette nå kan du gjøre det på et senere tidspunkt. Klikk avbryt for å legge til et bilde, klikk OK for å lage bruker");
	    if (drit_i_bilde) {
		//avatar-bilde
		$("#profilebildestreng").val("data:image/jpeg;base64,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");
	    } else {
	        return false;
	    }
	}
	else {
	    var brukerBilde = ctx.getImageData(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
	    var uploadCanvas = document.getElementById("uploadcanvas");
	    var uploadContext = uploadCanvas.getContext("2d");
	    uploadContext.putImageData(brukerBilde, 0, 0);
	    var brukerBildeStreng = uploadCanvas.toDataURL();
	    
	    $("#profilebildestreng").val(brukerBildeStreng);
	}
	
        $("#farge").val(userColor);
	
        this.submit();
	return true;
    });
    
    $("#ferdigknappen").click(function(){
	$("#quizform").submit();
    })
    
});

/*     COLOR PICKER KODE  */

var lastSelected = "";
var userColor = "#A9BAD4"; //default

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(rgbString) {
    var rgb = rgbString.match(/[0-9]+/g);
    var r = 1 * rgb[0];
    var g = 1 * rgb[1];
    var b = 1 * rgb[2];
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function OnCustomColorChanged(selectedColor, selectedColorTitle, colorPickerIndex) {
    //kalles hver gang ny farge velges
    lastSelected.css({border: "solid 0px #000000"});
    $("b.selected").css({border: "solid 1px #000000"});
    lastSelected = $("b.selected");
    userColor = rgbToHex(selectedColor);
};

