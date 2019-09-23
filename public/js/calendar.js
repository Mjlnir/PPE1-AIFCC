$(document).ready(function () {
    var mEvents;
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid'],
        defaultView: 'dayGridMonth',
        header: {
            left: 'title',
            right: 'prev,next today'
        },
        eventSources: [
               {
                   url: '<?php echo fctGetReservation(); ?>',
                   type: 'POST',
                   id:id,
                   title:title,
                   start:new Date(start),
                   end:new Date(end),// use the `url` property
                }                    
            ]
    });

    calendar.render();

    $('.fc-day').not('.fc-other-month').click(function () {
        $('#myModal').show();
        $('#date').attr("value", $(this).attr('data-date'));
    });
    $('.fc-today-button, .fc-prev-button, .fc-next-button, .fc-dayGridMonth-button, .fc-timeGridWeek-button, .fc-timeGridDay-button').click(function () {
        $('.fc-day').not('.fc-other-month').click(function () {
            $('#myModal').show();
            $('#date').attr("value", $(this).attr('data-date'));
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
