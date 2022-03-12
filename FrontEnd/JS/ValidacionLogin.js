// VALIDACION CAMPOS LOGIN -------------------------------------------
$('#login').submit(function(e){
var resultado = validarFormularioLogin();
if(resultado == false){
    e.preventDefault();
}

})

function validarFormularioLogin(){

    $('.alert').remove();
    var correo =$('#correo').val(),
        pass =$('#contra').val();

        var resultado = true;
    if(correo ==""||correo==null){
        cambiarColor("correo");
        mostrarAlertaVacioMail("Campo obligatorio")
        resultado = false;

    }else{
        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if(!expresion.test(correo)){
            cambiarColor("correo");
            mostrarAlertaCorreo("Por favor ingrese un correo valido");
            resultado = false;

        }
    }

    if(pass ==""||pass==null){
        cambiarColor("contra");
        mostrarAlertaVacioPass("Campo obligatorio")
        resultado = false;
    }
    // else{
    //     var lenght =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
    //     if(!lenght.test(pass)){
    //         cambiarColor("contra");
    //         mostrarAlertapass("Ingrese una contraseña de 8-15 caracteres. Debe contener 1 mayúscula, 1 minúscula, 1 número y un carater especial [$@$!%*?&]");
    //         resultado = false;
    //     }
    // }

    
    return resultado;

}

function cambiarColor(dato){
    $('#'+ dato).css({
        border: "1px solid #dd5144"
    });
    }
//-------------------------------

function mostrarAlertaVacioMail(texto){
    $('#correo').before('<div class= "alert" > Error: ' + texto +'</div>')
}

function mostrarAlertaVacioPass(texto){
    $('#contra').before('<div class= "alert" > Error: ' + texto +'</div>')
}

function mostrarAlertaCorreo(texto){
    $('#correo').before('<div class= "alert" > Error: ' + texto +'</div>')
}

function mostrarAlertapass(texto){
    $('#contra').before('<div class= "alert" > Error: ' + texto +'</div>')
}