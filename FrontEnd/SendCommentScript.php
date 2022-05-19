<?php
require 'connection.php';
require 'User.php';
$x=1;
$y=2;
if (!isset($_POST['data']) ){echo json_encode(array("success" => 0)); exit();}
$commentsarr = json_decode(stripslashes($_POST['data']),TRUE);
//determine wether is child (a response to another comment) or not
$ischild = false;
$ischild = $commentsarr['child'];
if(!$commentsarr['text']!=""){echo json_encode(array("success" => 0)); exit();}
if(!$ischild){
    $data = [];
    $data['text'] = $commentsarr['text'];
    $data['by']= $commentsarr['by'];
    $data['aid']= $commentsarr['aid'];
    if(!connection::AddComment($data)){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}
else{
    $data = [];
    $data['text']= $commentsarr['text'];
    $data['by']= $commentsarr['by'];
    $data['aid']= $commentsarr['aid'];
    $data['pid']= $commentsarr['pid'];
    if(!connection::AddComentChild($data)){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}


