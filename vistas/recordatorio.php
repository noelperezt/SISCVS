
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<head>
		<link rel="icon" type="image/png" href= "../images/icono.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SISCVS</title>
		<link href="../css/styles.css" rel="stylesheet" type="text/css" />
		<script src="../javascript/funciones.js" type="text/javascript"></script>  
	</head>
	<body onload= "fecha(); reloj();">
		<div id="cuerpo">
			<div id="cabecera">
				<img id= "imagen" src = "../images/cabecera.png"/>
			</div>
			<div id ="suplente"></div>
			<div id="contenido">
				</br></br></br>
				<center><h3 id= "titulo">¿Olvido su Contraseña?</h3></center>
				<div id="stylized" class="myform">
					<form id="form" name="form" method="post" action="../reportes/datos.php" enctype="multipart/form-data">
						<label>Nombre de Usuario:
							<span class="small">Ingrese Usuario SISCVS(*)</span>
						</label>
						<input type="text" name="user" id="user" maxlength = "100" required="required" />
						<center>
							<button  class="myButton" type="submit" name ="buscar" value ="buscar"><img id= "volver" src="../images/iconos/ico_correo_electronico.png" alt="enviar"/> Enviar</button>
							<a class="button"  href="../vistas/login.php"><img id ='volver' width = "16px" height = "16px" src='../images/iconos/ico_cancelar.png' /> Cancelar</a>
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