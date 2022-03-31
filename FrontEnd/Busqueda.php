
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
      
</head>

<body>
    <div class="Contenedor-base">
        <div class = "Barra-navegacion">
            <h3 class="Logo-web">Noticias</h3>
            <a href="index.php">Volver Al Indice</a>
            <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a>
            <form action="Busqueda.php" name="F_Search" class="SearchBarForm">
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda" value=<?php echo"'".$_GET['srchParam']."'";?>></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </form>
        </div>

        <div class="mainContenedor">
            <?php
            $srchParam = $_GET["srchParam"];
            ?>
            <div class="ZonaFeed">
            <?php
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

                 $numFoundArticulos = 0;
                 $FoundArticulos = [[]];
                 function buscarArticulos(string $inputSrch,$inarticls,&$numfound,&$found) {
                    for ($row = 0; $row < count($inarticls); $row++) {
                        if((strpos($inarticls[$row][0], $inputSrch) !== false) ||(strpos($inarticls[$row][2], $inputSrch) !== false)){
                            array_push($found,$inarticls[$row]);
                            $numfound++;
                        }
                    }
                    if($numfound > 0) return true;
                    else return false;
                  }

                ?>
                <?php
                $foundSomething = buscarArticulos($srchParam,$Articulos,$numFoundArticulos,$FoundArticulos);
                if ($foundSomething!==false){
                    $FoundArticulos = array_filter($FoundArticulos);
                    if(isset($FoundArticulos)){
                        $FooArt2 = array_values($FoundArticulos);
                        for ($row = 0; $row < count($FooArt2); $row++) {
                            
                            echo "<div class='ZonaNoticia'>";
                            /*echo'<div class="imgZone"> <img src="'.$FooArt2[$row][3].'" alt="ImagenNoticia"></div>
                                <div class="TxtZone">
                                <h1 class="txtTitulo">'.$FooArt2[$row][0].'</h1>
                                <p class="txtFecha">'.$FooArt2[$row][1].'<p>
                                <p class="txtDesc">
                                '.$FoundAFooArt2rticulos[$row][2].'
                                </p>
                                </div>';*/
                             
                            echo"<div class='imgZone'> <img src='".$FooArt2[$row][3]."'alt='ImagenNoticia'></div>";
                            echo"<div class='TxtZone'>";
                            echo"<h1 class='txtTitulo'>".$FooArt2[$row][0]."</h1>";
                            echo" <p class='txtFecha'>".$FooArt2[$row][1]."<p>"; 
                            echo "<p class='txtDesc'>".$FooArt2[$row][2]."</p>";  
                            echo"</div>";
                            echo "</div>";
                        }
                    }
                }
                else{
                    echo "<div class='ZonaNoticia'>";
                    echo'<h3>No Encontre Nada Papu xD</h3>';
                    echo "</div>";
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
