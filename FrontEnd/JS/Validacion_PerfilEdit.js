

//VALIDACION SECCIONES ALTA.................................................

$('#seccionval').submit(function (e) {
    var resultado = validarSECCIONALTA();
    if (resultado == false) {
        e.preventDefault();
    }
})

function validarSECCIONALTA() {

    $('.alert').remove();
    var secc = $('#SeccionAlta').val()
    var resultado = true;

    if (secc == "" || secc == null) {
        cambiarColor("SeccionAlta");
        mostrarAlertaVacioSecc("Campo obligatorio")
        resultado = false;

    } else {
        var lenght = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
        if (!lenght.test(secc)) {
            cambiarColor("SeccionAlta");
            mostrarAlerta_Secc("Por favor ingrese solo letras");
            resultado = false;
        }
    }

    return resultado;
}

function cambiarColor(dato) {
    $('#' + dato).css({
        border: "1px solid #dd5144"
    });
}


// ALTA SECCIONES ---------------------------------------------------------------------------

function mostrarAlertaVacioSecc(texto) {
    $('#SeccionAlta').before('<div class= "alert" > Error: ' + texto + '</div>')
}

function mostrarAlerta_Secc(texto) {
    $('#SeccionAlta').before('<div class= "alert" > Error: ' + texto + '</div>')
}

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
            'permission': 'E',
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

$('#btn_tools').on('click', function (e) {

    $('#btn_mod').toggle();
    $('#btn_cancel').toggle();
    $('.list_mod').toggle();
    $('#profile_pic_form').toggle();
    $('#banner_pic_form').toggle();

})

// ALTA REPORTEROS ---------------------------------------------------------------------------
function getJournalists() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {            
            'permission': 'E',
            'ajax_get_journalists': 1
        },

        success: function (response) {
            var data_array = $.parseJSON(response);
            var htmlJournalists = "";
            for(let key of data_array){
                if(key['JOURNALIST_STATUS'] == 'A' || key['JOURNALIST_STATUS'] == 'E'){
                    icon = key['JOURNALIST_ICON'];
                    if(icon == null)
                    icon = "../../Elementos/licpugberto.jpg";
                    htmlJournalists = htmlJournalists.concat('<div class="d-flex text-muted pt-3"><img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src='+icon+' role="img" aria-label="Placeholder:" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em"></text><div class="pb-3 mb-0 small lh-sm border-bottom w-100"><div class="d-flex justify-content-between"><strong value=' + key['ID_JOURNALIST']+ ' id="reportero_'+ key['ID_JOURNALIST']+ '"class="text-gray-dark">'+key['JOURNALIST_NAME']+'</strong><a href="javascript:VentanaBajaReportero('+ key['ID_JOURNALIST']+ ')" class="text-danger"><i class="fas fa-trash-alt"></i></a></div><span class="d-block">@'+key['JOURNALIST_ALIAS']+'</span></div></div>');
                }
            }
            
            $('#journalist_list').html(htmlJournalists);
            // $('#displayPhone').html('<i class="fas fa-phone-alt"></i> Telefono: +52'+phoneNumber);
            // $('#displayEmail').html('<i class="fas fa-envelope"></i> Email: '+email);
            // $('#displayAlias').html('<i class="fad fa-user-alt"></i> @'+nickname);
           console.log('obtuve los reporteros');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function getActiveRUsers() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {            
            'permission': 'E',
            'ajax_get_users': 1
        },

        success: function (response) {
            var data_array = $.parseJSON(response);
            var htmlRUsers = "";
            htmlRUsers = htmlRUsers.concat('<option value="N">Añade un Reportero...</option>');
            for(let key of data_array){
                if(key['USER_STATUS'] == 'A'){
                    htmlRUsers = htmlRUsers.concat('<option value='+ key['ID_USER']+'>@'+ key['USER_ALIAS']+': ' + key['USER_NAME']+'</option>');
                }
            }
            $('#state').html(htmlRUsers);
            // $('#displayPhone').html('<i class="fas fa-phone-alt"></i> Telefono: +52'+phoneNumber);
            // $('#displayEmail').html('<i class="fas fa-envelope"></i> Email: '+email);
            // $('#displayAlias').html('<i class="fad fa-user-alt"></i> @'+nickname);
           console.log('obtuve los usuarios registrados');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function setToRegisteredUser(id_journalist) {
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {            
            'permission': 'E',
            'ajax_set_registered_user': 1,
            'idUser':  id_journalist
        },
        success: function (response) {
            getJournalists();
            getActiveRUsers();
           console.log('Se convirtio en usuario registrado');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function setToJournalist() {
    var option = $("#state option:selected");
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {            
            'permission': 'E',
            'ajax_set_journalist': 1,
            'idUser':  option.val()
        },
        success: function (response) {
            getJournalists();
            getActiveRUsers();
           console.log('Se convirtio en reportero');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

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

$( document ).ready(function() {
    getJournalists();
    getActiveRUsers();
    $('#state').on("change", function(e){
       var valor = $("#state option:selected");
        console.log(valor.val());
        if(valor.val() != 'N'){
            $('#btn_add_journalist').toggle(true);
        }else{
            $('#btn_add_journalist').toggle(false);
        }
    });

})

