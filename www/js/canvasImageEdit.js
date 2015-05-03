/**
 * Created by eivindbakke on 4/30/15.
 */


/*
 * Henter et profilbilde fra brukeren og legger det i canvaset.
 */
var img = null;

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

    document.getElementById("profilbildestreng").value = img.src;

    context.strokeStyle = '#FFFFFF';
    context.strokeRect(uploadSquare.x, uploadSquare.y, uploadSquare.w, uploadSquare.h);
    context.strokeStyle = '#000000';
    context.strokeRect(uploadSquare.x - 1, uploadSquare.y - 1, uploadSquare.w + 2, uploadSquare.h + 2);
}

// Zoomer bildet ved aa legge til en andel av orginal bredden og storrelsen til orginal bredden / storrelsen. Andelen bestemmes av slideren, som brukere kontrollerer
function zoomImage(factor) {
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

    img = new Image();
    img.src = file.target.result;

    var Img = document.getElementById("profilbildeimg");
    var canvas = document.getElementById("redigeringscanvas"); // fordi vi trenger DOM objekteter og kan ikke bruke jQuery objektet
    //img.width = imageObj.width;
   // img.height = imageObj.height;
    Img.src = file.target.result; //fordi strengen må sendes med formen

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
    if (img.src.length > 550000){ // Using length of url string to check file size. 400 KB is a bit less than a length of 550 000 (about a 4/3 relationship to bytes)
	console.log("Original size: " + img.src.length + ".");
	var compCnvs = document.getElementById("compressioncanvas");
	var ctx = compCnvs.getContext("2d").drawImage(img, 0, 0, img.width, img.height);
	img.src = compCnvs.toDataURL("image/jpeg",  550000 / img.src.length);
	
        console.log("Compressed Size: " + img.src.length);
    }
    
    originalImgHeight = img.height;
    originalImgWidth = img.width;
    drawImage(img);
}

function openFile(event){

    var bildeInput = document.getElementById("bildeinput");

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

function canvasEditInit(square) {
    uploadSquare = square;
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
            drawImage(img, movingImgCoor.x, movingImgCoor.y);
        }
    });

    canvas.mouseup(function(e) {
        // naa oppdaterer vi bildekoordinatene vaare!
        imgCoor.x = movingImgCoor.x;
        imgCoor.y = movingImgCoor.y;
        dragging = false;
    });

}
