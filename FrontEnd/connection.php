<?php

include 'MyPdo.php';

class connection {

    function function_alert($message) {
      
        // Display the alert box 
        echo "<script>alert('$message');</script>";
    }
    
    //Abro Connecsao
    public static function connect()
    {
	  try {
		$conn = new MyPDO();
	  }
	  catch(PDOException $e) {
		echo "Connection failed" . $e->getMessage();
	  }
	  return $conn;
    }
    public static function validUser($parUname,$parPass)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_ValidUser(:usuario,:pass)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $parUname, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $parPass, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $resultao = true;
                //validacion esta chida
            } 
            else {
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

    public static function AddUser_UR(
    $parUname,
    $parPass,
    $parName,
    $parAp,
    $parAm,
    $parMail,
    $parPhone,
    $parBdate){
        $resultao= false;
        $data = [
            'usuario' => $parUname,
            'pass' => $parPass,
            'nombre' => $parName,
            'lastname' => $parAp,
            'slastname' => $parAm,
            'mail' => $parMail,
            'phone' => $parPhone,
            'bdate' => $parBdate,
        ];
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_User_Insert('I','UR',:usuario,:pass,:nombre,:lastname,:slastname,:mail,:phone,:bdate,0,null)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $conn->commit();
            if ($stmt->rowCount() > 0) {
                $x = 1;
                $resultao = true;
                //validacion esta chida
            } 
            else {
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

    public static function getDatosUsuario($parUname,&$DatosUsuarioArray)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Get_DatosUsuario(:usuario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $parUname, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $DatosUsuarioArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $DatosUsuarioArray = $row;
                    }
                }
                $resultao = true;
            } 
            else {
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

    public static function GetCategories(&$CategArray)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Get_Categories()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $CategArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    $CategArray = $rows;
                }
                $resultao = true;
            } 
            else {
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

}
