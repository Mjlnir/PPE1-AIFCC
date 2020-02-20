<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/core/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/daygrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/timegrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/datetimepicker-master/build/jquery.datetimepicker.min.css' />

<script type="text/javascript" src='./public/fullCalendar/core/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/core/locales/fr.js'></script>
<script type="text/javascript" src='./public/fullCalendar/daygrid/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/timegrid/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/interaction/main.js'></script>
<script type="text/javascript" src='./public/datetimepicker-master/build/jquery.datetimepicker.full.js'></script>

<script src='./public/js/calendar.js'></script>
<script type="text/javascript">
    var userLigue_id = '<?php echo $_SESSION['ligue']['idLigue'];?>';
</script>
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <br>
        <br>
    
        <div id="calendar"></div>
        <!-- Modal Create Reservation -->
        <div class="modal" id="createReservation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="CU_title">Réserver une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="startTime">Date et heure de début :</label>
                            <input type="text" id="startTime" name="startTime" class="form-control">
                            <label for="endTime">Date et heure de fin :</label>
                            <input type="text" id="endTime" name="endTime" class="form-control">
                            <small id="dateError" class="form-text" hidden>Erreur entre les dates.</small>
                            <label>Type de salle :</label>
                            <?php
                                    include("views/afficherSallesLibres.php");
                                ?>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="saveMdl" data-dismiss="modal">Réserver</button>
                        <button class="btn btn-danger" id="deleteMdl" data-dismiss="modal" hidden>Supprimer</button>
                        <button class="btn btn-danger closeMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include("footer.php");
?>
