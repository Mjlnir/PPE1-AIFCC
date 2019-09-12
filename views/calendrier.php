<?php
	include("header.php");
?>
    <link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">

    <link href='./public/fullCalendar/packages/core/main.css' rel='stylesheet' />
    <link href='./public/fullCalendar/packages/daygrid/main.css' rel='stylesheet' />
    <!--<link href='./public/fullCalendar/packages/timegrid/main.css' rel='stylesheet' />-->

    <script src='./public/fullCalendar/packages/core/main.js'></script>
    <script src='./public/fullCalendar/packages/core/locales/fr.js'></script>
    <script src='./public/fullCalendar/packages/daygrid/main.js'></script>
    <!--<script src='./public/fullCalendar/packages/timegrid/main.js'></script>-->
    <script src='./public/js/calendar.js'></script>
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <div id="calendar"></div>
    </div>
    <?php
        include("footer.php");
    ?>
