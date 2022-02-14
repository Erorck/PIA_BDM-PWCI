//VALIDACION PERFIL REPORTERO-----------------------------------------------------------------------


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
    

    function mostrarAlerta_VacioMail(texto){
        $('#examplecorreo').before('<div class= "alert" > Error: ' + texto +'</div>')
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