<?php
include "../classes/Login/login-contr.classes.php";

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pwd = $_POST["password"];


    $login = new LoginContr($email, $pwd);
    $login->loginUser();
    if (isset($_SESSION["permission"])) {
        header("location: ../Pages/Inicio.php?permission=".$_SESSION["permission"]);
    } else {
        header("location: ../Pages/Inicio.php?permission=none");
    }
}