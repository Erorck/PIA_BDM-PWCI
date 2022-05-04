

// Validaciones 
function validar(){

	var Informacion_Usuario = "";
	var Crear_Cuenta = document.F_Crear_Cuenta
	let error = {
		details: ""
	};
	//Validar Campos Vacios

	if(Crear_Cuenta.uname.value == 0 ||
	Crear_Cuenta.Nombre.value == 0 ||
	Crear_Cuenta.Apat.value == 0 ||
	Crear_Cuenta.Amat.value == 0 ||
	Crear_Cuenta.direccionemail.value == 0 ||
	Crear_Cuenta.pass.value == 0 ||
	Crear_Cuenta.passconf.value == 0){
		Swal.fire('Alguno o varios de los campos estan vacios','','warning')
		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	//Email

	if(!validateEmail(Crear_Cuenta.direccionemail.value)){
		Swal.fire('Email Invalido','','warning')
		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	//Contraseña
	if(!validatePass(Crear_Cuenta.pass.value,Crear_Cuenta.passconf.value,error)){
		Swal.fire('Contraseña Invalida',error.details,'warning')
		Informacion_Usuario.value ="";
		Informacion_Usuario.focus();
		return false;
	}

	return true;
}

function validateEmail(email) {
	const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

function validatePass(pass,confpass,error){ 
	var ok = true;
	var numUpper = pass.length - pass.replace(/[A-Z]/g, '').length;
	var numLower = pass.length - pass.replace(/[a-z]/g, '').length;  
	var specialCharformat = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
	if(pass.length < 8){
		ok = false;
		error.details = error.details.concat("Contraseña tiene menos de 8 caracteres\n");
	}
	if (numUpper < 1)
	{
		ok = false;
		error.details = error.details.concat("Contraseña no tiene letras mayusculas\n");
	}
	if (numLower < 1)
	{
		ok = false;
		error.details = error.details.concat("Contraseña no tiene letras minusculas\n");
	}
	if (!specialCharformat.test(pass))
	{
		ok = false;
		error.details = error.details.concat("Contraseña no tiene signo de puntuacion\n");
	}
	if(!(pass === confpass)){
		ok = false;
		error.details = error.details.concat("Contraseñas no conciden\n");
	}
	return ok;

}

function ValidBDate(input){ //evalua que una fecha de nacimienmto sea valida) osea Mayores de edad, y que no sean fechas futuras al dia actual

}

function ValidAlpha(){ // Valida solo letras

}

function ValidNum(){ // solo numeros

}

function ValidAlphaNum(){ // solo alfanumericos (sin caracteres especiales)

}

function ValidCharRange(input ,MinRange = 0, MaxRange = 0){ //evalua Que un campo este dentro del rango de caracteres

}


