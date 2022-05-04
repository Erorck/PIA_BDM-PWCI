<?php
 require 'connection.php';
 require 'User.php';
if (isset($_POST['uname']) && $_POST['uname'] && isset($_POST['pass']) && $_POST['pass']) {
    // do user authentication as per your requirements
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    if(connection::validUser($uname,$pass)){// based on successful authentication
    $datarray = null;
    if(connection::getDatosUsuario($uname,$datarray)){
        session_start();
        $DataUser = new DatosUsuarios($datarray);
        $_SESSION['DataUser']  = $DataUser; //guardamos datos de usuario en sesion
        $_SESSION['islogged'] = true;
        echo json_encode(array('success' => 1));
    }
    else 
    echo json_encode(array('success' => 0));
    }
    else 
    echo json_encode(array('success' => 0));
} else {
    echo json_encode(array('success' => 0));
}