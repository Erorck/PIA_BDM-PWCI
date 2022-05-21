<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $datarrayx = []; 
    $Categorias =[];
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $ArticulosPU=[];
    $CategsOfArticles=[];
    $SectionSort = false;
    $SortType="";
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged'] ){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
    }
    if(connection::GetCountArticles($numArticles,"XD")) $ArticlesExist = true;
    if(connection::GetCountArticles($numRRArticles,"RR")) $ArticlesRRExist = true;
    if(connection::GetCountArticles($numRAArticles,"RA")) $ArticlesRAExist = true;
    if(connection::GetCountArticles($numPUArticles,"PU")) $ArticlesPUExist = true;
    if($ArticlesPUExist)
    {
        if(connection::GetArticles($datarray)){
            foreach($datarray as $art){
            $arti = new Articulo($art);
            if($arti->ARTICLE_STATUS === 'PU'){
                array_push($ArticulosPU,$arti);
                $currcateg =null;
               if(connection::GetCategOfArticle($arti->ARTICLE_ID,$currcateg)){
                array_push($CategsOfArticles,$currcateg);
               }

            }
            }
        }
        // para ponerlos en la lista de articulos pendientes de revision paps
    }
    if($ArticlesRAExist)
    {
        if(connection::GetArticles($datarrayx)){
            foreach($datarrayx as $art){
            $arti = new Articulo($art);
            if($arti->ARTICLE_STATUS == 'RA'&&
            $arti->CREATED_BY==$loggedreporterid)array_push($ArticulosRA,$arti);
            }
        }
        // para ponerlos en la lista de articulos pendientes de revision paps
    }
    if(isset($_GET['section'])){
        $SortType=$_GET['section'];
        if(!($SortType=="urgent" || $SortType=="week"))$SectionSort=true;
        else{
            //we alter the ArticulosPU to only have those within today or this week
            $artaux = $ArticulosPU;
            $ArticulosPU=[];
            $Fechas =[];
            $FechasDates=[];
            $Tiempos =[];
            foreach($artaux as $a){
                array_push($Fechas, explode(" ",$a->EVENT_DATE)[0]);
                array_push($Tiempos, explode(" ",$a->EVENT_DATE)[1]);
            }
            foreach($Fechas as $a){
                array_push($FechasDates,date_create_from_format('Y-m-d', $a));
            }
            $Hoy =  date('Y-m-d');
            $HoyDate = date_create_from_format('Y-m-d', date('Y-m-d')); 
            switch($SortType){
                case'urgent':
                    for($i=0;$i<count($artaux);$i++){
                        if($Fechas[$i]==$Hoy)array_push($ArticulosPU,$artaux[$i]);
                    }
                break;
                case'week':
                    for($i=0;$i<count($artaux);$i++){
                        $interval = date_diff($FechasDates[$i], $HoyDate);
                        $differencia = $interval->format('%a');
                        $diffint = intval($differencia);
                        if($diffint<7){
                            array_push($ArticulosPU,$artaux[$i]);
                        }
                    }
                break;
            }
            //order by most recent
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>¡NotiPapa, La noticia de tu Papa Diaria!</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
            if($('.notify-bubble').attr("notifications") > 0){
                $('.notify-bubble').show(400);
            }
            $('#Account').on('click','#logout',function() {
                $.ajax({
                    type: "POST",
                    url: "LogOut.php",
                    data: "action=logout",
                    success: function(msg){
                        if(msg == "success"){
                            swal.fire('Se Ha Cerrado La sesion','','success')
                        }else{
                            //failed
                        }
                    },
                    error: function(msg){
                        alert('Error: cannot load page.');
                    }
                });
            });
            $('.ZonaNoticia').click(function(){
                $(this).children('.ArticleViewForm').submit();
            });
            $('.Categ').click(function(){
                let caac = $(this).attr('section');
                debugger;
                $('#section').val($(this).attr('section'));
                $('#SortForm').submit();
            });
        });
    </script>
      
</head>

<body>
    <div class="Contenedor-base">
        <div class ="topAnclado">
            <div class = "sidenav" id="catBar">
            <h3 class="Categ" style="background-color:red;" section="urgent">ULTIMA HORA!!!</h3>
                <h3 class="Categ" style="background-color:#2264a5;" section="week" >SEMANAL</h3>
                <?php
                foreach ($Categorias as $x ) {
                    echo '<h3 class="Categ" style="background-color:#'.$x->color.';" section="' . $x->name . '">' . $x->name . '</h3>';
                  };
                ?>
                <form action="Main.php" method="GET" id="SortForm"><input type="hidden" id="section" name="section"></form>
            </div>
            <div class = "Barra-navegacion">
                <h3 class="Logo-web">Noticias</h3>
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
                    <div class="notify-container">';
                    echo'<h3><a href="Perfil.php">'.$Perfil->USER_ALIAS.'';
                    switch($Perfil->USER_TYPE){
                        case 'AD':
                            if(!$ArticlesRAExist) echo'<span class="notify-bubble" notifications="'.$numRRArticles.'">'.$numRRArticles.'</span>';
                        break;
                        case 'RE':
                            if(!count($ArticulosRA) !=0) echo'<span class="notify-bubble" notifications="'.$numRAArticles.'">'.$numRAArticles.'</span>';
                          break;
                    }
                    echo'</a></h3>
                    </div>
                    <a id ="logout" href="">Cerrar sesion</a>
                    </div>';
                }
                ?>
            </div>
            
        </div>
        <div class="mainContenedor" id="portalcon">
            <div class="ZonaFeed">
                <?php
                if((!$ArticlesPUExist) || count($ArticulosPU) == 0) echo'<h3>No hay noticias pendientes</h3>';
                else{
                    for($i=0;$i<(count($ArticulosPU));$i++){
                        if($SectionSort){
                            if($SortType==$CategsOfArticles[$i]){
                                 //display Article
                            echo "<div class='ZonaNoticia'>";
                            echo'<form class="ArticleViewForm" action="ArticleView.php" method="GET">
                            <input type="hidden" id="ArticleId" name="ArticleId" value="'.$ArticulosPU[$i]->ARTICLE_ID.'">
                            </form>';
                            if(connection::GetImageArticle($ArticulosPU[$i]->ARTICLE_ID,$ImgBlob)){
                                echo'<div class="imgZone"> 
                                
                                <img src="data:'.$ImgBlob['mime'].';base64,'.base64_encode($ImgBlob['data']).'" alt="thumbnail">
                                </div>';
                            }
                            echo'<div class="TxtZone">
                                <h1 class="txtTitulo">'.$ArticulosPU[$i]->ARTICLE_HEADER.'</h1>
                                <p class="txtFecha">'.$ArticulosPU[$i]->EVENT_DATE.'<p>
                                <p class="txtDesc">
                                '.$ArticulosPU[$i]->ARTICLE_DESCRIPTION.'
                                </p>
                                </div>';
                            echo "</div>";
                            }
                        }
                        else{
                            //display Article
                            echo "<div class='ZonaNoticia'>";
                            echo'<form class="ArticleViewForm" action="ArticleView.php" method="GET">
                            <input type="hidden" id="ArticleId" name="ArticleId" value="'.$ArticulosPU[$i]->ARTICLE_ID.'">
                            </form>';
                            if(connection::GetImageArticle($ArticulosPU[$i]->ARTICLE_ID,$ImgBlob)){
                                echo'<div class="imgZone"> 
                                
                                <img src="data:'.$ImgBlob['mime'].';base64,'.base64_encode($ImgBlob['data']).'" alt="thumbnail">
                                </div>';
                            }
                            echo'<div class="TxtZone">
                                <h1 class="txtTitulo">'.$ArticulosPU[$i]->ARTICLE_HEADER.'</h1>
                                <p class="txtFecha">'.$ArticulosPU[$i]->EVENT_DATE.'<p>
                                <p class="txtDesc">
                                '.$ArticulosPU[$i]->ARTICLE_DESCRIPTION.'
                                </p>
                                </div>';
                            echo "</div>";
                        }
                        
                    }
                }
                ?>               
            </div>
        </div>
        <footer id="portalf">
        <div class="Derechos"> 2021 Todos los derechos reservados </div>
        <div class="Contactos"> Contacto: Tel:8118047600 Correo:Unote@gmail.com </div>
        <div class="Informacion"> Informacion Compañia | Privacion y Politica | Terminos y Condiciones </div>
    </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js\models\Notipapa.js"></script>
</body>