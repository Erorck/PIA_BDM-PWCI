<?php
 require 'connection.php';
 require 'User.php';
if (isset($_POST['data']) ) {
    // do user authentication as per your requirements
        $Categ = json_decode(stripslashes($_POST['data']),TRUE);
        $allclear = true;
        $Clave = $Categ['clave'];
        $Nombre = $Categ['nombre'];
        $Nombre = strtoupper($Nombre);
        $Color = $Categ['color'];
        $Color = substr($Color, 1,6);
        if(!connection::UpdateCategNameColor( $Clave,$Nombre,$Color)) {
            $allclear = false;
        }
        if($allclear) echo json_encode(array("success" => 1));
        else echo json_encode(array("success" => 0));
    }
    else 
    echo json_encode(array("success" => 0));