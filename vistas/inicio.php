<?php
require("../modelo/usuarios.php");
require("../modelo/empresas.php");
$usuario = new usuarios();
$empresas = new empresas();
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
		<script>
			window.onload=function(){
			var pos=window.name || 0;
			window.scrollTo(0,pos);
			}
			window.onunload=function(){
			window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
			}
		</script>
	</head>
	<body onload= "fecha(); reloj()">
		<div id="cuerpo">
			<div id="cabecera">
				<img id= "imagen" src = "../images/cabecera.png"/>
			</div>
			<?php 
				include '../menus/menu_admin.html'; 
				include '../panel/panel.php';?>
			<div id="contenido">
			<div id="marco_inicio">
			</br>
			<center><img id= "img_inicio" src = "../images/sistema.png"/></center>
			<p id = "p_inicio" align = "center" >Bienvenido(a) <strong><?php echo $usuario->getApellidos($_SESSION["usuario"]).' '.$usuario->getNombres($_SESSION["usuario"]);?></strong> al Sistema de Cumplimiento de variables de Seguridad, una Herramienta diseñada para automatizar emision de actas y certificados con el fin de dar cumplimiento a las normas de seguridad correpondientes.<p>
			</div>
			<?php $empresas->listarNoProcesados();?>
			</div>
			<div id ="pie"></div>
		</div>
	</body>
</html>