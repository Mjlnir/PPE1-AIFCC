<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/core/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/daygrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/timegrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/datetimepicker-master/build/jquery.datetimepicker.min.css' />

<script src='./public/js/calendar.js'></script>

<script src='./public/fullCalendar/core/main.js'></script>
<script src='./public/fullCalendar/core/locales/fr.js'></script>
<script src='./public/fullCalendar/daygrid/main.js'></script>
<script src='./public/fullCalendar/timegrid/main.js'></script>
<script src='./public/fullCalendar/interaction/main.js'></script>
<script src='./public/js/moment-with-locales.js'></script>
<!--<script src='./public/fullCalendar/moment/main.js'></script>-->
<script src='./public/datetimepicker-master/build/jquery.datetimepicker.full.js'></script>
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <div id="calendar"></div>
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
                                <label for="startTime">Date et heure de début :</label>
                                <input type="text" id="startTime" name="startTime" class="form-control">
                                <label for="endTime">Date et heure de fin :</label>
                                <input type="text" id="endTime" name="endTime" class="form-control">
                                <label>Type de salle:</label>
                                <select class="form-control typeSalle" name="typeSalle">
                                    <?php
                                    $arrSalleTypeNom = fctGet_Salles();
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
                                        echo "<option id=\"".$arrExpression['nomSalle']."\">".$arrExpression['nomSalle']."</option>";
                                        if(substr($arrExpression['nomSalle'],-1) == "5"){
                                            echo "</select>";
                                        }
                                    }
                                ?>
                                    <input id="date" type="hidden" name="date" value="">
                                </select>
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
                        <span id="startTimeRead"></span>
                        <span id="endTimeRead"></span>
                        <span id="salleRead"></span>
                        <span id="ligueRead"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include("footer.php");
?>
