$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid', 'interaction', 'moment'],
        defaultView: 'dayGridMonth',
        defaultDate: '2019-09-15',
        header: {
            left: 'title',
            right: 'prev,next today'
        },
        events: "index.php?action=getReservation",
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        eventClick: function (info) {
            $('#readReservation').show();
            $('#startTimeRead').append();
            $('#endTimeRead').append(info.event.end);
            var titleSplit = info.event.title.split(" ");
            $('#salleRead').append(titleSplit[0]);
            $('#ligueRead').append(titleSplit[1]);
        },
        editable: true,
        selectable: false,
        droppable: false
    });

    calendar.render();

    $('.fc-day').not('.fc-other-month').click(function () {
        $('#createReservation').show();
        $('#date').attr("value", $(this).attr('data-date'));
    });
    $('.fc-today-button, .fc-prev-button, .fc-next-button, .fc-dayGridMonth-button, .fc-timeGridWeek-button, .fc-timeGridDay-button').click(function () {
        $('.fc-day').not('.fc-other-month').click(function () {
            $('#createReservation').show();
            $('#date').attr("value", $(this).attr('data-date'));
        });
    });

    $('.closeMdl').click(function () {
        $('#createReservation').hide();
        $('#readReservation').hide();
    });

    $('.saveMdl').click(function () {
        $('#createReservation').hide();
    });

    $("#dtBox").DateTimePicker({
        mode: "time", // date, time or datetime
        timeSeparator: ":",
        timeFormat: "HH:mm",
        minuteInterval: 5,
        roundOffMinutes: true,
        showHeader: true,
        titleContentTime: "Sélectionnez l'heure",
        buttonsToDisplay: ["HeaderCloseButton", "SetButton", "ClearButton"],
        setButtonContent: "Sélectionner",
        clearButtonContent: "Annuler",
        incrementButtonContent: "+",
        decrementButtonContent: "-",
        setValueInTextboxOnEveryClick: false,
        readonlyInputs: false,
        animationDuration: 400,
        touchHoldInterval: 300, // in Milliseconds
        captureTouchHold: false, // capture Touch Hold Event
        mouseHoldInterval: 50, // in Milliseconds
        captureMouseHold: false, // capture Mouse Hold Event
        isPopup: true,
        parentElement: "body",
        isInline: false,
        inputElement: null,
        language: "fr"
    });

    $('.I1').hide();
    $('.I3').hide();
    $('.typeSalle').click(function () {
        var typeSalleChoosen = $(this).children("option:selected").val();
        switch (typeSalleChoosen) {
            case 'I1':
                $('.I1').show();
                $('.I3').hide();
                $('.B1').hide();
                break;
            case 'I3':
                $('.I1').hide();
                $('.I3').show();
                $('.B1').hide();
                break;
            case 'B1':
                $('.I1').hide();
                $('.I3').hide();
                $('.B1').show();
                break;
        }
    });
});
