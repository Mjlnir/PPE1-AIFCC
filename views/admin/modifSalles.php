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
                        <th scope="col">Informatisée</th>
                        <th scope="col">Active</th>
                        <th scope="col">Modifier</th>
                    </tr>
                </thead>
                <tbody id="tbSalle">
                    <?php
                        include("views/admin/afficherSalle.php");
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Modal Modif Reservation -->
        <div class="modal" id="modifSalleMdl">
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
                                <label></label>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="btnUpdateMdl" data-dismiss="modal">Modifier</button>
                                <button class="btn btn-danger" id="btnCancelMdl" data-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Delete Reservation -->
        <div class="modal" id="nbSalleMdl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Nombre de place d'une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="index.php?action=nbPlaceSalle" method="post">
                            <label>Changer le nombre de place de la salle ?</label>
                            <input type="number" id="nbPlace" name="nbPlace" class="form-control">
                            <div class="modal-footer">
                                <button class="btn btn-danger" id="btnNbPlaceMdl" data-dismiss="modal">Changer</button>
                                <button class="btn btn-danger" id="btnCancelMdl" data-dismiss="modal">Annuler</button>
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
