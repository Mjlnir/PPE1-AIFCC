<?php
    $arrSalles = fctGet_Salles();
    $iCpt = 1;
    foreach($arrSalles as $salle){
        echo "<tr>";
            echo "<th scope=\"row\">".$iCpt."</th>";
            echo "<td><a href=\"#\" class=\"btnNomSalle\" id=\"".$salle['idSalle']."\">".$salle['nomSalle']."</a></td>";
            echo "<td><a href=\"#\" class=\"btnNbPlaceSalle\" id=\"".$salle['idSalle']."\">".$salle['nbPersonneMax']."</a></td>";

            echo "<td><a href=\"#\" class=\"btnTypeSalle\" id=\"".$salle['idSalle']."\"><span class=\"octicon ";
            if($salle['idTypeSalle'] == 0){
               echo "octicon-x\">"; 
            }
            else{
                echo "octicon-check\">"; 
            }
            echo "</span></a></td>";

            echo "<td><a href=\"#\" class=\"btnActiveSalle\" id=\"".$salle['idSalle']."\"><span class=\"octicon ";
            if($salle['estActive'] == 0){
               echo "octicon-x\">"; 
            }
            else{
                echo "octicon-check\">";
            }
            echo "</span></a></td>";
        echo "</tr>";
        $iCpt++;
    }
?>
