<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $foundSomething = false; //bool que indica si se encontraron noticias
    $search=""; //string con lo que ingreso el tipo en el buscador
    $filtrosarr=[]; //arreglo de strings con los filtros, dicho arreglo se 
    //decodificara en json 
    //entre los tipos de filtros que son estan:
    /* AÑO,MES,DIA,SECCION,TAGS,PAIS
    AÑo viene siendo AÑO del evento;
    MES viene siendo MES del evento;
    DIA viene siendo DIA del evento;
    SECCION viene siendo Categoria del articulo;
    PAIS pais donde ocurrio el evento;
    TAGS viene siendo un booleano que indica si buscar por los tags especificados
    al momento de dar de alta el articulo;
    */
    $datarray = []; 
    $Categorias =[];
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $ArticulosPU=[];
    $ArticulosFound=[];
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
    
    if(isset($_GET['section'])){
        $SectionSort=true;
        $SortType=$_GET['section'];
    }
    if(isset($_GET['srchParam'])){
        $search = $_GET['srchParam'];
    }
    if(isset($_GET['filtros'])){
        $filtrosarr['none'] = false;
        switch($_GET['filtros'])
        {
            case'FECHA':
                $sel = $_GET['FECHA'];
               /* if(connection::SearchArticlesBy($search,$sel,$_GET['filtros'],$ArticulosFound)){
                    foreach($ArticulosFound as $art){
                        $arti = new Articulo($art);
                        array_push($ArticulosPU,$arti);
                    }
                    $foundSomething=true;
                }*/
            break;
            case'SECCION':
                $sel = $_GET['SECCION'];
                if(connection::SearchArticlesByContent($search,$ArticulosFound)){
                    foreach($ArticulosFound as $art){
                        $arti = new Articulo($art);
                        $categstring ="";
                        connection::GetCategOfArticle($arti->ARTICLE_ID,$categstring);
                        if($categstring==$sel)array_push($ArticulosPU,$arti);
                    }
                    $foundSomething=true;
                }
            break;
            case'PAIS':
                $sel = $_GET['PAIS'];
                if(connection::SearchArticlesByContent($search,$ArticulosFound)){
                    /*for($i=0;$i<10;$i++){
                        $arti = new Articulo($ArticulosFound[0]);
                        array_push($ArticulosPU,$arti);
                    }*/
                    foreach($ArticulosFound as $art){
                        $arti = new Articulo($art);
                        if($arti->LOCATION_COUNTRY==$sel)array_push($ArticulosPU,$arti);
                    }
                    $foundSomething=true;
                }
            break;
        }
    }
    else{
        $filtrosarr['none'] = true; //si no se especificaron filtros, entonces none = true;
    }
    if($ArticlesPUExist)
    {
        if($search!="" && $filtrosarr['none']){
            if(connection::SearchArticlesByContent($search,$ArticulosFound)){
                /*for($i=0;$i<10;$i++){
                    $arti = new Articulo($ArticulosFound[0]);
                    array_push($ArticulosPU,$arti);
                }*/
                foreach($ArticulosFound as $art){
                    $arti = new Articulo($art);
                    array_push($ArticulosPU,$arti);
                }
                $foundSomething=true;
            }
        }
    }
    $cstr = file_get_contents('data/WorldCountries.json');
    $cntrjson = json_decode($cstr,true);
    $cntrjson['Countries'] = strtoupper($cntrjson['Countries']);
    $countries = explode("//",$cntrjson['Countries']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
            //Articulo
            $('.ZonaNoticia').click(function(){
                $(this).children('.ArticleViewForm').submit();
            });
            //filtros
            let prev = null;
            $('#filterBtn').click(function(){
                $(this).replaceWith('<div style="width: 60%;" class="ZonaFeedProfile">'+
                '<div>'+
                'Seleccione El Filtro:'+
                '<Button class="BtnEditProfile" id="filterfechbtn" style="font-size:xx-large; color:black;">Fecha</Button>'+
                '<Button class="BtnEditProfile" id="filterseccbtn" style="font-size:xx-large; color:black;">Seccion</Button>'+
                '<Button class="BtnEditProfile" id="filterpaisbtn" style="font-size:xx-large; color:black;">Pais</Button>'+
                '</div>'+
                '</div>');
            });
            $('.mainContenedor').on('click','#filterfechbtn',function(){
                 prev = $('#filterfechbtn').parent().parent('div').html();
                 $('#filterfechbtn').parent('div').replaceWith('<div id="filtermenu">FILTRA POR FECHA'+
                 '<br>'+
                 '<form id="filterform" action="Busqueda.php">'+
                 '<input type="hidden" name="filtros" value="FECHA">'+
                 '<input type="hidden" name="srchParam" value="'+$('input[name=srchParam]').val()+'">'+
                 '<input type="datetime-local"  id="filtfecha" name="FECHA" />'+
                 '<input type="submit" value="Filtrar">'+
                 '</form>'+
                 '<br>'+
                 '<button id="backfilter">Volver</button></div>');
            });
            $('.mainContenedor').on('click','#filterseccbtn',function(){
                let opciones ="";
                let opcarr=$('#allcategs').val().split('//');
                debugger;
                for(i=0;i<opcarr.length;i++){
                    opciones = opciones + '<option value="'+opcarr[i]+'">'+opcarr[i]+'</option>';
                }
                prev = $('#filterfechbtn').parent().parent('div').html();
                 $('#filterseccbtn').parent('div').replaceWith('<div id="filtermenu">FILTRA POR SECCION'+
                 '<br>'+
                 '<form id="filterform"action="Busqueda.php">'+
                 '<input type="hidden" name="filtros" value="SECCION">'+
                 '<input type="hidden" name="srchParam" value="'+$('input[name=srchParam]').val()+'">'+
                 '<select  id="filtseccion" name="SECCION">'+
                 opciones+
                 '</select>'+
                 '<input type="submit" value="Filtrar">'+
                 '</form>'+
                 '<br>'+
                 '<button id="backfilter">Volver</button></div>');
            });
            $('.mainContenedor').on('click','#filterpaisbtn',function(){
                let opciones ="";
                let opcarr=$('#countries').val().split('//');
                for(i=0;i<opcarr.length;i++){
                    opciones = opciones + '<option value="'+opcarr[i]+'">'+opcarr[i]+'</option>';
                }
                 prev = $('#filterfechbtn').parent().parent('div').html();
                $('#filterpaisbtn').parent('div').replaceWith('<div id="filtermenu">FILTRA POR PAIS'+
                '<br>'+
                '<form id="filterform"action="Busqueda.php">'+
                 '<input type="hidden" name="filtros" value="PAIS">'+
                 '<input type="hidden" name="srchParam" value="'+$('input[name=srchParam]').val()+'">'+
                 '<select  id="filtpais" name="PAIS">'+
                 opciones+
                 '</select>'+
                 '<input type="submit" value="Filtrar">'+
                 '</form>'+
                 '<br>'+
                '<button id="backfilter">Volver</button></div>');
            }); 
            $('.mainContenedor').on('click','#backfilter',function(){
                $('#filtermenu').replaceWith(prev);
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
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda" value=<?php echo"'".$_GET['srchParam']."'";?>></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </form>
        </div>
        <input type="hidden" id="allcategs" value="<?php
        $stringchafa = "";
         foreach($Categorias as $categ){
             if($stringchafa=="") $stringchafa = $categ->name;
             else$stringchafa=$stringchafa."//".$categ->name;
         } 
         echo$stringchafa;
         ?>">
         <input type="hidden" id="countries" value="<?php echo$cntrjson['Countries'];?>">
        <div class="mainContenedor">
        <Button class="BtnEditProfile" id="filterBtn" style="font-size:xx-large; color:black;">Filtrar Busqueda</Button> 
            <div class="ZonaFeed">
            <?php
                if(!($ArticlesPUExist && $foundSomething)) echo'<h3>Nada que ver aqui :C</h3>';
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

        <footer>
        <div class="Derechos"> 2021 Todos los derechos reservados </div>
        <div class="Contactos"> Contacto: Tel:8118047600 Correo:Unote@gmail.com </div>
        <div class="Informacion"> Informacion Compañia | Privacion y Politica | Terminos y Condiciones </div>
    </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js\models\Notipapa.js"></script>
</body>
