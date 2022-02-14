
// VALIDACION CEAR NOTICIA---------------------------------

$('#crearNoticia').submit(function(e){
    var resultado = validarFormularioCuenta();
    if(resultado == false){
        e.preventDefault();
    }
    })

    function validarFormularioCuenta(){
    
        $('.alert').remove();
        var titulo =$('#titulo').val(),
            descrip =$('#descrip').val(),
            text =$('#Texto').val(),
            col =$('#address').val(),
            city =$('#address2').val(),
            pais =$('#country').val(),
            secc =$('#seccion').val(),
            date =$('#Fecha').val()
        
    
            var resultado = true;
        
           
            
            if(titulo ==""||titulo==null){
                cambiarColor("titulo");
                mostrarAlerta_VaciaTitle("Campo obligatorio")
                resultado = false;
            }

            if(descrip ==""||descrip==null){
                cambiarColor("descrip");
                mostrarAlerta_VaciaDescrip("Campo obligatorio")
                resultado = false;
        
            }

            if(text ==""||text==null){
                cambiarColor("Texto");
                mostrarAlerta_VaciaText("Campo obligatorio")
                resultado = false;
        
            }

            if(col ==""||col==null){
                cambiarColor("address");
                mostrarAlerta_VaciaAdd("Campo obligatorio")
                resultado = false;
        
            }
        
        if(city ==""||city==null){
            cambiarColor("address2");
            mostrarAlerta_VaciaCity("Campo obligatorio")
            resultado = false;
    
        }else{
            var ciud = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
            if(!ciud.test(city)){
                cambiarColor("address2");
                mostrarAlerta_Ciudad("Por favor ingrese solo letras");
                resultado = false;
    
            }
        }

        if(pais ==""||pais==null){
            cambiarColor("country");
            mostrarAlerta_VaciaCount("Campo obligatorio")
            resultado = false;
    
        }

        if(secc ==""||secc==null){
            cambiarColor("seccion");
            mostrarAlerta_VaciaSecc("Campo obligatorio")
            resultado = false;
    
        }

        if(date ==""||date==null){
            cambiarColor("Fecha");
            mostrarAlerta_VaciaFecha("Campo obligatorio")
            resultado = false;
    
        }
        return resultado;
    }
    
function cambiarColor(dato){
    $('#'+ dato).css({
        border: "1px solid #dd5144"
    });
    }

// CREAR NOTICIA VALID ----------------------------------------------------------------------



function mostrarAlerta_Ciudad(texto){
    $('#address2').before('<div class= "alert" > Error: ' + texto +'</div>')
}


            function mostrarAlerta_VaciaTitle(texto){
                $('#titulo').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaDescrip(texto){
                $('#descrip').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaText(texto){
                $('#Texto').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaAdd(texto){
                $('#address').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaCity(texto){
                $('#address2').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaCount(texto){
                $('#country').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaSecc(texto){
                $('#seccion').before('<div class= "alert" > Error: ' + texto +'</div>')
            }
            function mostrarAlerta_VaciaFecha(texto){
                $('#Fecha').before('<div class= "alert" > Error: ' + texto +'</div>')
            }