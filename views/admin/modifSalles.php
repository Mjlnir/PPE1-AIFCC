<?php
	include("views/header.php");
?>
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
                        
                        echo "<td><a href=\"#\" id=\"aSignUp\"><span class=\"octicon octicon-tools\"></span></a></td>";
                        echo "<td><a href=\"#\" id=\"aSignUp\"><span class=\"octicon octicon-trashcan\"></span></a></td>";
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
