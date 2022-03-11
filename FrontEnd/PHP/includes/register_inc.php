<?php
include"../classes/Register/register-contr.classes.php";

    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $pwd = $_POST["password"];
        $user_type = $_POST["userType"];

        $register = new RegisterControler( $name, $email, $pwd, $user_type);
        $register->registerUser();
        header("location: ../Pages/Inicio.php?error=none");

    }
    else{
        echo "Error";
    }
?>