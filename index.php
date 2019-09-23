<?php
    session_start();
    require_once("fonctions.php");

    if(isset($_GET['action'])) 
    {
        switch ($_GET['action'])
        {
            case "sigUpVerif" :
                /*if()
                {

                }*/
                break;
            case "signIn" :
                include("views/signIn.php");
                break;
            case "signInVerif":
                if(fctLogin($_POST['pseudo'], $_POST['pwd']))
                {
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
              case "signUp" :
                include("views/signUp.php");
                break;
              case "logOut":
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
    if(isset($_POST['action']))
    {
        switch($_POST['action']){
            case "getReservation":
                echo fctGetReservation();
                break;       
        }
    }
?>
