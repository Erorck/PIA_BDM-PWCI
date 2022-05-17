<?php
include 'MyPdo.php';
class connection {

    function function_alert($message) 
    {
      
        // Display the alert box 
        echo "<script>alert('$message');</script>";
    }
    
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
    ///////////////////////////////////////////
    ////////////////USER///////////////////////
    ///////////////////////////////////////////
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

    public static function AddUser_UR($parUname,$parPass, $parName,$parAp,$parAm,$parMail,$parPhone,$parBdate)
    {
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

    public static function GetUserId($uname, &$idref)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetUserId(:usuario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $uname, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $idref = $row['ID_USER'];
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
     ///////////////////////////////////////////
    ////////////////CATEGORIES/////////////////
    ///////////////////////////////////////////
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

    public static function AddCategory($CName,$Color,$AdId)
    {
        $data = [
            'Nombre' => $CName,
            'Color' => $Color,
            'AdId' => $AdId,
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Categories(:Nombre,:Color,:AdId)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $conn->commit();
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

    public static function SetCategOrder($CName,$NewOrder)
    {
        $data = [
            'Nombre' => $CName,
            'Orden' => $NewOrder, 
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_SetCategOrder(:Nombre,:Orden)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $done = $stmt !== false ? true : false;
            $conn->commit();
            if ($stmt->rowCount() > 0) {
                $resultao = true;
                //validacion esta chida
            } 
            else {
                if($done == false){
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                }
                else $resultao = true;
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

    public static function UpdateCategNameColor($Clave, $CName,$Color)
    {
        $data = [
            'Clave' =>$Clave,
            'Nombre' => $CName,
            'Color' => $Color, 
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_UpdateCategNameColor(:Clave,:Nombre,:Color)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $done = $stmt !== false ? true : false;
            $conn->commit();
            if ($stmt->rowCount() > 0) {
                $resultao = true;
                //validacion esta chida
            } 
            else {
                if($done == false){
                $resultao = false;
                $Errmessage = "PDOStatement::errorCode(): ". $stmt->errorCode();
                }
                else $resultao = true;
                //validacion no esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }
     ///////////////////////////////////////////
    ////////////////Articles////////////////////
    ///////////////////////////////////////////
    public static function GetCountArticles(&$count, $status){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "";
            switch($status){
                case "All":$sql = "CALL sp_GetCountArticles()";
                break;
                case "RR":$sql = "CALL sp_GetCountArticlesRR()";
                break;
                case "RA": $sql = "CALL sp_GetCountArticlesRA()";
                break;
                case "PU": $sql = "CALL sp_GetCountArticlesPU()";
                break;
                case "EL":$sql = "CALL sp_GetCountArticlesEL()";
                break;
                default: $sql = "CALL sp_GetCountArticles()";
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $count = $row['num'];
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
    
    public static function AddArticle($data){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Article(:sign,:street,:colon,:city,:state,
            :country,:date,:header,:desc,:content,:thumbnail,:mime,:author,:categ)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($data);
            $conn->commit();
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

    public static function GetImageArticle($id,&$imageObj){ //THUMBNAIl ONLY
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetArticleImg(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $imageObj['data'] = $row['THUMBNAIL'];
                        $imageObj['mime'] = $row['THUMBNAIL_MIME'];
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

    public static function GetIdArticleBy_DA_H_Cby(&$id,$date,$Header,$AuthorId){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetArticleId_DHCby(:date,:header,:authorid)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':header', $Header, PDO::PARAM_STR);
            $stmt->bindParam(':authorid', $AuthorId, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $id = $row['ARTICLE_ID'];
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

    public static function GetArticles(&$ArticleArray)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetArticles()";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $ArticleArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    $ArticleArray = $rows;
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
    ///////////////////////////////////////////
    ////////////////Media(Images and Videos)///
    ///////////////////////////////////////////
    public static function InsertMediaImage($datarray){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Image(:Aid,:Desc,:Content,:Mime,:Route)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($datarray);
            $conn->commit();
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

    public static function InsertMediaVideo($datarray){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Video(:Aid,:Desc,:Content,:Mime,:Route)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->execute($datarray);
            $conn->commit();
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

    public static function GetMediaImage($id,&$blobObj){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL SP_GetImage(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $blobObj['Data'] = $row['CONTENT'];
                        $blobObj['Mime'] = $row['MIME'];
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
    
    public static function GetMediaVideo($id,&$blobObj){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL SP_GetVideo(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $blobObj['Data'] = $row['CONTENT'];
                        $blobObj['Mime'] = $row['MIME'];
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

}
