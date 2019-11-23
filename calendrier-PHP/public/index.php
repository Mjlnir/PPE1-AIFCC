<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/calendrier.css">
</head>

<body>
    <?php
        require_once("../src/date/month.php");
        $month = new PPE1\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
        $firstDay = $month->getFirstDay()->modify('last monday');
    ?>
    <div class="d-flex flex-row align-items-center  justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>
    <table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
        <?php for ($i = 0; $i < $month->getWeeks(); $i++): ?>
        <tr>
            <?php foreach($month->days as $k => $day): 
                $date = (clone $firstDay)->modify("+".($k + $i * 7)." days")
            ?>
                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth' ?>">
                    <?php if ($i ===0): ?>
                        <div class="calendar__weekday"><?= $day ?></div>
                    <?php endif ?>
                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                </td>
            <?php endforeach ?>
        </tr>
        <?php endfor; ?>
    </table>
</body>

</html>
