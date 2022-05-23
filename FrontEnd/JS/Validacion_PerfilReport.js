//VALIDACION PERFIL REPORTERO-----------------------------------------------------------------------


$('#datosusuario').submit(function(e){
    var resultado = validarFormularioUsuario();
    if(resultado == false){
        e.preventDefault();
    }

    })

//VALIDACIONES USUARIO
function validarFormularioUsuario(){

    $('.alert').remove();
    var
        correo =$('#examplecorreo').val(),
        pass =$('#examplecontra').val(),
        passCfrm =$('#exampleconfirmar').val(),
        name =$('#examplename').val(),
        username =$('#exampleusername').val(),
        tel =$('#exampletel').val()

        var resultado = true;

        normalColor("exampletel");
        normalColor("examplename");
        normalColor("exampleusername");
        normalColor("examplecorreo");
        normalColor("examplecontra");
        normalColor("exampleconfirmar");


        if(tel ==""||tel==null){
            cambiarColor("exampletel");
            mostrarAlerta_Form("exampletel", "Campo obligatorio");
            resultado = false;

        }else{
            var telef = /^([0-9][ -]*){10}$/;
            if(!telef.test(tel)){
                cambiarColor("exampletel");
                mostrarAlerta_Form("exampletel", "Por favor ingrese solo 10 numeros");
                resultado = false;

            }
        }

        if(username ==""||username==null){
            cambiarColor("exampleusername");
                mostrarAlerta_Form("exampleusername", "Campo obligatorio");
            resultado = false;
        }

        if(name ==""||name==null){
            cambiarColor("examplename");
                mostrarAlerta_Form("examplename", "Campo obligatorio");
            resultado = false;

        }else{
            var nombr = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
            if(!nombr.test(name)){
                cambiarColor("examplename");
                mostrarAlerta_Form("examplename", "Por favor ingrese solo letras");
                resultado = false;

            }
        }



        if(correo ==""||correo==null){
            cambiarColor("examplecorreo");
                mostrarAlerta_Form("examplecorreo", "Campo obligatorio");
            resultado = false;

        }else{
            var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            if(!mail.test(correo)){
                cambiarColor("examplecorreo");
                mostrarAlerta_Form("examplecorreo", "Por favor ingrese un correo valido");
                resultado = false;

            }
        }


        if(pass ==""||pass==null){
            cambiarColor("examplecontra");
                mostrarAlerta_Form("examplecontra", "Campo obligatorio");
            resultado = false;

        }else{
            var lenght =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
            if(!lenght.test(pass)){
                cambiarColor("examplecontra");
                mostrarAlerta_Form("examplecontra", "Ingrese una contraseña maximo 15 caracteres y minimo 8, 1 Mayuscula, 1 minuscula y un digito");
                resultado = false;
            }else if(pass != passCfrm){
                cambiarColor("exampleconfirmar");
                mostrarAlerta_Form("exampleconfirmar", "Las contraseñas no coinciden");
                resultado = false;

            }
        }



        return resultado;

}

//#region ACTUALIZAR PERFIL
//Actualizar la imagen de perfil en el HTML
$('#upload_profile_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#profile_pic").attr('src', fr.result);
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

//Actualizar la imagen de perfil en el HTML
$('#upload_banner_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#banner_pic").css('background-image', 'url(' + fr.result + ')');
            $('#exampleBPic').val(fr.result);

        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})

function updateProfile() {
    let idUser = $('#exampleid').val();
    let nickname = $('#exampleusername').val();
    let email = $('#examplecorreo').val();
    let pwd = $('#examplecontra').val();
    let name = $('#examplename').val();
    let phoneNumber = $('#exampletel').val();
    let pPicture = $('#examplePPic').val();
    let bPicture = $('#exampleBPic').val();
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {
            'idUser': idUser,
            'Nombre': nickname,
            'Correo': email,
            'Contraseña': pwd,
            'NombreComp': name,
            'telefono': phoneNumber,
            'pPic': pPicture,
            'bPic': bPicture,
            'permission': 'R',
            'ajax_update_profile': 1
        },

        success: function (response) {
            $('#displayFullName').html(name);
            $('#displayPhone').html('<i class="fas fa-phone-alt"></i> Telefono: +52 '+phoneNumber);
            $('#displayEmail').html('<i class="fas fa-envelope"></i> Email: '+email);
            $('#displayAlias').html('<i class="fad fa-user-alt"></i> @'+nickname);
           console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error updating profile')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la actualización");
        }
    })
}

function deactivateProfile() {
    let idUser = $('#exampleid').val();
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {
            'idUser': idUser,        
            'permission': 'R',
            'ajax_deactivate_profile': 1
        },

        success: function (response) {            
           console.log(response);
           window.location.replace(response);     
        },
        error: function (jqXHR, status, error) {
            alert('Error deleting profile')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la baja");
        }
    })
}

function deleteReport(reportId) {
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportIdT': reportId,
            'ajax_delete_report': 1
        },

        success: function (response) {
           
           console.log(response);
        },
        error: function (jqXHR, status, error) {
            
            alert('Error deleting report')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la eliminacion");
        }
    })
}

//#endregion

//OBTENER NOTICIAS
function getNewsReports() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_news_f_journalist': 1
        },

        success: function (response) {
            var htmlNews = "";
            var bottom = ''
           // console.log(response);
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    htmlNews = htmlNews.concat('<li class="item-a" ><div onclick="getReport('+ key['REPORT_NUMBER'] + ')" id="report_' + key['REPORT_NUMBER']  +'" class="caja_cursos"><img src="' + key['THUMBNAIL'] + '" style="width:350px; height:204px; object-fit:cover;" class="img_curso_cuadro" alt="curso 1"><div class="detalles_curso"> <h2 class="text-truncate">' + key['HEADER'] + '</h2>');

                    if (key['REPORT_STATUS'] == 'RR') {
                        bottom = '<p> En redacción </p> <a onclick="event.preventDefault(); event.stopPropagation(); getReport('+ key['REPORT_NUMBER'] + ', \'edit\')" href="#" class="text-white btn-outline-secondary mb-3"> <i class="fas fa-edit"> </i> </a> <a href="#" onclick="event.preventDefault(); event.stopPropagation(); Ventanamod('+ key['REPORT_NUMBER'] + ')" id="show-modal" class="text-white btn-outline-secondary mb-3"> <i class="fas fa-trash"> </i> </a>';                        
                    }

                    if (key['REPORT_STATUS'] == 'RA') {
                        bottom = '<p> En revisión por editor </p> <a href="#" class="text-white btn-outline-secondary mb-3"> <i class="fas fa-edit"> </i> </a>';                        
                    }

                    if (key['REPORT_STATUS'] == 'P') {
                        bottom = '<p> Publicada </p>';                        
                    }

                    htmlNews = htmlNews.concat(bottom, '</div></div></li>')
                }
            }
            $('#autoWidth').html(htmlNews);
            $('#autoWidth').lightSlider({
                autoWidth:true,
                loop:true,
                onSliderLoad: function() {
                    $('#autoWidth').removeClass('cS-hidden');
                } 
            });
            console.log('obtuve las noticias del reportero');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting news')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta de noticias");
        }
    })
}


//#region MISCELANEOS

$('#btn_tools').on('click', function (e) {

    $('#btn_mod').toggle();
    $('#btn_cancel').toggle();
    $('.list_mod').toggle();
    $('#profile_pic_form').toggle();
    $('#banner_pic_form').toggle();

})

function cambiarColor(dato){
    $('#'+ dato).css({
        border: "1px solid #dd5144"
    });
    }

function normalColor(dato){
   $('#'+ dato).css({
       border: "3px solid #3b055f"
        });
    }

function mostrarAlerta_Form(id, texto){
        $('#'+id).before('<div class= "alert" > Error: ' + texto +'</div>');
}
//#endregion

$(document).ready(function(){
    getNewsReports();
    
})