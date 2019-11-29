$(document).ready(function () {
    //Variable globale
    var eventInfoID;

    moment.locale('fr');
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
        weekends: false,
        minTime: '08:00',
        maxTime: '19:00',
        dateClick: function (info) {
            $('#createReservation ').show();
            var dateDebut = moment(info.dateStr).format().replace(/-/g, '/').replace('T', ' ').slice(0, -9);
            var dateFin = moment(info.dateStr).add(1, 'hours').format().replace(/-/g, '/').replace('T', ' ').slice(0, -9);
            $('#startTime').val(dateDebut);
            $('#endTime').val(dateFin);
        },
        events: "index.php?action=getReservation",
        allDaySlot: false,
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        eventClick: function (info) {
            eventInfoID = info.event.id;

            $('#createReservation ').show();
            $('#startTime').val(moment(info.event.start).format("l") + ' ' + moment(info.event.start).format("LT"));
            $('#endTime').val(moment(info.event.end).format("l") + ' ' + moment(info.event.end).format("LT"));
            
            $('#nomSalle option').removeAttr("selected");
            $('.typeSalle option').removeAttr("selected");
            $('#nomLigue option').removeAttr("selected");
            $('.nomSalle').hide();

            var optionIdSalle = $('#' + info.event.extendedProps.nomSalle);
            optionIdSalle.prop('selected',true);
            var varTypeSalle = optionIdSalle.parent().attr('class').split(' ')[2];
            $('.' + varTypeSalle).show();
            $('#' + varTypeSalle).prop('selected',true);
            $('#' + info.event.extendedProps.nomLigue).attr("selected", "selected");
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
        $('option').each(function () {
            if ($(this).attr('disabled') == 'disabled') {
                $(this).removeAttr('disabled');
            }
        });
        $.ajax({
            url: "index.php?action=estReservable",
            type: "POST",
            data: {
                dateDebutFuturReservation: moment($('#startTime').val()).format().slice(0, -6),
                dateFinFuturReservation: moment($(this).val()).format().slice(0, -6)
            },
            dataType: "json"
        }).done(function (data) {
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
        $.post("index.php?action=reserver", {
            startTime: moment($('#startTime').val()).format().slice(0, -6),
            endTime: moment($('#endTime').val()).format().slice(0, -6),
            nomSalle: $("#nomSalle:visible :selected").text(),
            idLigue: $("#nomLigue :selected").attr("value"),
            description: null
        }, function (data) {
            $('#createReservation').hide();
            calendar.refetchEvents();
        });
    });

    $('#deleteMdl').click(function () {
        $.post("index.php?action=delReservation", {
            idReservation: eventInfoID
        }, function (data) {
            $('#readReservation').hide();
            calendar.refetchEvents();
        });
    });

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
    $(document).on('click', '.typeSalle', function () {
        //    $('.typeSalle').click(function () {
        var typeSalleChoosen = $(this).children("option:selected").attr('id');
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
