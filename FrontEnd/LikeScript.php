<?php
require 'connection.php';
require 'User.php';
$x=1;
$y=2;
if (!isset($_POST['data']) ){echo json_encode(array("success" => 0)); exit();}
$data = json_decode(($_POST['data']),TRUE);
if($data['like']){
    //like
    $aid = $data['aid'];
    $uid = $data['uid'];
    if(!connection::LikeArticle($aid,$uid)){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}
else{
    //dislike
    $aid = $data['aid'];
    $uid = $data['uid'];
    if(!connection::DislikeArticle($aid,$uid)){echo json_encode(array("success" => 0)); exit();}
    else{echo json_encode(array("success" => 1));}
}

