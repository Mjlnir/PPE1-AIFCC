<?php
    require_once("../views/header.php");
    require_once("../src/calendar/events.php");
    $events = new PPE1\Calendar\Events();
    if(!isset($_GET['id'])){
        header('location: /404.php');
    }
    $events = $events->find($_GET['id'] ?? null);
?>
<h1></h1>
<?php include("../views/footer.php") ?>
