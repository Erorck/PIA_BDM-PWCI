<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $userType = "";
    if($_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        $userType= $Perfil->USER_TYPE;
    }
    else{
        header('Location: '.'403.html');
    }
    
    if(connection::GetCountArticles($numArticles,"XD")) $ArticlesExist = true;
    if(connection::GetCountArticles($numRRArticles,"RR")) $ArticlesRRExist = true;
    if(connection::GetCountArticles($numRAArticles,"RA")) $ArticlesRAExist = true;
    if(connection::GetCountArticles($numPUArticles,"PU")) $ArticlesPUExist = true;
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
      <script type="text/javascript">
        $(document).ready(function() {
            if($('.notify-bubble').attr("notifications") > 0){
                $('.notify-bubble').show(400);
            }
         });
    </script>
</head>

<body>
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
            <div id="profilemenu">
            <Button class="BtnEditProfile" style="font-size:xx-large;"><a href="EditarPerfil.php"><i class="fa fa-pencil" aria-hidden="true"></i></a></Button> 
            <div class="notify-container">
                <?php
                    switch($userType){
                        case "AD":
                            echo'<Button class="BtnEditProfile" style="font-size:xx-large;"><a href="Portal_Editor.php">Portal del Editor</a>';
                            echo'<Button class="BtnEditProfile" style="font-size:xx-large;"><a href="RegisterReporter.php">Registrar Reportero</a>';
                            if($ArticlesRRExist) echo'<span class="notify-bubble" notifications="'.$numRRArticles.'">'.$numRRArticles.'</span>';
                            echo'</Button>';
                            if($ArticlesPUExist){
                                echo'<Button class="BtnEditProfile" style="font-size:xx-large;"><a href="ReportApi/Report.php">Generar Reporte de noticias</a>';
                                echo'</Button>';
                            }
                        break;
                        case"RE":
                        echo'<Button class="BtnEditProfile" style="font-size:xx-large;"><a href="Portal_Reportero.php">Portal del Reportero</a>';
                            if($ArticlesRAExist) echo'<span class="notify-bubble" notifications="'.$numRAArticles.'">'.$numRAArticles.'</span>';
                            echo'</Button>';
                            
                        break;
                        default:
                    }
                ?>
                
            </div>
            </div>
            <div class="ZonaFeedProfile">
            <?php
                echo'
                <img class="profpic" src="media/img/defProfPic.png" alt="UserImg" style="height 300px"> <br>
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