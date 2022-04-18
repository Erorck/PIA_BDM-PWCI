

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="blog-header-logo" href="#"><img src="../../Elementos/Good Old Times_LOGO2.invert.white.png" class="logo" alt="logo" width="200px" height="80px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">

          <li class="nav-item">
            <a class="nav-link text-primary" href="#">Internacional</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-success" href="#">Negocios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#">Tecnologia</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="#">Farandula</a>
          </li>
        </ul>
        <form class="d-flex" action="../includes/nav_bar_inc.php"> 

      <div class="row gy-3">
        <div class="col-md-6 columna">
          <input type="text" name="daterange" value="Fecha" class="calend"/>
        </div>
      </div>

          <?php
             if (isset($_SESSION["user_name"])) {
          ?>
             <input class="form-control me-2" type="search" placeholder= <?php echo '¿Buscamos_algo_'.$_SESSION["user_name"].'?' ?> aria-label="Search">
          <?php
             } else {
          ?>
             <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
          <?php
             }
          ?>
          <button class="btn btn-outline-light" type="submit" ><i class="fas fa-search"></i></button>
          <button class="btn btn-link" type="submit" name="profile" method="get"><i class="fas fa-user"></i></button>
        </form>
      </div>
    </div>
  </nav>


  <script>
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
  </script>
    