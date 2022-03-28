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
        <div class = "Barra-navegacion">
            <h3 class="Logo-web">Noticias</h3>
            <a href="index.php">Volver Al Indice</a>
            <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a>
            <form action="Busqueda.php" name="F_Search" class="SearchBarForm">
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda"></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </form>
        </div>

        <div class="mainContenedor">
            <div class="ZonaFeedPortal">
            <?php
            // Load Data
             $Categ = array("Deportes"=>"#e0b21b", "Salud"=>"#b03838", "Negocios"=>"#38b062", "Entretenimiento"=>"#c730a6");
             $Articulos = array(
                array(
                "Revive Gustavo Cerati ",
                "25/02/2022",
                "\"Che Que loco Revivi Fua xdxd\" Exclamo el cantante argentino",
                "media/img/GustavoCerati.jpg"
                ),
                array(
                "LLueve Bien Gacho We jaja nmms wtf",
                "26/02/2022",
                "LLovio y me parti mi madre we",
                "media/img/huracan.jpg"
                ),
                array(
                "LLEga el Coronavirus 3 La Venganza de los Sith",
                "24/02/2022",
                "JSJSJ NMMS MEJOR MATENME NO???",
                "media/img/Corona.jpg"
                ),
             );
            ?>  
                <hr>
                <div id="E_Portal_Categ_Div">
                <h2>SECCIONES DEL BOLETIN:</h2> 
                <?php
                    foreach ($Categ as $x => $x_value) {
                    echo '<h3 class="Categ" style="background-color:'.$x_value.';">' . $x . '<button class="btn_editCateg"><i class="fa fa-pencil" aria-hidden="true"></i></button>  </h3>';
                    };
                ?>  
                <button id="btnAddCateg"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
                <hr>
                <div id="E_Portal_PendArticles_Div">
                <h2>Noticias Pendientes de Revision:</h2>
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