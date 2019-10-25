<?php
	include("views/header.php");
?>
<link rel="stylesheet" type="text/css" href="./public/css/modifSalle.css">
</head>

<body class="d-flex flex-column">
    <?php
        include("views/navbar.php");
    ?>
    <div id="page-content">
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $arrLigues = fctGetLigues();
                    $iCpt = 1;
                    foreach($arrLigues as $ligue){
                        echo "<tr>";
                        echo "<th scope=\"row\">".$iCpt."</th>";
                        echo "<td>".$ligue['nomLigue']."</td>";
                        $utilisateur = fctGet_Utilisateur($ligue['idUtilisateur']);
                        echo "<td><a href=\"#\">".$utilisateur['loginUtilisateur']."</span></a></td>";
                        echo "<td><a href=\"#\"><span class=\"octicon octicon-tools\"></span></a></td>";
                        echo "<td><a href=\"#\"><span class=\"octicon octicon-trashcan\"></span></a></td>";
                        echo "</tr>";
                        $iCpt++;
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    include("views/footer.php");
?>
