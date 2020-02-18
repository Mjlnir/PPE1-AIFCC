<?php
	include("header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/modifSalle_Ligue.css">
<script src='./public/js/user.js'></script>
<script type="text/javascript">
    var userLigue_id = '<?php echo $_SESSION['ligue']['idLigue'];?>';
    var userUser_id = '<?php echo $_SESSION['user']['idUtilisateur'];?>';
</script>
</head>

<body class="d-flex flex-column">
    <?php
        include("navbar.php");
    ?>
    <div id="page-content">
        <h2>Modifier ses informations</h2>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Mot de passe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include("views/afficherUserSettings.php");
                    ?>
                </tbody>
            </table>
        </div>
        <h2>Modifier les informations de la ligue</h2>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include("views/afficherLigueSettings.php");
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
                        <h4 class="modal-title">Nom de l'utilisateur</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Changer le nom de l'utilisateur' ?</label>
                        <input type="text" id="nomUser" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnNomMdl" data-dismiss="modal">Changer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
	include("footer.php");
?>
