<?php
	include("views/header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/modifSalle_Ligue.css">
<script src='./public/js/modifSalles.js'></script>
<script type="text/javascript">
    var userLigue_id = '<?php echo $_SESSION['ligue']['idLigue'];?>';

</script>
</head>

<body class="d-flex flex-column">
    <div id="page-content">
        <?php
            include("views/navbar.php");
        ?>
        <br>
        <br>
        <br>
        <div class="scroll">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Salle</th>
                        <th scope="col">Places</th>
                        <th scope="col">Informatisée</th>
                        <th scope="col">Active</th>
                    </tr>
                </thead>
                <tbody id="tbSalle">
                    <?php
                        include("views/afficherSalles.php");
                    ?>
                </tbody>
            </table>
            <button class="btn btn-danger" id="btnCreateSalle">Créer Salle</button>
        </div>
        <!-- Modal Nom -->
        <div class="modal" id="nomMdl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Nom de la salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Changer le nom de la salle ?</label>
                        <input type="text" id="nomSalle" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnNomMdl" data-dismiss="modal">Changer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal nbPlaceMax -->
        <div class="modal" id="nbSalleMaxMdl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Nombre de place d'une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Changer le nombre de place de la salle ?</label>
                        <input type="number" id="nbPlace" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnNbPlaceMaxMdl" data-dismiss="modal">Changer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal createSalle -->
        <div class="modal" id="createSalleMdl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Créer une salle</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Nom de la salle :</label>
                        <input type="text" id="createNomSalle" class="form-control">
                        <label>Nombre de place :</label>
                        <input type="number" id="createNbPlaceSalle" class="form-control">
                        <label>Type :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="informatiseRadio" id="banRadio" value="1">
                            <label class="form-check-label" for="banRadio">Banalisé</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="informatiseRadio" id="infRadio" value="2">
                            <label class="form-check-label" for="infRadio">Informatisé</label>
                        </div>
                        <label>Active :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estActiveRadio" id="estActive" value="1">
                            <label class="form-check-label" for="estActive">Oui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estActiveRadio" id="pasActive" value="0">
                            <label class="form-check-label" for="pasActive">Non</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnCreate" data-dismiss="modal">Créer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("views/footer.php");
?>
