<!DOCTYPE html>
<html lang="en">

<?php
session_start();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario</title>
  <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

  <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">

  <link href="../../bootstrap-5.1.3-examples/assets/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <link rel="stylesheet" href="../../CSS/Estilo_Perfil_usuario.css">
  
  <!--==========================
=            html            =
===========================-->

  <<?php include '../templates/header_navbar.php'; ?> <section class="seccion-perfil-usuario">
    <div class="perfil-usuario-header">
      <?php
      if (isset($_SESSION['user']) && $_SESSION['user']['BANNER_PICTURE'] != null) {
        $hasBPicture = true;
        $imageB = $_SESSION['user']['BANNER_PICTURE'];
        $style = 'background-image: url('.$imageB.')';
        //$style = "background-image:".$imageB;
      ?>
        <div class="perfil-usuario-portada" id="banner_pic" style= "<?php echo $style; ?>" >
      <?php
      } else {
        $hasBPicture = false;
        ?>
        <div class="perfil-usuario-portada" id="banner_pic" >
      <?php
      }
      ?>
          <div class="perfil-usuario-avatar">
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']['PROFILE_PICTURE'] != null) {
              $hasPPicture = true;
              $imageP = $_SESSION['user']['PROFILE_PICTURE'];
            ?>
              <img src=<?php echo $imageP; ?> alt="img-avatar" id="profile_pic">
            <?php
            } else {
              $hasPPicture = false;
            ?>
              <img src="../../Elementos/Jordi.jpg" alt="img-avatar" id="profile_pic">
            <?php
            }
            ?>
            <button class="boton-avatar" id="profile_pic_form">
              <label class="far fa-image" for="upload_profile_pic"></label>
              <input class="upload_image" type="file" id="upload_profile_pic" name="upload_profile_pic">
            </button>
          </div>


          <button type="button" class="boton-portada">
            <label class="far fa-image" for="upload_banner_pic"></label>
            <input class="upload_image" type="file" id="upload_banner_pic" name="upload_banner_pic"> Cambiar fondo
          </button>
          </div>
        </div>
        <div class="perfil-usuario-body">
          <div class="perfil-usuario-bio">
            <h3 class="titulo"><?php echo  $_SESSION["user"]["FULL_NAME"] ?></h3>
            <p class="texto">Joven emprendedor mexicano, con grandes sueños de superacion y actualmente estudiante en la NASA</p>
          </div>
          <form action="../includes/user_profile_inc.php" method="post" id="datosusuario" enctype="multipart/form-data">
            <div class="perfil-usuario-footer">
              <ul class="lista-datos">
                <li hidden="true"><input id="exampleid" hidden="true" type="text" name="idUser" id="idUser" value="<?php echo $_SESSION["user"]["ID_USER"] ?>" class="input-100"></li>
                <li><input id="exampleusername" type="text" name="Nombre" placeholder="Nombre de Usuario" value="<?php echo $_SESSION["user"]["USER_ALIAS"] ?>" class="Nombre-usuario"></li>
                <?php
                    if (isset($_SESSION["error"]) && $_SESSION["error"] =="userChecked") {
                        $_SESSION["error"] = "none";
                ?>
                    <div class= "alert" > Error: El correo no está disponible </div>
                <?php
                    }
                ?>
                <li><input id="examplecorreo" type="email" name="Correo" placeholder="Correo" value="<?php echo $_SESSION["user"]["EMAIL"] ?>" class="input-100"></li>
                <li><input id="examplecontra" type="password" name="Contraseña" placeholder="Contraseña" value="<?php echo $_SESSION["HASH_CRED"] ?>" class="input-cont"></li>
                <li><input id="exampleconfirmar" type="password" name="ContraseñaConfirmar" placeholder="Confirmar Contraseña" value="<?php echo $_SESSION["HASH_CRED"] ?>" class="input-cont"></li>
              </ul>
              <ul class="lista-datos">
                <li><input id="examplename" type="text" name="NombreComp" placeholder="Nombre Completo" value="<?php echo $_SESSION["user"]["FULL_NAME"] ?>" class="Nombre-completo"></li>
                <li><input id="exampletel" type="tel" name="telefono" placeholder="Telefono" value="<?php echo $_SESSION["user"]["PHONE_NUMBER"] ?>" class="input-100"></li>
                <li hidden="true"><input id="examplePPic" hidden="true" name="pPic" value=<?php if($hasPPicture)echo $imageP ?> ></li>
                <li hidden="true"><input id="exampleBPic" hidden="true" name="bPic" value=<?php if($hasBPicture)echo $imageB ?> ></li>
                <a href="javascript:VentanamodUPDATE()"><li><button class="btn-outline-success" id="btn_change" type="button" >Guardar cambios</button></li></a>
                <br>
              </ul>
            </div>
          </form>
          <a href="javascript:VentanamodBAJA()" class="btn-outline-danger" id="btn_baja" type="submit">Dar de baja</a>
        </div>
        </section>

        <!--====  End of html  ====-->

        <script src="../../JS/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="../../JS/Validacion_PerfilUsuario.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




        <script>
          function VentanamodBAJA() {
            Swal.fire({
              title: '¿Estas seguro de dar de baja este usuario?',
              text: "¡Este proceso no se revertira!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si, ¡Da de baja!'
            }).then((result) => {
              if (result.isConfirmed) {
                Swal.fire(
                  '¡Borrado!',
                  'El usuario se a dado de baja',
                  'Exito!'
                )
              }
            })
          }

          function VentanamodUPDATE() {
            if(validarFormularioUsuario()){
              Swal.fire({
                title: '¿Quieres guardar los cambios a tu perfil?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, guardar los cambios'
              }).then((result) => {
                if (result.isConfirmed) {
                  updateProfile()
                  Swal.fire(
                    '¡Listo!',
                    'Tu perfil se ha actualizado',
                    'success'
                  )
                }
              })
            }
          }
        </script>
</body>



</html>