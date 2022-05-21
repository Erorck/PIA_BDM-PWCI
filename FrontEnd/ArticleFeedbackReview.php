<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Categorias =[];
    $feedbacks = [];
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $numFeedbacks = 0;
    $hasfeedbacks = false;
    $Articulo = null;
    $hasimages=false;
    $hasvideos=false;
    $articleCateg = "";
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        if(strcmp($Perfil->USER_TYPE,'RE')!==0){
            header('Location: '.'403.html');
        }
    }
    else{
        header('Location: '.'403.html');
    }
    if(connection::GetCountArticles($numArticles,"XD")) $ArticlesExist = true;
    if(connection::GetCountArticles($numRRArticles,"RR")) $ArticlesRRExist = true;
    if(connection::GetCountArticles($numRAArticles,"RA")) $ArticlesRAExist = true;
    if(connection::GetCountArticles($numPUArticles,"PU")) $ArticlesPUExist = true;
    if($ArticlesRRExist)
    {
        if(connection::GetArticles($datarray)){
            foreach($datarray as $art){
                $arti = new Articulo($art);
                if($arti->ARTICLE_ID == intval($_GET['ArticleId'])){
                    $Articulo = $arti;
                    break;
                }
            }
        }
        
    }
    if($Articulo!=null){
        //getArticleCateg
        connection::GetCategOfArticle($Articulo->ARTICLE_ID,$articleCateg);
        //get thumbnail
        $thmBlob = [];
        connection::GetImageArticle($Articulo->ARTICLE_ID,$thmBlob);
       //get all media
       $ImgBlobarr = [];
       $ImgBlobarr['Name'] = [];
       $ImgBlobarr['Data'] = [];
       $ImgBlobarr['Mime'] = [];
       $vBlobarr = [];
       $vBlobarr['Name'] = [];
       $vBlobarr['Data'] = [];
       $vBlobarr['Mime'] = [];
       
        if(connection::GetMediaImage($Articulo->ARTICLE_ID,$ImgBlobarr)){
            $hasimages = true;
        }
        if(connection::GetMediaVideo($Articulo->ARTICLE_ID,$vBlobarr)){
            $hasvideos = true;
        }
        //get feedbacks
        if(connection::GetFeedBackForArticle($Articulo->ARTICLE_ID,$feedbacks)){
            $hasfeedbacks = true;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Articulo</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
            $(document).ready(function() {
                var d = new Date();
                var month = d.getMonth()+1;
                var strmonth = "";
                month >= 10 ? (strmonth = month.toString()) : (strmonth = '0'+month.toString());
                //TAMBIEN DESPUES CONTINUAR CON LA VALIDACION DEL FORM Y hacer el PHP PARA EL INSERT va?
                var strDate = d.getFullYear() + "-" + strmonth + "-" + d.getDate() + "T23:59";
                $('#BtnSendArticle').click(function(e){
                   e.preventDefault();
                   $('#ProcesFeedbackForm').submit();
                });
                $('#BtnEditArticle').click(function(e){
                    e.preventDefault();
                    $('#ProcesFeedbackForm').attr('action', 'EditarNoticia.php');
                    $('#ProcesFeedbackForm').submit();
                });
                $('#BtnDeleteArticle').click(function(e){
                    e.preventDefault();
                });
                $('#ProcesFeedbackForm').on('submit',function(e){
                    let timerInterval
                        Swal.fire({
                        title: 'Cargando...',
                        timer: 5000,
                        timerProgressBar: true,
                        showCancelButton: false,
                        showConfirmButton: false,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        });
                    // e.preventDefault();
                    //alert('lasubmitie xd');
                });
            });
      </script>
</head>

<body>
    <div class="Contenedor-base">
        <div class = "Barra-navegacion">
            <h3 class="Logo-web">Noticias</h3>
            <a href="index.php">Volver Al Indice</a>
            <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a>
            <form action="Busqueda.php" name="F_Search" class="SearchBarForm">
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda"></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            <?php
                if(!$LoggedUser){
                echo'
                <div id="accountHyperlinks">
                <a href="Login.php">Ingresar</a>
                <a href="Register.php">Registrarse</a>
                </div>';
                }
                else{
                    echo '<div id="Account">
                    <h3><a href="Perfil.php">'.$Perfil->USER_ALIAS.'</a></h3>
                    </div>';
                }
                ?>
            </form>
        </div>

        <div class="mainContenedor">
            <div class="ZonaFeed" id="newview">
            <button type="button" style="background-color:gray; color:white;" value="Volver al Portal del Editor" onclick="window.history.go(-1); return false;"><i class="fa fa-arrow-left" aria-hidden="true"></i>Volver al Portal del Reportero</button>
                <?php
                if($hasfeedbacks){
                    $me = null;
                    $lastChildren = null;
                    connection::GetUserId($Perfil->USER_ALIAS,$me);
                    echo'<div class="FeedbackList">';
                    echo'<h4>Comentarios del Editor:</h4>';
                    for($i=0;$i<count($feedbacks);$i++){
                        echo'<div>';
                        if($feedbacks[$i]['FEEDBACK_BY'] == $me) echo'<h8>Yo:</h8> <br>';
                        else echo'<h8>Respuesta :</h8> <br>';
                        echo'<h7>'.$feedbacks[$i]['FEEDBACK_TEXT'].'</h7> <br>';
                        if($feedbacks[$i]['FEEDBACK_BY'] == $me) echo'<h8>revisado el:'.$feedbacks[$i]['CREATION_DATE'].'</h8> <br>';
                        else echo'<h8>enviado el:'.$feedbacks[$i]['CREATION_DATE'].'</h8> <br>';
                        echo'</div>';
                        //Get Last children index in feedback
                        if($i+1 == count($feedbacks)) $lastChildren = $i;
                    }
                    echo'<form id="ProcesFeedbackForm" action="ResendArticleScript.php" method="Post">';
                    echo'<input type="hidden" name="aid" value="'.$Articulo->ARTICLE_ID.'">';
                    echo'<input type="hidden" name="hasfeedbacks" id="hasfeedbacks" value="'.$hasfeedbacks.'">';
                    if($hasfeedbacks){
                        echo'<input type="hidden" name="pfeedbackid" value="'.$feedbacks[$lastChildren]['FEEDBACK_ID'].'">';
                        echo'<input type="hidden" name="pfeedbackby" value="'.$feedbacks[$lastChildren]['FEEDBACK_BY'].'">';
                        echo'<input type="hidden" name="pfeedbackfor" value="'.$feedbacks[$lastChildren]['FEEDBACK_FOR'].'">';
                        echo'<input type="hidden" name="pfeedbackdate" value="'.$feedbacks[$lastChildren]['CREATION_DATE'].'">';    
                    }
                    echo'<button id="BtnEditArticle"><h3><a style="text-decoration:none;color:black;"href="NuevaNoticia.php">Editar Noticia</a></h3></button>
                    <button id="BtnSendArticle"><h3>Mandar Noticia a revision</h3></button>
                    <button id="BtnDeleteArticle"><h3>Eliminar Noticia</h3></button>
                    ';
                    echo'</form>';
                    echo'</div>';
                }
                ?>
               <div id="ZonaNew">
                <?php
                function hazDivisible(&$resultado,$dividendo,$divisor){
                    if($dividendo % $divisor == 0) $resultado = $dividendo;
                    else{
                        $dividendo ++;
                        hazDivisible($resultado,$dividendo,$divisor);
                    }
                }
                if(!$Articulo != null) echo'<h3>No Existe el Articulo en la DB</h3>';
                else{
                    for($i=0;$i<count($Categorias);$i++){
                        if($Categorias[$i]->name ==$articleCateg) 
                        echo'<h3 class="Categ" style="background-color:#'.$Categorias[$i]->color.';">' . $Categorias[$i]->name . '</h3>';
                    }
                    echo'<h1 class="Titulo">'.$Articulo->ARTICLE_HEADER.'</h1>';
                    echo'<img class="Thumbnail"
                    src="data:'.$thmBlob['mime'].
                    ';base64,'.base64_encode($thmBlob['data']).
                    '">';
                    echo'<h3 class="Subtitulo">'.$Articulo->ARTICLE_DESCRIPTION.'</h3>';
                    echo'<h6 class="Fecha">'.$Articulo->EVENT_DATE.'</h6>';
                    echo'<h5 class="Direccion">'.$Articulo->LOCATION_STREET.' '.$Articulo->LOCATION_NEIGHB.' '
                    .$Articulo->LOCATION_CITY.' '.$Articulo->LOCATION_STATE.' '.$Articulo->LOCATION_COUNTRY.'</h5>';
                    echo'<br>';
                    $paragraphs = explode("\n",$Articulo->ARTICLE_CONTENT); // get paragraphs
                    for($i=0;$i<count($paragraphs);$i++){ //clean empty paragraphs
                        if($paragraphs[$i]=="") \array_splice($paragraphs, $i, 1);
                    }
                    $parNum = count($paragraphs);
                    $imgnum = 0;
                    $vnum = 0;
                    $orden = $parNum;
                    $delimitante = 0;
                    if($hasimages) $imgnum = count($ImgBlobarr['Mime']);
                    if($hasvideos) $vnum = count($vBlobarr['Mime']);
                    if($imgnum!=0){
                        hazDivisible($delimitante,$parNum,$imgnum);
                        $orden = $delimitante/$imgnum;
                    }
                    $imgindex = 0;
                    for($i=1;$i<=$delimitante;$i++){
                        if($i<=$parNum)echo'<p class="parrafo">'.$paragraphs[$i-1].'</p>';
                        if($i % $orden == 0){
                            echo'<img class="MediaImg"
                            src="data:'.$ImgBlobarr['Mime'][$imgindex].
                            ';base64,'.base64_encode($ImgBlobarr['Data'][$imgindex]).
                            '">';
                            $imgindex++;
                        }
                    }
                    echo'<br>';
                    for($i=0;$i<$vnum;$i++){
                        echo'<video class="Media" width="640" height="480" controls>';
                        echo'<source  src="data:'.$vBlobarr['Mime'][$i].';base64,
                        '.base64_encode($vBlobarr['Data'][$i]).'"></video>';
                    }
                    echo'<br>';
                    echo'<h5 class="parrafo"> Hecho por: -'.$Articulo->SIGN.'</h5>';
                    /*Cosas del form de los articuloides xd
                    <form action="ProcesarRevision.php" method="Post" id="ProcesRevisionForm">
                    <input type="hidden" name="aid" id="aid" value="<?php echo$Articulo->ARTICLE_ID; ?>">
                    <input type="hidden" name="author" id="author" value="<?php echo$Articulo->CREATED_BY; ?>">
                    <input type="hidden" name="Revision" id="Revision">
                    <button type="button" id="Aprobar" class="Aprobar">Aprobar Articulo</button>
                    <button type="button" id="Denegar" class="Denegar">Denegar Articulo y mandar comentarios</button>
                </form>*/
                }
                ?>
                <div id="ReviewMenu">
                </div>
                </div>
            </div>
        </div>

        <footer>
        <div class="Derechos"> 2021 Todos los derechos reservados </div>
        <div class="Contactos"> Contacto: Tel:8118047600 Correo:Unote@gmail.com </div>
        <div class="Informacion"> Informacion Compañia | Privacion y Politica | Terminos y Condiciones </div>
    </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js\models\Notipapa.js"></script>
</body>