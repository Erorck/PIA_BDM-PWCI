<?php 
include "../classes/Consult/consult-contr.classes.php";


if (isset($_GET["profile"])) {
    echo'Es get';
    session_start();
    // echo $_SESSION["user"]["USER_TYPE"];
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

if(isset($_GET["search"])){
    $dateMin = $_GET["fechaMin"] ?? null;
    $dateMax = $_GET["fechaMax"] ?? null;
    $querySearch = $_GET["buscarpalabra"] ?? "";

    $consult = new ConsultsControler();

    if($dateMin === '')
        $dateMin = null;
    if($dateMax === '')
        $dateMax = null;

    $news = $consult->getSearchedNews($querySearch, $dateMin, $dateMax);

    if($news === 0)
        $news = array();

    // TODO: redirect to result search page(pass search result with session) or include it right here and use regular variables


    include "../Pages/Resultados_Busqueda.php";
}
