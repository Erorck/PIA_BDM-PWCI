
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