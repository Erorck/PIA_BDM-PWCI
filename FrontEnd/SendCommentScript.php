<?php
require 'connection.php';
require 'User.php';
$x=1;
$y=2;
if (!isset($_POST['data']) ){echo json_encode(array("success" => 0)); exit();}
$commentsarr = json_decode(stripslashes($_POST['data']),TRUE);
if(!$commentsarr['text']!=""){echo json_encode(array("success" => 0)); exit();}
if(!connection::AddComment($commentsarr)){echo json_encode(array("success" => 0)); exit();}
else{echo json_encode(array("success" => 1));}

