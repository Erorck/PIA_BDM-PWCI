<?php
include"../classes/Login/login-contr.classes.php";

    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        

        $login = new LoginContr($email, $pwd);
        $login->loginUser();
        header("location: ../index.php?error=none");

    }
?>