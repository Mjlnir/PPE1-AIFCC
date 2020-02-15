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
    <?php
        include("views/navbar.php");
    ?>
    <div id="page-content">
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
                        include("views/admin/afficherSalles.php");
                    ?>
                </tbody>
            </table>
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
    </div>
    <?php
    include("views/footer.php");
?>
