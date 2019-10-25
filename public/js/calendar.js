$(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid', 'interaction', 'moment'],
        defaultView: 'dayGridMonth',
        defaultDate: moment().format("YYYY-MM-DD"),
        header: {
            left: 'title',
            right: 'prev,next today'// dayGridMonth'
        },
        navLinks: false, // can click day/week names to navigate views
        selectable: true,
        selectHelper: false,
        editable: false,
        droppable: false,
        dateClick: function (info) {
            $('#createReservation').show();
            $('#startTime').val(info.dateStr);
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

    $('#endTime').change(function () {
        $.ajax({
            url: "index.php?action=estReservable",
            type: "POST",
            data: {
                dateDebutFuturReservation: $('#startTime').val(),
                dateFinFuturReservation: $(this).val()
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
                idLigue: $('#nomLigue').children(":selected").attr("id")
            },
            dataType: "json"
        }).done(function (data) {
            if (data != null) {
                $('#createReservation').hide();
            }
        });
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

    $('#endTime').change(function () {
        var startTime = new Date($('#startTime').val()).getTime();
        var endTime = new Date($('#endTime').val()).getTime();
        if (endTime < startTime) {
            $('#endTime').addClass('error');
            $('#dateError').removeAttr("hidden");
            $('#saveMdl').attr('disabled', '');
        } else {
            $('#endTime').removeClass('error');
            $('#dateError').attr('hidden', '');
            $('#saveMdl').removeAttr('disabled');
        }
    });

});
