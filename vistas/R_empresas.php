<?php
require("../modelo/empresas.php");
$empresas = new empresas();
require("../modelo/usuarios.php");
$usuario = new usuarios();
session_start();
if (!isset($_SESSION['usuario']))
	header("location:login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<head>
		<link rel="icon" type="image/png" href= "../images/icono.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SISCVS</title>
		<link href="../css/styles.css" rel="stylesheet" type="text/css" />
		<script src="../javascript/funciones.js" type="text/javascript"></script> 
		<script language="javascript"  type="text/javascript">
function validatePass(campo) {
    var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
    var errorMessage = 'Password Incorrecta.';
    if ((campo.value.match(RegExPattern)) && (campo.value!='')) {
        alert('Password Correcta'); 
    } else {
        alert(errorMessage);
        campo.focus();
    } 
}
			var url = "../control/empresas.php?verificar=si&param=";  
			var url1 = "../control/empresas.php?cedula=si&param=";
			function handleHttpResponse() {  
				if (http.readyState == 4) {  
					results = http.responseText;  
					var usr = document.getElementById("status_usr");  
					usr.innerHTML = results;  
					var usr1 = document.getElementById("status_usr1");  
					usr1.innerHTML = results;  
				}  
			}  
			function verificarCodigo() {  
				var usrValue = document.getElementById("rif").value;  
				http.open("GET", url + escape(usrValue), true);  
				http.onreadystatechange = handleHttpResponse;  
				http.send(null);  
			}
			function verificarCedula() {  
				var usrValue = document.getElementById("cedula").value;  
				http.open("GET", url1 + escape(usrValue), true);  
				http.onreadystatechange = handleHttpResponse;  
				http.send(null);  
			}   
			function getHTTPObject() {  
				var xmlhttp;  
				if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {  
					try {  
						xmlhttp = new XMLHttpRequest();  
					} catch (e) {  
						xmlhttp = false;  
					}  
			}  
			return xmlhttp;  
			}  
			var http = getHTTPObject();  
		</script>
	</head>
	<body onload= "fecha(); reloj();">
		<div id="cuerpo">
			<div id="cabecera">
				<img id= "imagen" src = "../images/cabecera.png"/>
			</div>
			<?php 
				include '../menus/menu_admin.html'; 
				include '../panel/panel.php';?>
			<div id="contenido">
				</br>
				<center><h3 id= "titulo">Registrar Empresas</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/empresas.php" enctype="multipart/form-data">
						<label>Rif:
							<span class="small">Ej: J-00000000-0(*)</span>
						</label>
						<input type="text" maxlength = "12" name="rif" id="rif" required="required"  onblur=" document.getElementById('status_usr').style.display='none';"
						onkeyup=" verificarCodigo(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;" pattern = "[VEGJ]{1}-[0-9]{8}-[0-9]{1}" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<label>Nombre:
							<span class="small">Nombres de la Empresa(*)</span>
						</label>
						<input type="text" name="nombre" id="nombre" maxlength = "25" required="required" />
						<label>Ramo:
							<span class="small">Ramo de la Empresa(*)</span>
						</label>
						<select name="ramo" id ="ramo">
							<option value="">(Seleccionar)</option>';
							<?php $empresas->cargarRamo();?>
						</select>
						<label>Dirección:
							<span class="small">Direccion de la Empresa (*)</span>
						</label>
						<textarea name="direccion" rows="4" cols="74" maxlength = "100" required="required"></textarea>
						<label>Representante:
							<span class="small">Representante de la Empresa (*)</span>
						</label>
						<input type="text" name="representante" id="representante" maxlength = "25" required="required" />
						<label>Cédula:
							<span class="small">Cédula del Representante (*)</span>
						</label>
						<input type="number" name="cedula" id="cedula" min = "100" max = "99999999" required="required" onKeyPress="return checkIt(event)" onblur="document.getElementById('status_usr1').style.display='none';"
						onkeyup="verificarCedula(); document.getElementById('status_usr1').style.display='block'; this.focus(); return false;" />
						<div name="status_usr1" id="status_usr1" style="display:none"></div>
						<label>Teléfono:
							<span class="small">Teléfono Principal (*)</span>
						</label>
						<input type="tel" onKeyPress="return checkIt(event)"   name="telefono" id="telefono" required="required" />
						<label>Correo Electrónico:
							<span class="small">Correo de la Empresa(*)</span>
						</label>
						<input type="email" name="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="email" maxlength = "50" required="required" />
						<center>
							<button  class="myButton" type="submit" name ="empresa" value ="empresa"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_guardar.png' /> Guardar</button>
							<a class="button"  href="../vistas/L_empresas.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
						</center>
						<div class="spacer">
						</div>
					</form>
				</div>
				</br>
			</div>
			<div id ="pie"></div>
		</div>
	</body>
</html>