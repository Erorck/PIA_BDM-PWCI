// VALIDACION CREAR NOTICIA---------------------------------

$('#crearNoticia').submit(function (e) {
    var resultado = validarFormularioNoticia();
    if (resultado == false) {
        e.preventDefault();
    }
})

function validarFormularioNoticia() {

    $('.alert').remove();
    var titulo = $('#titulo').val(),
        firma = $('#firma').val(),
        descrip = $('#descrip').val(),
        text = $('#Texto').val(),
        sttr = $('#address').val(),
        col = $('#address2').val(),
        city = $('#address3').val(),
        pais = $("#country option:selected"),
        secc = $('#section_list_rad input[type=checkbox]:checked'),
        date = $('#Fecha').val()


    var resultado = true;

    normalColor("titulo");
    normalColor("firma");
    normalColor("descrip");
    normalColor("Texto");
    normalColor("address");
    normalColor("address2");
    normalColor("address3");
    normalColor("country");
    normalColor("Fecha");


    if (titulo == "" || titulo == null) {
        cambiarColor("titulo");
        mostrarAlerta_Form("titulo", "Campo obligatorio")
        resultado = false;
    }

    if (firma == "" || firma == null) {
        cambiarColor("firma");
        mostrarAlerta_Form("firma", "Campo obligatorio")
        resultado = false;
    }

    if (descrip == "" || descrip == null) {
        cambiarColor("descrip");
        mostrarAlerta_Form("descrip", "Campo obligatorio")
        resultado = false;

    }

    if (text == "" || text == null) {
        cambiarColor("Texto");
        mostrarAlerta_Form("Texto", "Campo obligatorio")
        resultado = false;

    }

    if (sttr == "" || sttr == null) {
        cambiarColor("address");
        mostrarAlerta_Form("address", "Campo obligatorio")
        resultado = false;

    }

    if (col == "" || col == null) {
        cambiarColor("address2");
        mostrarAlerta_Form("address2", "Campo obligatorio")
        resultado = false;

    }

    if (city == "" || city == null) {
        cambiarColor("address3");
        mostrarAlerta_Form("address3", "Campo obligatorio")
        resultado = false;

    } else {
        var ciud = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
        if (!ciud.test(city)) {
            cambiarColor("address3");
            mostrarAlerta_Form("address3", "Por favor ingrese solo letras");
            resultado = false;

        }
    }

    if (pais.val() == "" || pais.val() == null || pais.val() == "N") {
        cambiarColor("country");
        mostrarAlerta_Form("country", "Seleccione el país")
        resultado = false;

    }

    if (secc.length <= 0) {
        mostrarAlerta_Form("section_list_rad", "Seleccione al menos una sección")
        resultado = false;

    }

    if (date == "" || date == null) {
        cambiarColor("Fecha");
        mostrarAlerta_Form("Fecha", "Campo obligatorio")
        resultado = false;

    }
    return resultado;
}

//#region Imagenes y videos
//Actualizar la imagen de PORTADA en el HTML
$('#upload_banner_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#banner_pic").attr('src', fr.result);
            $('#examplePPic').val(fr.result);
        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})

//Agregar una imagen extra en el HTML
$('#upload_extra_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        var htmlExtraImg = "";       
        fr.onload = function () {

            var extraImgList = $('.extra_img_list').children();
            var idImagen = genRanHex(7);
            var idImg = "'"+ idImagen + "'";
            htmlExtraImg = htmlExtraImg.concat('<div class="' + idImagen + ' extra_img_container d-flex justify-content-start" >  <img src="' + fr.result + '" alt="Media Cont" id="FotografiadeCurso" class=" fotoCurso  mb-2" > </div>');


            if (extraImgList.length <= 0) {
                $('.extra_img_list').html(htmlExtraImg);
            } else
                extraImgList.last().after(htmlExtraImg);


            htmlExtraImg = "";
            htmlExtraImg = htmlExtraImg.concat('<img src="../../Elementos/1200px-Flat_cross_icon.svg.png" style=" width:30px;" class="fotoCurso delete-icon align-middle bottom top mb-2" onclick="VentanaBajaImagenTemp(' + idImg + ')">');
            $('.extra_img_list').children().last().children().last().after(htmlExtraImg);


            var extraImgArray = $('#extra_img_array').children();
            var inputExtraImg = ' <input class="'+ idImagen + '" hidden="true" value="' + fr.result + '"></input>';

            if (extraImgArray.length <= 0) {
                $('#extra_img_array').html(inputExtraImg);
            } else
             extraImgArray.last().after(inputExtraImg);
           
            $('#exampleEPic').val(fr.result);
        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})

//Agregar un video extra en el HTML
$('#upload_extra_vid').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        var htmlExtraVid = "";       
        fr.onload = function () {

            var extraVidList = $('.extra_vid_list').children();
            var idVideo = genRanHex(7);
            var idVid = "'"+ idVideo + "'";
            htmlExtraVid = htmlExtraVid.concat('<div class="' + idVideo + ' extra_vid_container d-flex justify-content-start"> <video class="mb-2" width="220" height="150" controls><source src="' + fr.result + '" type="video/mp4"> Your browser does not support the video tag.</video>  </div>');


            if (extraVidList.length <= 0) {
                $('.extra_vid_list').html(htmlExtraVid);
            } else
            extraVidList.last().after(htmlExtraVid);

            htmlExtraVid = "";
            htmlExtraVid = htmlExtraVid.concat('<img src="../../Elementos/1200px-Flat_cross_icon.svg.png" style=" width: 30px;" class="fotoCurso delete-icon align-top mb-2 bottom top" onclick="VentanaBajaVideoTemp(' + idVid + ')">');
            $('.extra_vid_list').children().last().children().last().after(htmlExtraVid);


            var extraVidArray = $('#extra_vid_array').children();
            var inputExtraVid = ' <input class="'+ idVideo + '" hidden="true" value="' + fr.result + '"></input>';

            if (extraVidArray.length <= 0) {
                $('#extra_vid_array').html(inputExtraVid);
            } else
            extraVidArray.last().after(inputExtraVid);
           
        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})

//#endregion

//#region MISCELANEOS

function cambiarColor(dato) {
    $('#' + dato).css({
        border: "1px solid #dd5144"
    });
}

function normalColor(dato) {
    $('#' + dato).css({
        border: "solid #3b055f"
    });
}

$("td").hover(
    function () {
        $(this).addClass("hover");
    },
    function () {
        $(this).removeClass("hover");
    }
);

function mostrarAlerta_Form(id, texto) {
    $('#' + id).before('<div class= "alert" > Error: ' + texto + '</div>');
}

const genRanHex = size => [...Array(size)].map(() => Math.floor(Math.random() * 16).toString(16)).join('');

//#endregion