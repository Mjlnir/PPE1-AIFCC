<?php
    session_start();
    require_once("fonctions.php");

    if(isset($_GET['action'])) 
    {
        switch ($_GET['action'])
        {
            case "signUp" :
                if(fctSignUp($_POST['prenom'], $_POST['nom'], $_POST['mail'], $_POST['tel'], $_POST['mdp']))
                {
                    $_SESSION['signUpSuccess'] = 1;
                    include("views/signIn.php");
                }
                else
                {
                    $_SESSION['signUpSuccess'] = 0;
                    include("views/signIn.php");
                }
                break;
            case "signIn" :
                include("views/signIn.php");
                break;
            case "signInVerif":
                if(fctSignIn($_POST['pseudo'], $_POST['pwd']))
                {
                    unset($_SESSION['user']);
                    unset($_SESSION['ligue']);
                    
                    $_SESSION['user'] = fctGetUser($_POST['pseudo']);
                    if($_SESSION['user']['idTypeUtilisateur'] == 1){
                        $_SESSION['ligue'] = fctGetLigue($_SESSION['user']['idUtilisateur']);
                    }
                    include("views/home.php");
                }
                else
                {
                    header("Location: index.php?action=signIn");
                }
                break;
              case "logOut":
                unset($_SESSION['user']);
                include("views/signIn.php");
                break;
              case "home":
                include("views/home.php");
                break;
              case "calendrier":
                include("views/calendrier.php");
                break;
              case "user":
                include("views/user.php");
                break;
              case "getReservation":
                echo fctGetReservation();
                break;
              case "estReservable":
                echo fctGet_Salles_Reserve($_POST['dateDebutFuturReservation'],
                                           $_POST['dateFinFuturReservation']);
                break;
              case "reserver":
                fctRerserver($_POST['startTime'],
                             $_POST['endTime'],
                             $_POST['nomSalle'],
                             $_POST['idLigue']);
                break;
            case "modifSalles":
                include("views/admin/modifSalles.php");
                break;
            case "modifLigues":
                include("views/admin/modifLigues.php");
                break;
            case "UPD_activeSalle":
                fctActiveSalle($_POST['idSalle']);
                break;
            case "UPD_informatiseeSalle":
                fctInformatiseeSalle($_POST['idSalle']);
                break;
            case "getSalle":
                include("views/admin/afficherSalle.php");
                break;
            case "UPD_nbPlaceMaxSalle":
                fctNbPlaceMaxSalle($_POST['idSalle'],$_POST['nbPlaceMax']);
                break;
            case "UPD_nomSalle":
                fctNomSalle($_POST['idSalle'],$_POST['nomSalle']);
                break;
          }
    }
    else
    {
        header('Location: index.php?action=signIn');
    }
?>
