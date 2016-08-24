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
				<center><h3 id= "titulo">Modificar Empresas</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/empresas.php?nro=<?php echo $_GET["nro"]?>" enctype="multipart/form-data">
						<?php 
							$nro = $_GET['nro'];
							$empresas->CargarFormulario($nro); 
			            ?>
						<center>
							<button  class="myButton" type="submit" name ="modificar" value ="modificar"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_guardar.png' /> Guardar</button>
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