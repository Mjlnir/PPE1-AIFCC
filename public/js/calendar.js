document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr',
        plugins: ['dayGrid'],
        defaultView: 'dayGridMonth',
        header: {
            center: 'addEventButton'
        },
        customButtons: {
            addEventButton: {
                text: 'Réserver',
                click: function () {
                    var dateStr = prompt('Entrer une date au format AAAA-MM-JJ.');
                    var date = new Date(dateStr + 'T00:00:00');

                    if (!isNaN(date.valueOf())) {
                        calendar.addEvent({
                            title: 'dynamic event',
                            start: date,
                            allDay: false
                        });
                        alert('Great. Now, update your database...');
                    } else {
                        alert('Date invalide.');
                    }
                }
            }
        }
    });

    calendar.render();
});
