<?php
require("../modelo/usuarios.php");
require("../modelo/solicitud.php");
$usuario = new usuarios();
$solicitud = new solicitud();
session_start();
if (!isset($_SESSION['usuario']))
	header("location:login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<head>
		<link rel="icon" type="image/png" href= "../images/icono.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SISCVS</title>
		<script src="../javascript/funciones.js" type="text/javascript"></script> 
		<link href="../css/styles.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../chosen/chosen.css">
		<script src="../jquery-ui/jquery.js"></script>
		<script language="javascript"  type="text/javascript">
			var url = "../control/solicitud.php?verificar=si&param=";  
			function handleHttpResponse() {  
				if (http.readyState == 4) {  
					results = http.responseText;  
					var usr = document.getElementById("status_usr");  
					usr.innerHTML = results;  
				}  
			}  
			function verificarCodigo() {  
				var usrValue = document.getElementById("cod").value;  
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
				<center><h3 id= "titulo">Modificar Solicitud</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../control/solicitud.php?nro=<?php echo $_GET["nro"]?>" enctype="multipart/form-data">
						<?php 
							$nro = $_GET['nro'];
							$solicitud->CargarFormulario($nro); 
			            ?>
						<center>
							<button  class="myButton" type="submit" name ="modificar" value ="modificar"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_guardar.png' /> Guardar</button>
							<a class="button"  href="../vistas/L_solicitud.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
						</center>
						<div class="spacer">
						</div>
					</form>
					<script src="../chosen/chosen.jquery.js" type="text/javascript"></script>
					<script src="../chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
					<script type="text/javascript">
						var config = {
							'.chosen-select'           : {},
							'.chosen-select-deselect'  : {allow_single_deselect:true},
							'.chosen-select-no-single' : {disable_search_threshold:10},
							'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
							'.chosen-select-width'     : {width:"95%"}
						}
						for (var selector in config) {
							$(selector).chosen(config[selector]);
						}
					</script>
				</div>
				</br>
			</div>
			<div id ="pie"></div>
		</div>
	</body>
</html>