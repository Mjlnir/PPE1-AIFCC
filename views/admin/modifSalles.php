<?php
	include("views/header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/modifSalle.css">
<script src='./public/js/modifSalles.js'></script>
</head>

<body class="d-flex flex-column">
    <?php
        include("views/navbar.php");
    ?>
    <div id="page-content">
        <div class="scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Places</th>
                        <th scope="col">Type</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $arrSalles = fctGet_Salles();
                    $iCpt = 1;
                    foreach($arrSalles as $salle){
                        echo "<tr>";
                        echo "<th scope=\"row\">".$iCpt."</th>";
                        echo "<td>".$salle['nomSalle']."</td>";
                        echo "<td>".$salle['nbPersonneMax']."</td>";
                        if($salle['idTypeSalle'] == 0){
                           echo "<td><span class=\"octicon octicon-briefcase\"></span></td>"; 
                        }
                        else{
                            echo "<td><span class=\"octicon octicon-device-desktop\"></span></td>"; 
                        }
                        
                        echo "<td><a href=\"#\"  id=\"tdModifSalle\"><span class=\"octicon octicon-tools\"></span></a></td>";
                        echo "<td id=\"delSalle\"><a href=\"#\"><span class=\"octicon octicon-trashcan\"></span></a></td>";
                        echo "</tr>";
                        $iCpt++;
                    }
                ?>
                </tbody>
            </table>
        </div>
        <!-- Modal Modif Reservation -->
        <div class="modal" id="modifSalle">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modifier une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="index.php?action=reserver" method="post">
                            <div class="form-group">

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" id="saveMdl" data-dismiss="modal">Réserver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Delete Reservation -->
        <div class="modal" id="deleteSalle">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Supprimer une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="index.php?action=reserver" method="post">
                            <div class="form-group">

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" id="saveMdl" data-dismiss="modal">Réserver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("views/footer.php");
?>
