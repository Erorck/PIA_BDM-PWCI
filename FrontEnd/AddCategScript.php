<?php
 require 'connection.php';
 require 'User.php';
 session_start();
if (isset($_POST['CategName']) && $_POST['CategName'] &&
     isset($_POST['CategColor']) && $_POST['CategColor']) {
    // do user authentication as per your requirements
    $Nombre = $_POST['CategName'];
    $Nombre = strtoupper($Nombre);
    $Color = $_POST['CategColor'];
    $Color = substr($Color, 1,6);
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $UserName = $_SESSION['DataUser']->USER_ALIAS;
        $Id = null;
        if(connection::GetUserId($UserName,$Id)){
            if(connection::AddCategory($Nombre,$Color,$Id)){
                echo json_encode(array('success' => 1));
            }else echo json_encode(array('success' => 0));
        }else echo json_encode(array('success' => 0));
    }else echo json_encode(array('success' => 0));
} else echo json_encode(array('success' => 0));
