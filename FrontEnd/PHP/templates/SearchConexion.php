
<?php
$servidor= "localhost";
$usuario= "root";
$password ="root";
$nombreBD="good_old_times_db";
$conexion = new mysqli($servidor, $usuario, $password, $nombreBD);

//if($conexion->connect_error){
//die("la conexion ha fallado: ", $conexion ->connect_error);
//}

//print_r ($_POST);
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(!isset($_POST['buscarpalabra'])){$_POST['buscarpalabra']='';}
  if(!isset($_POST['fechas'])){$_POST['fechas']='';}
  
  $palabra = $_POST['buscarpalabra'];
  $fechaMin = $_POST["fechaMin"];
  $FechaMax = $_POST["fechaMax"];
  $query = "select * from FAKENEWS
  where if('$palabra' Is null,1, TITULO like concat('%', '$palabra','%'))
  and if ( '$fechaMin' is null,1, FECHAS >=  '$fechaMin')
  and if ('$FechaMax' is null,1, FECHAS <= '$FechaMax')";
  //$sql = $conexion -> query($query);
  $sql = $conexion -> query("SELECT * FROM FAKENEWS");

  // $noticias=[];
  // while ($row = $sql->fetch_object()){
  //     $noticias[]=$row;
  // }
  
  // print_r($noticias);
  include "../Pages/ResultadosBusqueda.php";
  
}

?>