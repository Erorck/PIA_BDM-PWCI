function validar(){

	var Crear_Cuenta = document.F_Crear_Cuenta

	if(Crear_Cuenta.Nombre_de_usuario.value == 0){

		Swal.fire('Alguno o varios de los campos estan vacios')

		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	if(Crear_Cuenta.Nombre.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Crear_Cuenta.Apellido_P.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Crear_Cuenta.Apellido_M.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Crear_Cuenta.direccionemail.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Crear_Cuenta.Contraseña.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}

	if(Crear_Cuenta.Contraseña_Confirm.value == 0){

	Swal.fire('Alguno o varios de los campos estan vacios')

	Informacion_Usuario.value ="";
	Informacion_Usuario.focus();
	return false;
	}




}