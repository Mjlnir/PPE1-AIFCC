<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php?action=home"><img src="./public/image/Triathlon_all_3_stages_pictogram_white.png" alt="Logo M2L" style="width:40px;"></a>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item" id="calendrier">
            <a class="nav-link" href="index.php?action=calendrier">Calendrier</a>
        </li>
        <?php
            if(!isset($_SESSION['ligue'])){
               echo "<li class=\"nav-item\" id=\"modifSalles\">
                        <a class=\"nav-link\" href=\"index.php?action=modifSalles\">Salles</a>
                    </li>";
                echo "<li class=\"nav-item\" id=\"modifLigues\">
                        <a class=\"nav-link\" href=\"index.php?action=modifLigues\">Ligues</a>
                    </li>";
            }
        ?>
        <li class="nav-item dropdown ml-auto">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user']['loginUtilisateur']; ?></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="index.php?action=user" class="dropdown-item">Paramètres</a>
                <div class="dropdown-divider"></div>
                <a href="index.php?action=logOut" class="dropdown-item">Déconnexion</a>
            </div>
        </li>
    </ul>
    <span class="navbar-brand">
        <?php
            if($_SESSION['user']['idTypeUtilisateur'] == 0){
                echo "Administrateur";
            }
            else{
                echo "Ligue ".$_SESSION['ligue']['nomLigue'];
            }
        ?>
    </span>
</nav>
