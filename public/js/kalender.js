/**
 * Created by eivindbakke on 1/26/15.
 */

var overlay = false;
var currentEvent = null;
var myevent = null;

function EventForDisplay(title, start, end) {
    var self = this;
    this.id = null;
    this.title = title;
    this.start = start;
    this.end = end;
    this.returnEventJSON = function() {
        return {id: self.id, title: self.title, start: self.start.toISOString(), end: self.end.toISOString()};
    }
}


// Thank you Tim Down for these conversion functions! http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb
function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

// And thanks to Gacek for this great white or black font decider based on luminance algorithm! http://stackoverflow.com/questions/1855884/determine-font-color-based-on-background-color
function contrastColor(color) {
    var contrastingColor = 0;
    luminance = 1 - (0.299 * color.r + 0.587 * color.g + 0.114 * color.b) / 255;

    if (luminance < 0.5) { // Bright background --> black foreground
        contrastingColor = {
            r: 0,
            g: 0,
            b: 0
        }
    } else {
        contrastingColor = { // Dark background --> white foreground
            r: 1,
            g: 1,
            b: 1
        }
    }
    return contrastingColor;
}

function addContrastingColors(event) {
    var eventRGBColor = hexToRgb(event.color);
    var eventTextRGBColor = contrastColor(eventRGBColor);
    var eventContrastColor = rgbToHex(eventTextRGBColor.r, eventTextRGBColor.g, eventTextRGBColor.b);
    event.textColor = eventContrastColor;
    event.borderColor = eventContrastColor;
    return event;
}

for(var i = 0; i < eventJSON.length; i++) {
    addContrastingColors(eventJSON[i]);
}

function showOverlay(x, y, afterPresentation) {
    var eventOverlay = $('#eventoverlay');
    eventOverlay.css('display', 'block');
    eventOverlay.css("left", x - 22);
    eventOverlay.css("top", y + 27);

    var editElements = $('.eventedit');
    var descElements = $('.eventdesc');

    if (currentEvent.creator == bruker) {
        editElements.prop('disabled', false);
        descElements.prop('disabled', true);
        $('.editbuttons').css('display', 'inline');
        eventOverlay.css('height', '160pt');
    } else {
        editElements.prop('disabled', true);
        descElements.prop('disabled', false);
        $('.editbuttons').css('display', 'none');
        eventOverlay.css('height', '130pt');
    }

    $('#titleinput').val(currentEvent.title);
    $('#descriptioninput').val(currentEvent.details ? currentEvent.details : "");
    $('#eventcreator').text(currentEvent.creator);
    $('#createbutton').css('display', 'none');

    if (!currentEvent.title) {
        $('.editbuttons').css('display', 'none');
        $('#createbutton').css('display', 'inline');
    }
    afterPresentation();
}

function hideOverlay(afterHiding) {
    var eventOverlay = $('#eventoverlay');
    eventOverlay.css('display', 'none');
    afterHiding();
}

function addEvent(nyEvent, callback) {
    var tmp = JSON.stringify(nyEvent);

    $.ajax({
        type: "POST",
        url: "/api/kalender.php",
        data: {"nyEvent": tmp},
        success: function(message) {
            callback(message);
        }
    });
}

function updateEvent(event, callback) {
    var tmpEvent = {
        title: event.title,
        creator: event.creator,
        details: event.details,
        color: event.color,
        start: event.start,
        end: event.end,
        id: event.id
    };
    var tmp = JSON.stringify(tmpEvent);

    $.ajax({
        type: "POST",
        url: "/api/kalender.php",
        data: {"oppdatertEvent": tmp},
        success: function(message) {
            callback(message);
        }
    });
}

function deleteEvent(id, callback) {
    $.ajax({
        type: "POST",
        url: "/api/kalender.php",
        data: {"deleteId": id},
        success: function(message) {
            callback(message);
            console.log(message);
        }
    });
}

$(document).ready(function() {

    $('#calendar').fullCalendar({
        height: 500,
        defaultDate: '2015-05-01',
        events: eventJSON,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        allDayDefault: true,

        select: function(start, end, e, view) { // her må også hendelsen skrives til events.json filen.
            var xPos = e.pageX;
            var yPos = e.pageY;

            var pos = $(e.target).offset();
            xPos = pos.left;
            yPos = pos.top + 30;

            currentEvent = {
                start: start,
                end: end
            };
            currentEvent.creator = bruker;

            showOverlay(xPos, yPos, function() {
                overlay = true;
            });
        },

        unselect: function(view, e) {
            //hideOverlay();
        },

        eventClick: function(event, e, view) {
            var pos = $(this).offset();
            xPos = pos.left;
            yPos = pos.top;

            if (!overlay) {
                currentEvent = event;
                showOverlay(xPos, yPos, function() {
                    overlay = true;
                });
            } else {
                if (currentEvent.id == event.id) {
                    hideOverlay(function() {
                        currentEvent = null;
                        overlay = false;
                    });
                } else {
                    currentEvent = event;
                    showOverlay(xPos, yPos, function() {
                        overlay = true;
                    });
                }
            }
        },

        eventRender: function(event, element) {
            if (event.creator !== bruker) {
                event.editable = false;
            }
        },

        eventDrop: function(event, delta, revertFunc) {
            updateEvent(event, function(oppdatertEvent) {
                //console.log(nyEvent);
            });
        }
    });


    $('#createbutton').click(function(e) {
        currentEvent.title = $('#titleinput').val();
        if (!currentEvent.title) {
            alert("Husk å skrive hva som skjer!");
            return;
        }
        currentEvent.details = $('#descriptioninput').val();
        currentEvent.color = brukerFarge;

        addEvent(currentEvent, function(event) {
            currentEvent = null;


            myevent = addContrastingColors(JSON.parse(event));
            eventJSON.push(addContrastingColors(JSON.parse(event)));

            $('#calendar').fullCalendar('renderEvent', JSON.parse(event), true); // stick? = true
            hideOverlay(function() {
                currentEvent = null;
                overlay = false;
            });
        });
    });

    $('#deletebutton').click(function(e) {
        deleteEvent(currentEvent.id, function(id) {
            if(id) {
                $('#calendar').fullCalendar('removeEvents', currentEvent.id);
                hideOverlay(function() {
                    currentEvent = null;
                    overlay = false;
                });
            }
        });
    });

    $('#savebutton').click(function(e) {
        if (!currentEvent.title) {
            alert("Husk å skrive hva som skjer!");
            return;
        }

        if (currentEvent.title != $('#titleinput').val() || currentEvent.details != $('#descriptioninput').val()) {
            currentEvent.title = $('#titleinput').val();
            currentEvent.details = $('#descriptioninput').val();
            updateEvent(currentEvent, function(event) {
                $('#calendar').fullCalendar('updateEvent', currentEvent);
                hideOverlay(function () {
                    currentEvent = null;
                    overlay = false;
                });
            })
        }
    });

    $('#closeoverlay').click(function(e) {
        hideOverlay(function () {
            currentEvent = null;
            overlay = false;
        });
    });
});