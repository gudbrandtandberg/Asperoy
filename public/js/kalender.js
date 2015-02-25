/**
 * Created by eivindbakke on 1/26/15.
 */

var eventFormDivVisible = false;
var nyEvent = {};

function EventForDisplay(title, start, end) {
    var self = this;
    this.title = title;
    this.start = start;
    this.end = end;
    this.returnEventJSON = function() {
        return {title: self.title, start: self.start.toISOString(), end: self.end.toISOString()};
    }
}

function toggleCreateEventDiv(show, x, y, event) {
    var eventFormDiv = $('#nyeventinfoformdiv');
    var eventForm = $('#eventform');
    var titleLabel = $('#titlelabel');

    if (event && event.title) {
        eventForm.css("display", "none");
        titleLabel.css("display", "block");
        titleLabel.text(event.title);
    } else {
        eventForm.css("display", "block");
        titleLabel.css("display", "none");
    }
    if (show) {
        eventFormDiv.css("left", x + 10);
        eventFormDiv.css("top", y + 10);
        eventFormDiv.css("display", "block");
        eventFormDivVisible = true;
    } else {
        eventFormDiv.css("display", "none");

        eventFormDivVisible = false;
    }
}

function postNewEventJSON(){
    var tmp = JSON.stringify(eventJSON);

    $.ajax({
        type: "POST",
        url: "api/nyEvent.php",
        data: {"nyEvent": tmp},
        success: function(message) {
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
        unselectCancel: "#nyeventinfoformdiv",

        select: function(start, end, e, view) { // her må også hendelsen skrives til events.json filen.
            var xPos = e.pageX;
            var yPos = e.pageY;

            nyEvent = new EventForDisplay(null, start, end);

            toggleCreateEventDiv(true, xPos, yPos, nyEvent);
        },

        unselect: function(view, e) {
            toggleCreateEventDiv();
        },

        eventClick: function(event, e, view) {
            var xPos = e.pageX;
            var yPos = e.pageY;

            toggleCreateEventDiv(true, xPos, yPos, event);
        }
    });


    $('#eventform').submit(function(e) {
        e.preventDefault();

        nyEvent.title = $('#eventtitleinput').val();
        $('#eventtitleinput').val("");
        eventJSON.push(nyEvent.returnEventJSON());
        $('#calendar').fullCalendar('renderEvent', nyEvent, true); // stick? = true
        postNewEventJSON();
        toggleCreateEventDiv();
    });
});