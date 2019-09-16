$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid'],
        defaultView: 'dayGridMonth',
        header: {
            left: 'title',
            right: 'prev,next today'
        },
        customButtons: {
            addEventButton: {
                text: 'Réserver',
                click: function () {
                    $('#myModal').show();
                    /*var dateStr = prompt('Entrer une date au format AAAA-MM-JJ.');*/
                    var date = new Date(dateStr + 'T00:00:00');

                    /*if (!isNaN(date.valueOf())) {
                        calendar.addEvent({
                            title: 'dynamic event',
                            start: date,
                            allDay: false
                        });*/
                }
            }
        }
    });
    calendar.render();
    $('.fc-day').not('.fc-other-month').click(function () {
        $('#myModal').show();
    });
    $('.fc-today-button, .fc-prev-button, .fc-next-button, .fc-dayGridMonth-button, .fc-timeGridWeek-button, .fc-timeGridDay-button').click(function () {
        $('.fc-day').not('.fc-other-month').click(function () {
            $('#myModal').show();
        });
    });

    $('.closeMdl').click(function () {
        $('#myModal').hide();
    });
    $('.saveMdl').click(function () {
        $('#myModal').hide();
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

});
