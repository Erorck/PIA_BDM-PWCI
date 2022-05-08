<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Perfil = null;
    $LoggedUser = false;
    if($_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
    }
    else{
        header('Location: '.'403.html');
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Perfil</title>
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
            <Button class="BtnEditProfile" style="font-size:xx-large;"><i class="fa fa-pencil" aria-hidden="true"></i></Button>
            <div class="ZonaFeedProfile">
            <?php
                echo'
                <img class="profpic" src="media/img/img_Usuarios/portrait.jpg" alt="UserImg" style="height 300px"> <br>
                <strong>'.$Perfil->USER_ALIAS. '</strong> <br>
                <strong>'.$Perfil->NAME.' '.$Perfil->FIRST_LAST_NAME.' '.$Perfil->SECOND_LAST_NAME.'</strong> <br>
                <strong>'.$Perfil->EMAIL. '</strong> <br>
                <strong>'.$Perfil->BIRTHDAY. '</strong> <br>
                ';
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