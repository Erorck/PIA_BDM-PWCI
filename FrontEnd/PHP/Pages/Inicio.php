<?php 
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Good Old Times - Inicio</title>

  <script type="text/javascript" src="../../JS/JQuery3.3.1.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/blog/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/album-rtl/">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">


  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/89688bb0b5.js" crossorigin="anonymous"></script>

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
  </style>


  <!-- Custom styles for this template -->
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="../../CSS/Inicio.css" rel="stylesheet">
</head>

<body>

  <!--<div class="container">-->
  <!-- <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      
      <div class="col-4 text-center">
        <a class="blog-header-logo" href="#"><img src="/Elementos/Good Old Times_LOGO2.2.png" class="logo" alt="logo" width="200px" height="80px"></a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
          <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
          <a class="link-secondary" href="#" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg> 
        </a>
        <a class="btn btn-sm btn-outline-secondary" href="#"> Iniciar Sesion</a>
      </div>
    </div>
  </header> -->


  <?php include '../templates/header_navbar.php'; ?>

  <main class="container">
    <br>
    <br>
    <div class="py-3 p-md-2 mb-1 text-black rounded bg-dark">
      <div class="primicia">
        <div class="col-md-6 px-0">
          <h1 class="display-4 fst-italic">Orgullo Mexicano</h1>
          <p class="lead my-3 text-black">Joven Mexicano gana beca para estudiar en la NASA ciencia aeroespacial y astrofisica</p>
          <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continuar leyendo...</a></p>
        </div>
      </div>
    </div>
    <br>
    <br>
    <h3 class="row mb-2" id="Masvistas">NOTICIAS MAS VISTAS</h3>

    <div class="row mb-2">
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">World</strong>
            <h3 class="mb-0">Konan Bieber</h3>
            <div class="mb-1 text-muted">Nov 12</div>
            <p class="card-text mb-auto">Nuevo cambio de look que tiene el conductor de es show en este nuevo año...</p>
            <a href="#" class="stretched-link">Continuar leyendo</a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <!-- <a class="blog-header-logo" href="#"><img src="/Elementos/Good Old Times_LOGO2.2.png" class="logo" alt="logo"></a> -->

            <img src="../../Elementos/konan.jpg" class="imagen" alt="imagen" width="300px" height="300px">

          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success">Design</strong>
            <h3 class="mb-0">Chavis rompe en llanto</h3>
            <div class="mb-1 text-muted">Nov 11</div>
            <p class="mb-auto">Momento exacto en el que el conductor rompe en llanto por...</p>
            <a href="#" class="stretched-link">Continuar leyendo</a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img src="../../Elementos/Chavis.jpg" class="imagen" alt="imagen" width="300px" height="300px">

          </div>
        </div>
      </div>
    </div>
    <!--</div>-->


    <div class="album py-5 bg-light" >
      <div class="container" >
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="recent_news">
        </div>

      </div>  
    </div>  

          




  </main>

  <footer class="blog-footer">
    <a href="#">Regresar a la parte superior</a>
    </p>
  </footer>

  <script src="../../JS/bootstrap.bundle.min.js"></script>

    <script>
      function setNews(news){
        var html_content = ''
        for(let data of news) {
          console.log(data)
              html_content = html_content.concat(`
                <div class="col">
                  <div class="card shadow-sm">

                    <img src="${data['THUMBNAIL']}" class="imagen" alt="imagen"style="height:204px; object-fit:cover; width="100%" height="225">


                    <div class="card-body">
                      <p class="card-text text-black">${data['HEADER']}</p>
                      <p class="text">${data['REPORT_DESCRIPTION']}</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <a href="Pagina_noticia.php?reportId=${data['REPORT_NUMBER']}" class="btn btn-sm btn-outline-secondary">Continuar leyendo</a>
                        </div>
                        <small class="text-muted">${data['EVENT_DATE']}</small>
                      </div>
                    </div>
                  </div>
                </div>
              `)
          }
          console.log(html_content)
          $('#recent_news').append(html_content)

      }


      $(document).ready(function(){
        $.ajax({
          url: '../includes/consults_inc.php',
          type: 'POST',
          data: {
              'ajax_get_all_news_published': 1
          },
          success: function(response)  {
            console.log(response);
            if(response !== 0){
              var data_array = $.parseJSON(response)
              setNews(data_array)
            }
          },
          error: function (jqXHR, status, error) {
            alert('Error consulting news')
            console.log(error);
            console.log(status);
          },
          complete: function (jqXHR, status) {
              console.log("se concreto la consulta de noticias en inicio");
          }

        })
      })
    </script>
</body>

</html>