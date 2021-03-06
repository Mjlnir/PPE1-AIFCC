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
                    $_SESSION['ligue'] = fctGetLigue($_SESSION['user']['idUtilisateur']);
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
                if($_SESSION['user']['idTypeUtilisateur'] == 1){
                    echo fctGetReservation();   
                }
                else{
                    echo fctGetReservationByID($_SESSION['ligue']['idLigue']);
                }
                break;
              case "estReservable":
                echo fctGet_Salles_Reserve($_POST['dateDebutFuturReservation'],
                                           $_POST['dateFinFuturReservation']);
                break;
              case "reserver":
                if($_SESSION['user']['idTypeUtilisateur'] == 2){
                    $idLigue = $_SESSION['ligue']['idLigue'];
                }
                else{
                    $idLigue = $_POST['idLigue'];
                }
                echo fctRerserver($_POST['startTime'],
                                  $_POST['endTime'],
                                  $_POST['nomSalle'],
                                  $_SESSION['user']['idUtilisateur'],
                                  $idLigue,
                                  $_POST['description']);
                break;
            case "updateReservation":
                if($_SESSION['user']['idTypeUtilisateur'] == 2){
                    $idLigue = $_SESSION['ligue']['idLigue'];
                }
                else{
                    $idLigue = $_POST['idLigue'];
                }
                echo fctUpdateRerservation($_POST['startTime'],
                                  $_POST['endTime'],
                                  $_POST['nomSalle'],
                                  $_SESSION['user']['idUtilisateur'],
                                  $idLigue,
                                  $_POST['description'],
                                  $_POST['idReservation']);
                break;
            case "delReservation":
                echo fctDelRerservation($_POST['idReservation']);
                break;
            case "modifSalles":
                include("views/modifSalles.php");
                break;
            case "modifLigues":
                include("views/modifLigues.php");
                break;
            case "getSalles":
                include("views/afficherSalles.php");
                break;
            case "getLigues":
                include("views/afficherLigues.php");
                break;
            case "UPD_activeSalle":
                echo fctActiveSalle($_POST['idSalle']);
                break;
            case "UPD_informatiseeSalle":
                echo fctInformatiseeSalle($_POST['idSalle']);
                break;
            case "UPD_nbPlaceMaxSalle":
                echo fctNbPlaceMaxSalle($_POST['idSalle'],$_POST['nbPlaceMax']);
                break;
            case "UPD_nomSalle":
                echo fctNomSalle($_POST['idSalle'],$_POST['nomSalle']);
                break;
            case "ADD_createSalle":
                echo fctAddSalle($_POST['nbPlaceMax'],$_POST['nomSalle'],$_POST['estActive'],$_POST['informatise']);
                break;
            case "UPD_activeLigue":
                echo fctActiveLigue($_POST['idLigue']);
                break;
            case "UPD_nomLigue":
                echo fctNomLigue($_POST['idLigue'],$_POST['nomLigue']);
                break;
            case "UPD_nomUserLigue":
                echo fctNomUserLigue($_POST['idLigue'],$_POST['idUserLigue']);
                break;
            case "ADD_Ligue":
                echo fctAddLigue($_POST['nomLigue'],$_POST['userLigue'],$_POST['estActive']);
                break;
          }
    }
    else
    {
        header('Location: index.php?action=signIn');
    }
?>
