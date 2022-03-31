<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="css/styles.css" >
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
    <script  type="text/javascript" src="js/models/validations.js" ></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js\models\Notipapa.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                    
            $("#btnReg").click(function(){
                if(validar()){
                    swal.fire('¡¡ ESTA USTED REGISTRADO !!','','success')
                }
            })
             
             
        });
    </script>
      
</head>

<body>
    <div class="Contenedor-base">
    <div class = "Barra-navegacion">
                <h3 class="Logo-web">Noticias</h3>
                <a href="index.php">Volver Al Indice</a>
                <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a> 
            </div>

        <div class="mainContenedor">
            <div class="Login">
                <h1  style="color:#F5F5F5; font-family:sans-serif; font-weight:bolder;" >Crear cuenta</h1>
                <form action="" method="POST" class="Formulario" name ="F_Crear_Cuenta">
                <input class="form-control" type="text" id="usernameIt" name="Nombre_de_usuario" placeholder="Nombre de Usuario">
                <input class="form-control" type="text" id="nombreIt" name="Nombre" placeholder="Nombre(s)">
                <input class="form-control" type="text" id="apellPIt" name="Apellido_P" placeholder="Apellido Paterno">
                <input class="form-control" type="text" id="apellMIt" name="Apellido_M" placeholder="Apellido Materno">
                <h5 style="font-family:sans-serif; color:#F5F5F5; font-weight:bolder;">Fecha de nacimiento</h5>
                <input class="form-control" type="date" id="f_NacIt" name="Fecha de nacimiento" >
                <input class="form-control" type="email" id="emailIt" name="direccionemail" placeholder="Ej.: usuario@servidor.com">
                <input class="form-control" type="password" id="clave_1It" name="Contraseña" placeholder="Contraseña">
                <input class="form-control" type="password" id="clave_2It" name="Contraseña_Confirm" placeholder="Verificacion de contraseña">
                <br>
                <button class ="btn btn-danger" type="button" id="btnReg"> Registrarse </button>
                <br>
                <a href="Login.php" style="color:#F5F5F5; font-size: 150%;">¿Ya tienes cuenta?, ¡Inicia sesión!</a>  
                </form>
            </div>
        </div>
        <footer>
        <div class="Derechos"> 2021 Todos los derechos reservados </div>
        <div class="Contactos"> Contacto: Tel:8118047600 Correo:Unote@gmail.com </div>
        <div class="Informacion"> Informacion Compañia | Privacion y Politica | Terminos y Condiciones </div>
    </footer>
    </div>
</body>
</html>