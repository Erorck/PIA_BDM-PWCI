<?php
  include "../classes/Consult/consult-contr.classes.php";
  include "../classes/News_Comments/news_comts-contr.classes.php";
  include "../classes/Reactions/reactions-contr.classes.php";

  $consult = new ConsultsControler();

  $newsDetails = $consult->getReportById($_GET['reportId']);
  
  $sections= $consult->getReportCtgs($_GET['reportId']);

  $videos= $consult->getReportVideos($_GET['reportId']);
  if($videos == 0)
    $videos = array();

  $images = $consult->getReportImages($_GET["reportId"]);
  if($images == 0)
    $images = array();

  $commentsConsult = new News_CommentsContr();
  $comments = $commentsConsult->getCommentsByReportId(($_GET['reportId']));

  $reaction = ReactionsContr::withId($_SESSION['user']['ID_USER'], $_GET["reportId"], 0);;
  
  if(!isset($_SESSION['user']))
    session_start();


  $reactionData = $reaction->getReaction();
  $hasReacted = false;

  if($reactionData != 0){
    $hasReacted = true;
  }
  
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

    <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>

    <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">
    <link href="../../bootstrap-5.1.3-examples/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <

    
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../CSS/Inicio.css" rel="stylesheet">
    <link href="../../CSS/Estilo_Pagina_Noticia.css" rel="stylesheet">
  </head>
  <body>
  
  <?php include '../templates/header_navbar.php'; ?>


<main class="container">
  
    <div class="imagen_portada p-2 mb-3 bg-light rounded-3">
          <img src="<?php echo $newsDetails[0]["THUMBNAIL"] ?>" class="img-fluid img-thumbnail mx-auto d-block" alt="">
      </div>

    

      <div class="row g-5">
        <div class="col-md-8">
          <article class="blog-post">
            <input type="text" id="reportTemp" value="<?php echo $_GET["reportId"] ?>" hidden="true">
            <h2 class="blog-post-title"><?php echo $newsDetails[0]["HEADER"]?></h2>
            <div id="rCtgs" class="meta-data d-flex blog-post-meta" styl>
              <?php foreach($sections as $section): ?>
                <div class="mr-3" style=" text-decoration: underline; text-decoration-thickness:3px; text-decoration-color: <?php echo $section["COLOR"]?> ; margin-right:15px "> <?php echo $section["CATEGORY_NAME"] ?> </div>
              <?php endforeach?>
            </div>
            <p class="Fecha de suceso blog-post-meta"><?php echo $newsDetails[0]["EVENT_DATE"] ?></p>
            <p class="Lugar se suceso blog-post-meta"><?php echo 'Colonia ' . $newsDetails[0]['EVENT_NEIGHBOURHOOD'] . ', ' . $newsDetails[0]['EVENT_STREET'] . ', ' . $newsDetails[0]['EVENT_CITY'] . ', ' . $newsDetails[0]['EVENT_COUNTRY'];  ?></p>

    
            <p><?php echo $newsDetails[0]["REPORT_DESCRIPTION"] ?></p>
            <hr>
            <p><?php echo $newsDetails[0]["CONTENT"] ?> </p>                
            <h2><?php echo  $newsDetails[0]["REPORT_DESCRIPTION"] ?></h2>
            <div id="rImages" class="d-flex flex-row justify-content-around">
              <?php foreach($images as $image): ?>
                <img src="<?php echo $image['CONTENT'] ?> " class="img-fluid img-thumbnail mx-auto" alt="" style="height:180px;">
              <?php endforeach?>
            </div>
            <div id="rVideos" class="d-flex flex-row justify-content-around"> 
              <?php foreach($videos as $video): ?>
                <div class="extra_vid_container d-flex justify-content-start"> 
                  <video class="mb-2" width="290" height="170" controls><source src="<?php echo $video['CONTENT'] ?> " type="video/mp4"> Your browser does not support the video tag.</video>  
                </div>
              <?php endforeach?>
            </div>

            </article>
        </div>


    
        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem;">
            <div class="p-4 mb-3 bg-light rounded">
              <h4 class="fst-italic">Autor de la Noticia</h4>
              <p class="Info_nota blog-post-meta"><?php echo $newsDetails[0]['PUBLICATION_DATE'] ?> por <a href="#"><?php echo $newsDetails[0]['CREATED_BY_NAME'] ?></a></p>
              <p class="Cant_likes blog-post-meta">Likes de la noticia: <a id="like_counter" class="text-dark" href="#">
                <?php echo $newsDetails[0]["LIKES"] ?></a></p>
                
              <?php if(isset($_SESSION['user'])): ?>   

                <button class="button_like" 
                value=<?php if($hasReacted && $reactionData[0]['LIKED']== 1) echo 'true'; else echo 'false'; ?>
                id="btn_like" 
                onclick="reaction(<?php echo intval($_GET['reportId']).','. $newsDetails[0]['LIKES']?>)">
                

                <i class="far fa-thumbs-up"></i> 
                <?php if($hasReacted && $reactionData[0]['LIKED']== 1) echo 'Quitar like'; else echo 'Dar like ' ; ?>

                </button>
              <?php else: ?>   
                <button class="button_like" id="btn_nlike">                
                <i class="far fa-thumbs-up"></i> Dar like 
                </button>       
              <?php endif?>
              
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
 <div class="my-3 p-3 bg-dark rounded shadow-sm">
  <h6 class="border-bottom pb-2 mb-0 text-light">Comentarios de la Noticia </h6>
  <div id="rComments">
    <?php if(count($comments) == 0): ?>
      <h6 class="border-bottom pb-2 mb-0 mt-1 text-light text-center">No hay comentarios</h6>
      
    <?php endif?>
      <?php foreach($comments as $comment): ?>
        <div id="comment_<?php echo $comment["COMMENT_ID"] ?>" class="d-flex text-muted pt-3">
          <div id="comment_<?php echo $comment["COMMENT_ID"] ?>T" class="d-flex w-100">
            <?php if($comment["PROFILE_PICTURE"] == ""): ?>
              <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
            <?php else: ?>          
              <img src="<?php echo $comment["PROFILE_PICTURE"] ?>" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" >
            <?php endif?>      
            <p class="pb-3 mb-0 small lh-sm border-bottom w-100">
              <strong class="d-block text-gray-dark">@<?php echo $comment["USER_ALIAS"] ?></strong>
              <?php echo $comment["COMMENT_TEXT"] ?>
              <strong class="d-block small text-gray-dark">  <?php echo $comment["CREATION_DATE"] ?>  </strong>
            </p>
          </div>
          <?php if($_SESSION['user']['USER_TYPE'] == "E"): ?>
            <a href="javascript:VentanaBajaComentario(<?php echo $comment["COMMENT_ID"].','.$_GET['reportId'] ?>)" class="text-danger"><i class="fas fa-trash-alt"></i></a>
          <?php endif?>
        </div>
        
      <?php endforeach?>
  </div>
  </div>
  <?php if(isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE']!= 'E'): ?>    

    <div class="my-3 p-3 bg-dark rounded shadow-sm">
      <h6 class="text-light border-bottom pb-3 mb-0">Comentario para la noticia</h6>
      <small class="d-block text-end mt-3">
        <?php if(isset($_SESSION['user'])): ?>    
          <a class="btn btn-success mb-3" onclick="sendComment(<?php echo $_GET['reportId'].',\''.$_SESSION['user']['USER_TYPE'].'\''?>)">Enviar Comentario</a>
        <?php else: ?>          
          <a class="btn btn-success mb-3" href="Login.php" >Enviar Comentario</a>
        <?php endif?>
        <input type="text" class="form-control" name="coment" id="commentInput"></input>
      </small>
    </div>
  <?php endif?>


</main>

<footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
  </p>
</footer>

<script src="../../JS/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../../JS/Script_Pagina_Noticia.js"></script>

<script>

 function VentanaBajaComentario(id_comment, reportId) {
      var comment = $("#comment_" + id_comment +"T");
      var commentTemp = '<div class="bg-dark text-light rounded shadow-sm w-100">';
      
      commentTemp = commentTemp.concat(comment.html());
      commentTemp = commentTemp.concat('</div>');

      Swal.fire({
        title: commentTemp,
        text: "Desea borrar este comentario ¡Este proceso no se revertira!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminar comentario!'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteComment(reportId, id_comment);
          Swal.fire(
            '¡Eliminado!',
            'Se ha eliminado el comentario',
            'success'
          )
        }
      })
    }

</script>

  </body>

</html>
