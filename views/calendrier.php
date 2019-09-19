<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">
<link href='./public/fullCalendar/packages/core/main.css' rel='stylesheet' />
<link href='./public/fullCalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='./public/fullCalendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='./public/dateTimePicker/src/DateTimePicker.css' rel='stylesheet' />

<script src='./public/fullCalendar/packages/core/main.js'></script>
<script src='./public/fullCalendar/packages/core/locales/fr.js'></script>
<script src='./public/fullCalendar/packages/daygrid/main.js'></script>
<script src='./public/fullCalendar/packages/timegrid/main.js'></script>
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
    <div class="modal" id="myModal">
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
                            <input type="time" name="startTime" class="form-control" readonly>
                            <label for="endTime">Heure de fin :</label>
                            <input type="time" name="endTime" class="form-control" readonly>
                            <div id="dtBox"></div>
                            <label for="sel1">Type de salle:</label>
                            <?php
                                $arrSalleTypeNom = fctGetSalle_Type_Nom();
                                foreach($arrExpression as $arrSalleTypeNom){
                                    echo $arrExpression[]
                                }
                            ?>
                            <select class="form-control typeSalle" name="typeSalle">
                                <option>Banalisé 18 places</option>
                                <option>Informatique 18 places</option>
                                <option>Informatique 30 places</option>
                            </select>
                            <select class="form-control b18" name="nomSalle">
                                <option>C1</option>
                                <option>C1</option>
                                <option>C3</option>
                                <option>C4</option>
                                <option>C5</option>
                            </select>
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
    <?php
        include("footer.php");
    ?>
