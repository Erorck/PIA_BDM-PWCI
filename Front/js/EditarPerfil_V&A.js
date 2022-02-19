
const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}


//VALIDACIONES

function validar(){

	var Informacion_Usuario = document.Informacion_Usuario

	if(Informacion_Usuario.Nombre_Usuario.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	else if(expresiones.usuario.test(Informacion_Usuario.Nombre_Usuario.value) == false ){

		Swal.fire('El nombre de usuario solo puede contener Letras, numeros, guion y guion bajo')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}


	if(Informacion_Usuario.Nombres.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;

	}

	else if(expresiones.nombre.test(Informacion_Usuario.Nombres.value) == false ){

		Swal.fire('El nombre solo puede contener Letras y espacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Informacion_Usuario.Apellido_Paterno.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;

	}

	else if(expresiones.nombre.test(Informacion_Usuario.Apellido_Paterno.value) == false ){

		Swal.fire('El Apellido Paterno solo puede contener Letras')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Informacion_Usuario.Apellido_Materno.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;

	}

	else if(expresiones.nombre.test(Informacion_Usuario.Apellido_Materno.value) == false ){

		Swal.fire('El Apellido Materno solo puede contener Letras')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Informacion_Usuario.Correo.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;

	}

		else if(expresiones.correo.test(Informacion_Usuario.Correo.value) == false ){

		Swal.fire('El correo necesita un @, y solo puede contener letras, numeros y guion bajo')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Informacion_Usuario.Fecha_Nac.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;

	}

}

function validar_contra(){

	 //CAMPOS DE CONTRASEÑA

	var Informacion_Contraseña = document.Cambiar_Contraseña

	if(Informacion_Contraseña.Contraseña.value == 0){

		Swal.fire('Llene por favor ambos campos de la contraseña')

		Informacion_Contraseña.value ="";
		Informacion_Contraseña.focus();
		return false;


	}

	if(Informacion_Contraseña.Contraseña_confirm.value == 0){

		Swal.fire('Llene por favor ambos campos de la contraseña')

		Informacion_Contraseña.value ="";
		Informacion_Contraseña.focus();
		return false;


	}
		
}



//ADVERTENCIAS

var btn_Contraseña = document.getElementById('id_Cambiar_Contraseña')
var btn_Cambiar_Foto = document.getElementById('id_Cambiar_Foto')
var btn_GuardarInfo = document.getElementById('id_Guardarinfo')

function Alerta_Contraseña(){

			Swal.fire({
			  title: '¿Estas seguro?',
			  text: "¿Seguro que quieres cambiar la contraseña?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, estoy seguro'
			}).then((result) => {
			  if (result.isConfirmed) {
			    Swal.fire(
			      'Completado',
			      'Tu contraseña ha sido cambiada',
			      'success'
			    )
			  }
			})

}

function Alerta_GuardarInfo(){

			Swal.fire({
			  title: '¿Estas seguro?',
			  text: "¿Seguro que quieres guardar estos nuevos cambios?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, estoy seguro'
			}).then((result) => {
			  if (result.isConfirmed) {
			    Swal.fire(
			      'Completado',
			      'Tu informacion ha sido cambiada',
			      'success'
			    )
			  }
			})

}

function Alerta_CambiarFoto(){

			Swal.fire({
			  title: '¿Estas seguro?',
			  text: "¿Seguro que quieres cambiar la foto?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, estoy seguro'
			}).then((result) => {
			  if (result.isConfirmed) {
			    Swal.fire(
			      'Completado',
			      'Tu foto ha sido cambiada',
			      'success'
			    )
			  }
			})

}

btn_Contraseña.addEventListener('click',Alerta_Contraseña,true)
btn_GuardarInfo.addEventListener('click',Alerta_GuardarInfo,true)
btn_Cambiar_Foto.addEventListener('click',Alerta_CambiarFoto,true)











