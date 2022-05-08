<?php
 require 'connection.php';
 require 'User.php';
if (isset($_POST['data']) ) {
    // do user authentication as per your requirements
        $nCatOrarr = json_decode(stripslashes($_POST['data']),TRUE);
        $allclear = true;
        foreach($nCatOrarr as $cator){
            $var = 1;
            $nombre = $cator['nombre'];
            $orden = $cator['orden'];
            if(!connection::SetCategOrder($nombre,$orden)) {
                $allclear = false;
                break;
            }
        }
        if($allclear)
        echo json_encode(array("success" => 1));
        else
         echo json_encode(array("success" => 0));
    }
    else 
    echo json_encode(array("success" => 0));
    
