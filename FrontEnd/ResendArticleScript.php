<?php
require 'connection.php';
require 'User.php';
if (!(isset($_POST['aid']) && $_POST['aid'])) echo'No jalo variables en post';
else{
    $ParentId = $_POST['pfeedbackid'];
    $ParentBy = $_POST['pfeedbackby'];
    $ParentFor = $_POST['pfeedbackfor'];
    $aid = $_POST['aid'];
    $data = [];
    $data['text']="Documento Reenviado";
    $data['by']=$ParentFor; //intercambiamos destinatarios, ya que el reportero esta mandando el feedback
    $data['for']=$ParentBy; //aqui tambien ya que el editor recibe el feedback
    $data['aid']= $aid;
    $data['pid']=$ParentId;
    //Generar Feedback que diga Documento Reenviado
    //adjuntar dicho feedback como parent del feedback ya presente
    if(!connection::AddChildrenFeedBack($data)) echo'No Jalo Añadir Feedback';
    else{
        //cambiar estatus de noticia a RR;
        if(!connection::ChangeArticleStatus($aid,"RR")) { echo'No jalo Cambiar Status';exit();}
        header('Location:Portal_Reportero.php');
        exit();
    }
    
}