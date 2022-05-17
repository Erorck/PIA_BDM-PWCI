<?php
require 'connection.php';
$vBlob = null;
$vok = false;
if(connection::GetMediaVideo(1,$vBlob)){
    $vok = true;
}
else $imageok = false;
?><!DOCTYPE html>
<html>
<head>
    <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
</head>
<body>
    <h3>Visualizador de vidios xd</h3>
    
    <?php
    if($vok){
        echo'<video width="320" height="240" controls>';
        echo'<source  src="data:'.$vBlob['Mime'].';base64,'.base64_encode($vBlob['Data']).'">';
    }
    else echo'<h3>ALGO NO JALO PAPU AAAA</h3>';
    ?>
</body>
</html>