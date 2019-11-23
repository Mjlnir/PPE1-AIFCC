    <?php
        require_once("../src/calendar/month.php");
        require_once("../src/calendar/events.php");
        $events = new PPE1\Calendar\Events();
        $month = new PPE1\Calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
        $firstDay = $month->getFirstDay();
        $firstDay = $firstDay->format('N') === '1' ? $firstDay : $month->getFirstDay()->modify('last monday');
        $weeks = $month->getWeeks();
        $endDay = (clone $firstDay)->modify('+'.(6 + 7 * ($weeks - 1)).' days');
        $events = $events->getEventsBetween($firstDay,$endDay);
        require_once("../views/header.php");
    ?>
    <div class="d-flex flex-row align-items-center  justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>
    <table class="calendar__table calendar__table--<?= $weeks ?>weeks">
        <?php for ($i = 0; $i < $weeks; $i++): ?>
        <tr>
            <?php foreach($month->days as $k => $day): 
                $date = (clone $firstDay)->modify("+".($k + $i * 7)." days");
                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
            ?>
                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth' ?>">
                    <?php if ($i ===0): ?>
                        <div class="calendar__weekday"><?= $day ?></div>
                    <?php endif ?>
                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                    <?php foreach($eventsForDay as $event): ?>
                        <div class="calendar__event">
                            <?= (new DateTime($event['start']))->format('H:i'); ?> - <a href="/event.php?id=<?= $event['id']; ?>"><?= $event['name']; ?></a>
                        </div>
                    <?php endforeach; ?>
                </td>
            <?php endforeach ?>
        </tr>
        <?php endfor; ?>
    </table>
<?php include("../views/footer.php") ?>
