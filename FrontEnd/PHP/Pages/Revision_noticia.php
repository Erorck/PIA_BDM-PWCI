<!doctype html>
<html lang="en">

<?php
session_start();
$isSelected = false;
if (isset($_SESSION['c_report']))
  $isSelected = true;
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Good Old Times - Revision Noticia</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <link href="../../bootstrap-5.1.3-examples/offcanvas-navbar/offcanvas.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>

  <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">
  <link href="../../bootstrap-5.1.3-examples/assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../CSS/Estilo_Revision_Noticia.css" rel="stylesheet">

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/offcanvas-navbar/">

  <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>

  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../../CSS/Inicio.css" rel="stylesheet">
</head>

<body>

  <?php include "../templates/header_navbar.php" ?>

  <main class="container">
    <h6 class=" Titulo_pagina text-dark">REVISIÓN DE NOTICIA</h6>
    <div class="imagen_portada p-2 mb-3 bg-light rounded-3">
      <img id="rBanner" src=<?php if (isset($_SESSION['c_report'])) {
       echo $_SESSION['c_report'][0]['THUMBNAIL'];
      } else echo '../../Elementos/NP.jpg'; ?> class="img-fluid img-thumbnail mx-auto d-block" alt="">
    </div>
    <div class="row g-5">
      <div class="col-md-8">
        <article class="blog-post">
          <h2 id="rHeader" class="blog-post-title"><?php if ($isSelected) {echo $_SESSION['c_report'][0]['HEADER'];} else echo 'Orgullo Mexicano'; ?></h2>
          <div id="rCtgs" class="meta-data d-flex blog-post-meta" styl>
            <div class="mr-3" style="margin-right:15px">Historia </div>
            <div class="mr-3" style="margin-right:15px">Internacional </div>
            <div class="mr-3" style="margin-right:15px">Farandula </div>
          </div>

          <div id="rTags" class="meta-data d-flex blog-post-meta">
            <div class="mr-3" style="margin-right:15px">#Historia </div>
            <div class="mr-3" style="margin-right:15px">#Internacional </div>
            <div class="mr-3" style="margin-right:15px">#Farandula </div>
          </div>
          <br>
          <p id="rEventDate" class="meta-data blog-post-meta"> <?php if ($isSelected) {
           echo 'Fecha de suceso: ' . $_SESSION['c_report'][0]['EVENT_DATE'] . ' en';
           } else echo '27 de Febrero del 2022 9:30.P.M'; ?></p>
          <p id="rEventLocation" class="meta-data blog-post-meta"><?php if ($isSelected) {
            echo 'Colonia ' . $_SESSION['c_report'][0]['EVENT_NEIGHBOURHOOD'] . ', ' . $_SESSION['c_report'][0]['EVENT_STREET'] . ', ' . $_SESSION['c_report'][0]['EVENT_CITY'] . ', ' . $_SESSION['c_report'][0]['EVENT_COUNTRY']; } else echo 'Texcoco #89, Yucatán. México'; ?> </p>


          <p id="rDescription"> <?php if ($isSelected) {
             echo $_SESSION['c_report'][0]['REPORT_DESCRIPTION'];
             } else echo 'Joven Mexicano gana beca para estudiar en la NASA ciencia aeroespacial y astrofisica'; ?> </p>
          <hr>
          <p>
            <?php
            if ($isSelected) {
              echo $_SESSION['c_report'][0]['CONTENT'];
            } else echo " I just made something unexpected
              Something sharp
              Something new
              It's not symmetrical or perfect
              But it's beautiful
              And it's mine
              What else can I do?
  
              Bring it in, bring it in
              (Good talk!) Bring it in, bring it in
              What else can I do?
              (Let's walk!) Bring it in, bring it in
              (Free hugs!) Bring it in, bring it in
  
              I grow rows and rows of roses
              Flor de mayo by the mile
              I make perfect, practised poses
              So much hides behind my smile
              "; ?>

          </p>
          <h2><?php if ($isSelected) {
                echo $_SESSION['c_report'][0]['REPORT_DESCRIPTION'];
              } else echo 'Orgullo Mexicano'; ?></h2>
          <div id="rImages" class="d-flex flex-row flex-wrap justify-content-around">
            <img src="../../Elementos/NASA.jpg" class="img-fluid img-thumbnail mx-auto d-block" alt="">
          </div>
          <br>
          <div id="rVideos" class="d-flex flex-row flex-wrap justify-content-around">
          </div>

          
        </article>
      </div>

      <div class="col-md-4">
        <div class="position-relevate" style="top: 2rem;">
          <div class="p-4 mb-3 bg-light rounded">
            <h4 id="rAutorSign" class="fst-italic"><?php if ($isSelected) { echo $_SESSION['c_report'][0]['CREATED_BY_NAME']; } else echo 'Autor de la Noticia'; ?></h4> <div id="rPubDate" class="Info_nota blog-post-meta meta-data"> <?php if ($isSelected) {
              echo 'Publicada a fecha: ' . $_SESSION['c_report'][0]['PUBLICATION_DATE'] . ' por'; } else echo '28 de Febrero del 2022 8:40.P.M por'; ?> <p id="rAutorUser"><?php if ($isSelected) {echo '@' . $_SESSION['c_report'][0]['AUTOR_SIGN'];
               } else echo '@Autor'; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

  <!--  COMENTARIOS NOTICIA  -->
  <hr class="my-4">
  <?php if ($isSelected && $_SESSION['permission']=='E') {?>
    <button class=" boton_final w-100 btn btn-outline-success btn-lg " onclick="VentanaAprobarNoticia(<?php if ($isSelected) {echo $_SESSION['c_report'][0]['REPORT_NUMBER'];}?>)" type="button">APROBAR NOTICIA</button>
    <br>
  <?php } ?>

  <?php if ($isSelected && $_SESSION['permission']=='R' && $_SESSION['c_report'][0]['REPORT_STATUS'] == 'RR') {?>
    <br>
    <a class=" boton_final w-100 btn btn-outline-info btn-lg " href=<?php if ($isSelected) {
              echo 'Editar_Noticia.php?'.$_SESSION['c_report'][0]['HEADER']; }?> id="btn_to_edit">EDITAR NOTICIA</a>
    <br>
  <?php } ?>

  <br>

  <?php if ($isSelected && $_SESSION['permission']=='E') {?>
  
    <main class="container">
      <div class="my-3 p-3 bg-dark rounded shadow-sm">
        <h6 class="text-light border-bottom pb-2 mb-0">Comentario para Reportero</h6>
        <small class="d-block text-end mt-3">
          <input type="text" class="form-control" name="coment" id="commentE" placeholder="Sin comentario"></input>
        </small>
      </div>
    </main>

    <button class=" boton_final w-100 btn btn-outline-danger btn-lg "  onclick="VentanaRechazarNoticia(<?php if ($isSelected) {echo $_SESSION['c_report'][0]['REPORT_NUMBER'].', '. $_SESSION['user']['ID_USER'];}?>)" type="button">DEVOLVER NOTICIA CON COMENTARIO</button>
  <?php } ?>


  <?php if ($isSelected && $_SESSION['permission']=='R' && $_SESSION['c_report'][0]['REPORT_STATUS'] == 'RR') {?>
  
    <main class="container">
      <div class="my-3 p-3 bg-dark rounded shadow-sm">
        <h6 class="text-light border-bottom pb-2 mb-0">Comentario de Editor</h6>
        <small class="d-block text-end mt-3">
          <input type="text" class="form-control" name="coment" id="commentFJ" placeholder="Sin comentarios" disabled="true"></input>
        </small>
      </div>
    </main>

        <button onclick="VentanaEnviarNoticia(<?php if ($isSelected) {echo $_SESSION['c_report'][0]['REPORT_NUMBER'];}?>)" class=" boton_final w-100 btn btn-outline-warning btn-lg " type="button">ENVIAR PARA REVISIÓN</button>
  <?php } ?>


  <footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
    </p>
  </footer>

  <script src="../../JS/bootstrap.bundle.min.js"></script>
  <script src="../../JS/Validacion_Revision_Noticia.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
      function VentanaEnviarNoticia(reportId) {

        Swal.fire({
          title: '¿Estas segur@ de enviar la Nota a revisión?',
          text: "¡No se podrá eliminar o editar hasta haber sido devuelta por un editor!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, ¡Enviarla!'
        }).then((result) => {
          if (result.isConfirmed) {
            sendReportToEditor(reportId);
          
            Swal.fire(
              '¡En revisión!',
              'La Nota a sido enviada al editor',
              'success'
              ).then((result) => {
                getReport(reportId);
              })
              
          }
        })
      }

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

      function VentanaRechazarNoticia(reportId, editorId) {
        let comment = $("#commentE").val();
        if(validarFormularioUsuario()){
          Swal.fire({
            title: '¿Devolver nota con este comentario?',
            text: "\"" +  comment + "\"",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, ¡Enviarla!'
          }).then((result) => {
            if (result.isConfirmed) {
              sendBackToJournalist(reportId);
              sendEditorComment(comment, reportId);
              console.log('Paso');
              Swal.fire(
                '¡Listo!',
                'La Nota ha sido devuelta al reportero',
                'success'
                ).then((result) => {
                  window.location.replace("Perfil_Editor.php");
                })
                
            }
          })
          }
        }



  </script>

</body>

</html>