

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://kit.fontawesome.com/20eb58569d.js" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="blog-header-logo" href="../Pages/Inicio.php"><img src="../../Elementos/Good Old Times_LOGO2.invert.white.png" class="logo" alt="logo" width="200px" height="80px"></a>
      <a href="https://twitter.com/intent/tweet?screen_name=TwitterDev&ref_src=twsrc%5Etfw" class="twitter-mention-button" data-show-count="false">Tweet to @TwitterDev</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul id="section_list_navb" class="navbar-nav me-auto mb-2 mb-md-0">

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
        <!-- <form class="d-flex" id="form1" name="form" action="ResultadosBusqueda.php" method="POST"> -->

      <div class="row gy-3">
        <div class="col-md-6 columna">
          <input type="date" name="fechaMin" class="calend">
          <input type="date" name="fechaMax" class="calend">
        </div>
      </div>

          <?php
             if (isset($_SESSION["user_name"])) {
          ?>
             <input class="form-control me-2" type="search" placeholder= <?php echo $_SESSION["user_name"] ?> aria-label="Search" name="buscarpalabra">
          <?php
             } else {
          ?>
             <input class="form-control me-2" type="search"  placeholder="Buscar" aria-label="Search" name="buscarpalabra">
          <?php
             }
          ?>
          <button class="btn btn-outline-light" type="submit" name="search" method="get"><i class="fas fa-search"></i></button>
          <button class="btn btn-primary p-3 ml-2 mr-2" type="submit" name="profile" method="get"><i class="fas fa-user "></i></button>
          <?php if(isset($_SESSION['user'])): ?>
            <button class="btn btn-danger p-3 ml-2 mr-2" onclick="Logout()" type="button" ><i class="fa-solid fa-right-from-bracket "></i></button>
          <?php endif?>
        </form>
      </div>
    </div>
  </nav>

  <?php 



/*
  if($_POST['buscarpalabra'] == ''){$_POST['buscarpalabra']=' ';}
  $aKeyword = explode(" ", $_POST['buscarpalabra']);

  if($_POST["buscarpalabra"] == '' AND $_POST["fechas"]){
    $query = "SELECT * FROM " ;
  }else{
    $query = "SELECT * FROM " ;

    if($_POST["buscarpalabra"] != ''){
      $query .= "WHERE (  LIKE LOWER{ '%".$aKeyword[0]."%'} OR LIKE LOWER {'%" .$aKeyword[0]. "%'})";
      
      for($i = 1; $i < count($aKeyword); $i++){
        if(!empty($aKeyword[$i])){
          $query .= " OR LIKE '%". $aKeyword[$i] . "%' OR LIKE '%" . $aKeyword[$i] . "%'";
        }
      }
    }

    if ($_POST["fechas"] != ''){
      $query .= " AND BETWEEN  '". $_POST["fechas"]. "' AND '" .$_POST["fechas"]."' ";
    }
  }

*/

  ?>

<script src="../../JS/Scripts_Navbar.js"></script>
<!-- 
  <script>
  $(function() {
    $('input[name="fechas"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
  </script> -->
    