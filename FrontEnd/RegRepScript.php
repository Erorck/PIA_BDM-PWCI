<?php
 require 'connection.php';
 require 'User.php';
if (isset($_POST['uname']) && $_POST['uname'] &&
    isset($_POST['Nombre']) && $_POST['Nombre'] &&
    isset($_POST['Apat']) && $_POST['Apat'] &&
    isset($_POST['Amat']) && $_POST['Amat'] &&
    isset($_POST['bdate']) && $_POST['bdate'] &&
    isset($_POST['direccionemail']) && $_POST['direccionemail'] &&
    isset($_POST['phone']) && $_POST['phone'] &&
    isset($_POST['pass']) && $_POST['pass'] &&
    isset($_POST['passconf']) && $_POST['passconf'] ) {
    // do user authentication as per your requirements
    $uname = $_POST['uname'];
    $name = $_POST['Nombre'];
    $apat = $_POST['Apat'];
    $amat = $_POST['Amat'];
    $bdate = $_POST['bdate'];
    $email = $_POST['direccionemail'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    $passconf = $_POST['passconf'];
    if(connection::AddUser_RE($uname,$pass,$name,$apat,$amat,$email,$phone,$bdate)){
        $datarray = null;
        if(connection::getDatosUsuario($uname,$datarray)){
            echo json_encode(array('success' => 1));
        }
        else 
        echo json_encode(array('success' => 0));
    }
    else echo json_encode(array('success' => 0));
} else {
    echo json_encode(array('success' => 0));
}