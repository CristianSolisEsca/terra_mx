
$(document).ready(function () {
	$.ajax({
		url: "engine/frontLogin.php",
		data: {resetSession : true},
		type: 'post'
	});
});

$(document).ready(function () {

function openModal () {
	getRealName();

    $("#nameLogged").empty();
	$("#bodyLogged").empty();
	$("#continueLogged").attr("href", "");	
	
	url = "user/index.php";	


 swal("¡Bienvenido!", " "+localStorage.realname + "." ,"success");

	setTimeout(function() {
		window.location = url;
	}, 3000);
}

$('#loginForm').on('submit', function (e) {
	e.preventDefault(); // ← ¡Necesario!

	var email = $("#email").val();
	var passw = $("#password").val();
	console.log("Entro");

	$.ajax({
		url: 'engine/frontLogin.php',
		data: {email : email, passw : passw},
		type: 'POST',
		timeout: 1000,
		success: function (data) {
			var array = JSON.parse(data);
			console.log(array);
			
			if(array == "001"){
				swal("Error", "El usuario '"+email +"' no existe Favor de verificar.", "error");
				return;
			}

			if (array == "002") {
				swal("Nombre de usuario y/o contraseña incorrectos", "El inicio ha sido denegado porque el usuario y la contraseña no son correctos.","error");
				return;
			}

			if (array == "006") {
				swal("Error", "El Usuario ('"+email+"') se encuentra desactivado favor de ponerse en contacto con el Administrador","error");
				return;
			}

			if (array == "003") {
				swal("Error", "Error Interno Del Servidor");
				return;
			}

			if (array == "004") {
				$.when(getRealName()).done(function () {
					openModal();
					turn("off");
				});
			}
		},
		error: function (x, t, m) {
			if(t === 'timeout'){
				swal("Ha pedido la conexion con el servidor", "La conexion con el servidor ha excedido el tiempo, recomendamos recargar la pagina.","error");
			}
		}
	});
});


function getRealName(){
	return $.ajax({
		url: "engine/frontLogin.php",
		data: {getRealName : true},
		type: 'post',
		success: function (data) {
			if (localStorage.realname) {
				localStorage.realname = data;
			}else{
				localStorage.setItem("realname", data);
			}
		}
	});
}


function turn (opc) {
	if (opc == "on") {
		$("#preLoader").addClass("indeterminate");
		$("#ajaxLoader").addClass("active");
	}

	if (opc == "off") {
		$("#preLoader").removeClass("indeterminate");
		$("#ajaxLoader").removeClass("active");
	}

}

$("#modalError").on("hidden", function () {
	console.log(true);
	if($('#modalError').is(':visible'))
		("#submitLoginForm").prop("disabled", false);
	
});

});