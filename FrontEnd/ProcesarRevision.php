<?php
 require 'connection.php';
 require 'User.php';
 session_start();
if (!(isset($_POST['Revision']) &&
isset($_POST['author']) && $_POST['author']&&
isset($_POST['aid']) && $_POST['aid'])) echo'No jalo variables en post';
else{
    $feedback = "";
    $pubdate = "";
    $done = false;
    $setFback = isset($_POST['feedback']) && $_POST['feedback'];
    $setPubDate = isset($_POST['PubDate']) && $_POST['PubDate'];
    $aid = $_POST['aid'];
    $author = $_POST['author'];
    $Editor = null;
    if(connection::GetUserId($_SESSION['DataUser']->USER_ALIAS,$Editor))
    if(isset($_POST['hasfeedbacks']) && $_POST['hasfeedbacks'] == 0){
        //EL POST NO TIENE FEEDBACKS, ASI QUE NO TIENE CHILDREN NI PARENT; NO SE CREA ASOSIATIVA
        switch($_POST['Revision']){
            case 0: //not aproved, create feedback and change status to RA.
                $feedback = $setFback ?  $_POST['feedback']: "NA";
                if($feedback==="NA") {echo'No jalo';break;}
                if(!connection::ChangeArticleStatus($aid,"RA")) { echo'No jalo Cambiar Status';break; }
                else{
                    $data = [];
                    $data['text']=$feedback;
                    $data['by']=$Editor;
                    $data['for']=$author;
                    $data['aid']= $aid;
                    //Crear Feedback en tabla Feedback, y asociarla al articulo en News_feedbacks
                    if(!connection::AddFeedBack($data)) echo'No Jalo Añadir Feedback';
                    else{
                        //Exito
                        header('Location:Portal_Editor.php');
                        exit();
                    }
                }
            break;
            case 1://aproved, create feedback with "todo bien", update publication date and change status to PU
                if($feedback==="NA") {echo'No jalo';break;}
                if($pubdate==="NA") {echo'No jalo';break;}   
                if(!connection::ChangeArticleStatus($aid,"PU")){ echo'No jalo';break; }
                else{
                    //Crear Feedback en tabla Feedback, y asociarla al articulo en News_feedbacks
                    echo'si jalo, noticia publicada';
                }
            break;
            default: echo'No jalo';
        }
    }
    else{
        //EL POST SI TIENE FEEDBACKS, ASI QUE  TIENE CHILDREN Y PARENT; SE CREA ASOSIATIVA
        switch($_POST['Revision']){
            case 0: //not aproved, create feedback and change status to RA.
                $feedback = $setFback ?  $_POST['feedback']: "NA";
                if($feedback==="NA") {echo'No jalo';break;}
                if(!connection::ChangeArticleStatus($aid,"RA")) { echo'No jalo Cambiar Status';break; }
                else{
                    $data = [];
                    $ParentId = $_POST['pfeedbackid'];
                    $data['text']=$feedback;
                    $data['by']=$Editor;
                    $data['for']=$author;
                    $data['aid']= $aid;
                    $data['pid']=$ParentId;
                    //Crear Feedback en tabla Feedback, y asociarla al articulo en News_feedbacks
                    if(!connection::AddChildrenFeedBack($data)) echo'No Jalo Añadir Feedback';
                    else{
                        //Exito
                        header('Location:Portal_Editor.php');
                        exit();
                    }
                }
            break;
            case 1://aproved, create feedback with "todo bien"
                // change all news_feedbacks of article Active to 0
                // update publication date and change status to PU
                if($feedback==="NA") {echo'No jalo';break;}
                $pubdate = $setPubDate ?  $_POST['PubDate']: "NA";
                if($pubdate==="NA") {echo'No jalo';break;}   
                if(!connection::ChangeArticleStatus($aid,"PU")){ echo'No jalo';break; }
                else{
                    //Cambiar fecha de publicacion a pubdate
                    if(!connection::ChangeArticlePubDate($aid,$pubdate)){ echo'No jalo';break;}
                    else{
                        echo'si jalo, noticia publicada';
                        header('Location:Portal_Editor.php');
                    exit();
                    }
                }
            break;
            default: echo'No jalo';
        }
    }
    
}