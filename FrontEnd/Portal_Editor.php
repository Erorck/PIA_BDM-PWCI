<?php
    require 'connection.php';
    require 'User.php';
    session_start();
    $datarray = []; 
    $Categorias =[];
    $Perfil = null;
    $LoggedUser = false;
    $numArticles = $numRRArticles = $numRAArticles = $numPUArticles = 0;
    $ArticlesExist = $ArticlesRRExist = $ArticlesRAExist = $ArticlesPUExist = false;
    $ArticulosRR = [];
    if(connection::GetCategories($datarray)){
        foreach($datarray as $cat){
        $categ = new Categoria($cat);
        array_push($Categorias,$categ);
        }
    }
    if(isset($_SESSION['islogged']) && $_SESSION['islogged']){
        $LoggedUser = true;
        $Perfil = $_SESSION['DataUser'];
        if(strcmp($Perfil->USER_TYPE,'AD')!==0){
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
    if($ArticlesRRExist)
    {
        if(connection::GetArticles($datarray)){
            foreach($datarray as $art){
            $arti = new Articulo($art);
            if($arti->ARTICLE_STATUS === 'RR')array_push($ArticulosRR,$arti);
            }
        }
        // para ponerlos en la lista de articulos pendientes de revision paps
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Para aceptar todas las letras-->
    <title>Portal Editor</title>
    <link rel="stylesheet" href="css/styles.css" >
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="js/libs/jquery-3.6.0.min.js" ></script>
    <script type="text/javascript" src= "js/libs/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/models/validations.js" ></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/libs/jscolor.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var nCategCap = 0; // para que no se pueda añadir/editar mas de una categoria a la vez
            var shouldReorder = false; //para validar el reorder de las cosas
            $( "#sortable" ).sortable(); //para activar el ui del sortable del reorder  
            $("#reorderzone").hide(); //para esconder el ui del reorder
            var auxCategEdit = null; //auxiliar para guardar el Elemento de la categoria como texto, si se va a editar
            var auxCategEditId = null;
            var Editing = false; //booleano para saber si actualmente estamos editando una categoria o no

            //utilidades
            const rgb2hex = (rgb) => `#${rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/).slice(1).map(n => parseInt(n, 10).toString(16).padStart(2, '0')).join('')}`

            ////////////////////////////////////
            //        Editar Orden Categorías
            ////////////////////////////////////
            $('.ChBox_EditOrder').click(function(){
                let dynbtnAdderA = '<button style="background-color: #000000;" class="btn_saveNcateg" id="btn_ReorderConfirm"><i class="fa fa-floppy-o" aria-hidden="true">Guardar</i></button>';
                let dynbtnAdderB = '<button style="background-color: #000000;" class="btn_cancelCateg" id="btn_ReorderCancel"><i class="fa fa-times-circle" aria-hidden="true">Cancelar</i></button>';
                finalstring = dynbtnAdderA.concat(dynbtnAdderB);
                if ($('input.ChBox_EditOrder').prop('checked')) {
                    shouldReorder = true;
                    $("#reorderzone").toggle();
                    $('#CategsToShow').toggle();  
                    $('#btnAddCateg').toggle();
                    $( "#reorderzone" ).append(finalstring);
                } else{
                    shouldReorder = false;
                    $("#reorderzone").toggle();
                    $('#CategsToShow').toggle(); 
                    $('#btnAddCateg').toggle(); 
                    $( "#btn_ReorderConfirm" ).remove();
                    $( "#btn_ReorderCancel" ).remove();
                }
            });

            $('#reorderzone').on('click','#btn_ReorderConfirm',function(e) {
                Swal.fire({  
                    title: 'Guardar el Nuevo Orden de las Categorías??',  
                    showDenyButton: true,  showCancelButton: false,  
                    confirmButtonText: `Confirmar Nuevo Orden`,  
                    denyButtonText: `Cancelar Nuevo Orden`,
                }).then((result) => {  
                    /* Read more about isConfirmed, isDenied below */  
                    if (result.isConfirmed) {    
                        let i = 0;
                        let nOrdrArr = [];
                        $('#reorderzone > #sortable > li').each(function(e) {
                            let nombre = $(this).children(['namefieldyn']).attr('value');
                            let newOrderObj ={};
                            newOrderObj['nombre'] = nombre.toString();
                            newOrderObj['orden'] = i;
                            nOrdrArr.push(newOrderObj);
                            i++;
                        });
                        if(nOrdrArr.length > 0){
                            console.log(nOrdrArr); //Arreglo con el nuevo Orden
                            //Ajax and shit
                            var jsonString = JSON.stringify(nOrdrArr);
                            $.ajax({
                                type: "POST",
                                url: "CategReorderScript.php",
                                data: {data : jsonString}, 
                                cache: false,
                                success: function(response){
                                    var jsonData = JSON.parse(response);
                                    if (jsonData.success == "1")
                                    {
                                        swal.fire('OrdenActualizado');
                                        location.href = 'Portal_Editor.php';
                                    }
                                    else{ alert('Error de algun tipo')}
                                }
                            });
                        }
                    } else if (result.isDenied) {    
                        Swal.fire('Aki no Paso nada', '', 'info')
                    }
                });
            });

            $('#reorderzone').on('click','#btn_ReorderCancel',function(e) {
                shouldReorder = false;
                $('input.ChBox_EditOrder').prop("checked", false);
                $("#reorderzone").toggle();
                $('#CategsToShow').toggle(); 
                $('#btnAddCateg').toggle(); 
                $( "#btn_ReorderConfirm" ).remove();
                $( "#btn_ReorderCancel" ).remove();
            });
            ////////////////////////////////////
            //        Añadir  Categorías
            ////////////////////////////////////
            $('#btnAddCateg').click(function() {
                $('.ChBox_EditOrder').toggle();
                $('#btnAddCateg').toggle();
                if(nCategCap < 1){
                    nCategCap ++;
                    let dynCategAdderA = '<h3 class="Categ" id="AddCategH3" style="background-color:#353A34;">';
                    let dynCategAdderX = '<form id="AddCategForm" method="post" name ="F_AddCateg">'
                    let dynCategAdderB = '<input type="text" style="text-transform:uppercase"  id="CategNameIn" name="CategName" placeholder="Nueva Categoria">';
                    let dynCategAdderC = 'COLOR: <input data-jscolor="{}" value="#353A34" id="CategColorIn" name="CategColor">';
                    let dynCategAdderD = '<button type="submit" class="btn_saveNcateg" id="btn_saveNcateg"><i class="fa fa-floppy-o" aria-hidden="true">Guardar</i></button>';
                    let dynCategAdderY = '<button class="btn_cancelCateg" id="btn_cancelCateg"><i class="fa fa-times-circle" aria-hidden="true">Cancelar</i></button>';
                    let dynCategAdderE = '</form></h3>';
                    let finalstring = dynCategAdderA.concat(dynCategAdderX,dynCategAdderB,dynCategAdderC,dynCategAdderD,dynCategAdderY,dynCategAdderE);
                    $( "#ZonaCategAdd" ).append(finalstring);
                    jscolor.install(); 
                }
            });

            $('#ZonaCategAdd').on('click','#btn_cancelCateg',function(e) {
                $('.ChBox_EditOrder').toggle();
                $('#btnAddCateg').toggle();
                if(nCategCap>=1){
                $('#AddCategH3').remove();    
                nCategCap --;
                }
            });

            $('#ZonaCategAdd').on('submit','#AddCategForm',function(e) {
                e.preventDefault();
                let val = $('#CategNameIn').val();
                if(!val.length > 0) swal.fire('Favor de Insertar un Nombre Para la Categoria','','error');
                else
                $.ajax({
                    type: "POST",
                    url: 'AddCategScript.php',
                    data: $(this).serialize(),
                    success: function(response)
                    {
                        debugger;
                        var jsonData = JSON.parse(response);
                        // user is logged in successfully in the back-end
                        // let's redirect
                        if (jsonData.success == "1")
                        {
                            Swal.fire('Categoria Añadida Con Exito').then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire('Recargando Pagina');
                                    location.href = 'Portal_Editor.php';
                                }
                                else location.href = 'Portal_Editor.php';
                            });
                        }
                        else
                        {
                            swal.fire('Favor de Insertar un Nombre Para la Categoria','','error')
                        }
                    }
                });
            });
            ////////////////////////////////////
            //        Editar Categoría
            ////////////////////////////////////
            $('#CategsToShow').on('click','.btn_editCateg',function(){
                $('.ChBox_EditOrder').toggle();
                $('#btnAddCateg').toggle();
                if(!Editing){
                    var Categ = $(this).parent();
                    auxCategEdit = Categ.prop('outerHTML');
                    auxCategEditId = Categ.attr('id')
                    Editing = true;
                    let color = Categ.css('background-color');
                    let hexcolor = rgb2hex(color);
                    let name = Categ.attr('id')
                    let dynCategAdderA = '<h3 class="Categ" id="EditCategH3" style="background-color:' + hexcolor.toString() + '">';
                    let dynCategAdderB = '<input type="text" style="text-transform:uppercase"  id="CategNameIn" name="CategName" value="'+ name +'">';
                    let dynCategAdderC = 'COLOR: <input data-jscolor="{}" value="' + hexcolor.toString() + '" id="CategColorIn" name="CategColor">';
                    let dynCategAdderD = '<button type="button" class="btn_confirmEditcateg" id="btn_confirmEditcateg"><i class="fa fa-floppy-o" aria-hidden="true">Guardar</i></button>';
                    let dynCategAdderY = '<button class="btn_cancelEditCateg" id="btn_cancelEditCateg"><i class="fa fa-times-circle" aria-hidden="true">Cancelar</i></button>';
                    let dynCategAdderE = '</h3>';
                    let finalstring = dynCategAdderA.concat(dynCategAdderB,dynCategAdderC,dynCategAdderD,dynCategAdderY,dynCategAdderE);
                    Categ.replaceWith(finalstring);
                    jscolor.install(); 
                }
                else{
                    Swal.fire('Porfavor termine de editar la Categoria o cancele su edicion antes de editar otra');
                }
            });

            $('#CategsToShow').on('click','#btn_cancelEditCateg',function(e){
                e.preventDefault();
                $(this).parent().replaceWith(auxCategEdit);
                Editing = false;
                auxCategEdit = null;
                auxCategEditId = null;
                $('.ChBox_EditOrder').toggle();
                $('#btnAddCateg').toggle();
            });

            $('#CategsToShow').on('click','#btn_confirmEditcateg',function(e){
                e.preventDefault();
                if(Editing){
                    var Cat = $(this).parent();
                    let CatEdited ={};
                    CatEdited['clave'] = auxCategEditId;
                    CatEdited['nombre'] = Cat.children('#CategNameIn').val().toString();
                    CatEdited['color'] = Cat.children('#CategColorIn').val().toString();
                    if(!(CatEdited['nombre'] == "" && CatEdited['color'] != " "))
                    {
                    //do ajax shit here
                        var jsonString = JSON.stringify(CatEdited);
                        $.ajax({
                            type: "POST",
                            url: "EditCategScript.php",
                            data: {data : jsonString}, 
                            cache: false,
                            success: function(response){
                                debugger;
                                var jsonData = JSON.parse(response);
                                if (jsonData.success == "1")
                                {
                                    swal.fire('Orden Actualizado');
                                    location.href = 'Portal_Editor.php';
                                }
                                else{ alert('Error de Algun Tipo')}
                            }
                        });
                    } else Swal.fire('Inserte un nombre valido para la categoría');
                }
            });

        });
    </script>
</head>
<body>
    <div class="Contenedor-base">
    <div class ="topAnclado">
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
            
        </div>

        <div class="mainContenedor">
            <div class="ZonaFeedPortal">
                <hr>
                <div id="E_Portal_Categ_Div">
                    <h2>SECCIONES DEL BOLETIN:</h2> 
                    <?php
                    if(count($Categorias)>0)
                        echo'<input type="checkbox" class="ChBox_EditOrder" name="EditOrder">
                        <label for="EditOrder">Cambiar Orden de las Categorías</label><br>';
                    ?>
                    <div id="reorderzone">
                    <h3 class="CoolWhiteText" id="reorderInstructions">Arrastra Las categorias para reordenarlas</h3>
                    <ul id="sortable">
                    <?php
                    if(count($Categorias)>0)
                        foreach ($Categorias as $x ) {
                                echo '<li class="ui-state-default" style="background-color:#'.$x->color.';">' . $x->name . '<input type="hidden" class="namefieldyn" name="'. $x->name .'_name" value="'. $x->name.'"><input type="hidden" class="orderfieldyn" name="'. $x->name .'_Order" value="'. $x->order.'"></li>';
                        }
                    ?>
                    </ul>
                    </div>
                    <div id="CategsToShow">
                        <?php
                        if(count($Categorias)>0){
                         foreach ($Categorias as $x ) {
                            echo '<h3 class="Categ" id="' . $x->name . '" style="background-color:#'.$x->color.';">' . $x->name . '<button class="btn_editCateg"><i class="fa fa-pencil" aria-hidden="true"></i></button>  </h3>';
                        }
                        }
                        else{
                         echo'<h3>Aun No Hay Categorias en el Boletin<h3>';  
                        }
                        ?>
                    </div>
                    <div id="ZonaCategAdd">
                    </div>
                    <button id="btnAddCateg"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
                <hr>
                <div id="E_Portal_PendArticles_Div">
                <h2 >NOTICIAS PENDIENTES DE REVISION:</h2>
                
                <?php
                if(!$ArticlesRRExist) echo'<h3>No hay noticias pendientes</h3>';
                else{
                    $ImgBlob = Null;
                    echo'<h4>Hay <span style="background-color: #9d0e28; color:white;" >'.$numRRArticles.'</span> Articulos pendientes de Revision</h4>';
                    for($i=0;$i<(count($ArticulosRR));$i++){
                        //display Article
                        echo "<div class='ZonaNoticia'>";
                        if(connection::GetImageArticle($ArticulosRR[$i]->ARTICLE_ID,$ImgBlob)){
                            echo'<div class="imgZone"> 
                            
                            <img src="data:'.$ImgBlob['mime'].';base64,'.base64_encode($ImgBlob['data']).'" alt="thumbnail">
                            </div>';
                        }
                        echo'<div class="TxtZone">
                            <h1 class="txtTitulo">'.$ArticulosRR[$i]->ARTICLE_HEADER.'</h1>
                            <p class="txtFecha">'.$ArticulosRR[$i]->EVENT_DATE.'<p>
                            <p class="txtDesc">
                            '.$ArticulosRR[$i]->ARTICLE_DESCRIPTION.'
                            </p>
                            </div>';
                        echo "</div>";
                    }
                }
                /* DEPRECATED DEMO CODE.
                    for ($row = 0; $row < count($ArticulosRR); $row++) {
                        echo "<div class='ZonaNoticia'>";
                        echo'<div class="imgZone"> <img src="'.$ArticulosRR[$row][3].'" alt="ImagenNoticia"></div>
                            <div class="TxtZone">
                            <h1 class="txtTitulo">'.$ArticulosRR[$row][0].'</h1>
                            <p class="txtFecha">'.$ArticulosRR[$row][1].'<p>
                            <p class="txtDesc">
                            '.$ArticulosRR[$row][2].'
                            </p>
                            </div>';
                        echo "</div>";
                      }
                      */
                ?>  
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
</html>