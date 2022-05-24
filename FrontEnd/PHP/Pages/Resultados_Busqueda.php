<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Good Old Times - Busqueda</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/album-rtl/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">


  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>
  
  <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>

  <link rel="shortcut icon" href="../../Elementos/Good Old Times-ICON.2.png" type="image/x-icon">
  <link href="../../bootstrap-5.1.3-examples/assets/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    #Masvistas {
      margin-left: 2%;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .separacion{
      margin-top:3%;
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../../CSS/Inicio.css" rel="stylesheet">
</head>

<body>

  <?php include '../templates/header_navbar.php'; ?>


  <main class="container">

  <p class="separacion" > </p>
  <?php if(count($news) == 0): ?>
    <h1 class="text-center">No se han encontrado resultados</h1>
  <?php elseif(count($news) > 0): ?>
    <div class="album py-5 bg-light" >
        <div class="container" >
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="recent_news">
            <?php foreach($news as $new): ?>
                <div class="col">
                  <div class="card shadow-sm">

                    <img src="<?php echo $new["THUMBNAIL"] ?>" class="imagen" alt="imagen" width="100%" height="225">


                    <div class="card-body">
                      <strong class="d-inline-block mb-2 text-primary">World</strong>

                      <p class="card-text text-black"><?php echo $new["HEADER"]?></p>
                      <p class="text"><?php echo $new["REPORT_DESCRIPTION"] ?></p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                        <a href="../Pages/Pagina_noticia.php?reportId=<?php echo $new['REPORT_NUMBER'] ?>" class="btn btn-sm btn-outline-secondary">Continuar leyendo</a>
                        </div>
                        <small class="text-muted"><?php echo $new["EVENT_DATE"] ?></small>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach?>
          </div>

        </div>  
    </div> 
  <?php endif?>
     
    
     
      
  </main>

  <footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
    </p>
  </footer>

  <script src="../../JS/bootstrap.bundle.min.js"></script>


</body>