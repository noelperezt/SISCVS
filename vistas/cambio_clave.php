<?php
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
			var url = "../control/usuarios.php?verificar=si&param=";  
			function handleHttpResponse() {  
				if (http.readyState == 4) {  
					results = http.responseText;  
					var usr = document.getElementById("status_usr");  
					usr.innerHTML = results;  
				}  
			}  
			function verificarClave() {  
				var usrValue = document.getElementById("actual").value;  
				http.open("GET", url + escape(usrValue), true);  
				http.onreadystatechange = handleHttpResponse;  
				http.send(null);  
			}  
			function verificarRepetido() {  
				var nuevo = document.getElementById("nueva").value;  
				var confirmacion = document.getElementById("confirmacion").value;  
				http.open("GET", "../control/usuarios.php?comprobar=si&nuevo=" + escape(nuevo)+"&confirmacion=" + escape(confirmacion), true);  
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
				<center><h3 id= "titulo">Cambio de Contraseña</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/usuarios.php" enctype="multipart/form-data">
						<label>Contraseña Actual:
							<span class="small">Ingrese Contraseña Actual(*)</span>
						</label>
						<input type="password" name="actual" id="actual" maxlength = "20" required="required" onblur="document.getElementById('status_usr').style.display='none';"
						onkeyup="verificarClave(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;"/>
						<label>Nueva Contraseña:
							<span class="small">Ingrese Nueva Contraseña(*)</span>
						</label>
						<input type="password" name="nueva" id="nueva" maxlength = "20" required="required" onblur="document.getElementById('status_usr').style.display='none';"
						onkeyup="verificarRepetido(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;"/>
						<label>Confirme Contraseña:
							<span class="small">Confirme Nueva Contraseña(*)</span>
						</label>
						<input type="password" name="confirmacion" id="confirmacion" maxlength = "20" required="required" onblur="document.getElementById('status_usr').style.display='none';"
						onkeyup="verificarRepetido(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<center>
							<button  class="myButton" type="submit" name ="cambio" value ="cambio"><img id ='agregar' width = "16px" height = "16px" src='../images/iconos/ico_llave.png' /> Cambiar</button>
							<a class="button"  href="../vistas/inicio.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
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