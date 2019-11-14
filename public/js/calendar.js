$(document).ready(function () {
    moment.locale('en');
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid', 'timeGrid', 'interaction', 'moment'],
        defaultView: 'timeGridWeek',
        //defaultDate: moment().format(),
        header: {
            left: 'title',
            right: 'prev,next today' // dayGridMonth'
        },
        navLinks: false, // can click day/week names to navigate views
        selectable: true,
        selectHelper: false,
        editable: false,
        droppable: false,
        dateClick: function (info) {
            $('#createReservation').show();
            var $date = moment(info.dateStr).format().replace(/-/g,'/').replace('T',' ').slice(0,-9);
            $('#startTime').val($date);
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
            $('#startTimeRead').html("Heure de début: " + moment(info.event.start).format("l") + ' ' + moment(info.event.start).format("LT"));
            $('#endTimeRead').html("Heure de fin: " + moment(info.event.end).format("l") + ' ' + moment(info.event.end).format("LT"));
            var titleSplit = info.event.title.split(" ");
            $('#salleRead').html("Nom de la salle: " + titleSplit[0]);
            $('#ligueRead').html("Nom de la ligue: " + titleSplit[1]);
        }
    });

    calendar.render();

    $('#endTime').change(function () {
        var startTime = moment($('#startTime').val());
        var endTime = moment($('#endTime').val());
        if (endTime < startTime) {
            $('#endTime').addClass('error');
            $('#dateError').removeAttr("hidden");
            $('#saveMdl').attr('disabled', '');
        } else {
            $('#endTime').removeClass('error');
            $('#dateError').attr('hidden', '');
            $('#saveMdl').removeAttr('disabled');
        }
//        alert(moment($('#startTime').val()).format().slice(0,-6) + ' ' + moment($(this).val()).format().slice(0,-6));
        $.ajax({
            url: "index.php?action=estReservable",
            type: "POST",
            data: {
                dateDebutFuturReservation: moment($('#startTime').val()).format().slice(0,-6),
                dateFinFuturReservation: moment($(this).val()).format().slice(0,-6)
            },
            dataType: "json"
        }).done(function (data) {
            console.log(data);
            if (data != null) {
                for (iCpt = 0; iCpt < data.length; iCpt++) {
                    $('#' + data[iCpt]).attr('disabled', '');
                }
            }
        });
    });

    $('.closeMdl').click(function () {
        $('#createReservation').hide();
        $('#createReservation').find('input').val('');
        $('#readReservation').hide();
    });

    $('#saveMdl').click(function () {
        $.ajax({
            url: "index.php?action=reserver",
            type: "POST",
            data: {
                startTime: $('#startTime').val(),
                endTime: $('#endTime').val(),
                nomSalle: $("#nomSalle option:selected").text(),
                idLigue: $("#nomLigue option:selected").attr("value")
            },
            dataType: "html"
        }).done(function (data) {
            $('#createReservation').hide();
        });
    });

    //$.datetimepicker.setLocale('fr');
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
    $('.B3').hide();
    $('.typeSalle').click(function () {
        var typeSalleChoosen = $(this).children("option:selected").val();
        switch (typeSalleChoosen) {
            case 'I1':
                $('.I1').show();
                $('.B3').hide();
                $('.B1').hide();
                break;
            case 'B3':
                $('.I1').hide();
                $('.B3').show();
                $('.B1').hide();
                break;
            case 'B1':
                $('.I1').hide();
                $('.B3').hide();
                $('.B1').show();
                break;
        }
    });
});
