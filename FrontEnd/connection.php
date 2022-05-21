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
    ////////////////Assoc///////////////////////
    ///////////////////////////////////////////
    public static function AsocNewsCateg($aid,$categ,$author)
    {
        $data = [
            'aid' => $aid,
            'categ' => $categ,
            'author' => $author,
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_asoc_news_categories(:aid,:categ,:author)";
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

    public static function GetCategOfArticle($aid,&$categreturn)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetCategOfArticle(:aid)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':aid', $aid, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $CategArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                    $categreturn = $row['CATEGORY'];
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

    public static function AddUser_RE($parUname,$parPass, $parName,$parAp,$parAm,$parMail,$parPhone,$parBdate)
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
            $sql = "CALL sp_User_Insert('I','RE',:usuario,:pass,:nombre,:lastname,:slastname,:mail,:phone,:bdate,0,null)";
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
    public static function GetUname($id, &$unameef)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Get_Uname(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $unameef = $row['USER_ALIAS'];
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

    public static function UpdateArticle($data){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Update_Article(:aid,:updater,:sign,:street,:colon,:city,:state,
            :country,:date,:header,:desc,:content,:thumbnail,:mime,:categ)";
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
                //validacion no esta chida
                }
                else $resultao = true; //validacion esta chida
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

    public static function ChangeArticleStatus($id,$status){
        $data = [
            'id' => $id,
            'status' => $status, 
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_ChangeArticleStatus(:id,:status)";
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
    
    public static function ChangeArticlePubDate($id,$pubdate){
        $data = [
            'id' => $id,
            'pubdate' => $pubdate, 
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_ChangeArticlePubDate(:id,:pubdate)";
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

    public static function LikeArticle($aid,$uid){
        $data = [
            'aid' => $aid,
            'uid' => $uid,
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Like(:aid,:uid)";
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

    public static function DislikeArticle($aid,$uid){
        $data = [
            'aid' => $aid,
            'uid' => $uid,
        ];
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Dislike(:aid,:uid)";
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

    public static function GetLikesArticle($id,&$likes){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetLikes(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $ArticleArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $likes = $row['LIKES'];
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

    public static function GetReactions($id,&$reactionarr){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetReactions(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $ArticleArray= $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($reactionarr,$row);
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
    ////////////////Media(Images and Videos)///
    ///////////////////////////////////////////
    public static function DeleteMediaArticle($aid){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Delete_MediaFromArticle(:aid)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':aid', $aid, PDO::PARAM_INT);
            $stmt->execute();
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
                //validacion no esta chida
                }
                else $resultao = true; //validacion esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

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
                        array_push($blobObj['Name'],$row['DESCRIPTION']);
                        array_push($blobObj['Data'],$row['CONTENT']);
                        array_push($blobObj['Mime'],$row['MIME']);
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
                        array_push($blobObj['Name'],$row['DESCRIPTION']);
                        array_push($blobObj['Data'],$row['CONTENT']);
                        array_push($blobObj['Mime'],$row['MIME']);
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
    ////////////////FeedBacks//////////////////
    ///////////////////////////////////////////
    public static function AddFeedBack($data)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Feedbacks(:text,:by,:for,:aid)";
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

    public static function AddChildrenFeedBack($data)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Feedbacks_Children(:text,:by,:for,:aid,:pid)";
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

    public static function GetFeedBackId($by,$for,$datetime,&$returned){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetFeedbackId(:by,:for,:date)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':by', $by, PDO::PARAM_INT);
            $stmt->bindParam(':for', $for, PDO::PARAM_INT);
            $stmt->bindParam(':date', $datetime, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        $returned = $row['FEEDBACK_ID'];
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

    public static function GetFeedBacksForReporter($forId,&$feedbackarr){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetFeedbacksFor(:id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $forId, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($feedbackarr,$row);
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

    public static function GetFeedBackForArticle($Aid,&$feedbackarr){
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetFeedbacksArticle(:aid)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':aid', $Aid, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($feedbackarr,$row);
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
    ////////////////Comments//////////////////
    ///////////////////////////////////////////
    public static function AddComment($data)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_Comment(:text,:by,:aid)";
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

    public static function AddComentChild($data)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Insert_asoc_news_comments(:text,:by,:aid,:pid)";
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

    public static function GetCommentsArticle($Aid,&$commentarr)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetCommentsArticle(:aid)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':aid', $Aid, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($commentarr,$row);
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

    public static function GetChildCommentsArticle($Aid,&$commentarr)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_GetChildCommentsArticle(:aid)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':aid', $Aid, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($commentarr,$row);
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

    public static function DeleteComment($cid){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Delete_Comment(:cid)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
            $stmt->execute();
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
                //validacion no esta chida
                }
                else $resultao = true; //validacion esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }

    public static function DeleteChildComment($cid){ 
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_Delete_ChildComment(:cid)";
            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_INT);
            $stmt->execute();
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
                //validacion no esta chida
                }
                else $resultao = true; //validacion esta chida
            }
        }
        catch(PDOException $e) {
            echo "Connection failed" . $e->getMessage();
        }

        return $resultao;
    }
    ///////////////////////////////////////////
    ////////////////Busqueda///////////////////
    ///////////////////////////////////////////
    public static function  SearchArticlesByContent($regexpp,&$Articlearr)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CALL sp_SearchArticleBy_Content(:regexpp)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':regexpp', $regexpp, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($Articlearr,$row);
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
    public static function  SearchArticlesBy($regexpp,$parametro,$filtro,&$Articlearr)
    {
        $resultao= false;
        try {
            $conn = new MyPDO();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            switch($filtro){
                case 'FECHA':
                    $sql = "CALL sp_SearchArticleBy_FECHA(:regexpp,:par)";
                break;
                case'PAIS':
                    $sql = "CALL sp_SearchArticleBy_PAIS(:regexpp,:par)";
                break;
                default: return false;
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':regexpp', $regexpp, PDO::PARAM_STR);
            $stmt->bindParam(':par', $parametro, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while($rows = $stmt->fetchAll()) {   
                    foreach ($rows as $row) {
                        array_push($Articlearr,$row);
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
