var lastSelected = "";
var userColor = "#A9BAD4"; //default

function OnCustomColorChanged(selectedColor, selectedColorTitle, colorPickerIndex) {

    //kalles hver gang ny farge velges
    lastSelected.css({border: "solid 0px #000000"});
    $("b.selected").css({border: "solid 1px #000000"});
    lastSelected = $("b.selected");
    userColor = selectedColor;
    
};