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
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda"></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </form>
        </div>

        <div class="mainContenedor">
            <div class="ZonaFeedProfile">
                <form action="" method="POST" name="F_EditPerfil">
                <?php
                    $User = array(
                        "LeoPoldinXDUchiha2002",
                        "Leopoldo",
                        "Martinez",
                        "Guerrero",
                        "ItachiModoSenin2002@hotmail.com",
                        "21/02/2002",
                        "media/img/img_Usuarios/portrait.jpg"
                    );
                    echo' <img class="profpic" src="'.$User[6].'" alt="UserImg" style="height 300px"> <Button class="BtnEditProfile" id="btnPfpChange" style="font-size:xx-large;"><i class="fa fa-pencil" aria-hidden="true"></i></Button><br> <br>';
                    echo' <input class="form-control" type="text" id="username" name="uname" placeholder="'.$User[0]. '"> <br> ';
                    echo' <input class="form-control" type="text" id="usernombre" name="name" placeholder="'.$User[1]. '"> <br> ';
                    echo' <input class="form-control" type="text" id="userap" name="apaterno" placeholder="'.$User[2]. '"> <br> ';
                    echo' <input class="form-control" type="text" id="useram" name="amaterno" placeholder="'.$User[3]. '"> <br> ';
                    echo' <input class="form-control" type="text" id="usermail" name="mail" placeholder="'.$User[4]. '"> <br> ';
                ?>
            <button type="reset" value="Reset">Reset</button>
            <button type="submit" value="Submit">Guardar Cambios</button> 
            <button type="button">Cancelar</button> 
            </form>
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