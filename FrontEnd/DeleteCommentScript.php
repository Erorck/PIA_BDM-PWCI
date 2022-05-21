<?php
require 'connection.php';
require 'User.php';
$x=1;
$y=2;
if (!isset($_POST['data']) ){echo json_encode(array("success" => 0)); exit();}
$data = json_decode(stripslashes($_POST['data']),TRUE);
//determine wether is child (a response to another comment) or not
$ischild = false;
$ischild = $data['child'];
if(!$data['cid']!=null){echo json_encode(array("success" => 0)); exit();}
if(!$ischild){
    $pass = [];
    $pass['cid'] = $data['cid'];
    if(!connection::DeleteComment($pass['cid'])){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}
else{
    $pass = [];
    $pass['cid'] = $data['cid'];
    if(!connection::DeleteChildComment($pass['cid'])){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}


