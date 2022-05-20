<!doctype html>
<html lang="en">

<?php
  session_start();
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Good Old Times - Creacion de Noticia</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/checkout/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dropdowns/">

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>


  <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">
  <link href="../../CSS/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link href="../../CSS/Estilo_Crear_Noticia.css" rel="stylesheet">


  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../../CSS/Inicio.css" rel="stylesheet">
  <link href="../../CSS/form-validation.css" rel="stylesheet">
  <link href="../../CSS/dropdowns.css" rel="stylesheet">

  <script type="text/javascript" src="../../JS/Script_Crear_Noticia.js"></script>


</head>

<body>

  <?php include "../templates/header_navbar.php" ?>

  <div class="container">

    <main>
      <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="../../Elementos/Good Old Times-ICON.2.png" alt="" width="80" height="80">
        <h2>Creación de la noticia</h2>
      </div>
      <form action="#" id="crearNoticia">
        <div class="contenido">
          <div class="row g-5">
            <div class="col-md-7 col-lg-8">
              <div class="contenido_text">
                <h4 class="mb-3">Datos de la noticia</h4>
                <div class="row g-3">
                  <div class="col-12">
                    <label for="text" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" placeholder="Erase una vez...">
                  </div>

                  <div class="col-12">
                    <label for="text" class="form-label">Firma autor</label>
                    <input type="text" class="form-control" id="firma" placeholder="@Reportero" value=<?php if (isset($_SESSION['user']) && $_SESSION['user']['USER_ALIAS'] != null) echo $_SESSION['user']['USER_ALIAS']?>>
                  </div>

                  <div class="col-12">
                    <label for="text" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descrip" placeholder="El acontecimiento sucedio...">
                  </div>

                  <div class="col-12">
                    <label for="text" class="form-label">Desarrollo de la noticia</label>
                    <textarea type="text" class="form-control" id="Texto" placeholder="Esta nota acontece..."> </textarea>
                  </div>


                  <div class="col-12">
                    <label for="address" class="form-label">Calle</label>
                    <input type="text" class="form-control" id="address" placeholder="Av. Siempre viva 201">
                  </div>

                  <div class="col-12">
                    <label for="address" class="form-label">Colonia</label>
                    <input type="text" class="form-control" id="address2" placeholder="Main St">
                  </div>

                  <div class="col-12">
                    <label for="address2" class="form-label">Ciudad </label>
                    <input type="text" class="form-control" id="address3" placeholder="Nuevo León">
                  </div>

                  <div class="col-md-5">
                    <label for="country" class="form-label">País</label>
                    <select class="form-select" id="country">
                      <option value="N">Elige...</option>
                      <option value="México">México</option>
                      <option value="EE.UU">EE.UU</option>
                      <option value="Canadá">Canadá</option>
                      <option value="Brasil">Brasil</option>
                    </select>
                  </div>


                  <div class="col-md-5" id="section_list_rad">
                    <label for="country" class="form-label">Secciones</label>

                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="same-address">
                      <label class="form-check-label" for="same-address">Ultima Hora</label>
                    </div>

                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="save-info">
                      <label class="form-check-label" for="save-info">Intrigante</label>
                    </div>

                  </div>

                  <div class=" contenido_multi col-md-5 col-lg-9 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                      <span class="text-black">Contenido multimedia de la nota</span>
                    </h4>
                    <ul class="list-group mb-3">

                      <!-- PORTADA  -->
                      <li class="list-group-item d-flex justify-content-between lh-sm mb-3">
                        <div>
                          <h6 class="Texto_Foto my-0 mb-1">Portada de Nota</h6>
                          <img alt="Portada Pic" id="banner_pic" class="fotoCurso mb-2" style="width:auto; height: 150px;">
                          <input id="upload_banner_pic" type="file" name="Fotografia" placeholder="Portada" class="input-foto mb-1" required>
                          <input id="examplePPic" name="pPic" value=<?php //if ($hasPPicture) echo $imageP 
                                                                    ?>>
                        </div>
                      </li>

                      <!-- IMAGENES EXTRA  -->
                      <li class="list-group-item d-flex justify-content-between lh-sm mb-3">
                        <div>
                          <h6 class="my-0 mb-1">Imagenes extra</h6>

                          <div class="extra_img_list">
                            
                            <!-- <div class="extra_img_container d-flex justify-content-center align-items-center">
                              <img src="../../Elementos/Chavis.jpg" alt="Media Cont" id="FotografiadeCurso" class=" fotoCurso bottom top mb-2" >
                              <img src="../../Elementos/1200px-Flat_cross_icon.svg.png" class="fotoCurso delete-icon align-middle mb-2">
                            </div>

                            <div>
                              <img alt="Media Cont" id="FotografiadeCurso" class="fotoCurso top mb-2" style="width:auto;">
                            </div> -->
                          </div>
                          <div id="extra_img_array"> </div>
                          <input id="upload_extra_pic" type="file" name="Fotografia" placeholder="Contenido multimedia" class="input-foto mb-1" >
                          <input id="exampleEPic" name="ePic">
                        </div>
                      </li>

                      <!-- VIDEOS EXTRA  -->
                      <li class="list-group-item d-flex justify-content-between lh-sm mb-3">
                        <div>
                          <h6 class="my-0 mb-1">Videos extra</h6>

                          <div class="extra_vid_list">
                            <!-- <video class="mb-2" width="220" height="140" controls>
                              <source src="movie.mp4" type="video/mp4">
                              <source src="movie.ogg" type="video/ogg">
                              Your browser does not support the video tag.
                            </video> -->
                          </div>

                          <div id="extra_vid_array"></div>
                          <input id="upload_extra_vid" type="file" name="Fotografia" placeholder="Contenido multimedia" class="input-foto mb-1" >
                          <input id="exampleEVid" name="eVid">
                        </div>
                      </li>

                    </ul>
                  </div>
                </div>

                <hr class="my-4">
                <h4 class="mb-3">Palabras clave</h4>

                <div id="tag_list_rad">

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="same-address">
                    <label class="form-check-label" for="same-address">Ultima Hora</label>
                  </div>

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="save-info">
                    <label class="form-check-label" for="save-info">Intrigante</label>
                  </div>

                </div>
                <hr class="my-4">

                <div class="row gy-3">
                  <div class="col-md-6">
                    <label for="cc-name" class="form-label">Fecha de acontecimiento</label>
                    <input class=" calendario form-control" type="datetime-local" id="Fecha" placeholder="Selecciona la fecha del suceso">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-4">
        <button id="upload_report" class=" boton_final w-100 btn btn-outline-success btn-lg" type="button" >CREAR NOTICIA</button>
      </form>

    </main>
  </div>


  <footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
    </p>
  </footer>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../JS/bootstrap.bundle.min.js"></script>

  <!--flatpickr-->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="../../JS/Validacion_CrearNoticia.js"></script>


  <script>
    config = {
      enableTime: true,
      dateFormat: "Y-m-d H:i",
      altImput: true,
      altFormat: "F j, Y (h:5 K)"
    }

    flatpickr("input[type=datetime-local]", config);
  </script>

  <script>
    function VentanaBajaImagen(container_id) {

      console.log(container_id);

      Swal.fire({
        title: '¿Estas segur@ de quitar la imagen #' + container_id + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminarla!'
      }).then((result) => {
        if (result.isConfirmed) {
          $('.' + container_id).remove();
        }
      })
    }
  </script>
</body>

</html>