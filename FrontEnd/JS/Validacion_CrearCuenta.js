
//VALIDACION CREAR CUENTA -----------------------------------------------------------------------


$('#crearcuent').submit(function(e){
    var resultado = validarFormularioCuenta();
    if(resultado == false){
        e.preventDefault();
    }
    
    })
    
    function validarFormularioCuenta(){
    
        $('.alert').remove();
        var correo =$('#correo').val(),
            pass =$('#contra').val(),
            name =$('#name').val(),
            passC =$('#contraConfirm').val();

    
            var resultado = true;
        
            
        if(name ==""||name==null){
            cambiarColor("name");
            mostrarAlertaVacioName("Campo obligatorio")
            resultado = false;
    
        }else{
            var nombr = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
            if(!nombr.test(name)){
                cambiarColor("name");
                mostrarAlertaName("Por favor ingrese solo letras");
                resultado = false;
    
            }
        }

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
    
        }else{
            var lenght =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
            if(!lenght.test(pass)){
                cambiarColor("contra");
                mostrarAlertapass("Ingrese una contraseña maximo 15 caracteres y minimo 8, 1 Mayuscula, 1 minuscula y un digito");
                resultado = false;
            }else if (pass != passC){
                cambiarColor("contraConfirm");
                mostrarAlertapassConfirm("Las contraseñas no coinciden");
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



    function mostrarAlertaVacioName(texto){
        $('#name').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertaVacioMail(texto){
        $('#correo').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertaVacioPass(texto){
        $('#contra').before('<div class= "alert" > Error: ' + texto +'</div>')
    }


    function mostrarAlertaName(texto){
        $('#name').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertaCorreo(texto){
        $('#correo').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    
    function mostrarAlertapass(texto){
        $('#contra').before('<div class= "alert" > Error: ' + texto +'</div>')
    }

    function mostrarAlertapassConfirm(texto){
        $('#contraConfirm').before('<div class= "alert" > Error: ' + texto +'</div>')
    }
    