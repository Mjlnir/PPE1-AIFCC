<?php
                                    $arrSalles = fctGet_Salles();
                                    $arrNomLigues = fctGetLigues();
                            
                                    $temp = null;
                                
                                    
                                    echo "<select class=\"form-control typeSalle\" name=\"typeSalle\">";
                                     foreach($arrSalles as $Salle){
                                        if($temp != $Salle['typeSalle'].$Salle['nbPersonneMax']){
                                            $temp = $Salle['typeSalle'].$Salle['nbPersonneMax'];
                                            echo "<option id=\"".substr($Salle['typeSalle'],0,1).
                                                substr($Salle['nbPersonneMax'],0,1)."\">";
                                            echo $Salle['typeSalle']." ".$Salle['nbPersonneMax']." places";
                                            echo "</option>";
                                        }
                                    }
                                    echo "</select>";
                                
                                    echo "<label>Nom de la salle :</label>";
                                    $temp = null;
                                    foreach($arrSalles as $arrSalle){
                                        if($temp != substr($arrSalle['nomSalle'],0,2)){
                                            $temp = substr($arrSalle['nomSalle'],0,2);
                                            echo "<select class=\"form-control nomSalle ".substr($arrSalle['nomSalle'],0,2)."\" id=\"nomSalle\">";
                                        }
                                        echo "<option id=\"".$arrSalle['idSalle']."\">".$arrSalle['nomSalle']."</option>";
                                        if(substr($arrSalle['nomSalle'],-1) == "5"){
                                            echo "</select>";
                                        }
                                    }
                                    
                                    if($_SESSION['user']['idTypeUtilisateur'] == 1){
                                        echo "<label class=\"ligueTab\">Nom de la Ligue :</label>";
                                        echo "<select class=\"form-control ligueTab\" id=\"nomLigue\">";
                                        foreach($arrNomLigues as $arrNomLigue){
                                            if($arrNomLigue['idLigue'] != 0){
                                                echo "<option class=\"ligueTab\" id=\"".$arrNomLigue['idLigue']."\">".$arrNomLigue['nomLigue']."</option>";
                                            }
                                        }
                                        echo "</select>";
                                    }
                                ?>