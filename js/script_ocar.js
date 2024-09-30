//     -.-.-.-.- VALIDACIONES DEL REGISTRO -.-.-.-.-

function validarEmail(){
	var email1 = document.getElementById('email').value;
	var formaEmail = /@(gmail|yahoo|hotmail)\.com$/;
	if (formaEmail.test(email1)==false){
		alert("el formato de email ingresado no es valido");
	} 
}

function compararEmails(){
	var email1 = document.getElementById('email').value;
	var email2 = document.getElementById('confEmail').value;
	if (email1 != email2){
		alert("los emails ingresados no son identicos");
	}
}

function validarContrasenia(){
	var passw1 = document.getElementById('contrasenia').value;
	var longitud = /^.{5,15}$/;
	var minuscula = /[a-z]/;
	var num= /[0-9]/;
	if (longitud.test(passw1) == false){
		alert("la contraseña debe contener entre 5 y 15 caracteres");
	}
	if(minuscula.test(passw1) == false){
		alert("la contraseña debe contener al menos una minuscula");
	}
	if(num.test(passw1) == false){
		alert("la contraseña debe contener al menos un numero");
	}
}
 
function compararContrasenias(){
	var passw1 = document.getElementById('contrasenia').value;
	var passw2 = document.getElementById('confContra').value;
	if (passw1 != passw2){
		alert("las contraseñas ingresadas no coinciden");
	}
}

//     -.-.-.-.- VALIDACION CIERRE DE SESION -.-.-.-.-

function cerrarSesion() {
    var respuesta = confirm("¿Está seguro de que desea cerrar sesión?" );
  
    if (respuesta) {
      window.location.href = "php/cerrar_sesion.php";
    }
  }

