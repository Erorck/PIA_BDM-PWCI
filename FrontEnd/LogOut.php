<?php
if($_POST['action'] == "logout"){
    session_start();
    $_SESSION['islogged'] = false;
    unset($_SESSION['DataUser']);
    echo "success";
}