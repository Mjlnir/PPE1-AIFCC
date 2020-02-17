$(document).ready(function () {
    //Variable globale
    var eventInfoID; //Permet de passer l'id d'une réservation à un event
    var eventUpdateClick; //Permet de savoir si l'utilisateur click sur une réservation pour activer la modification et non l'ajout de réservation

    function toTimestamp(_tDate) {
        var starTime = _tDate;
        var starTimeToDate = starTime.match(/(\d+)\/(\d+)\/(\d+) (\d+):(\d+)/);
        var starTimeToTimestamp = (new Date(starTimeToDate[3], parseInt(starTimeToDate[2], 10) - 1, starTimeToDate[1], starTimeToDate[4], starTimeToDate[5]).getTime() / 1000);
        return starTimeToTimestamp;
    }

    function RefreshSalleLibres(dateDebut, dateFin) {
        $.ajax({
            url: "index.php?action=estReservable",
            type: "POST",
            data: {
                dateDebutFuturReservation: toTimestamp(dateDebut),
                dateFinFuturReservation: toTimestamp(dateFin)
            },
            dataType: "json"
        }).done(function (data) {
            if (data != null) {
                for (let iCpt = 0; iCpt < data.length; iCpt++) {
                    $('#nomSalle option[id="' + data[iCpt] + '"]').attr('disabled', true);
                }
                $('#nomSalle option:not([disabled]):first').attr('selected', true);
            }
        });
    }

    //    jQuery.datetimepicker.setLocale('fr');

    //    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        locale: 'fr',
        plugins: ['dayGrid', 'timeGrid', 'interaction'],
        defaultView: 'timeGridWeek',
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
            var dateEvent = new Date(info.dateStr);
            var date = new Date();
            //Si la date choisit est inférieur à la date d'aujourd'hui on ne montre pas le modal de réservation
            if (dateEvent.getTime() >= date.getTime()) {
                if (userLigue_id != 0) {
                    $(".ligueTab").attr('hidden', '');
                }

                $('#createReservation ').show();
                $('#CU_title').text('Réserver une salle');
                $('#saveMdl').html('Réserver');
                var date = new Date(info.dateStr);
                var dateDebut = date.toLocaleDateString() + " " + date.toLocaleTimeString();
                var hourFin = date.setHours(date.getHours() + 1);
                var dateFin = date.toLocaleDateString() + " " + date.toLocaleTimeString();

                $('#startTime').val(dateDebut);
                $('#endTime').val(dateFin);
                RefreshSalleLibres(dateDebut, dateFin);
            }
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
            var dateEvent = info.event.end;
            var date = new Date();
            //Si la date de fin de la réservation est inférieur à la date d'aujourd'hui on ne montre pas l'event
            if (dateEvent.getTime() > date.getTime()) {
                eventInfoID = info.event.id;
                eventUpdateClick = true;

                $('#createReservation').show();
                $('#CU_title').text('Modifier une réservation');

                $('#deleteMdl').removeAttr('hidden');
                $('#saveMdl').html('Modifier');

                $('#startTime').val(new Date(info.event.start).toLocaleDateString() + " " + new Date(info.event.start).toLocaleTimeString());
                $('#endTime').val(new Date(info.event.end).toLocaleDateString() + " " + new Date(info.event.end).toLocaleTimeString());

                $('#nomSalle option').each(function () {
                    $(this).removeAttr("selected");
                });
                $('.typeSalle option').each(function () {
                    $(this).removeAttr("selected");
                });
                $('#nomLigue option').each(function () {
                    $(this).removeAttr("selected");
                });
                $('.nomSalle').hide();

                var optionIdSalle = $('#' + info.event.extendedProps.idSalle);
                optionIdSalle.prop('selected', true);
                var varTypeSalle = optionIdSalle.parent().attr('class').split(' ')[2];
                $('.' + varTypeSalle).show();
                $('#' + varTypeSalle).prop('selected', true);
                var optionIdLigue = $('#' + info.event.extendedProps.idLigue);
                optionIdLigue.prop('selected', true);
            }
        }
    });

    calendar.render();

    //TODO #startTime
    $('#endTime').change(function () {
        var startTime = new Date($('#startTime').val()).toLocaleDateString() + " " + new Date($('#startTime').val()).toLocaleTimeString();
        var endTime = new Date($('#endTime').val()).toLocaleDateString() + " " + new Date($('#endTime').val()).toLocaleTimeString();
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
        RefreshSalleLibres($('#startTime').val(), $(this).val());
    });

    $('.closeMdl').click(function () {
        $('#createReservation').hide();
        $('#createReservation').find('input').val('');
        if (eventUpdateClick) {
            eventUpdateClick = false;
        }
    });

    $('#saveMdl').click(function () {
        if (eventUpdateClick) {
            if (userLigue_id == $("#nomLigue :selected").attr("id")) {
                $.post("index.php?action=updateReservation", {
                    idLigue: $("#nomLigue :selected").attr("id"),
                    startTime: toTimestamp($('#startTime').val()),
                    endTime: toTimestamp($('#endTime').val()),
                    nomSalle: $("#nomSalle:visible :selected").text(),
                    description: "",
                    idReservation: eventInfoID
                }, function () {
                    eventUpdateClick = false;
                    $('#createReservation').hide();
                    calendar.refetchEvents();
                });
            }
        } else {
            $.post("index.php?action=reserver", {
                idLigue: $("#nomLigue :selected").attr("id"),
                startTime: toTimestamp($('#startTime').val()),
                endTime: toTimestamp($('#endTime').val()),
                nomSalle: $("#nomSalle:visible :selected").text(),
                description: ""
            }, function () {
                $('#createReservation').hide();
                calendar.refetchEvents();
            });
        }
    });

    $('#deleteMdl').click(function () {
        eventUpdateClick = false;
        $.post("index.php?action=delReservation", {
            idReservation: eventInfoID
        }, function () {
            $('#createReservation').hide();
            calendar.refetchEvents();
        });
    });

    $('#startTime').datetimepicker({
        setLocale: 'fr',
        datepicker: false,
        allowTimes: [
                '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
                '15:00', '16:00', '17:00', '18:00'
            ]
    });

    $('#endTime').datetimepicker({
        setLocale: 'fr',
        datepicker: true,
        allowTimes: [
                '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
                '15:00', '16:00', '17:00', '18:00'
            ]
    });

    $('.I1').hide();
    $('.B3').hide();
    $(document).click('.typeSalle', function () {
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
