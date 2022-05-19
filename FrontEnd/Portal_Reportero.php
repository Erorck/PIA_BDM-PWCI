<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Categorias =[];
    $Perfil = null;
    $LoggedUser = false;
    $loggedreporterid = null;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $ArticulosRA = [];
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
        connection::GetUserId($Perfil->USER_ALIAS,$loggedreporterid);
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
            if($arti->ARTICLE_STATUS === 'RA'&&
            $arti->CREATED_BY===$loggedreporterid)array_push($ArticulosRA,$arti);
            }
        }
        // para ponerlos en la lista de articulos pendientes de revision paps
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Portal Reportero</title>
    <link rel="stylesheet" href="css/styles.css" >
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
    <script type="text/javascript" src= "js/libs/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/models/validations.js" ></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/libs/jscolor.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
            ////////////////////////////////////
            //        Revisar Articulos
            ////////////////////////////////////
            $('.ZonaNoticia').click(function(){
                $(this).children('.ArticleReviewForm').submit();
            });
            

        });
    </script>
</head>
<body>
    <div class="Contenedor-base">
    <div class ="topAnclado">
            <div class = "Barra-navegacion">
                <h3 class="Logo-web">Noticias</h3>
                <a href="index.php">Volver Al Indice</a>
                <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a>
                <form action="Busqueda.php" name="F_Search" class="SearchBarForm">
                <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda"></div>
                <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
                </form>
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
            </div>
            
        </div>

        <div class="mainContenedor">
            <div class="ZonaFeedPortal">
                <div id="E_Portal_PendArticles_Div">
                <button class="BtnEditProfile"><h3><a style="text-decoration:none;color:black;"href="NuevaNoticia.php">Crear Articulo</a></h3></button>
                <hr>                
                <h2 >NOTICIAS PENDIENTES DE CORRECCION:</h2>
                <?php
                if(!$ArticlesRRExist) echo'<h3>No hay noticias pendientes</h3>';
                else{
                    $ImgBlob = Null;
                    echo'<h4>Hay <span style="background-color: #9d0e28; color:white;" >'.$numRAArticles.'</span> Articulos Revisados, pendientes de correccion</h4>';
                    for($i=0;$i<(count($ArticulosRA));$i++){
                        //display Article
                        echo "<div class='ZonaNoticia'>";
                        echo'<form class="ArticleReviewForm" action="ArticleFeedbackReview.php" method="GET">
                        <input type="hidden" id="ArticleId" name="ArticleId" value="'.$ArticulosRA[$i]->ARTICLE_ID.'">
                        </form>';
                        if(connection::GetImageArticle($ArticulosRA[$i]->ARTICLE_ID,$ImgBlob)){
                            echo'<div class="imgZone"> 
                            
                            <img src="data:'.$ImgBlob['mime'].';base64,'.base64_encode($ImgBlob['data']).'" alt="thumbnail">
                            </div>';
                        }
                        echo'<div class="TxtZone">
                            <h1 class="txtTitulo">'.$ArticulosRA[$i]->ARTICLE_HEADER.'</h1>
                            <p class="txtFecha">'.$ArticulosRA[$i]->EVENT_DATE.'<p>
                            <p class="txtDesc">
                            '.$ArticulosRA[$i]->ARTICLE_DESCRIPTION.'
                            </p>
                            </div>';
                            $feedbacks = [];
                        if(connection::GetFeedBackForArticle($ArticulosRA[$i]->ARTICLE_ID,$feedbacks)){
                            echo'<div class="FeedbackList">';
                            echo'<h4>Comentarios del Editor:</h4>';
                            foreach($feedbacks as $feedback){
                                echo'<div>';
                                echo'<h7>'.$feedback['FEEDBACK_TEXT'].'</h7> <br>';
                                echo'<h8>revisado el:'.$feedback['CREATION_DATE'].'</h8> <br>';
                                echo'</div>';
                            }
                            echo'</div>';
                        }
                        echo "</div>";
                        
                    }
                }
                ?>  
                <hr>
                <h2 >NOTICIAS PUBLICADAS:</h2>
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
</html>