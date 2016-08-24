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
		<link href="../jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="../jquery-ui/jquery.js"></script>
		<script src="../jquery-ui/jquery-ui.js"></script>
		<script>
		 $.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['es']);
			$(function () {
			$('#fecha_c').datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true, yearRange: '-100:+0'});
			});
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
				<center><h3 id= "titulo">Listado de Solicitudes</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" target="_blank" action="../reportes/solicitudes.php" enctype="multipart/form-data">
						<label>Fecha:
							<span class="small">Seleccione Fecha(*)</span>
						</label>
						<input type="text" name="fecha_c" id="fecha_c" required="required" autocomplete= "off" value = "<?php echo date("d/m/Y");?>"/>
						<center>
							<button  class="myButton" type="submit" name ="buscar" value ="buscar"><img id= "volver" src="../images/iconos/ico_impresora.png" alt="buscar"/> Imprimir</button>
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