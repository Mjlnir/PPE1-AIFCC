<?php
    $arrLigues = fctGetLigues();
    $iCpt = 1;
    foreach($arrLigues as $ligue){
        echo "<tr>";
        echo "<th scope=\"row\">".$iCpt."</th>";
        echo "<td><a href=\"#\" class=\"btnNomLigue\" id=\"".$ligue['idLigue']."\">".$ligue['nomLigue']."</a></td>";
        
        $utilisateur = fctGetUserId($ligue['idUtilisateur']);
        
        echo "<td><a href=\"#\" class=\"btnUserLigue\" id=\"".$ligue['idLigue']."\">".$utilisateur['loginUtilisateur']."</a></td>";
        
        echo "<td><a href=\"#\" class=\"btnActiveLigue\" id=\"".$ligue['idLigue']."\"><span class=\"octicon ";
        if($ligue['estActive'] == 0){
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
