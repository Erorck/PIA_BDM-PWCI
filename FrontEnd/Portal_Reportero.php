<?php
require 'connection.php';
require 'User.php';
session_start();
$datarray = []; 
$Categorias =[];
$Perfil = null;
$LoggedUser = false;
if(connection::GetCategories($datarray)){
    foreach($datarray as $cat){
    $categ = new Categoria($cat);
    array_push($Categorias,$categ);
    }
}
if($_SESSION['islogged']){
    $LoggedUser = true;
    $Perfil = $_SESSION['DataUser'];
    if(strcmp($Perfil->USER_TYPE,'RE')!==0){
        header('Location: '.'403.html');
    }
}
else{
    header('Location: '.'403.html');
}
$Articulos = array(
    array(
    "Revive Gustavo Cerati ",
    "25/02/2022",
    "\"Che Que loco Revivi Fua xdxd\" Exclamo el cantante argentino",
    "media/img/GustavoCerati.jpg"
    ),
    array(
    "LLueve Bien Gacho Y Mucha gente se cayo",
    "26/02/2022",
    "Se rompieron la maceta",
    "media/img/huracan.jpg"
    ),
    array(
    "LLEga el Coronavirus 3 La Venganza de los Sith",
    "24/02/2022",
    "Todos Vamos A Morir Dicen los reporteros",
    "media/img/Corona.jpg"
    ),
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Portal Editor</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      
</head>

<body>
    <div class="Contenedor-base">
    <div class ="topAnclado">
            <div class = "sidenav" id="EditorSideNav">
                <?php
                echo'
                <hr>
                <img  src="media/img/defProfPic.png" alt="UserImg" style="height 300px"> <br>
                <strong>'.$Perfil->USER_ALIAS. '</strong> <br>
                <hr>
                ';
                ?>
            </div>
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
                <hr>
                <div id="E_Portal_PendArticles_Div">
                <h2 >NOTICIAS PENDIENTES DE REVISION:</h2>
                <?php
                    for ($row = 0; $row < count($Articulos); $row++) {
                        echo "<div class='ZonaNoticia'>";
                        echo'<div class="imgZone"> <img src="'.$Articulos[$row][3].'" alt="ImagenNoticia"></div>
                            <div class="TxtZone">
                            <h1 class="txtTitulo">'.$Articulos[$row][0].'</h1>
                            <p class="txtFecha">'.$Articulos[$row][1].'<p>
                            <p class="txtDesc">
                            '.$Articulos[$row][2].'
                            </p>
                            </div>';
                        echo "</div>";
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