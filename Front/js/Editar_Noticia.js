function validar_Noticia(){

	var Informacion_Noticia = document.Datos_de_Noticia

	if(Informacion_Noticia.Lugar.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Informacion_Noticia.Firma_Reportero.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Informacion_Noticia.Titulo_Noticia.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Informacion_Noticia.Descripcion_Noticia.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Informacion_Noticia.Texto.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}


	if(Informacion_Noticia.Palabras_Clave.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}



}

function Alerta_Enviar(){

			Swal.fire({
			  title: '¿Estas seguro?',
			  text: "¿Seguro que quieres enviar la noticia para su revision",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, estoy seguro'
			}).then((result) => {
			  if (result.isConfirmed) {
			    Swal.fire(
			      'Completado',
			      'Tu noticia ha sido enviada',
			      'success'
			    )
			  }
			})

}

var btn_Enviar = document.getElementById('id_Enviar_para_revision')
btn_Enviar.addEventListener('click',Alerta_Enviar,true)