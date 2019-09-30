<?php
//FONCTIONS TECHNIQUES

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
        $sql = "EXEC PRD_SIGNIN :pseudo,:mdp";
        
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

        // execute the stored procedure
        $sql = "EXEC PRD_SIGNUP :prenom, :nom, :mail, :tel, :mdp";
        
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
        $sql = "EXEC PRD_EST_ADMIN :pseudo";
        
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
        $sql = "EXEC PRD_GET_USER :pseudo";
        
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

function fctGet_Salles(){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_GET_SALLES";
        
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

//FONCTIONS METIER
function fctGetReservation(){
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_GET_RESERVATION";
        
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
function fctRerserver($startTime, $endTime, $typeSalle, $date){
    if(!isset($startTime) && !isset($endTime) && !isset($typeSalle) && !isset($date)){
        $row[0] = 1;
        return $row;
    }
}

function fctVerifReservation($startTime, $endTime, $typeSalle, $date){
    if($startTime == null || $endTime == null || $typeSalle == null){
        return -999;
    }
    
    $dtStartTime = Date($date." ".$startTime.":00");
    $dtEndTime = Date($date." ".$endTime.":00");
    
    try
    {
        $conn = DBLog();

        // execute the stored procedure
        $sql = "EXEC PRD_VERIF_RESERVATION :pseudo";
        
        // call the stored procedure
        $query = $conn->prepare($sql);
        $query->bindParam(":pseudo", $_SESSION['pseudo']);
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
