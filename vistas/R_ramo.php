<?php
require_once("../modelo/ramo.php");
$ramo = new ramo();
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
			var url = "../control/ramo.php?verificar=si&param=";  
			function handleHttpResponse() {  
				if (http.readyState == 4) {  
					results = http.responseText;  
					var usr = document.getElementById("status_usr");  
				}  
			}  
			function verificarCodigo() {  
				var usrValue = document.getElementById("rif").value;  
				http.open("GET", url + escape(usrValue), true);  
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
				<center><h3 id= "titulo">Registrar Ramo</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/ramo.php" enctype="multipart/form-data">
						<label>Codigo:
							<span class="small">Codigo del Ramo(*)</span>
						</label>
						<input type="number" name="cod" id="cod" min = "100" max = "100000000" required="required" onKeyPress="return checkIt(event)" onblur="document.getElementById('status_usr').style.display='none';"
						onkeyup="verificarCodigo(); document.getElementById('status_usr').style.display='block'; this.focus(); return false;" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<label>Descripción:
							<span class="small">Descripcion del Ramo(*)</span>
						</label>
						<textarea name="descripcion" rows="4" cols="74" maxlength = "100" required="required"></textarea>
						<center>
							<button  class="myButton" type="submit" name ="ramo" value ="ramo"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_guardar.png' /> Guardar</button>
							<a class="button"  href="../vistas/L_ramo.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
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