<?php 

if (isset($_GET["profile"])) {
    echo'Es get';
    session_start();
    echo $_SESSION["user"]["USER_TYPE"];
    if (isset($_SESSION["user"])) {
        switch ($_SESSION["user"]["USER_TYPE"]) {
            case 'UR':
                header("location: ../Pages/Perfil_usuario.php?permission=".$_SESSION["permission"]);
                break;

            case 'R':
                header("location: ../Pages/Perfil_reportero.php?permission=".$_SESSION["permission"]);
                break;

            case 'E':
                header("location: ../Pages/Perfil_Editor.php?permission=".$_SESSION["permission"]);
                break;
            
            default:
                header("location: ../Pages/Login.php");
                break;
        }
    } 
}
