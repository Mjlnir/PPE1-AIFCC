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
                    $_SESSION['user'] = fctGetUser($_POST['pseudo']);
                    include("views/home.php");
                }
                else
                {
                    header("Location: index.php?action=signIn");
                }
                break;
              case "reserver":
                echo fctRerserver();
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
          }
    }
    else
    {
        header('Location: index.php?action=signIn');
    }
?>
