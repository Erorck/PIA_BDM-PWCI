<?php
  include "../classes/Consult/consult-contr.classes.php";

  $consult = new ConsultsControler();

  $newsDetails = $consult->getReportById($_GET['reportId']);
  if($newsDetails == 0){
    // TODO: redirect to error page
  }


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Good Old Times - Noticia</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/jumbotron/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/offcanvas-navbar/">


  
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      .imagen_portada{
          margin-top: 3%;
      }
      .Cant_likes{
          text-decoration:underline;
      }
      .button_like{
          color: rgb(42, 112, 173);
          border-radius: 30px;
          background-color: rgb(227, 216, 247);
      }
      .Rel_notice{
          color: black;
      }
      .blog-footer{
          margin-top: 5%;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../CSS/Inicio.css" rel="stylesheet">
  </head>
  <body>
  
  <?php include '../templates/header_navbar.php'; ?>


<main class="container py-4">
  
    <div class="imagen_portada p-2 mb-3 bg-light rounded-3">
          <img src="<?php echo $newsDetails[0]["THUMBNAIL"] ?>" class="img-fluid img-thumbnail mx-auto d-block" alt="">
      </div>

    

      <div class="row g-5">
        <div class="col-md-8">
          <article class="blog-post">
            <h2 class="blog-post-title"><?php echo $newsDetails[0]["HEADER"] ?></h2>
            <p class="Fecha de suceso blog-post-meta"><?php echo $newsDetails[0]["EVENT_DATE"] ?></p>
            <p class="Lugar se suceso blog-post-meta"><?php echo 'Colonia ' . $newsDetails[0]['EVENT_NEIGHBOURHOOD'] . ', ' . $newsDetails[0]['EVENT_STREET'] . ', ' . $newsDetails[0]['EVENT_CITY'] . ', ' . $newsDetails[0]['EVENT_COUNTRY'];  ?></p>

    
            <p><?php echo $newsDetails[0]["REPORT_DESCRIPTION"] ?></p>
            <hr>
            <p><?php echo $newsDetails[0]["CONTENT"] ?> </p>                
            <h2><?php echo  $newsDetails[0]["REPORT_DESCRIPTION"] ?></h2>
            <img src="../Elementos/NASA.jpg" class="img-fluid img-thumbnail mx-auto d-block" alt="">

        
            </article>
        </div>


    
        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem;">
            <div class="p-4 mb-3 bg-light rounded">
              <h4 class="fst-italic">Autor de la Noticia</h4>
              <p class="Info_nota blog-post-meta"><?php echo $newsDetails[0]['PUBLICATION_DATE'] ?> por <a href="#"><?php echo $newsDetails[0]['CREATED_BY_NAME'] ?></a></p>
              <p class="Cant_likes blog-post-meta">Likes de la noticia: <a class="text-dark" href="#"><?php echo $newsDetails[0]["LIKES"] ?></a></p>
              <button class="button_like"><i class="far fa-thumbs-up"></i> Dar like</button>
            </div>

            <div class="Rel_notice p-4">
                <h4 class="fst-italic">Noticias relacionadas</h4>
                <ol class="list-unstyled mb-0">
                  <li><a class="text-dark" href="#">Chavis rompe en llanto</a></li>
                  <li><a class="text-dark" href="#">Konan Bieber ¡VOLVIO!</a></li>
                  <li><a class="text-dark" href="#">Detienen a Altonio</a></li>
                  <li><a class="text-dark" href="#">¡AMLO RULES IN THE AREA!</a></li>
                </ol>
              </div>
      
          </div>
        </div>
      </div>

</main>

 <!--  COMENTARIOS NOTICIA  -->
 <main class="container">
 <div class="my-3 p-3 bg-body rounded shadow-sm">
  <h6 class="border-bottom pb-2 mb-0 text-light">Comentarios de la Noticia </h6>
  <div class="d-flex text-muted pt-3">
    <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>

    <p class="pb-3 mb-0 small lh-sm border-bottom">
      <strong class="d-block text-gray-dark">@usernameX</strong>
      "Supe cool la noticia, excelente redaccion y un orgullo mexicano el muchachito"
    </p>
  </div>
  <div class="d-flex text-muted pt-3">
    <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e83e8c"/><text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text></svg>

    <p class="pb-3 mb-0 small lh-sm border-bottom">
      <strong class="d-block text-gray-dark">@usernameX</strong>
      "No pues en hora buena por este país, ya hacia falta joveazos asi eda"
    </p>
  </div>
  <div class="d-flex text-muted pt-3">
    <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#6f42c1"/><text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text></svg>

    <p class="pb-3 mb-0 small lh-sm border-bottom">
      <strong class="d-block text-gray-dark">@usernameX</strong>
       "Ay ese muchachito me recuerda a otro joven que se dedica a la industria de la cinematografia dirigida a publico mayor, no recuerdo como se llama. Pero en hora buena por el muchacho"
    </p>
  </div>
</div>
<div class="my-3 p-3 bg-body rounded shadow-sm">
  <h6 class="text-light border-bottom pb-2 mb-0">Comentario para la noticia</h6>
  <small class="d-block text-end mt-3">
    <a class="text-light" href="#">Enviar Comentario</a>
    <input type="text" class="form-control" name="coment"></input>
  </small>
</div>
</main>

<footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
  </p>
</footer>

<script src="../JS/bootstrap.bundle.min.js"></script>

    
  </body>

</html>
