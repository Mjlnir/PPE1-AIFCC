<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">
<link rel="stylesheet" type="text/css" rel="stylesheet" type="text/css" href='./public/fullCalendar/packages/core/main.css'/>
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/packages/daygrid/main.css'/>
<link rel="stylesheet" type="text/css" href='./public/dateTimePicker/src/DateTimePicker.css'/>

<script src='./public/fullCalendar/packages/core/main.min.js'></script>
<script src='./public/fullCalendar/packages/core/locales/fr.js'></script>
<script src='./public/fullCalendar/packages/daygrid/main.min.js'></script>
<script src='./public/fullCalendar/packages/moment/main.min.js'></script>
<script src='./public/fullCalendar/packages/interaction/main.min.js'></script>
<script src='./public/js/calendar.js'></script>

<script src='./public/dateTimePicker/src/DateTimePicker.js'></script>
<script src='./public/dateTimePicker/src/i18n/DateTimePicker-i18n.js'></script>
<script src='./public/dateTimePicker/src/i18n/DateTimePicker-i18n-fr.js'></script>
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <div id="calendar"></div>
    </div>
    <!-- Modal Create Reservation -->
    <div class="modal" id="createReservation">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Réserver une salle</h4>
                    <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="index.php?action=reserver" method="post">
                        <div class="form-group">
                            <label for="startTime">Heure de début :</label>
                            <input type="time" id="startTime" name="startTime" class="form-control" readonly>
                            <label for="endTime">Heure de fin :</label>
                            <input type="time" id="endTime" name="endTime" class="form-control" readonly>
                            <div id="dtBox"></div>
                            <label>Type de salle:</label>
                            <select class="form-control typeSalle" name="typeSalle">
                                <?php
                                    $arrSalleTypeNom = fctGetType_Salle();
                                    $temp = null;
                                    foreach($arrSalleTypeNom as $arrExpression){
                                        if($temp != $arrExpression['nomTypeSalle']){
                                            $temp = $arrExpression['nomTypeSalle'];
                                            echo "<option value=\"".substr($arrExpression['nomSalle'],0,2)."\">".$arrExpression['nomTypeSalle']."</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "<label>Nom de la salle:</label>";
                                    $temp = null;
                                    foreach($arrSalleTypeNom as $arrExpression){
                                        if($temp != substr($arrExpression['nomSalle'],0,2)){
                                            $temp = substr($arrExpression['nomSalle'],0,2);
                                            echo "<select class=\"form-control nomSalle ".substr($arrExpression['nomSalle'],0,2)."\" name=\"nomSalle\">";
                                        }
                                        echo "<option>".$arrExpression['nomSalle']."</option>";
                                        if(substr($arrExpression['nomSalle'],-1) == "5"){
                                            echo "</select>";
                                        }
                                    }
                                ?>
                                <input id="date" type="hidden" name="date" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger saveMdl" data-dismiss="modal">Réserver</button>
                        </div>
                    </form>
                </div>

                <!-- Modal footer
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger saveMdl" data-dismiss="modal">Réserver</button>
                </div>-->
            </div>
        </div>
    </div>
    <!-- Modal Read Reservation -->
    <div class="modal" id="readReservation">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Description de la réservation</h4>
                    <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="readReservationModalBody">
                    <span id="startTimeRead">Heure de début : </span>
                    <span id="endTimeRead">Heure de fin : </span>
                    <span id="salleRead">Nom de la salle: </span>
                    <span id="ligueRead">Nom de la ligue: </span>
                </div>
            </div>
        </div>
    </div>
<?php
    include("footer.php");
?>
