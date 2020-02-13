<?php
	include("views/header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/modifSalle.css">
<script src='./public/js/modifLigues.js'></script>
<script type="text/javascript">
    var userLigue_id = '<?php echo $_SESSION['ligue']['idLigue'];?>';
</script>
</head>

<body class="d-flex flex-column">
    <?php
        include("views/navbar.php");
    ?>
    <div id="page-content">
        <table class="table scroll">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ligue</th>
                    <th scope="col">Utilisateur</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody id="tbLigue">
                <?php
                    include("views/admin/afficherLigues.php");
                ?>
            </tbody>
        </table>
    <!-- Modal Nom -->
        <div class="modal" id="nomMdl">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Nom de la ligue</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Changer le nom de la ligue ?</label>
                        <input type="text" id="nomLigue" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnNomMdl" data-dismiss="modal">Changer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal nomUser -->
        <div class="modal" id="nomUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Changer d'utilisateur</h4>
                        <button type="button" class="close closeMdl" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Changer l'utilisateur de la ligue ?</label>
                        <?php
                            $arrUserLigues = fctGetUsers();
                            echo "<select class=\"form-control\" id=\"nomUserLigue\">";
                            foreach($arrUserLigues as $arrUserLigue){
                                echo "<option id=\"".$arrUserLigue['idUtilisateur']."\">".$arrUserLigue['loginUtilisateur']."</option>";
                            }
                            echo "</select>";
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btnNomUserMdl" data-dismiss="modal">Changer</button>
                        <button class="btn btn-danger btnCancelMdl" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("views/footer.php");
?>
