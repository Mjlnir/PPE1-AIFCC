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
                          
                    }
                  break;
                  case "Accueil" :
                        include("vues/Accueil.php");
                  break;
                  case "sigUp" :
                        include("vues/signUp.php");
                  break;
          }
    }
    else
    {
        header('Location: index.php?action=signIn');
    }

    /*if(!isset($_GET['action']))
    {
        $_GET['action'] = 'logout';
    }

    switch($_GET['action'])
    {
        case 'login':
            if(login($_POST['pseudo'], $_POST['mdp']))
            {
                if(estAdmin($_POST['pseudo']))
                {
                    $_SESSION['admin'] = true;
                }
                else
                {
                    $_SESSION['admin'] = false;
                }
                $_SESSION['pseudo'] = $_POST['pseudo'];
                $_GET['action'] = 'compte';
                include("views/logedIn.php");
            }
            else
            {
                $alert = true;
                include("views/logedOut.php");
            }
        break;
        case 'modifInfoUser':
            if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['mail']) || !isset($_POST['telephone']))
            {
               $message = modifUser($_POST['nom'],$_POST['prenom'],$_POST['mail'],$_POST['telephone']);
               if($message != 'OK')
               {
                $alert = true;
               }
               include("views/logedIn.php");
            }
            else
            {
                $alert = true;
                $message = "Information incorrect.";
                include("views/logedIn.php");
            }
            break;


        case 'logout':
            unset($_SESSION['pseudo']);
            unset($_SESSION['admin']);
            include("views/logedOut.php");
        break;
        case 'compte':
            $_GET['action'] = 'compte';
            include("views/logedIn.php");
        break;
        case 'calendrier':
            $_GET['action'] = 'calendrier';
            include("views/calendrier.php");
        break;
        case 'salles':
            $_GET['action'] = 'salles';
            include("views/salles.php");
        break;
        case 'reservation':
            $_GET['action'] = 'reservation';
            include("views/reservation.php");
        break;
    }*/
?>
