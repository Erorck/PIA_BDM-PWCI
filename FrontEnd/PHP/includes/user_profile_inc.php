<?php

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $pwd = $_POST["password"];

    if (isset($_SESSION["permission"])) {
        header("location: ../Pages/Inicio.php?permission=".$_SESSION["permission"]);
    } else {
        header("location: ../Pages/Inicio.php?permission=none");
    }
}
