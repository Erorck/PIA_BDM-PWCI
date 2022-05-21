<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Categorias =[];
    $feedbacks = [];
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $numFeedbacks = 0;
    $hasfeedbacks = false;
    $Articulo = null;
    $hasimages=false;
    $hasvideos=false;
    $articleCateg = "";
    $aCateg = null;
    $aid = intval($_POST['aid']);
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        if(strcmp($Perfil->USER_TYPE,'RE')!==0){
            header('Location: '.'403.html');
        }
    }
    else{
        header('Location: '.'403.html');
    }
    if(connection::GetCountArticles($numArticles,"XD")) $ArticlesExist = true;
    if(connection::GetCountArticles($numRRArticles,"RR")) $ArticlesRRExist = true;
    if(connection::GetCountArticles($numRAArticles,"RA")) $ArticlesRAExist = true;
    if(connection::GetCountArticles($numPUArticles,"PU")) $ArticlesPUExist = true;
    if($ArticlesRAExist)
    {
        if(connection::GetArticles($datarray)){
            foreach($datarray as $art){
                $arti = new Articulo($art);
                if($arti->ARTICLE_ID == intval($_POST['aid'])){
                    $Articulo = $arti;
                    break;
                }
            }
        }
        
    }
    if($Articulo!=null){
        //getArticleCateg
        if(connection::GetCategOfArticle($Articulo->ARTICLE_ID,$articleCateg)){
            for($i=0;$i<count($Categorias);$i++){
                if($Categorias[$i]->name ==$articleCateg) $aCateg = $Categorias[$i];
            }
        }
        //get thumbnail
        $thmBlob = [];
        connection::GetImageArticle($Articulo->ARTICLE_ID,$thmBlob);
        //get all media
        $ImgBlobarr = [];
        $ImgBlobarr['Name'] = [];
        $ImgBlobarr['Data'] = [];
        $ImgBlobarr['Mime'] = [];
        $vBlobarr = [];
        $vBlobarr['Name'] = [];
        $vBlobarr['Data'] = [];
        $vBlobarr['Mime'] = [];
       
        if(connection::GetMediaImage($Articulo->ARTICLE_ID,$ImgBlobarr)){
            $hasimages = true;
        }
        if(connection::GetMediaVideo($Articulo->ARTICLE_ID,$vBlobarr)){
            $hasvideos = true;
        }
        //get feedbacks
        if(connection::GetFeedBackForArticle($Articulo->ARTICLE_ID,$feedbacks)){
            $hasfeedbacks = true;
        }
    }
    $cstr = file_get_contents('data/WorldCountries.json');
    $cntrjson = json_decode($cstr,true);
    $cntrjson['Countries'] = strtoupper($cntrjson['Countries']);
    $countries = explode("//",$cntrjson['Countries']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Editar Articulo</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
          blobthmb = null;
          blobfiles=[];
          addingfiles=false;
          changingfiles = false;
          deletingfiles=[]; //has a boolean for each index in blobfiles
          totalAddedFiles=0;

        function dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), 
            n = bstr.length, 
            u8arr = new Uint8Array(n);
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type:mime});
        }

        async function loadfiles(filenum,blobarr,src,name){
            debugger;
            for(i=0;i<filenum;i++){
                blobarr.push(await dataURLtoFile(src[i],name[i]));
                deletingfiles.push(false);
            }
            debugger;
        }
        
        async function loadOgThumbnail(){
            blobthmb = await dataURLtoFile($('#preview').attr('src'),'thumbnail.'+$('#thdata').attr('mimetype').split('/')[1]);
        }

        function previewFile(preview,file) {
            //var preview = document.querySelector('#preview');
            //var file    = document.querySelector('#imageFile').files[0];
            var reader  = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                b64img = reader.result;
                debugger;
            }
            if (file) {
                reader.readAsDataURL(file);
                var blobfile = file;
                addingfiles = true;
                return blobfile;
            } 
            else{
                preview.src = preview.src;
            }
        }

        function addFileInput(div){
            //$('#FileAddDiv').append('<hr>');
            div.append('<hr>');
            totalAddedFiles ++;
            subPrevStr = '<img class = "preview" id="subPreview_'+totalAddedFiles+'"src="media/img/papas.jpg" alt="Thumbnail Image">';
            inputStr = '<input class="AdjuntedFile" type="file" id="AddedFile_'+totalAddedFiles+'" onchange="blobfiles.push(previewFile(document.querySelector(\'#subPreview_'+totalAddedFiles+'\'),document.querySelector(\'#AddedFile_'+totalAddedFiles+'\').files[0]))" name="File_'+totalAddedFiles+'" accept=".jpg,.jpeg,.png,.mp4" file-position="'+totalAddedFiles+'"/>';
            //$('#FileAddDiv').append(inputStr);
            //$('#FileAddDiv').append(subPrevStr);
            div.append(inputStr);
            div.append(subPrevStr);
        } 

        $(document).ready(function() {
            loadOgThumbnail();
            //set country select to original
            $('#SelCountry').val($('#originalCountry').val());
            $('#SelCateg').val($('#originalCateg').val());
            var evdate = $('#orignialEventDate').val();
            var evdtestr = evdate.split(' ');
            var evdtestrx = evdtestr[1].split(':')[0]+':'+evdtestr[1].split(':')[1]
            var evdatetopass = evdtestr[0] +"T"+evdtestrx;
            $('#dtp').val(evdatetopass);
            var numArchivos = $('#numArchivos').attr('numfiles');
            var numImg = $('#numImagenes').attr('numfiles');
            var numVid = $('#numVideos').attr('numfiles');
            var srcs=[];
            var filenames=[];
            for(i=0;i<numImg;i++){
                currFile=$('.MediaI[position='+i+']');
                srcs.push(currFile.attr('src'));
                filenames.push(currFile.attr('filename'));
            }
            debugger;
            for(i=0;i<numVid;i++){
                currFile=$('.MediaV[position='+i+']').children('source');
                srcs.push(currFile.attr('src'));
                filenames.push(currFile.attr('filename'));
            }
            debugger;
            loadfiles(numArchivos,blobfiles,srcs,filenames);
            //append controls for  Adding Files, Editing current files and Eliminating Current Files
            $('#adjuntarFile').click(function(){
                addFileInput($('#FileAddDiv'));
            });
            $('#cboxChangeFiles').click(function(){
                changingfiles = true;
                if ($('input#cboxChangeFiles').prop('checked')) $('.changeFile').prop('disabled', false);
                if (!$('input#cboxChangeFiles').prop('checked')) $('.changeFile').prop('disabled', true);
            
            });
            $('#cboxchangeThumbnail').click(function(){
                if ($('input#cboxchangeThumbnail').prop('checked')) $('#imageFile').prop('disabled', false);
                if (!$('input#cboxchangeThumbnail').prop('checked')) $('#imageFile').prop('disabled', true);
            });
            $('#ArticleForm').submit(function(e){
                e.preventDefault();
                debugger;
                let timerInterval
                        Swal.fire({
                        title: 'Cargando...',
                        timer: 5000,
                        timerProgressBar: true,
                        showCancelButton: false,
                        showConfirmButton: false,
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        });
                var formData = new FormData();
                formData.append('image', blobthmb);  //append thumbnail
                for(var i = 0; i < blobfiles.length;i++){
                    //añadimos al Form data los archivos adjuntados
                    formData.append('Files[]', blobfiles[i]); 
                    debugger;
                }
                debugger;
                var aux ={};
                aux['aid'] = $('#aid').val();
                aux['updater'] = $('#author').val();
                aux['sign'] = $('#sign').val();
                aux['street'] = $('#calle').val();
                aux['colon']= $('#colonia').val();
                aux['city']= $('#municipio').val();
                aux['state']= $('#estado').val();
                aux['country']= $('#SelCountry option:selected').val();
                aux['date'] = $('#dtp').val();
                aux['header']= $('#header').val().toUpperCase();
                aux['desc']= $('#desc').val();
                aux['content']= $('#content').val();
                aux['categ'] = $('#SelCateg option:selected').val();
                //Adjuntamos Archivos
                //Validamos que nada este vacio;
                if(validarArticulos(aux)){
                    var jsonString = JSON.stringify(aux);
                    formData.append('data', jsonString);
                    formData.append('FilesCount', blobfiles.length);
                    $.ajax({
                        type: "POST",
                        url: "EditArticleScript.php",
                        data: formData, 
                        cache: false,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,   // tell jQuery not to set contentType
                        success: function(response){
                            debugger;
                            var jsonData = JSON.parse(response);
                            if (jsonData.success == "1")
                            {
                                swal.fire('El Articulo se ha Editado!');
                                location.href = 'Portal_Reportero.php';
                            }
                            else{ alert('Error de algun tipo')}
                        }
                    });         
                }
            });
        });
      </script>
</head>

<body>
    <div class="Contenedor-base">
        <div class = "Barra-navegacion">
            <h3 class="Logo-web">Noticias</h3>
            <a href="Main.php"><i class="fa fa-home" aria-hidden="true"></i></a>
            <form action="Busqueda.php" name="F_Search" class="SearchBarForm">
            <div id="Barra"><input type = "text" name ="srchParam" placeholder="Busqueda"></div>
            <button class ="btn btn-danger"type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> 
            </form>
            <?php
                if(!$LoggedUser){
                echo'
                <div id="accountHyperlinks">
                <a href="Login.php">Ingresar</a>
                <a href="Register.php">Registrarse</a>
                </div>';
                }
                else{
                    echo '<div id="Account">
                    <h3><a href="Perfil.php">'.$Perfil->USER_ALIAS.'</a></h3>
                    </div>';
                }
                ?>
        </div>

        <div class="mainContenedor" id="NNcontainer">
            <div class="ZonaFeed">
                <div class="NewArticle">
                <h1  style="font-family:sans-serif; font-weight:bolder;" >Editar Articulo</h1>
                <form id="ArticleForm" method="post" name ="ArticleForm" autocomplete="off">
                    <input type="hidden" id="aid" value="<?php echo $Articulo->ARTICLE_ID;?>">
                    <input type="hidden" id="author" value="<?php echo $Articulo->CREATED_BY;?>">
                    <label >Categoria del Articulo:</label>
                    <input type="hidden" id="originalCateg" value="<?php echo $aCateg->name;?>">
                    <select class="form-control" id="SelCateg" name="SelCateg" placeholder="Categoria">
                        <?php
                        foreach($Categorias as $Categ){
                            echo'<option class="Categ" value="'.$Categ->name.'" style="background-color:#'.$Categ->color.'">'.$Categ->name.'</option>';
                        }
                        ?>
                    </select>
                    <label for="eventDate">Fecha y Hora del Acontecimiento:</label>
                    <input type="hidden" id="orignialEventDate" value="<?php echo $Articulo->EVENT_DATE;?>">
                    <input type="datetime-local" class="form-control" id='dtp' name="eventDate" />
                    <label >Direccion del Acontecimiento:</label>
                    <div id="DirArt">
                    <input value="<?php echo $Articulo->LOCATION_STREET;?>"class="form-control" type="text" id="calle" name="calle" placeholder="CALLE">
                    <input value="<?php echo $Articulo->LOCATION_NEIGHB;?>"class="form-control" type="text" id="colonia" name="colonia" placeholder="COLONIA">
                    <input value="<?php echo $Articulo->LOCATION_CITY;?>"class="form-control" type="text" id="municipio" name="municipio" placeholder="MUNICIPIO">
                    <input value="<?php echo $Articulo->LOCATION_STATE;?>"class="form-control" type="text" id="estado" name="estado" placeholder="ESTADO">
                    <input type="hidden" id="originalCountry" value="<?php echo $Articulo->LOCATION_COUNTRY;?>">
                    <select class="form-control" id="SelCountry" name="SelCountry" placeholder="Pais">
                        <?php
                        //remember to set selection to its original value in the document ready using jquery
                        foreach($countries as $country){
                            echo'<option value="'.$country.'">'.$country.'</option>';                        }
                        ?>
                    </select>
                    </div>
                    <label >Articulo:</label>
                    <input value="<?php echo $Articulo->ARTICLE_HEADER;?>"class="form-control" type="text" id="header" name="header" placeholder="ENCABEZADO">
                    <input value="<?php echo $Articulo->ARTICLE_DESCRIPTION;?>"class="form-control" type="text" id="desc" name="desc" placeholder="SUBTITULO">
                    <textarea class="form-control" rows="10" cols="93"id="content" name="content" placeholder="CUERPO/CONTENIDO"><?php echo $Articulo->ARTICLE_CONTENT;?></textarea>
                    <label >Miniatura Noticia:</label>
                    <div id="ArtTh">
                    <input type="hidden" id="thdata" mimetype="<?php echo$thmBlob['mime']?>">
                    <label><input type="checkbox" id="cboxchangeThumbnail" value="cthumb">Cambiar Miniatura</label>
                    <input disabled type='file' id="imageFile" onchange="blobthmb = previewFile(document.querySelector('#preview'),document.querySelector('#imageFile').files[0])" name="thumbnail" accept=".jpg,.jpeg,.png*"/>
                    <img class = "preview" id="preview" src="<?php echo'data:'.$thmBlob['mime'].';base64,'.base64_encode($thmBlob['data']) ;?>" alt="Thumbnail Image">
                    </div>
                    <label >Firma del Reportero:</label>
                    <input value="<?php echo $Articulo->SIGN;?>"class="form-control" type="text" id="sign" name="sign" placeholder="firma">
                    <hr>
                    <?php
                    echo'<h3>Archivos Adjuntados a la noticia</h3>';
                    $numfiles= count($ImgBlobarr['Mime']) + count($vBlobarr['Mime']);
                    $fileiteration=-1;
                    echo'<h6 id="numArchivos" numfiles="'. $numfiles.'">hay '.$numfiles.' archivos adjuntados al articulo</h6>';
                    echo'<label><input type="checkbox" id="cboxChangeFiles" value="cfiles">Cambiar Archivos</label>';
                    echo'<h4 id="numImagenes" numfiles="'.count($ImgBlobarr['Mime']).'" >imagenes:</h4>';
                    for($i=0;$i<count($ImgBlobarr['Mime']);$i++){
                        $fileiteration++;
                        echo '<div style="border: dashed white 2px;">';
                        echo'<label style="color:black;">Cambiar Archivo: <input disabled type="file" class="changeFile" id="Cfile_'.$fileiteration.'"
                        onchange="blobfiles['.$fileiteration.'] = previewFile(document.querySelector(\'#OgFilesPreview_'.$fileiteration.'\'),document.querySelector(\'#Cfile_'.$fileiteration.'\').files[0])" name="ogFile_'.$fileiteration.'" accept=".jpg,.jpeg,.png,.mp4" ogfile-position="'.$fileiteration.'"
                        ></label>';
                        echo'<img class="MediaI preview" id="OgFilesPreview_'.$fileiteration.'" position="'.$i.'" filename="'.$ImgBlobarr['Name'][$i].'" src="data:'.$ImgBlobarr['Mime'][$i].';base64,'.base64_encode($ImgBlobarr['Data'][$i]).'">';
                        echo'<label style="color:red;"><input type="checkbox" id="Dfile_'.$fileiteration.'" value="dfiles">Eliminar Archivo?</label>';
                        echo '</div>';
                    }
                    echo'<h4 id="numVideos" numfiles="'.count($vBlobarr['Mime']).'" >videos:</h4>';
                    for($i=0;$i<count($vBlobarr['Mime']);$i++){
                        $fileiteration++;
                        echo '<div style="border: dashed white 2px;">';
                        echo'<label style="color:black;">Cambiar Archivo: <input disabled type="file" class="changeFile" id="Cfile_'.$fileiteration.'"
                        onchange="blobfiles['.$fileiteration.'] = previewFile(document.querySelector(\'#OgFilesPreview_'.$fileiteration.'\'),document.querySelector(\'#Cfile_'.$fileiteration.'\').files[0])" name="ogFile_'.$fileiteration.'" accept=".jpg,.jpeg,.png,.mp4" ogfile-position="'.$fileiteration.'"
                        ></label>';
                        echo'<img class="MediaVthumbnail preview" id="OgFilesPreview_'.$fileiteration.'">';
                        echo'<video position="'.$i.'" class="MediaV" width="240" height="240" controls>';
                        echo'<source filename="'.$vBlobarr['Name'][$i].'"  src="data:'.$vBlobarr['Mime'][$i].';base64,'.base64_encode($vBlobarr['Data'][$i]).'"></video>';
                        echo'<label style="color:red;"><input type="checkbox" id="Dfile_'.$fileiteration.'" value="dfiles">Eliminar Archivo?</label>';
                        echo '</div>';
                    }
                    ?>
                    <h3>Adjuntar Archivos a la noticia</h3>
                    <h4>tipos admitidos: jpg, png, mp4</h4>
                    <div id="FileAddDiv" style="border: solid 1px rgb(0,0,0); width:100%; height:fit-content;">
                    <button type="button" id="adjuntarFile"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                    <hr>
                    <input type="submit"class="btn btn-warning" name="ArticleSubmit" id="ArticleSubmit" value="Enviar" />
                    <input type="button"class="btn btn-warning" style="background-color:red; color:white;"name="ArticleSubmit" id="ArticleSubmit" value="Cancelar" onclick="window.history.go(-1); return false;" />  
                </form>
                </div>
            </div>
        </div>
        <footer>
        <div class="Derechos"> 2021 Todos los derechos reservados </div>
        <div class="Contactos"> Contacto: Tel:8118047600 Correo:Unote@gmail.com </div>
        <div class="Informacion"> Informacion Compañia | Privacion y Politica | Terminos y Condiciones </div>
    </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js\models\Notipapa.js"></script>
</body>