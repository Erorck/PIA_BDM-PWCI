
//VALIDACION SECCIONES ALTA.................................................

$('#seccionval').submit(function(e){
    var resultado = validarSECCIONALTA();
    if(resultado == false){
        e.preventDefault();
    }
    })
    
    function validarSECCIONALTA(){
    
        $('.alert').remove();
        var secc =$('#SeccionAlta').val()
            var resultado = true;

        if(secc ==""||secc==null){
            cambiarColor("SeccionAlta");
            mostrarAlertaVacioSecc("Campo obligatorio")
            resultado = false;
    
        }else{
            var lenght = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
            if(!lenght.test(secc)){
                cambiarColor("SeccionAlta");
                mostrarAlerta_Secc("Por favor ingrese solo letras");
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
    
    
    // ALTA SECCIONES ---------------------------------------------------------------------------
    

    function mostrarAlertaVacioSecc(texto){
        $('#SeccionAlta').before('<div class= "alert" > Error: ' + texto +'</div>')
    }

    function mostrarAlerta_Secc(texto){
        $('#SeccionAlta').before('<div class= "alert" > Error: ' + texto +'</div>')
    }