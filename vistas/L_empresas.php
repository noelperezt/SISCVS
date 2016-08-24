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
			<div id = "buscador">
				<label for='txtBuscar'>Buscar: </label>
				<input type='search' id='txtBuscar' autofocus class="light-table-filter" data-table="order-table"
				placeholder='Digite el texto que desea encontrar y presione ENTER. Para cancelar la tecla ESCAPE.'>
			</div>
			<?php 
				$empresas->listar(); 
			?>
			<p align="center">
				<a class="button" onClick="history.go(-1);"><img id= "volver" src="../images/iconos/ico_volver.png" alt="volver"/> Volver</a>
			</p>
			</div>
			<div id ="pie"></div>
		</div>
	</body>
</html>