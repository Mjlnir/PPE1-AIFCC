<?php
/********************************************************
*** FONCTIONS TECHNIQUES ********************************
********************************************************/

function DBLog(){
    try  
    {
        $conn = new PDO("sqlsrv:Server=localhost,1433;Database=M2L", "M2L", "MPM2L");
        if($conn)
        {
            return $conn;
        }
        else
        {
            echo "La connexion n'a pu être établie.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
    }
    catch (PDOException $e)
    {
        echo 'Échec lors de la connexion : ' . $e->getMessage();
    } 
}

function fctLogin($login, $mdp)
{
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_LOGIN :pseudo,:mdp";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $login);
        $query->bindParam(":mdp", $mdp);
        $query->execute();
        
        $row = $query->fetch();

        return $row[0] == 1;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctEstAdmin($pseudo)
{
	try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_EST_ADMIN :pseudo";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $_POST['pseudo']);
        $query->execute();
        
        while ($row = $query->fetch())
        {
            if($row[0] == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGetUser($pseudo)
{
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_GET_USER :pseudo";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $_SESSION['pseudo']);
        $query->execute();
        
        $row = $query->fetch();
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

/********************************************************
*** FONCTIONS METIER ************************************
********************************************************/

function onglet($action, $titre)
{
    if(!isset($_GET['action']))
    {
        $_GET['action'] = "accueil";
    }
    if($_GET['action'] == $action)
    {
        echo "<li class='current'><a href='index.php?action=".$action."'>".$titre."</a></li>";
    }
    else
    {
        echo "<li><a href='index.php?action=".$action."'>".$titre."</a></li>";
    }
}

function modifUser($nom, $prenom, $mail, $tel)
{
    if(!preg_match("/^[0-9]{10}$/", $tel))
    {
        return "Numéro téléphone non valide. \"ex: 0123456789\"";    
    }
}
?>