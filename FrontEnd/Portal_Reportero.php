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
            <div class="ZonaFeed">
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