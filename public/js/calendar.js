$(document).ready(function () {
            //Variable globale
            var eventInfoID; //Permet de passer l'id d'une réservation à un event
            var eventUpdateClick; //Permet de savoir si l'utilisateur click sur une réservation pour activer la modification et non l'ajout de réservation

            //    var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                locale: 'fr',
                plugins: ['dayGrid', 'timeGrid', 'interaction'],
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
                    //Passer les dates de début et de fin en timestamp et les reconvertir en date dans sql pour la réservation, ATTENTION le timestamp en JS est en ms /1000 pour les s
                    //            var TAMERE = dateDebut.match(/(\d+)\/(\d+)\/(\d+) (\d+):(\d+)/);
                    //            var TAMERE2 = new Date(TAMERE[3], parseInt(TAMERE[2], 10) - 1, TAMERE[1], TAMERE[4], TAMERE[5]).getTime() / 1000;
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
                    eventUpdateClick = true;

                    $('#createReservation').show();
                    $('#CU_title').text('Modifier une réservation');

                    $('#deleteMdl').removeAttr('hidden');
                    $('#saveMdl').html('Modifier');

                    $('#startTime').val(moment(info.event.start).format("l") + ' ' + moment(info.event.start).format("LT"));
                    $('#endTime').val(moment(info.event.end).format("l") + ' ' + moment(info.event.end).format("LT"));

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
            });

            calendar.render();

            //TODO #startTime
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
                            $('#nomSalle option[id="' + data[iCpt] + '"]').attr('disabled', '');
                        }
                    }
                });
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
                                startTime: moment($('#startTime').val()).format("YYYY-DD-MM HH:MM:SS"),
                                endTime: moment($('#endTime').val()).format("YYYY-DD-MM HH:MM:SS"),
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
                            startTime: moment($('#startTime').val()).format().slice(0, -6),
                            endTime: moment($('#endTime').val()).format().slice(0, -6),
                            nomSalle: $("#nomSalle:visible :selected").text(),
                            description: ""
                        }, function () {
                            $('#createReservation').hide();
                            calendar.refetchEvents();
                        });
                        //        }
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

                $('.I1').hide(); $('.B3').hide(); $(document).click('.typeSalle', function () {
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
