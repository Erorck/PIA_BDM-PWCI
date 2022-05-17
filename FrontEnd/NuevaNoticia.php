<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Categorias =[];
    $Perfil = null;
    $LoggedUser = false;
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        if((strcmp($Perfil->USER_TYPE,'AD')!==0) && (strcmp($Perfil->USER_TYPE,'RE')!==0)){
            header('Location: '.'403.html');
        }
    }
    else{
        header('Location: '.'403.html');
    }
    $str = file_get_contents('data/EstadosMexico.json');
    $estadosjson = json_decode($str,true);
    $estadosjson['Estados'] = strtoupper($estadosjson['Estados']);
    $Estados = explode(" ",$estadosjson['Estados']);
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
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="css/styles.css" >
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script  type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
      <script  type="text/javascript" src="js/models/validations.js" ></script>
      <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript">
            var blobImg = null;
            var blobfilesarr = [];
            var b64img = "";
            var totalfiles = 0;
            async function loadDefThumbnail(){
                blobImg = await fetch('media/img/defArtThumb.jpg').then(r => r.blob())
                .then(blobImg => new File([blobImg], "defArtThumb.jpg", { type: "image/jpeg" }));
                defthumbnailtob64str(blobImg);
            }

            function  defthumbnailtob64str(blobImg){
                var reader  = new FileReader();
                reader.onloadend = function(){
                    b64img = reader.result;
                }
                if(blobImg){
                    reader.readAsDataURL(blobImg);
                }
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
                    return blobfile;
                } 
                else{
                    preview.src = preview.src;
                }
            }

            function addFileInput(){
                $('#FileAddDiv').append('<hr>');
                totalfiles ++;
                subPrevStr = '<img class = "preview" id="subPreview_'+totalfiles+'"src="media/img/papas.jpg" alt="Thumbnail Image">';
                inputStr = '<input class="AdjuntedFile" type="file" id="AddedFile_'+totalfiles+'" onchange="blobfilesarr.push(previewFile(document.querySelector(\'#subPreview_'+totalfiles+'\'),document.querySelector(\'#AddedFile_'+totalfiles+'\').files[0]))" name="File_'+totalfiles+'" accept=".jpg,.jpeg,.png,.mp4" file-position="'+totalfiles+'"/>';
                $('#FileAddDiv').append(inputStr);
                $('#FileAddDiv').append(subPrevStr);
            } 

            $(document).ready(function() { 
            loadDefThumbnail();
            var d = new Date();
            var month = d.getMonth()+1;
            var strmonth = "";
            month >= 10 ? (strmonth = month.toString()) : (strmonth = '0'+month.toString());
            //TAMBIEN DESPUES CONTINUAR CON LA VALIDACION DEL FORM Y hacer el PHP PARA EL INSERT va?
            var strDate = d.getFullYear() + "-" + strmonth + "-" + d.getDate() + "T23:59";
            $('#dtp').val(strDate);
            $('#adjuntarFile').click(function(){
                addFileInput();
            });
            $('#ArticleForm').submit(function(e){
                e.preventDefault();
                var formData = new FormData();
                formData.append('image', blobImg);  //append thumbnail
                for(var i = 0; i < blobfilesarr.length;i++){
                    //añadimos al Form data los archivos adjuntados
                    formData.append('Files[]', blobfilesarr[i]); 
                    debugger;
                }
                debugger;
                var aux ={};
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
                    formData.append('FilesCount', blobfilesarr.length);
                    $.ajax({
                        type: "POST",
                        url: "AddArticleScript.php",
                        data: formData, 
                        cache: false,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,   // tell jQuery not to set contentType
                        success: function(response){
                            debugger;
                            var jsonData = JSON.parse(response);
                            if (jsonData.success == "1")
                            {
                                swal.fire('El Articulo se ha subido para su revision por el editor!');
                                location.href = 'Main.php';
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
            <a href="index.php">Volver Al Indice</a>
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
                <h1  style="font-family:sans-serif; font-weight:bolder;" >Nuevo Articulo</h1>
                <form id="ArticleForm" method="post" name ="ArticleForm" autocomplete="off">
                    <label >Categoria del Articulo:</label>
                    <select class="form-control" id="SelCateg" name="SelCateg" placeholder="Categoria">
                        <option value="PENDING">Dejar Que el Editor Decida</option>
                        <?php
                        foreach($Categorias as $Categ){
                            echo'<option class="Categ" value="'.$Categ->name.'" style="background-color:#'.$Categ->color.'">'.$Categ->name.'</option>';
                        }
                        ?>
                    </select>
                    <label for="eventDate">Fecha y Hora del Acontecimiento:</label>
                    <input type="datetime-local" class="form-control" id='dtp' name="eventDate" />
                    <label >Direccion del Acontecimiento:</label>
                    <div id="DirArt">
                    <input class="form-control" type="text" id="calle" name="calle" placeholder="CALLE">
                    <input class="form-control" type="text" id="colonia" name="colonia" placeholder="COLONIA">
                    <input class="form-control" type="text" id="municipio" name="municipio" placeholder="MUNICIPIO">
                    <input class="form-control" type="text" id="estado" name="estado" placeholder="ESTADO">
                    <select class="form-control" id="SelCountry" name="SelCountry" placeholder="Pais">
                        <?php
                        foreach($countries as $country){
                            echo'<option value="'.$country.'">'.$country.'</option>';                        }
                        ?>
                    </select>
                    </div>
                    <label >Articulo:</label>
                    <input class="form-control" type="text" id="header" name="header" placeholder="ENCABEZADO">
                    <input class="form-control" type="text" id="desc" name="desc" placeholder="SUBTITULO">
                    <textarea class="form-control" rows="10" cols="93"id="content" name="content" placeholder="CUERPO/CONTENIDO"></textarea>
                    <label >Miniatura Noticia:</label>
                    <div id="ArtTh">
                    <input type='file' id="imageFile" onchange="blobImg = previewFile(document.querySelector('#preview'),document.querySelector('#imageFile').files[0])" name="thumbnail" accept=".jpg,.jpeg,.png*"/><img class = "preview" id="preview" src="media/img/defArtThumb.jpg" alt="Thumbnail Image">
                    </div>
                    <label >Firma del Reportero:</label>
                    <input class="form-control" type="text" id="sign" name="sign" placeholder="firma">
                    <hr>
                    <h3>Adjuntar Archivos a la noticia</h3>
                    <h4>tipos admitidos: jpg, png, mp4</h4>
                    <div id="FileAddDiv" style="border: solid 1px rgb(0,0,0); width:100%; height:fit-content;">
                    <button type="button" id="adjuntarFile"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                    <br>
                    <input type="submit"class="btn btn-warning" name="ArticleSubmit" id="ArticleSubmit" value="Enviar" /> 
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