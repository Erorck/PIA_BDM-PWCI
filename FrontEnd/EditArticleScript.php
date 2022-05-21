<?php
 require 'connection.php';
 require 'User.php';
 session_start();
 $fileok = false;
 $x = 1;
 if(!isset($_FILES['image'])) echo json_encode(array('success' => 0));
else{
    $error = arraY();
    $file_name = $_FILES['image']['name'];
    $file_tmpname = $_FILES['image']['tmp_name'];
    $path = "media/img"."/uploads"."/".$file_name;
    if(!empty($error)==true)echo json_encode(array('success' => 0)); // checamos si no dio error
    else{
        $file_type = strtolower(pathinfo($path,PATHINFO_EXTENSION));
        $extensions = array("jpg","jpeg","png");
        if(!in_array($file_type,$extensions))echo json_encode(array('success' => 0)); //checamos que se admite el tipo de archivo
        else{
            if(!move_uploaded_file($file_tmpname,"media/img/uploads/".$file_name))echo json_encode(array('success' => 0));//checamos si se movio el archivo subido a la carpeta uploads
            else {
                //File has been moved and we have name, proceed with the shit
                //Aqui podriamos optimizarla, comprimirla, cambiarle el tamaño, y todo lo necesario antes de subirla a la DB
                $imgData = file_get_contents($path);
                $imgDataEncoded = base64_encode($imgData);
                $Mime = $_FILES['image']['type'];
                $fileok = true;
            }
        }
    }
}
 if (!(isset($_POST['data']) && $fileok == true)) echo json_encode(array('success' => 0));
 else{
    if (!(isset($_SESSION['islogged']) && $_SESSION['islogged'])) echo json_encode(array('success' => 0));
    else{
        $arrArticulo = json_decode(($_POST['data']),TRUE);
        $contentconslahes = json_decode($_POST['data'],true);
        $textpconbreaks = $contentconslahes['content'];
        $arrArticulo['content'] = $textpconbreaks;
        $uname = $_SESSION['DataUser'] ->USER_ALIAS;
        $id = null;
        //get img from files
        if(!connection::GetUserId($uname,$id)) echo json_encode(array('success' => 0));
        else{
            $arrArticulo['thumbnail'] = $imgData;
            $arrArticulo['mime'] = $Mime;
            $textoarea = $arrArticulo['content'];
            $textoarea2 = addslashes($arrArticulo['content']);
            if(!connection::UpdateArticle($arrArticulo)) echo json_encode(array('success' => 0));
            else{
                //if there are files do insert files in DB
                if(isset($_POST['FilesCount']) && $_POST['FilesCount'] >0 ){
                    //delete all media previously associated with this article
                        if(!connection::DeleteMediaArticle($arrArticulo['aid'])) echo json_encode(array('success' => 0));
                        else{
                            $AdjFiles = $_FILES['Files'];
                            $currfileok = false;
                            for($i = 0;$i<count($AdjFiles['name']);$i++){
                            //check whether is vid or img
                            $curfiletype = explode('/',$AdjFiles['type'][$i])[0];
                            if($curfiletype === "video"){
                                $verror = arraY();
                                $vfile_name = $AdjFiles['name'][$i];
                                $vfile_tmpname = $AdjFiles['tmp_name'][$i];
                                $vpath = "media/video"."/uploads"."/".$vfile_name;
                                if(!empty($verror)==true){echo json_encode(array('success' => 0)); $currfileok = false; break;} // checamos si no dio error
                                $vfile_type = strtolower(pathinfo($vpath,PATHINFO_EXTENSION));
                                $vextensions = array("mp4");
                                if(!in_array($vfile_type,$vextensions)){echo json_encode(array('success' => 0)); $currfileok = false; break;} //checamos que se admite el tipo de archivo
                                if(!move_uploaded_file($vfile_tmpname,"media/video/uploads/".$vfile_name)){echo json_encode(array('success' => 0)); $currfileok = false; break;}//checamos si se movio el archivo subido a la carpeta uploads
                                //File has been moved and we have name, proceed with the shit
                                //Aqui podriamos optimizarla, comprimirla, cambiarle el tamaño, y todo lo necesario antes de subirla a la DB
                                $videoData = file_get_contents($vpath);
                                $videoDataEncoded = base64_encode($videoData);
                                //procedemos a pasar datos a un arreglo subir archivo a la db
                                $videoArray = [];
                                $videoArray['Aid'] =$arrArticulo['aid'] ;
                                $videoArray['Desc'] =$vfile_name;
                                $videoArray['Content']=$videoData;
                                $videoArray['Mime']=$AdjFiles['type'][$i];
                                $videoArray['Route']=$vpath;
                                if(!connection::InsertMediaVideo($videoArray)){echo json_encode(array('success' => 0)); $currfileok = false; break;}
                                $currfileok = true;
                            }
                            if($curfiletype === "image"){
                                $ierror = arraY();
                                $ifile_name = $AdjFiles['name'][$i];
                                $ifile_tmpname = $AdjFiles['tmp_name'][$i];
                                $ipath = "media/img"."/uploads"."/".$ifile_name;
                                if(!empty($ierror)==true){echo json_encode(array('success' => 0)); $currfileok = false; break;} // checamos si no dio error
                                $ifile_type = strtolower(pathinfo($ipath,PATHINFO_EXTENSION));
                                $iextensions = array("jpg","jpeg","png");
                                if(!in_array($ifile_type,$iextensions)){echo json_encode(array('success' => 0)); $currfileok = false; break;} //checamos que se admite el tipo de archivo
                                if(!move_uploaded_file($ifile_tmpname,"media/img/uploads/".$ifile_name)){echo json_encode(array('success' => 0)); $currfileok = false; break;}//checamos si se movio el archivo subido a la carpeta uploads
                                //File has been moved and we have name, proceed with the shit
                                //Aqui podriamos optimizarla, comprimirla, cambiarle el tamaño, y todo lo necesario antes de subirla a la DB
                                $iData = file_get_contents($ipath);
                                $iDataEncoded = base64_encode($iData);
                                //procedemos a pasar datos a un arreglo subir archivo a la db
                                $imageArray = [];
                                $imageArray['Aid'] =$arrArticulo['aid'] ;
                                $imageArray['Desc'] =$ifile_name;
                                $imageArray['Content']=$iData;
                                $imageArray['Mime']=$AdjFiles['type'][$i];
                                $imageArray['Route']=$ipath;
                                if(!connection::InsertMediaImage($imageArray)){echo json_encode(array('success' => 0)); $currfileok = false; break;}
                                $currfileok = true;
                            }
                        }
                        if($currfileok||count($AdjFiles['name'])==0){
                            echo json_encode(array('success' => 1));
                        } 
                        else echo json_encode(array('success' => 0));
                        }
                    
                }
                else echo json_encode(array('success' => 1));
            }  
        }
    }
 }