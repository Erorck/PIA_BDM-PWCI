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

  <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>


  <style type="text/css">
    html {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      text-size-adjust: 100%;
      line-height: 1.4;
    }


    * {
      margin: 0;
      padding: 0;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    body {
      color: #404040;
      font-family: "Arial", Segoe UI, Tahoma, sans-serifl, Helvetica Neue, Helvetica;
    }

    .seccion-perfil-usuario .perfil-usuario-body,
    .seccion-perfil-usuario {
      display: flex;
      flex-wrap: wrap;
      flex-direction: column;
      align-items: center;
    }

    .seccion-perfil-usuario .perfil-usuario-header {
      width: 100%;
      display: flex;
      justify-content: center;
      background: linear-gradient(#B873FF, transparent);
      margin-bottom: 1.25rem;
    }

    .seccion-perfil-usuario .perfil-usuario-portada {
      display: block;
      position: relative;
      width: 90%;
      height: 17rem;
      background-image: linear-gradient(45deg, #BC3CFF, #317FFF);
      border-radius: 0 0 20px 20px;
      /*
    background-image: url('http://localhost/multimedia/png/user-portada-3.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    */
    }

    .seccion-perfil-usuario .perfil-usuario-portada .boton-portada {
      position: absolute;
      top: 1rem;
      right: 1rem;
      border: 0;
      border-radius: 8px;
      padding: 12px 25px;
      background-color: rgba(0, 0, 0, .5);
      color: #fff;
      cursor: pointer;
    }

    .seccion-perfil-usuario .perfil-usuario-portada .boton-portada i {
      margin-right: 1rem;
    }

    .seccion-perfil-usuario .perfil-usuario-avatar {
      display: flex;
      width: 180px;
      height: 180px;
      align-items: center;
      justify-content: center;
      border: 7px solid #FFFFFF;
      background-color: #DFE5F2;
      border-radius: 50%;
      box-shadow: 0 0 12px rgba(0, 0, 0, .2);
      position: absolute;
      bottom: -40px;
      left: calc(50% - 90px);
      z-index: 1;
    }

    .seccion-perfil-usuario .perfil-usuario-avatar img {
      width: 100%;
      position: relative;
      border-radius: 50%;
    }

    .seccion-perfil-usuario .perfil-usuario-avatar .boton-avatar {
      position: absolute;
      left: -2px;
      top: -2px;
      border: 0;
      background-color: #fff;
      box-shadow: 0 0 12px rgba(0, 0, 0, .2);
      width: 45px;
      height: 45px;
      border-radius: 50%;
      cursor: pointer;
    }

    .seccion-perfil-usuario .perfil-usuario-body {
      width: 70%;
      position: relative;
      max-width: 750px;
    }

    .seccion-perfil-usuario .perfil-usuario-body .titulo {
      display: block;
      width: 100%;
      font-size: 1.75em;
      margin-bottom: 0.5rem;
    }

    .seccion-perfil-usuario .perfil-usuario-body .texto {
      color: #848484;
      font-size: 0.95em;
    }

    .seccion-perfil-usuario .perfil-usuario-footer,
    .seccion-perfil-usuario .perfil-usuario-bio {
      display: flex;
      flex-wrap: wrap;
      padding: 1.5rem 2rem;
      box-shadow: 0 0 12px rgba(0, 0, 0, .2);
      background-color: #fff;
      border-radius: 15px;
      width: 100%;
    }

    .seccion-perfil-usuario .perfil-usuario-bio {
      margin-bottom: 1.25rem;
      text-align: center;
    }

    .seccion-perfil-usuario .lista-datos {
      width: 50%;
      list-style: none;
    }

    .seccion-perfil-usuario .lista-datos li {
      padding: 5px 0;
    }

    .seccion-perfil-usuario .lista-datos li>.icono {
      margin-right: 1rem;
      font-size: 1.2rem;
      vertical-align: middle;
    }

    .seccion-perfil-usuario .herramientas {
      position: absolute;
      right: calc(0px - 50px - 1rem);
      top: 0;
      display: flex;
      flex-direction: column;
    }

    .seccion-perfil-usuario .herramientas .boton-redes {
      border: 0;
      background-color: #fff;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      color: #fff;
      box-shadow: 0 0 12px rgba(0, 0, 0, .2);
      font-size: 1.3rem;
    }

    .seccion-perfil-usuario .herramientas .boton-redes+.boton-redes {
      margin-top: .5rem;
    }

    .seccion-perfil-usuario .boton-redes.facebook {
      background-color: #5955FF;
    }

    .seccion-perfil-usuario .boton-redes.twitter {
      background-color: #35E1BF;
    }

    .seccion-perfil-usuario .boton-redes.instagram {
      background: linear-gradient(45deg, #FF2DFD, #40A7FF);
    }

    /* adactacion a dispositivos */
    @media (max-width: 750px) {
      .seccion-perfil-usuario .lista-datos {
        width: 100%;
      }

      .seccion-perfil-usuario .perfil-usuario-portada,
      .seccion-perfil-usuario .perfil-usuario-body {
        width: 95%;
      }

      .seccion-perfil-usuario .herramientas {
        position: relative;
        flex-direction: row;
        width: 100%;
        left: 0;
        text-align: center;
        margin-top: 1rem;
        margin-bottom: 1rem;
        align-items: center;
        justify-content: center
      }

      .seccion-perfil-usuario .herramientas .boton-redes+.boton-redes {
        margin-left: 1rem;
        margin-top: 0;
      }
    }

    body {
      min-height: 75rem;
      padding-top: 4.5rem;
    }

    .blog-header {
      line-height: 1;
      border-bottom: 1px solid #e5e5e5;
    }

    .blog-header-logo {
      font-family: "Playfair Display", Georgia, "Times New Roman", serif
        /*rtl:Amiri, Georgia, "Times New Roman", serif*/
      ;
      font-size: 2.25rem;

    }

    .blog-header-logo:hover {
      text-decoration: none;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Playfair Display", Georgia, "Times New Roman", serif
        /*rtl:Amiri, Georgia, "Times New Roman", serif*/
      ;
    }

    .div .containter {
      background-color: #e5e5e5;
      margin-bottom: 130px;
      position: absolute;
    }


    .primicia {
      background-image: url(/Elementos/NP.jpg);
    }

    .display-4 {
      font-size: 2.5rem;
    }

    @media (min-width: 768px) {
      .display-4 {
        font-size: 4rem;
        padding: 0rem;
      }
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
      text-decoration: none;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
      text-decoration: none;

    }

    .nav-scroller .nav-link {
      padding-top: .75rem;
      padding-bottom: .75rem;
      font-size: .875rem;
    }

    .card-img-right {
      height: 100%;
      border-radius: 0 3px 3px 0;
    }

    .flex-auto {
      flex: 0 0 auto;
    }

    .h-250 {
      height: 250px;
    }

    @media (min-width: 768px) {
      .h-md-250 {
        height: 250px;
      }
    }

    /* Pagination */
    .blog-pagination {
      margin-bottom: 4rem;
    }

    .blog-pagination>.btn {
      border-radius: 2rem;
    }

    /*
   * Blog posts
   */
    .blog-post {
      margin-bottom: 4rem;
    }

    .blog-post-title {
      margin-bottom: .25rem;
      font-size: 2.5rem;
    }

    .blog-post-meta {
      margin-bottom: 1.25rem;
      color: #727272;
    }

    /*
   * Footer
   */
    .blog-footer {
      padding: 2.5rem 0;
      color: #727272;
      text-align: center;
      background-color: #f9f9f9;
      border-top: .05rem solid #e5e5e5;
    }

    .blog-footer p:last-child {
      margin-bottom: 0;
    }


    .lista-datos input {
      background: #e1d8e7be;
      outline: none;
      font-size: 15px;
      border-radius: 5px;
      border: 3px solid #3b055f;
    }


    #btn_baja {
      background: #ec0437be;
      outline: none;
      font-size: 15px;
      width: 200px;
      color: rgb(230, 218, 218);
      border-radius: 5px;
      border: 3px solid #690404;
      margin-top: 2%;
      text-decoration: none;
      text-align: center;
    }

    .lista-datos #btn_change {
      background: #1bcf33be;
      outline: none;
      font-size: 15px;
      width: 200px;
      color: rgb(20, 20, 20);
      border-radius: 5px;
      border: 3px solid #044419;
      margin-bottom: 2%;
    }

    .alert {
      display: block;
      padding: 12px 20px;
      background: #f8d7da;
      color: #721c24;
      margin-bottom: 10px;
      border: 1px solid #f5c6cb;
    }

    .upload_image {
      opacity: 0;
      position: absolute;
      z-index: -1;
    }
  </style>
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
                <li><input id="exampleid" type="text" name="idUser" id="idUser" value="<?php echo $_SESSION["user"]["ID_USER"] ?>" class="input-100"></li>
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
              </ul>
              <ul class="lista-datos">
                <li><input id="examplename" type="text" name="NombreComp" placeholder="Nombre Completo" value="<?php echo $_SESSION["user"]["FULL_NAME"] ?>" class="Nombre-completo"></li>
                <li><input id="exampletel" type="tel" name="telefono" placeholder="Telefono" value="<?php echo $_SESSION["user"]["PHONE_NUMBER"] ?>" class="input-100"></li>
                <li><input id="examplePPic" name="pPic" value=<?php if($hasPPicture)echo $imageP ?> ></li>
                <li><input id="exampleBPic" name="bPic" value=<?php if($hasBPicture)echo $imageB ?> ></li>
                <button class="btn-outline-success" id="btn_change" name="btn_update_profile" type="submit">Guardar cambios</button>
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
        </script>
</body>



</html>