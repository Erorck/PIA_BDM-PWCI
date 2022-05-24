<!DOCTYPE html>
<html lang="en">

<?php
session_start();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Editor</title>
  <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <script src="https://kit.fontawesome.com/20eb58569d.js" crossorigin="anonymous"></script>

  <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.css">

  <!--  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />-->

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/offcanvas-navbar/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/checkout/">
  <script src="../..//JS/offcanvas.js"></script>


  <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="../../JS/lightslider.js"></script>
  <link rel="stylesheet" href="../../CSS/lightslider.css">


  <link href="../../bootstrap-5.1.3-examples/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../..//bootstrap-5.1.3-examples/offcanvas-navbar/offcanvas.css" rel="stylesheet">
  <link href="../../CSS/form-validation.css" rel="stylesheet">
  <link href="../../CSS/Estilo_Perfil_editor.css" rel="stylesheet">



</head>

<body>



  <!--==========================
=            html            =
===========================-->
  <?php include "../templates/header_navbar.php" ?>

  <section class="seccion-perfil-usuario">
    <div class="perfil-usuario-header">
      <?php
      if (isset($_SESSION['user']) && $_SESSION['user']['BANNER_PICTURE'] != null) {
        $hasBPicture = true;
        $imageB = $_SESSION['user']['BANNER_PICTURE'];
        $style = 'background-image: url(' . $imageB . ')';
      ?>
        <div class="perfil-usuario-portada" id="banner_pic" style="<?php echo $style; ?>">
        <?php
      } else {
        $hasBPicture = false;
        ?>
          <div class="perfil-usuario-portada" id="banner_pic">
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
              <img src="../../Elementos/licpugberto.jpg" alt="img-avatar" id="profile_pic">
            <?php
            }
            ?>
            <button class="boton-avatar" id="profile_pic_form" style="display: none">
              <label class="far fa-image" for="upload_profile_pic"></label>
              <input class="upload_image" type="file" id="upload_profile_pic" name="upload_profile_pic">
            </button>
          </div>
          <button type="button" id="banner_pic_form" class="boton-portada" style="display: none">
            <label class="far fa-image" for="upload_banner_pic"></label>
            <input class="upload_image" type="file" id="upload_banner_pic" name="upload_banner_pic"> Cambiar fondo
          </button>
          </div>
        </div>
        <div class="perfil-usuario-body">
          <div class="perfil-usuario-bio">
            <h3 id="displayFullName" class="titulo"><?php echo $_SESSION["user"]["FULL_NAME"] ?></h3>
          </div>
          <div class="perfil-usuario-footer">

            <div id="btn_tools" class="herramientas">
              <button id="btn_mod" class="boton-redes facebook"><i class="fas fa-wrench"></i></button>
              <button id="btn_cancel" style="display: none" class="boton-redes cancel"><i class="fas fa-xmark"></i></button>
            </div>

            <!-- DISPLAYS  ---------------------------------------- -->
            <ul class="lista-datos">
              <li id="displayAlias"><i class="fad fa-user-alt"></i> <?php echo '@' . $_SESSION["user"]["USER_ALIAS"] ?></li>
              <li><i class="fad fa-briefcase"></i> Editor en jefe de Good Old Times</li>
            </ul>

            <ul class="lista-datos">
              <li id="displayPhone"><i class="fas fa-phone-alt"></i> Telefono: +52 <?php echo $_SESSION["user"]["PHONE_NUMBER"] ?></li>
              <li id="displayEmail"><i class="fas fa-envelope"></i> Correo: <?php echo $_SESSION["user"]["EMAIL"] ?></li>
            </ul>

            <!-- INPUTS  ---------------------------------------- -->
            <ul class="lista-datos list_mod" style="display: none">
              <li hidden="true"><input id="exampleid" hidden="true" type="text" name="idUser" id="idUser" value="<?php echo $_SESSION["user"]["ID_USER"] ?>" class="input-100"></li>
              <li><input id="exampleusername" type="text" name="Nombre" placeholder="Nombre de Usuario" value="<?php echo $_SESSION["user"]["USER_ALIAS"] ?>" class="Nombre-usuario"></li>

              <?php
              if (isset($_SESSION["error"]) && $_SESSION["error"] == "userChecked") {
                $_SESSION["error"] = "none";
              ?>

                <div class="alert"> Error: El correo no está disponible </div>

              <?php
              }
              ?>

              <li><input id="examplecorreo" type="email" name="Correo" placeholder="Correo" value="<?php echo $_SESSION["user"]["EMAIL"] ?>" class="input-100"></li>
              <li><input id="examplecontra" type="password" name="Contraseña" placeholder="Contraseña" value="<?php echo $_SESSION["HASH_CRED"] ?>" class="input-cont"></li>
              <li><input id="exampleconfirmar" type="password" name="ContraseñaConfirmar" placeholder="Confirmar Contraseña" value="<?php echo $_SESSION["HASH_CRED"] ?>" class="input-cont"></li>
            </ul>

            <ul class="lista-datos list_mod" style="display: none">
              <li><input id="examplename" type="text" name="NombreComp" placeholder="Nombre Completo" value="<?php echo $_SESSION["user"]["FULL_NAME"] ?>" class="Nombre-completo"></li>
              <li><input id="exampletel" type="tel" name="telefono" placeholder="Telefono" value="<?php echo $_SESSION["user"]["PHONE_NUMBER"] ?>" class="input-100"></li>
              <li hidden="true"><input id="examplePPic" name="pPic" value=<?php if ($hasPPicture) echo $imageP ?>></li>
              <li hidden="true"><input id="exampleBPic" name="bPic" value=<?php if ($hasBPicture) echo $imageB ?>></li>
              <a href="javascript:VentanaModPerfil()">
                <li><button class="btn-outline-success" id="btn_change" type="button">Guardar cambios</button></li>
              </a>
            </ul>

          </div>

        </div>
  </section>

  <section id="cursos">
    <div class="container-fluid">
      <div class="Misnoticias content_lado">
        <br><br><br>
        <h2>Noticias por aprobar</h2>
      </div>

      <div class="row">

        <body>
          <div class="contenedor_recuadros">
            <ul id="autoWidth" class="cs-hidden">
              <!-- 1  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/NP.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2>Chavis rompe en llanto</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>

                  </div>
                </div>
              </li>

              <!-- 2  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/Altonio.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2> Cae capo de sinaloa</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>
                  </div>
                </div>
              </li>

              <!-- 3  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/Altonio.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2> ¡Escandalo sucede en es show!</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>
                  </div>
                </div>
              </li>

              <!-- 4  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/NP.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2>Chavis rompe en llanto</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>
                  </div>
                </div>
              </li>

              <!-- 5  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/NP.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2>Chavis rompe en llanto</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>
                  </div>
                </div>
              </li>

              <!--6  ---------------------------------------- -->
              <li class="item-a">
                <div class="caja_cursos">
                  <img src="../../Elementos/NP.jpg" class="img_curso_cuadro" alt="curso 1">
                  <div class="detalles_curso">
                    <h2>Chavis rompe en llanto</h2>
                    <!--<a href="/html/Info_Curso.html">-->
                    <a href="#" class="text-white btn-outline-secondary"><i class="fad fa-comment-alt-edit"></i></a>
                    <a href="javascript:Ventanamod()" id="show-modal" class="text-white btn-outline-secondary"><i class="fas fa-check-square"></i></a>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </body>
      </div>
    </div>

    <!-- SECCIONES -->
  </section>
  <main class="container" id="Edit_secok">
    <div class="my-3 p-3 bg-dark rounded shadow-sm">
      <h6 class="text-light border-bottom pb-2 mb-0">Edición de Secciones</h6>
      <div class="d-flex text-muted pt-3">
        <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
          <p class="text-light">Selecciona un color<input class="form-control" href="javascript:colorpick()" id="color-picker" value='#276cb8' /></p>
        </div>
      </div>
      <div class="d-flex text-muted pt-3">
        <select id="cbOrder" class="form-select" id="country" required>
          <option value="N">Posición de la sección...</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        </select>
      </div>
      <small class="d-block text-end mt-3">
        <select id="cbSection" class="form-select" id="country" required>
          <option value="N">Elige la seccion a Editar...</option>
          <option>Internacional</option>
        </select>
        <button style="display: none" id="btn_update_section" onclick="VentanaModAttrSeccion()" class="btn_seccok"><i class="fas fa-check"></i></button>
      </small>
    </div>
  </main>

  <main class="container">
    <form action="" id="seccionval">
      <div class="my-3 p-3 bg-body-light rounded shadow-sm ">
        <h6 class="border-bottom pb-2 mb-0">Secciones</h6>

        <div id="sections_list">
          <div class="d-flex text-muted pt-3">
            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
            </svg>
            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
              <div class="d-flex justify-content-between">
                <strong class="text-gray-dark">Internacional</strong>
                <a href="javascript:VentanaBajaSeccion()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
              </div>
              <a href="javascript:VentanaModNameSeccion()" class="lapiz"><i class="fas fa-pen"></i></a>
            </div>
          </div>

          <div class="d-flex text-muted pt-3">
            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
            </svg>
            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
              <div class="d-flex justify-content-between">
                <strong class="text-gray-dark">Negocios</strong>
                <a href="javascript:VentanaBajaSeccion()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
              </div>
              <a href="javascript:VentanaModNameSeccion()" class="lapiz"><i class="fas fa-pen"></i></a>
            </div>
          </div>

          <div class="d-flex text-muted pt-3">
            <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
            </svg>
            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
              <div class="d-flex justify-content-between">
                <strong class="text-gray-dark">Tecnologia</strong>
                <a href="javascript:VentanaBajaSeccion()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
              </div>
              <a href="javascript:VentanaModNameSeccion()" class="lapiz"><i class="fas fa-pen"></i></a>
            </div>
          </div>
        </div>

        <small class="d-block text-dark mt-3">
          <input id="SeccionAlta" class="form-control" type="text" name="sec" placeholder="Farándula...">
          <button class="text-dark text-decoration-none" id="btn_add_section" onclick="VentanaAltaSeccion()" type="button">Añadir Sección</button>
        </small>
      </div>
    </form>
  </main>

  <!-- REPORTEROS -->
  <main class="container">
    <div class="my-3 p-3 bg-dark rounded shadow-sm">
      <h6 id="before_journalist" class="text-light border-bottom pb-2 mb-0">Reporteros</h6>

      <div id="journalist_list">
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>

          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <strong class="text-gray-dark">Chafana del Jesus Tremendo Socorro</strong>
              <a href="javascript:VentanaBajaReportero()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
            </div>
            <span class="d-block">@ChavisconC</span>
          </div>
        </div>

        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>

          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <strong class="text-gray-dark">Jazmin sin J Arroyo Villarreal</strong>
              <a href="javascript:VentanaBajaReportero()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
            </div>
            <span class="d-block">@JazminconJ</span>
          </div>
        </div>

        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>

          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <strong class="text-gray-dark">Konan el barbaro Gutierrez Pequeño</strong>
              <a href="javascript:VentanaBajaReportero()" class="text-danger"><i class="fas fa-trash-alt"></i></a>
            </div>
            <span class="d-block">@KonanBigOfficial</span>
          </div>
        </div>
      </div>


      <small class="d-block text-end mt-3">
        <li id="btn_add_journalist" style="display: none"><button class="btn-outline-success" onclick="VentanaAltaReportero()" type="button">Añadir reportero</button></li>
        <select class="form-select" id="cbJournalist" required>
          <option value='N'>Selecciona un Reportero...</option>
          <option>Mafer Chavana</option>
        </select>
      </small>
    </div>
  </main>

  <!-- REPORTE NOTICIAS -->
  <main class="container">
    <form action="">
      <div class="my-3 p-3 bg-body-light rounded shadow-sm ">
        <h6 class="border-bottom pb-2 mb-0">Reporte - Noticias mas buscadas</h6>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>
          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <label for="Tipo" class="form-label">Noticia o Sección</label>
              <select class="form-select" id="Tipo">
                <option value="N">Noticia</option>
                <option value="S">Sección</option>
              </select>
            </div>
          </div>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>
          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <label for="seccion" class="form-label">Secciónes</label>
              <select class="form-select" id="cbSectionRep">
                <option value="0">Todas</option>
                <option>Sección 01</option>
                <option>Sección 02</option>
              </select>
            </div>
          </div>
        </div>
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>
          <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
            <div class="d-flex justify-content-between">
              <label for="country" class="form-label">Fechas</label>
              <div class="row gy-3">
                <div class="col-md-6 columna">
                  <input type="date" id="fechaMinRep" class="calend">
                  <input type="date" id="fechaMaxRep" class="calend">
                </div>
              </div>
            </div>
          </div>
        </div>
        <small class="d-block text-dark mt-3">
          <button class="text-dark text-decoration-none" id="CrearReporte" type="button" onclick="getLikesReports()">Crear Reporte</button>
        </small>
      </div>
    </form>

    <table class="reporte" id="tablareporte">
      <thead id="tableHeader">
        <tr>
          <th>Sección</th>
          <th id="posMes">Fecha</th>
          <th id="posAño">Noticia</th>
          <th>Likes</th>
          <th>Numero Comentarios</th>
        </tr>
      </thead>
      <tbody id="reportRows">
        <tr>
          <td>Farandula</td>
          <td>30/SEP/2022</td>
          <td>Alfredo Adame...</td>
          <td>300 </td>
          <td>30</td>
        </tr>
        <tr>
          <td>Deportes</td>
          <td>10/DIC/2022</td>
          <td>Big Neurosis gana...</td>
          <td>301</td>
          <td>200</td>
        </tr>
        <tr>
          <td>Internacional</td>
          <td>20/DIC/2022</td>
          <td>Mafer Chavana World Tour</td>
          <td>2300</td>
          <td>10</td>
        </tr>
        <tr>
          <td>Clima</td>
          <td>1/ENE/2022</td>
          <td>¡Se viene la llovina!</td>
          <td>90</td>
          <td>405</td>
        </tr>
      </tbody>
      </div>
    </table>
    <br>
    <br>

  </main>




  <footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
    </p>
  </footer>

  <!--====  End of html  ====-->

  <script src="../../JS/bootstrap.bundle.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../JS/form-validation.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2/dist/spectrum.min.js"></script>
  <script src="../../JS/Validacion_PerfilEdit.js"></script>

  <script>
    function abrir() {
      document.getElementById("vent").style.display = "block";
    }

    function cerrar() {
      document.getElementById("vent").style.display = "none";
    }
  </script>

  <!-- SCRIPTS REVISIÓN NOTICIAS -->
  <script>
    function VentanaAprobarNoticia(reportId) {

      Swal.fire({
        title: '¿Estas segur@ de aprobar la Nota?',
        text: "¡Se publicará en el portal!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Aprobarla!'
      }).then((result) => {
        if (result.isConfirmed) {
          approveReport(reportId);

          Swal.fire(
            '¡Aprobada!',
            'La Nota a sido publicada',
            'success'
          ).then((result) => {
            window.location.reload();
          })

        }
      })
    }
  </script>

  <!-- SCRIPTS ABC SECCIONES -->
  <script>
    function VentanaBajaSeccion(id_section) {
      var section = $("#seccion_" + id_section);

      Swal.fire({
        title: '¿Estas segur@ de eliminar la sección "' + section.html() + '"?',
        text: "Este proceso puede revertirse en el futuro",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminarla!'
      }).then((result) => {
        if (result.isConfirmed) {
          if (modSectionStatus(id_section, 'E')) {
            Swal.fire(
              '¡Eliminada!',
              'La seccion a sido eliminada',
              'success'
            )
          }
          //TODO
          // else {
          //   Swal.fire(
          //     'Ha ocurrido un problema',
          //     'No se ha sido posible eliminar la sección',
          //     'error'
          //   )
          // }
        }
      })
    }

    function VentanaReactivarSeccion(id_section) {
      var section = $("#seccion_" + id_section);

      Swal.fire({
        title: '¿Estas segur@ de reactivar la sección "' + section.html() + '"?',
        text: "Todas sus noticias volveran a aparecer en el portal",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reactivala!'
      }).then((result) => {
        if (result.isConfirmed) {
          if (modSectionStatus(id_section, 'H')) {
            Swal.fire(
              '¡Eliminada!',
              'La seccion a sido reactivada',
              'success'
            )
          }
          //TODO
          // else {
          //   Swal.fire(
          //     'Ha ocurrido un problema',
          //     'No se ha sido posible reactivar la sección',
          //     'error'
          //   )
          // }
        }
      })
    }

    function VentanaModNameSeccion(id_section) {
      var section = $("#seccion_" + id_section);

      Swal.fire({
        title: 'Editar nombre de sección',
        input: 'text',
        inputValue: section.html(),
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Editar',
        inputValidator: (value) => {
          if (!value) {
            return '¡Escribe un nombre valido!';
          }
          var lenght = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
          if (!lenght.test(value)) {
            return '¡Solo utiliza letras!';
          }
        }
      }).then((result) => {
        if (result.isConfirmed) {
          if (updateSectionName(id_section, section.html())) {
            //TODO
            Swal.fire(
              '¡Listo!',
              'Se ha cambiado el nombre de la categoria',
              'success'
            )
          } else {
            inputValidator: 'Nombre ocupado por otra seccion';
          }
        }
      })
    }

    function VentanaModAttrSeccion() {
      let section = $("#cbSection option:selected");
      Swal.fire({
        title: '¿Desea actualizar la categoria "' + section.html() + '"?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, guardar los cambios'
      }).then((result) => {
        if (result.isConfirmed) {
          if (updateSectionAttr(section.val())) {
            Swal.fire(
              '¡Listo!',
              'La categoria se ha actualizado',
              'success'
            )
          }
        }
      })
    }

    function VentanaAltaSeccion() {
      let newSection = $('#SeccionAlta').val();
      if (newSection == "")
        newSection = "Seccion nueva";
      if (validarSECCIONALTA()) {
        if (insertSection(newSection)) {
          Swal.fire(
            '¡Seccion añadida!',
            newSection,
            'success'
          )
        }
      }
    }
  </script>


  <!-- SCRIPTS ABC REPORTEROS -->
  <script>
    function VentanaBajaReportero(id_journalist) {
      var journalist = $("#reportero_" + id_journalist);
      Swal.fire({
        title: '¿Estas segur@ de quitar el rol de reportero al usuario ' + journalist.html() + '?',
        text: "¡Este proceso no se revertira!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Quitar rol!'
      }).then((result) => {
        if (result.isConfirmed) {
          setToRegisteredUser(id_journalist);
          Swal.fire(
            '¡Eliminado!',
            'Se le a quitado el rol a este Usuario',
            'success'
          )
        }
      })
    }

    function VentanaAltaReportero() {
      var valor = $("#cbJournalist option:selected");
      Swal.fire({
        title: '¿Estas segur@ de añadir el rol de reportero al usuario ' + valor.text() + '?',
        text: "¡Este proceso no se revertira!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Darle el rol!'
      }).then((result) => {
        if (result.isConfirmed) {
          setToJournalist();
          Swal.fire(
            '¡Nuevo reporter@!',
            'Se le ha asignado el rol a este usuario',
            'success'
          )
        }
      })
    }
  </script>

  <!-- SCRIPTS EDICIÓN PERFIL -->
  <script>
    function VentanaModPerfil() {
      if (validarFormularioUsuario()) {
        Swal.fire({
          title: '¿Quieres guardar los cambios a tu perfil?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, guardar los cambios'
        }).then((result) => {
          if (result.isConfirmed) {
            if (updateProfile()) {
              Swal.fire(
                '¡Listo!',
                'Tu perfil se ha actualizado',
                'success'
              )
            }
          }
        })
      }
    }
  </script>

  <!-- SCRIPTS COLORPICKER -->
  <script type="text/javascript">
    $(document).ready(function($) {
      $('#color-picker').spectrum({
        type: "component",
        togglePaletteOnly: true,
        hideAfterPaletteSelect: true
      });
    });
  </script>

  <script>
    $("#picker").spectrum({
      color: tinycolor,
      type: "string", // text, component, color, flat
      showInput: "bool",
      showInitial: "bool",
      allowEmpty: "bool",
      showAlpha: "bool",
      disabled: "bool",
      localStorageKey: "string",
      showPalette: "bool",
      showPaletteOnly: "bool",
      togglePaletteOnly: "bool",
      showSelectionPalette: "bool",
      clickoutFiresChange: "bool",
      containerClassName: "string",
      replacerClassName: "string",
      preferredFormat: "string",
      maxSelectionSize: "int",
      palette: [
        ["string"]
      ],
      selectionPalette: ["string"],
      // specify locale
      locale: "string",
      // or directly change the translations
      cancelText: "string",
      chooseText: "string",
      togglePaletteMoreText: "string",
      togglePaletteLessText: "string",
      clearText: "string",
      noColorSelectedText: "string",
    });
  </script>

</body>

</html>