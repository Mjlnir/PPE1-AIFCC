<?php
    session_start();
    require_once("fonctions.php");

    if(isset($_GET['action'])) 
    {
        switch ($_GET['action'])
        {
            case "signUp" :
                $azeaz =  fctSignUp($_POST['prenom'], $_POST['nom'], $_POST['mail'], $_POST['tel'], $_POST['mdp']);
                echo $azeaz;
                /*if(fctSignUp($_POST['prenom'], $_POST['nom'], $_POST['mail'], $_POST['tel'], $_POST['mdp']))
                {
                    header("Location: index.php?action=signIn&success=1");
                }
                else
                {
                    header("Location: index.php?action=signIn&success=0");
                }*/
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
          }
    }
    else
    {
        header('Location: index.php?action=signIn');
    }
?>
