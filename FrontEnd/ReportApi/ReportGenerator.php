<?php
class MyPDO extends PDO
{
    public function __construct($file = 'config/conn_settings.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}

class Report{
  
  private static function GetArticles(&$ArticleArray){
      $resultao= false;
      try {
          $conn = new MyPDO();
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $sql = "CALL sp_Rep_GetArticles()";
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

  private static function GetSimpleArticles(&$ArticleArray){
    $resultao= false;
    try {
        $conn = new MyPDO();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CALL sp_Rep_GetArticles_Simple()";
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

  public static function GenReport(&$htmlstr,&$message,$tableid,$simple){
    $articleArray =[];
    $PuArtArr=[];
    $thead_open ="<thead>";
    $thead_close ="</thead>";
    $tbody_open ="<tbody>";
    $tbody_close ="</tbody>";
    $tbl_open ="<table id='".$tableid."'>";
    $tbl_close ="</table>";
    $hdr_open ="<th>";
    $hdr_close="</th>";
    $row_open ="<tr>";
    $row_close ="</tr>";
    $d_open ="<td>";
    $d_close ="</td>";
    if($simple){
      if(!Report::GetSimpleArticles($articleArray)){$message.="Couldn't Get Articles at connection::GetArticles";return false;}
    }
    else{
      if(!Report::GetArticles($articleArray)){$message.="Couldn't Get Articles at connection::GetArticles";return false;}
    }
    if(!count($articleArray) > 0){$message.="No Articles in Array";return false;}
    foreach($articleArray as $art){
      if($art['ARTICLE_STATUS']=='PU')array_push($PuArtArr,$art);
    }
    if(!count($PuArtArr) > 0){$message.="No Published Articles in Array";return false;}
    $Likes = array_column($PuArtArr, 'LIKES');
    array_multisort($Likes,SORT_DESC,$PuArtArr);
    $keys = array_keys($PuArtArr[0]);
    $htmlstr.=$tbl_open;
    $htmlstr.=$thead_open;
    $htmlstr.=$row_open;
    foreach($keys as $k){
      $htmlstr.=$hdr_open;
      $htmlstr.=$k;
      $htmlstr.=$hdr_close;
    }
    $htmlstr.=$row_close;
    $htmlstr.=$thead_close;
    $htmlstr.=$tbody_open;
    foreach($PuArtArr as $art){
      $htmlstr.=$row_open;
      foreach($art as $val){
        $htmlstr.=$d_open;
        $htmlstr.=$val;
        $htmlstr.=$d_close;
      }
      $htmlstr.=$row_close;
    }
    $htmlstr.=$tbody_close;
    $htmlstr.=$tbl_close;
    return true;
  }
}

?>