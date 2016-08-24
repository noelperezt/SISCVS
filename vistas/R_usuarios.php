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
		<script src="../jquery-ui/jquery.js"></script>
		<script src="../jquery-ui/jquery-ui.js"></script>
		<link href="../jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script language="javascript"  type="text/javascript">
			var url1 = "../control/usuarios.php?consultar=si&param=";  
			var url = "../control/usuarios.php?verificar=si&param=";  
			function handleHttpResponse() {  
				if (http.readyState == 4) {  
					results = http.responseText;  
					var usr = document.getElementById("status_usr");  
					usr.innerHTML = results;  
					var usr1 = document.getElementById("status_usr1");  
					usr1.innerHTML = results;  
				}  
			}  
			function verificarRepetido() {  
				var nuevo = document.getElementById("nueva").value;  
				var confirmacion = document.getElementById("confirmacion").value;  
				http.open("GET", "../control/usuarios.php?comprobar=si&nuevo=" + escape(nuevo)+"&confirmacion=" + escape(confirmacion), true);  
				http.onreadystatechange = handleHttpResponse;  
				http.send(null);  
			}  
			function verificar() {  
				var usrValue = document.getElementById("user_validar").value;  
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
				<center><h3 id= "titulo">Registrar Usuario</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/usuarios.php?nro=<?php echo $_GET["nro"]; ?>" enctype="multipart/form-data">
						<label>Nombre de Usuario:
							<span class="small">Nombre para acceder a SISCVS(*)</span>
						</label>
						<img id = "img_user"  src='../images/iconos/ico_usuario.png'>
						<input type="text" onclick= "verificar(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;" onblur="document.getElementById('status_usr').style.display='none';"
						onkeyup="verificar(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;"  name="user_validar" id="user_validar"  value="" maxlength = "25" required="required" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						
						<label>Contraseña:
							<span class="small">Ingrese Nueva Contraseña(*)</span>
						</label>
						<input type="password" name="nueva" id="nueva" maxlength = "20" required="required" onblur="document.getElementById('status_usr1').style.display='none';"
						onkeyup="verificarRepetido(); document.getElementById('status_usr1').style.display='block'; this.focus(); return false;"/>
						<label>Confirme Contraseña:
							<span class="small">Confirme Nueva Contraseña(*)</span>
						</label>
						<input type="password" name="confirmacion" id="confirmacion" maxlength = "20" required="required" onblur="document.getElementById('status_usr1').style.display='none';"
						onkeyup="verificarRepetido(); document.getElementById('status_usr1').style.display='block'; this.focus(); return false;" />
						<div name="status_usr1" id="status_usr1" style="display:none"></div>
						<label>Nombres:
							<span class="small">Nombres del Usuario(*)</span>
						</label>
						<input type="text" name="nombre" id="nombre" maxlength = "40" required="required" />
						<label>Apellidos:
							<span class="small">Apellidos del Usuario(*)</span>
						</label>
						<input type="text" name="apellido" id="apellido" maxlength = "40" required="required" />
						<label>Correo Electrónico:
							<span class="small">Correo del Usuario(*)</span>
						</label>
						<input type="email" name="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="email" maxlength = "50" required="required" />
						<center>
							<button  class="myButton" type="submit" name ="usuario" value ="usuario"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_guardar.png' /> Guardar</button>
							<a class="button"  href="../vistas/L_usuarios.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
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