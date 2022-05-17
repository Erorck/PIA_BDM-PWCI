<?php
 require 'connection.php';
 require 'User.php';
if (isset($_POST['data']) ) {
    // do user authentication as per your requirements 
    //El proceso de borrado es llamar el procedure de delete (asi sabremos si funciono o no el delete)
    //y luego el procedure que re ordena las categorias para que se re ordenen
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