/**
 * Created by eivindbakke on 1/26/15.
 */

var eventFormDivVisible = false;
var nyEvent = {};
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

function toggleCreateEventDiv(show, x, y, event) {
    var eventFormDiv = $('#nyeventinfoformdiv');
    var eventForm = $('#eventform');
    var titleLabel = $('#titlelabel');

    if (event && event.title) {
        $(".oldevent").css("display", "block");
        $(".newevent").css("display", "none");

        $(".creator").css("display", bruker === event.creator ? "inline" : "none");
        titleLabel.text(event.title);
    } else {
        $(".oldevent").css("display", "none");
        $(".newevent").css("display", "block");
        titleLabel.css("display", "block");
        titleLabel.text("Hva skjer da?");
    }
    if (show) {
        eventFormDiv.css("left", x - 22);
        eventFormDiv.css("top", y + 27);
        eventFormDiv.css("display", "block");
        eventFormDivVisible = true;
    } else {
        eventFormDiv.css("display", "none");

        eventFormDivVisible = false;
    }
}

function addEvent(nyEvent, callback) {
    var tmp = JSON.stringify(nyEvent);

    $.ajax({
        type: "POST",
        url: "/api/kalender.php",
        data: {"nyEvent": tmp},
        success: function(message) {
            console.log(message);
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
            //console.log(message);
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
            var pos = $(this).offset();
            xPos = pos.left;
            yPos = pos.top;

            currentEvent = event;

            toggleCreateEventDiv(true, xPos, yPos, event);
        },

        eventRender: function(event, element) {
            //element.popover({
            //    title: event.title,
            //    placement: 'top',
            //    content: "<a href='#'>test</a>",
            //    container: "body"
            //});
        }
    });


    $('#eventform').submit(function(e) {
        e.preventDefault();

        nyEvent.title = $('#eventtitleinput').val();

        addEvent(nyEvent, function(id) {
            nyEvent.id = id;

            $('#eventtitleinput').val("");
            eventJSON.push(nyEvent.returnEventJSON());
            $('#calendar').fullCalendar('renderEvent', nyEvent, true); // stick? = true
            toggleCreateEventDiv();
        });
    });

    $('#deleteanchor').click(function(e) {
        e.preventDefault();
        deleteEvent(currentEvent.id, function(id) {
            if(id) {
                $('#calendar').fullCalendar('removeEvents', currentEvent.id);
                toggleCreateEventDiv();
            }
        });
    });

    $('#editanchor').click(function(e) {
        $('#myModal').modal('show');
    })
});