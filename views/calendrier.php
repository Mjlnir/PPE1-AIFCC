<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/calendrier.css">
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/core/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/daygrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/fullCalendar/timegrid/main.css' />
<link rel="stylesheet" type="text/css" href='./public/datetimepicker-master/build/jquery.datetimepicker.min.css' />

<script src='./public/js/calendar.js'></script>

<script type="text/javascript" src='./public/fullCalendar/core/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/core/locales/fr.js'></script>
<script type="text/javascript" src='./public/fullCalendar/daygrid/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/timegrid/main.js'></script>
<script type="text/javascript" src='./public/fullCalendar/interaction/main.js'></script>
<script type="text/javascript" src='./public/js/moment-with-locales.js'></script>
<!--<script src='./public/fullCalendar/moment/main.js'></script>-->
<script type="text/javascript" src='./public/datetimepicker-master/build/jquery.datetimepicker.full.js'></script>
<script type="text/javascript">
    var userLigue_id = '<?php echo $_SESSION['ligue']['idLigue'];?>';

</script>
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
                                    $arrSalles = fctGet_Salles();
                                    $arrNomLigues = fctGetLigues();
                            
                                    $temp = null;
                                
                                    
                                    echo "<select class=\"form-control typeSalle\" name=\"typeSalle\">";
                                     foreach($arrSalles as $Salle){
                                        if($temp != $Salle['typeSalle'].$Salle['nbPersonneMax']){
                                            $temp = $Salle['typeSalle'].$Salle['nbPersonneMax'];
                                            echo "<option id=\"".substr($Salle['typeSalle'],0,1).
                                                substr($Salle['nbPersonneMax'],0,1)."\">";
                                            echo $Salle['typeSalle']." ".$Salle['nbPersonneMax']." places";
                                            echo "</option>";
                                        }
                                    }
                                    echo "</select>";
                                
                                    echo "<label>Nom de la salle :</label>";
                                    $temp = null;
                                    foreach($arrSalles as $arrSalle){
                                        if($temp != substr($arrSalle['nomSalle'],0,2)){
                                            $temp = substr($arrSalle['nomSalle'],0,2);
                                            echo "<select class=\"form-control nomSalle ".substr($arrSalle['nomSalle'],0,2)."\" id=\"nomSalle\">";
                                        }
                                        echo "<option id=\"".$arrSalle['nomSalle']."\">".$arrSalle['nomSalle']."</option>";
                                        if(substr($arrSalle['nomSalle'],-1) == "5"){
                                            echo "</select>";
                                        }
                                    }
                            
                                    echo "<label class=\"ligueTab\">Nom de la Ligue :</label>";
                                    echo "<select class=\"form-control ligueTab\" id=\"nomLigue\">";
                                    foreach($arrNomLigues as $arrNomLigue){
                                        if($arrNomLigue['idLigue'] != 0){
                                            echo "<option class=\"ligueTab\" id=\"".$arrNomLigue['idLigue']."\">".$arrNomLigue['nomLigue']."</option>";
                                        }
                                    }
                                    echo "</select>";
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
