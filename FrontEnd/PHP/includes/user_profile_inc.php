<?php

include "../classes/User/user-contr.classes.php";

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    if (isset($_SESSION["permission"])) {
        header("location: ../Pages/Inicio.php?permission=".$_SESSION["permission"]);
    } else {
        header("location: ../Pages/Inicio.php?permission=none");
    }
}
//Actualizacion de perfil mediante formulario
if (isset($_POST["btn_update_profile"])) {
    $idUser = $_POST["idUser"];
    $nickname = $_POST["Nombre"];
    $email = $_POST["Correo"];
    $pwd = $_POST["Contraseña"];
    $name = $_POST["NombreComp"];
    $phoneNumber = $_POST["telefono"];
    $pPicture = $_POST["pPic"];
    $bPicture = $_POST["bPic"];
    $userType = $_SESSION["permission"];

    $user = new UserControler($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $userType);
    $user->updateUserSelf();

    if (isset($_SESSION["permission"])) {
        header("location: ../Pages/Perfil_usuario.php?permission=".$_SESSION["permission"]);
    } else {
        header("location: ../Pages/Inicio.php?permission=none");
    }
}
//Actualizacion de perfil mediante ajax
if (isset($_POST["ajax_update_profile"])) {
    $idUser = $_POST["idUser"];
    $nickname = $_POST["Nombre"];
    $email = $_POST["Correo"];
    $pwd = $_POST["Contraseña"];
    $name = $_POST["NombreComp"];
    $phoneNumber = $_POST["telefono"];
    $pPicture = $_POST["pPic"];
    $bPicture = $_POST["bPic"];
    $userType = $_POST["permission"];

    $user = new UserControler($idUser, $nickname, $email, $pwd, $name, $phoneNumber, $pPicture, $bPicture, $userType);
    $user->updateUserSelf();

    echo'Se logro c:';

}
//Baja de usuario mediante ajax
if (isset($_POST["ajax_deactivate_profile"])) {
    $idUser = $_POST["idUser"];    

    $user = new UserControler($idUser, 0, 0, 0, 0, 0, 0, 0, 0);
    $user->deleteUserSelf();

    //header("location: ../Pages/Login.php");

    echo"../Pages/Login.php";
    

}
