<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: 'LoginScript.php',
                data: $(this).serialize(),
                success: function(response)
                {
                    debugger;
                    var jsonData = JSON.parse(response);
    
                    // user is logged in successfully in the back-end
                    // let's redirect
                    if (jsonData.success == "1")
                    {
                        //swal.fire('LOGIN EXITOSO','','success')
                        let timerInterval
                        Swal.fire({
                        title: 'LoginSuccessful!',
                        timer: 2000,
                        timerProgressBar: true,
                        showCancelButton: false,
                        showConfirmButton: false,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.href = 'Main.php';
                        }
                        })  
                    }
                    else
                    {
                        swal.fire('USUARIO O CONTRASEÑA ERRONEOS','','error')
                    }
            }
        });
        });
    });
    </script>
</head>

<body>
    <div class="Contenedor-base">
    <div class = "Barra-navegacion">
                <h3 class="Logo-web">Noticias</h3>
                <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a> 
            </div>

        <div class="mainContenedor">
            <div class="Login">
                <h1  style="color:#F5F5F5; font-family:sans-serif; font-weight:bolder;" >Iniciar Sesion</h1>
                <form id="loginForm" method="post" class="Formulario" name ="F_Login">
                <input class="form-control" type="text" id="usernameIt" name="uname" placeholder="Nombre de Usuario">
                <input class="form-control" type="password" id="pass" name="pass" placeholder="Contraseña">
                <br>
                <input type="submit"class="btn btn-danger" name="loginBtn" id="loginBtn" value="Ingresar" />
                <br>
                <a href="Register.php" style="color:#F5F5F5; font-size: 150%;">¿No tienes cuenta?, ¡Registraté!</a>  
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
</html>