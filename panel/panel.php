
<div id="identificacion">
	<?php 
	echo '<img id ="datos" src="../images/iconos/ico_datos_basicos.png"/>';?>
	<div id="ventana">
		<div id="basicos">
			<h1 id= "apellidos"><?php echo $usuario->getApellidos($_SESSION['usuario']); ?>, </h1>
			<h2 id= "nombres"><?php echo $usuario->getNombres($_SESSION['usuario']); ?> </h2>
			<h3 id= "usuario">/<?php echo $_SESSION['usuario']; ?></h3>
		</div>
		<div id="calendario">
			<h1 id= "fecha"></h1>
			<h1 id='reloj'></h1>
			<a title="Cerrar Sesión" href="../control/salir.php"><img id="puerta" name "puerta" src="../images/iconos/ico_puerta_abierta.png" alt="Cerrar Sesión" /></a>
		</div>
	</div>
	</div>
	
