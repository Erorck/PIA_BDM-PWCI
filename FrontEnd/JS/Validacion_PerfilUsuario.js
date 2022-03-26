//VALIDACION PERFIL USUARIO-----------------------------------------------------------------------

function checkEmail() {
    let userId = $('#idUser').val();
}


//Actualizar la imagen de perfil en el HTML
$('#upload_profile_pic').on('change', function (evt){
    var tgt = evt.target || window.event.src,
    files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#profile_pic").attr('src',fr.result);
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
$('#upload_banner_pic').on('change', function (evt){
    var tgt = evt.target || window.event.src,
    files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#banner_pic").css('background-image', 'url('+ fr.result +')');
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


function updateProfileImage() {
    let image = $("#upload_profile_pic").val();
    $.ajax({
        url: '../includes/image_inc.php',
        type: 'post',
        data: {'imageData': image, 'ajax_submit': 1},

        success: function (response) {

            console.log(response);
            $("#profile_pic").attr('src',response);
            alert('Se actualizo la imagen: ' + image);

        },
        error: function (jqXHR, status, error) {
            alert('Error al actualizar la imagen');
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se intento");
        }
    })
}


$('#datosusuario').submit(function(e){
    var resultado = validarFormularioUsuario();
    if(resultado == false){
        e.preventDefault();
    }
    
    })
    
    function validarFormularioUsuario(){
    
        $('.alert').remove();
        var
            correo =$('#examplecorreo').val(),
            pass =$('#examplecontra').val(),
            name =$('#examplename').val(),
            tel =$('#exampletel').val()
    
            var resultado = true;

            normalColor("exampletel");
            normalColor("examplename");
            normalColor("examplecorreo");
            normalColor("examplecontra");


            if(tel ==""||tel==null){
                cambiarColor("exampletel");
                mostrarAlerta_VacioTel("Campo obligatorio")
                resultado = false;
        
            }else{
                var telef = /^([0-9][ -]*){10}$/;
                if(!telef.test(tel)){
                    cambiarColor("exampletel");
                    mostrarAlertaTel("Por favor ingrese solo 10 numeros");
                    resultado = false;
        
                }
            }
           
            
        if(name ==""||name==null){
            cambiarColor("examplename");
            mostrarAlerta_VacioName("Campo obligatorio")
            resultado = false;
    
        }else{
            var nombr = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
            if(!nombr.test(name)){
                cambiarColor("examplename");
                mostrarAlertaName("Por favor ingrese solo letras");
                resultado = false;
    
            }
        }



        if(correo ==""||correo==null){
            cambiarColor("examplecorreo");
            mostrarAlerta_VacioMail("Campo obligatorio")
            resultado = false;
    
        }else{
            var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
            if(!mail.test(correo)){
                cambiarColor("examplecorreo");
                mostrarAlertaCorreo("Por favor ingrese un correo valido");
                resultado = false;
    
            }
        }
        

        if(pass ==""||pass==null){
            cambiarColor("examplecontra");
            mostrarAlerta_VacioPass("Campo obligatorio")
            resultado = false;
    
        }else{
            var lenght =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
            if(!lenght.test(pass)){
                cambiarColor("examplecontra");
                mostrarAlertapass("Ingrese una contraseña maximo 15 caracteres y minimo 8, 1 Mayuscula, 1 minuscula y un digito");
                resultado = false;
            }
        }
       


        return resultado;
    
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
    
        
    function mostrarAlerta_VacioMail(texto){
        $('#examplecorreo').before('<div class= "alert" > Error: ' + texto +'</div>');
    }
    
    function mostrarAlerta_VacioName(texto){
        $('#examplename').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlerta_VacioPass(texto){
        $('#examplecontra').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlerta_VacioTel(texto){
        $('#exampletel').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    


    function mostrarAlertaName(texto){
        $('#examplename').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertaCorreo(texto){
        $('#examplecorreo').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertapass(texto){
        $('#examplecontra').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertaTel(texto){
        $('#exampletel').before('<div class= "alert" > Error: ' + texto +'</div>')
    }