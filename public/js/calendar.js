$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid', 'timeGrid', 'interaction', 'moment'],
        defaultView: 'dayGridMonth',
        defaultDate: moment().format("YYYY-MM-DD"),
        header: {
            left: 'title',
            right: 'prev,next today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        navLinks: false, // can click day/week names to navigate views
        selectable: true,
        selectHelper: false,
        editable: false,
        droppable: false,
        dateClick: function (info) {
            $('#createReservation').show();
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
            $('#startTimeRead').html("Heure de début: " + moment(info.event.start).format("HH:mm"));
            $('#endTimeRead').html("Heure de fin: " + moment(info.event.end).format("HH:mm"));
            var titleSplit = info.event.title.split(" ");
            $('#salleRead').html("Nom de la salle: " + titleSplit[0]);
            $('#ligueRead').html("Nom de la ligue: " + titleSplit[1]);
        }
    });

    calendar.render();
    
    $('#startTime').change(function(){
        alert('OK');
    });

    $('.closeMdl').click(function () {
        $('#createReservation').hide();
        $('#createReservation').find('input').val('');
        $('#readReservation').hide();
    });

    $('.saveMdl').click(function () {
        $('#createReservation').hide();
    });

    $.datetimepicker.setLocale('fr');
    $('#startTime').datetimepicker({
        datepicker: false,
        allowTimes: [
            '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
            '15:00', '16:00', '17:00', '18:00'
        ]
    });
    
    $('#endTime').datetimepicker({
        datepicker: true,
        allowTimes: [
            '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
            '15:00', '16:00', '17:00', '18:00'
        ]
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
