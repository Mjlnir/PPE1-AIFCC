<?php
function DBLog(){
    try  
    {
        $conn = new PDO("sqlsrv:Server=localhost,1433;Database=M2L", "M2L", "M2L");
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

function fctSignIn($login, $mdp)
{
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_SIGNIN :pseudo,:mdp";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $login);
        $query->bindParam(":mdp", $mdp);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row[0] == 1;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctSignUp($prenom, $nom, $mail, $tel, $mdp)
{
    try
    {
        $conn = DBLog();
        $outputReturn;

        // execute the stored procedure
        $sql = "EXEC PRC_SIGNUP :prenom, :nom, :mail, :tel, :mdp";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":prenom", $prenom);
        $query->bindParam(":nom", $nom);
        $query->bindParam(":mail", $mail);
        $query->bindParam(":tel", $tel);
        $query->bindParam(":mdp", $mdp);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
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
        $sql = "EXEC PRC_EST_ADMIN :pseudo";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $pseudo);
        $query->execute();
        
        while ($row = $query->fetch())
        {
            return $row[0] == 1;
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
        $sql = "EXEC PRC_GET_USER :pseudo";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $pseudo);
        $query->execute();
        
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGetLigue($idUtilisateur)
{
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_LIGUE :idUtilisateur";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idUtilisateur", $idUtilisateur);
        $query->execute();
        
        $row = $query->fetch(PDO::FETCH_ASSOC);
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGetLigues()
{
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_LIGUES";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->execute();
        
        $row = $query->fetchAll();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGet_Salles(){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_SALLES";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->execute();
        
        $row = $query->fetchAll();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGet_Salles_Reserve($datedebut, $datefin){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_SALLES_RESERVE :datedebut, :datefin";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":datedebut", $datedebut);
        $query->bindParam(":datefin", $datefin);
        $query->execute();
        
        $row = $query->fetchAll();
        
        $iCpt = 0;
        foreach($row as $result)
        {
         $data[] = $result["nomSalle"];
         $iCpt++;
        }
        $query -> closeCursor();
        
        return json_encode($data);
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGetReservation(){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_RESERVATION";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->execute();
        
        $row = $query->fetchAll();
        $iCpt = 0;
        foreach($row as $result)
        {
         $data[] = array(
          'id'      => $iCpt,
          'title'   => $result["title"],
          'start'   => $result["start"],
          'end'     => $result["end"]
         );
            $iCpt++;
        }
        
        $query -> closeCursor();
        
        return json_encode($data);
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}
function fctRerserver($startTime, $endTime, $nomSalle, $idLigue){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_RESERVER :endTime, :startTime, :nomSalle, :idUser, :idLigue";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":endTime", $endTime);
        $query->bindParam(":startTime", $startTime);
        $query->bindParam(":nomSalle", $nomSalle);
        $query->bindParam(":idUser", $_SESSIONS['user']['idUtilisateur']);
        if($_SESSION['user']['idTypeUtilisateur'] == 1){
            $query->bindParam(":idLigue", $_SESSIONS['ligue']['idLigue']);
        }
        else{
            $query->bindParam(":idLigue", $idLigue);
        }
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctGet_Utilisateur($idUtilisateur){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_GET_UTILISATEUR :idUtilisateur";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idUtilisateur", $idUtilisateur);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}

function fctActiveSalle($idSalle){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_UPD_ACTIVE_SALLE :idSalle";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idSalle", $idSalle);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}
function fctInformatiseeSalle($idSalle){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_UPD_INFORMATISEE_SALLE :idSalle";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idSalle", $idSalle);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}
function fctNbPlaceMaxSalle($idSalle, $nbPlaceMax){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_UPD_NBPLACE_SALLE :idSalle,:nbPlaceMax";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":nbPlaceMax", $nbPlaceMax);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}
function fctNomSalle($idSalle, $nomSalle){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRC_UPD_NOM_SALLE :idSalle,:nomSalle";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":idSalle", $idSalle);
        $query->bindParam(":nomSalle", $nomSalle);
        $query->execute();
        
        $row = $query->fetch();
        
        $query -> closeCursor();
        
        return $row;
    }
    catch (PDOException $e)
    {
        die("Error occurred:" . $e->getMessage());
    }
}
?>
