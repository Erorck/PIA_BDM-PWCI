<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../CSS/bootstrap.min.css">
    <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">

    <style>
        body{
            background: rgb(45, 70, 138);
            background: linear-gradient(to right, rgb(23, 7, 80), rgb(107, 158, 216));
        }
        .bg{
            background-image: url(../../Elementos/GOT_BACK_WHITE.jpg);
            background-position: center center;
        }
         
        .alert{
            display: block;
            padding: 12px 20px;
            background: #f8d7da;
            color: #721c24;
            margin-bottom: 10px;
            border: 1px solid #f5c6cb; 
        }
    </style>

</head>
<body>

    <div class="container w-75 mt-5 rounded shadow">
    <div class="row align-items-stretch">
        <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

        </div>
        <div class="col bg-white p-5 rounded-end">
         <div class="text-end">
    <img src="../../Elementos/Good Old Times_LOGO2.2.png" width="100" alt="">
         </div> 
    <h2 class="fw-bold text-center "> ¡Bienvenido de nuevo!</h2>

    <form action="../includes/login_inc.php" method="post" enctype="multipart/form-data" id="login">
        <div class="mb-4">
            <label for="email" class="form-label">Correo electrónico</label>
            <?php
                 if (isset($_SESSION["error"]) && $_SESSION["error"] =="userNotFound") {
                    $_SESSION["error"] = "none";
            ?>
                <div class= "alert" > Error: El correo no está ligado a ninguna cuenta </div>
            <?php
                 }
            ?>
            <input type="email" class="form-control" id="correo" name="email">
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <?php
                 if (isset($_SESSION["error"]) && $_SESSION["error"] =="wrongPassword") {
                    $_SESSION["error"] = "none";
            ?>
                <div class= "alert" > Error: Contraseña incorrecta </div>
            <?php
                 }
            ?>
            <input type="password" class="form-control" id="contra" name="password">
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" name="connected">
            <label for="connected" class="form-check-label">Mantenerme conectado</label>
        </div>
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Iniciar Sesion</button>
        </div>

        <div class="my-3">
            <span>No tienes cuenta? <a href="#">Registrate</a></span><br>
            <span><a href="#">Recuperar contraseña</a></span>
        </div>
    </form>
<!-- Login redes sociales-->
        <div class="container w-100 my-4">
            <div class="row text-center">
                <div class="col-12">Iniciar Sesión con:</div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-outline-primary w-100 my-1">
                        <div class="row align-items-center">
                            <div class="col-2 d-none d-md-block">
                                <img src="../../Elementos/fb_icon.png" width="32" alt="">
                            </div>
                            <div class="col-12 col-md-10 text-center">
                                Facebook
                            </div>
                        </div>
                    </button>
                </div>
                <div class="col">
                    <button class="btn btn-outline-danger w-100 my-1">
                        <div class="row align-items-center">
                            <div class="col-2 d-none d-md-block">
                                <img src="../../Elementos/google_icon.png" width="32" alt="">
                            </div>
                            <div class="col-12 col-md-10 text-center">
                                Google
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="../../JS/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="../../JS/ValidacionLogin.js"></script>

</body>
</html>