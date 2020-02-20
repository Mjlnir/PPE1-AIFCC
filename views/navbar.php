<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top"> <a class="navbar-brand" href="index.php?action=home"><img src="./public/image/Triathlon_all_3_stages_pictogram_white.png" alt="Logo M2L" style="width:40px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item" id="calendrier">
                <a class="nav-link" href="index.php?action=calendrier">Calendrier</a>
            </li>
            <li class="nav-item" id="modifSalles">
                <a class="nav-link" href="index.php?action=modifSalles">Salles</a>
            </li>
            <li class="nav-item" id="modifLigues">
                <a class="nav-link" href="index.php?action=modifLigues">Ligues</a>
            </li>
            <li class="nav-item" id="logOut">
                <a href="index.php?action=logOut" class="nav-link">Déconnexion</a>
            </li>
        </ul>
        <span class="navbar-brand">
            <?php
                echo $_SESSION['user']['loginUtilisateur'];
                echo " | ";
                if($_SESSION['user']['idTypeUtilisateur'] == 1){
                    echo "Administrateur";
                }
                else{
                    echo "Ligue ".$_SESSION['ligue']['nomLigue'];
                }
            ?>
        </span>
    </div>
</nav>
