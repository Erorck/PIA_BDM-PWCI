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
    $childCommentsarr =[];
    $hasComments=false;
    $numComments=0;
    $hasChildComments = false;
    $numFeedbacks = 0;
    $hasfeedbacks = false;
    $Articulo = null;
    $hasimages=false;
    $hasvideos=false;
    $articleCateg = "";
    $LikeAmount = null;
    $Reactions = [];
    $hasLikes = $reactionsloaded = $ilikedit = false;
    $loggeduserid = null;
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        connection::GetUserId($Perfil->USER_ALIAS, $loggeduserid);
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
        $childComments =[];
        if(connection::GetChildCommentsArticle($Articulo->ARTICLE_ID,$childComments)){
            $hasChildComments = true;
        }
       
        if(connection::GetMediaImage($Articulo->ARTICLE_ID,$ImgBlobarr)){
            $hasimages = true;
        }
        if(connection::GetMediaVideo($Articulo->ARTICLE_ID,$vBlobarr)){
            $hasvideos = true;
        }
        //get Child Comments and then comments that arent childs
        if($hasChildComments){
            $auxcommarr = [];
            if(connection::GetCommentsArticle($Articulo->ARTICLE_ID,$auxcommarr)){
                $hasComments = true;
                for($i=0;$i<count($childComments);$i++){
                    for($j=0;$j<count($auxcommarr);$j++){
                        if($childComments[$i]['COMMENT_ID'] == $auxcommarr[$j]['COMMENT_ID']){
                            array_push($childCommentsarr,$auxcommarr[$j]);
                            \array_splice($auxcommarr, $j, 1);
                        }
                    }
                }
                $commentsarr = $auxcommarr;

            }
        }
        else{
            if(connection::GetCommentsArticle($Articulo->ARTICLE_ID,$commentsarr)){
                $hasComments = true;

            }
        }

        if(connection::GetLikesArticle($Articulo->ARTICLE_ID,$LikeAmount)){
            if($LikeAmount > 0){
                $hasLikes = true;
                if(connection::GetReactions($Articulo->ARTICLE_ID,$Reactions)){ 
                    $reactionsloaded =true;
                    if($LoggedUser) foreach($Reactions as $reac){
                        if($reac['USER']==$loggeduserid) {$ilikedit =true; break;}
                    }
                }
            }
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
          var once = false;
            function alertasimple()
                {
                Swal.fire({
                title: 'Debes iniciar sesion para poder dar Like',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iniciar Sesion'
                }).then((result) => {
                if (result.isConfirmed) {
                    location.href="Login.php";
                }
                });
            }
            function fastupdatelikebttn(like){
                let currentlikes = parseInt($('#likecounter').text());
                let newlikequantity = like ?  currentlikes + 1: currentlikes - 1;
                debugger;
                $('#likecounter').text(newlikequantity);
            }
            function React(like){
                fastupdatelikebttn(like);
                let data={}
                data['like'] = like;
                data['uid'] = $('#likebtn').attr('from');
                data['aid'] = $('#likebtn').attr('to');
                var jsonString = JSON.stringify(data);
                return $.ajax({
                    type: "POST",
                    url: "LikeScript.php",
                    data: {data : jsonString}, 
                    cache: false,
                    async: false
                });
            }
            $(document).ready(function() {
                //like
                $('#likezone').on('click','#likebtn',function(){
                    //check if we can like
                    debugger;
                    let avaliable = $(this).attr('avaliable');
                    let liked = $(this).attr('liked');
                    switch(avaliable){
                        case 'yes':
                            debugger;
                            if(liked == 'no'){
                                var jsonData ="";
                                React(true).done(function(response){
                                    debugger;
                                    jsonData = JSON.parse(response);
                                    if (jsonData.success == "1")
                                    {
                                        $("#likezone").load(location.href+" #likezone>*","");
                                    }
                                    else{ 
                                        alert('Error de algun tipo');
                                    }
                                });
                            }
                            else if(liked == 'yes'){
                                var jsonData ="";
                                    React(false).done(function(response){
                                    debugger;
                                    jsonData = JSON.parse(response);
                                    if (jsonData.success == "1")
                                    {
                                        $("#likezone").load(location.href+" #likezone>*","");
                                    }
                                    else{ 
                                        alert('Error de algun tipo');
                                    }
                                });
                            }
                        break;
                        case'no':
                            alertasimple();
                        break;
                    }
                });
                //comments and comments's comments
                $('.answerComment').click(function(){
                    if(!once){
                        once = true;
                        let pid = $(this).parent().parent().attr('id');
                        let me= $('#commentdata').attr('by');
                        let aid =$('#commentdata').attr('aid');
                        $(this).replaceWith('<form id="answerform"><input type="hidden" id="answerdata"by="'+me+'" aid="'+aid+'" pid="'+pid+'">'
                        +'<textarea style="display:inline;float:left;resize:none;width: 90%;" class="commentContent" placeholder="Comentario..."id="answerContent" name="answerContent" rows="4" cols="60"></textarea>'+
                        '<button id="sendAnswer" style="transition:none;width:100%;textalign:center;">Enviar</button></form>');
                    }
                });
                $('#sendComment').click(function(e){
                    e.preventDefault();
                    debugger;
                    let data = {};
                    data['text']=$('#commentContent').val();
                    data['by']=$('#commentdata').attr('by');
                    data['aid']=$('#commentdata').attr('aid');
                    data['child']=false;
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
                $('.deleteComment').click(function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    let cid = null;
                    cid = $(this).parent().parent().attr('id');
                    let child = false;
                    if($(this).parent().parent().parent('.comment').length) child = true;
                    let data = {};
                    data['cid']=cid;
                    data['child'] = child;
                    if(data['cid']!=null){ //there is actual id
                        var jsonString = JSON.stringify(data);
                        $.ajax({
                            type: "POST",
                            url: "DeleteCommentScript.php",
                            data: {data : jsonString}, 
                            cache: false,
                            success: function(response){
                                debugger;
                                var jsonData = JSON.parse(response);
                                if (jsonData.success == "1")
                                {
                                    swal.fire('Comentario Eliminado');
                                    setTimeout(function(){location.reload();}, 0001);
                                }
                                else{ 
                                    alert('Error de algun tipo');
                                    setTimeout(function(){location.reload();}, 0001);
                                }
                            }
                        });
                    }
                })
                $('.comment').on('click','#answerform > #sendAnswer',function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    debugger;
                    let data = {};
                    data['text']=$('#answerContent').val();
                    data['by']=$('#answerdata').attr('by');
                    data['aid']=$('#answerdata').attr('aid');
                    data['pid']=$('#answerdata').attr('pid');
                    data['child']=true;
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
                                    $('.comment').off('click','#answerform > #sendAnswer');
                                    setTimeout(function(){location.reload();}, 0001);
                                }
                                else{ 
                                    alert('Error de algun tipo');
                                    $('.comment').off('click','#answerform > #sendAnswer');
                                    setTimeout(function(){location.reload();}, 0001);
                                }
                            }
                        });
                    }
                });
                
            });
      </script>
</head>

<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v13.0" nonce="yVtoNnuj"></script>
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
                    if($dividendo % $divisor == 0) $resultado = $dividendo;
                    else{
                        $dividendo ++;
                        hazDivisible($resultado,$dividendo,$divisor);
                    }
                }
                if(!$Articulo != null) echo'<h3>No Existe el Articulo en la DB</h3>';
                else{
                    echo'<p hidden id="this_aid" aid="'.$Articulo->ARTICLE_ID.'" >xD</p>';
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
                    else{
                        $delimitante=$parNum;
                    }
                    $imgindex = 0;
                    for($i=1;$i<=$delimitante;$i++){
                        if($i<=$parNum)echo'<p class="parrafo">'.$paragraphs[$i-1].'</p>';
                        if($i % $orden == 0 && $imgnum!=0){
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
                <div id="likezone">
                    <button id="likebtn" class="btnlike" avaliable=<?php
                    if((!$LoggedUser)/*||$ilikedit*/) echo'"no"';
                    else echo'"yes"';?> style=<?php
                    if($ilikedit)echo'"background-color:#fea900;"';
                    else echo'"background-color:#d1e8ec;"';
                    ?>
                    liked =<?php
                    if($ilikedit)echo'"yes"';
                    else echo'"no"';
                    ?>
                    from=<?php echo'"'.$loggeduserid.'"';?>
                    to=<?php echo'"'.$Articulo->ARTICLE_ID.'"';?>>
                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    <span id="likecounter"><?php echo $LikeAmount;?></span>
                    </button></div>
                </div>
                <br>
                <div style="display:flex; justify-content:center;"class="fb-share-button" data-href="window.location.href" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
                <br>
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
                    function lookforchild($comment,$childsarray,$childinfoarray,$LoggedUser,$Perfil,$Articulo){
                        //search if current comment has child
                        $childfound=false;
                        $thechilds=[];
                        foreach($childinfoarray as $child){
                            if($comment['COMMENT_ID']==$child['PARENT_ID']){
                            $thechildaux = null;
                            foreach($childsarray as $actualchild){
                                if($actualchild['COMMENT_ID']==$child['COMMENT_ID']){
                                    $thechildaux=$actualchild;
                                    array_push($thechilds,$thechildaux);
                                }
                            }
                            $childfound=true;
                            }
                        }
                        if($childfound){
                                //print comment
                                if(connection::GetUname($comment['CREATED_BY'],$author)){
                                    echo'<div class="comment child" by="'.$comment['CREATED_BY'].'"id="'.$comment['COMMENT_ID'].'"aid="'.$comment['ARTICLE_ID'].'">
                                    <div class="commentAuthor">
                                    <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                                    <h6>'.$author.'</h6>
                                    </div>
                                    <p class="commentContent"><span class="fecha">'.$comment['CREATION_DATE'].'<br></span>'.$comment['COMMENT_TEXT'].'<br>';
                                    if($LoggedUser){
                                        $me = null;
                                        echo'<button class="answerComment">Responder</button>';
                                        if((strcmp($Perfil->USER_TYPE,'AD')==0)||
                                        ((strcmp($Perfil->USER_TYPE,'RE')==0)&& connection::GetUserId($Perfil->USER_ALIAS,$me)&&$me==$Articulo->CREATED_BY)||
                                        connection::GetUserId($Perfil->USER_ALIAS,$me)&& $me==$comment['CREATED_BY'])
                                        echo'<button class="deleteComment" style="background-color:red">Eliminar</button>';
                                    } 
                                    echo'</p>';
                                    foreach($thechilds as $thechild){
                                        lookforchild($thechild,$childsarray,$childinfoarray,$LoggedUser,$Perfil,$Articulo);
                                        
                                    }
                                    echo'</div>'; 
                            }
                        }
                        else{
                            //print comment
                            if(connection::GetUname($comment['CREATED_BY'],$author)){
                                echo'<div class="comment child" by="'.$comment['CREATED_BY'].'"id="'.$comment['COMMENT_ID'].'"aid="'.$comment['ARTICLE_ID'].'">
                                <div class="commentAuthor">
                                <img class="commentPfp" src="media\img\defProfPic.png" alt="profpic">
                                <h6>'.$author.'</h6>
                                </div>
                                <p class="commentContent"><span class="fecha">'.$comment['CREATION_DATE'].'<br></span>'.$comment['COMMENT_TEXT'].'<br>';
                                if($LoggedUser){
                                    $me = null;
                                    echo'<button class="answerComment">Responder</button>';
                                    if((strcmp($Perfil->USER_TYPE,'AD')==0)||
                                    ((strcmp($Perfil->USER_TYPE,'RE')==0)&& connection::GetUserId($Perfil->USER_ALIAS,$me)&&$me==$Articulo->CREATED_BY)||
                                    connection::GetUserId($Perfil->USER_ALIAS,$me)&& $me==$comment['CREATED_BY'])
                                    echo'<button class="deleteComment" style="background-color:red">Eliminar</button>';
                                } 
                                echo'</p>';
                                echo'</div>';
                            }
                        }
                    }
                    foreach($commentsarr as $comment){
                        lookforchild($comment,$childCommentsarr,$childComments,$LoggedUser,$Perfil,$Articulo);
                    }
                    ?>
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