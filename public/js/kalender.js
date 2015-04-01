/**
 * Created by eivindbakke on 1/26/15.
 */

var overlay = false;
var currentEvent = null;

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

            eventJSON.push(JSON.parse(event));
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