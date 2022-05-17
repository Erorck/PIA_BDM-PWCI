<?php
require 'connection.php';
$ImgBlob = [];
$imageok = false;
if(connection::GetMediaImage(1,$ImgBlob)){
    $imageok = true;
}
else $imageok = false;
?><!DOCTYPE html>
<html>
<head>
    <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
</head>
<body>
    <h3>Visualizador de imagenes xd</h3>
    
    <?php
    if($imageok){
        echo'<img src="data:'.$ImgBlob['Mime'].';base64,'.base64_encode($ImgBlob['Data']).'">';
    }
    else echo'<h3>ALGO NO JALO PAPU AAAA</h3>';
    ?>
</body>
</html>