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
    $commentsarr=[];
    $hasComments=false;
    $numComments=0;
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
                if($arti->ARTICLE_ID === intval($_GET['ArticleId'])){
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
        //get Comments
        if(connection::GetCommentsArticle($Articulo->ARTICLE_ID,$commentsarr)){
            $hasComments = true;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title><?php echo$Articulo->ARTICLE_HEADER; ?></title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
            $(document).ready(function() {
                $('#sendComment').click(function(){
                    let data = {};
                    data['text']=$('#commentContent').val();
                    data['by']=$('#commentdata').attr('by');
                    data['aid']=$('#commentdata').attr('aid');
                    debugger;
                    if(data['text']!=""){ //there is actual comment
                        var jsonString = JSON.stringify(data);
                        $.ajax({
                            type: "POST",
                            url: "SendCommentScript.php",
                            data: {data : jsonString}, 
                            cache: false,
                            success: function(response){
                                debugger;
                                var jsonData = JSON.parse(response);
                                if (jsonData.success == "1")
                                {
                                    swal.fire('Comentario Añadido');
                                    setTimeout(function(){location.reload();}, 0001);
                                }
                                else{ alert('Error de algun tipo')}
                            }
                        });
                    }
                });
            });
      </script>
</head>

<body>
    <div class="Contenedor-base">
        <div class = "Barra-navegacion">
            <h3 class="Logo-web">Noticias</h3>
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
            <button type="button" style="background-color:gray; color:white;" onclick="window.history.go(-1); return false;"><i class="fa fa-arrow-left" aria-hidden="true"></i>Volver a Inicio</button>
                <div id="ZonaNew">
                <?php
                function hazDivisible(&$resultado,$dividendo,$divisor){
                    if($dividendo % $divisor === 0) $resultado = $dividendo;
                    else{
                        $dividendo ++;
                        hazDivisible($resultado,$dividendo,$divisor);
                    }
                }
                if(!$Articulo != null) echo'<h3>No Existe el Articulo en la DB</h3>';
                else{
                    for($i=0;$i<count($Categorias);$i++){
                        if($Categorias[$i]->name ===$articleCateg) 
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
                        if($paragraphs[$i]==="") \array_splice($paragraphs, $i, 1);
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
                        if($i % $orden === 0){
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
                }
                ?>
                </div>
                <div id="commentsDiv">
                    <h3>COMENTARIOS</h3>
                    <div id="AddCommentsDiv">
                    <?php
                    if(!$LoggedUser){
                        echo'<h5>Debes Estar Registrado para Comentar</h5>';
                        
                    }
                    else{
                        $me = null;
                        connection::GetUserId($Perfil->USER_ALIAS,$me);
                        echo'<div class="comment" style="background-color:#badade;">';
                        echo'<div class="commentAuthor">
                        <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                        <h6>'.$Perfil->USER_ALIAS.'</h6></div>';
                        echo'<input type="hidden" id="commentdata"by="'.$me.'" aid="'.$Articulo->ARTICLE_ID.'">';
                        echo'<textarea style="display:inline;float:left;resize:none;width: 90%;" class="commentContent" placeholder="Comentario..."id="commentContent" name="commentContent" rows="4" cols="60"></textarea>';
                        echo'<button id="sendComment" style="transition:none;width:100%;textalign:center;">Enviar</button>' ;
                        echo'</div>';
                    }
                    ?>
                    </div>
                    <?php
                    if($hasComments){
                        foreach($commentsarr as $comment){
                            $author = "";
                            if(connection::GetUname($comment['CREATED_BY'],$author)){
                                echo'<div class="comment" by="'.$comment['CREATED_BY'].'"id="'.$comment['COMMENT_ID'].'"aid="'.$comment['ARTICLE_ID'].'">
                                <div class="commentAuthor">
                                <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                                <h6>'.$author.'</h6>
                                </div>
                                <p class="commentContent"><span class="fecha">'.$comment['CREATION_DATE'].'<br></span>'.$comment['COMMENT_TEXT'].'<br>
                                <button id="answerComment">Responder</button></p>
                                </div>';
                            }
                        }
                    }
                    ?>
                    
                    <!-- EJEMPLO DE COMENTARIOS CON TODO E HIJOS
                        <div class="comment">
                        <div class="commentAuthor">
                            <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                            <h6>Nombre de usuario</h6>
                        </div>
                        <p class="commentContent">comentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDcomentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDcomentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDcomentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDD</p>
                    </div>
                    <div class="comment">
                        <div class="commentAuthor">
                            <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                            <h6>Nombre de usuario</h6>
                        </div>
                        <p class="commentContent">comentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDD</p>
                        <div class="comment child">
                            <div class="commentAuthor">
                                <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                                <h6>Nombre de usuario</h6>
                            </div>
                            <p class="commentContent">Hola soy un commentario hijo</p>
                            <div class="comment child">
                            <div class="commentAuthor">
                                <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                                <h6>Nombre de usuario</h6>
                            </div>
                            <p class="commentContent">Hola soy un commentario hijoHola soy un commentario hijoHola soy un commentario hijoHola soy un commentario hijoHola soy un commentario hijoHola soy un commentario hijo</p>
                        </div>
                        </div>
                    </div>
                    <div class="comment">
                        <div class="commentAuthor">
                            <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                            <h6>Nombre de usuario</h6>
                        </div>
                        <p class="commentContent">comentario XDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDDD XDDDDDDDDD XDDDDDDD</p>
                    </div>
                    -->
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