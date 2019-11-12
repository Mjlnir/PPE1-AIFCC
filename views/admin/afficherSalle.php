<?php
    $arrSalles = fctGet_Salles();
    $iCpt = 1;
    foreach($arrSalles as $salle){
        echo "<tr>";
            echo "<th scope=\"row\">".$iCpt."</th>";
            echo "<td class=\"btnNomSalle\" id=\"".$salle['idSalle']."\"><a href=\"#\">".$salle['nomSalle']."</a></td>";
            echo "<td class=\"btnNbPlaceSalle\" id=\"".$salle['idSalle']."\"><a href=\"#\">".$salle['nbPersonneMax']."</a></td>";

            echo "<td class=\"btnTypeSalle\" id=\"".$salle['idSalle']."\"><a href=\"#\"><span class=\"octicon ";
            if($salle['idTypeSalle'] == 0){
               echo "octicon-x\">"; 
            }
            else{
                echo "octicon-check\">"; 
            }
            echo "</span></a></td>";

            echo "<td class=\"btnActiveSalle\" id=\"".$salle['idSalle']."\"><a href=\"#\"><span class=\"octicon ";
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
