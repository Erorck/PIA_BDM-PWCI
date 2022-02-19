function validar(){

	var Inicio_Sesion = document.Inicio_Sesion

	if(Inicio_Sesion.Nombre_Usuario.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Inicio_Sesion.Contraseña.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}


}