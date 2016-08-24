<?php 
    
	require_once("../modelo/usuarios.php");
	$usuarios = new usuarios();
	session_start();

	
	//------------------------------------------ REGISTRAR USUARIOS----------------------------------------------------------------------	
	if(!empty($_POST["usuario"])){ 
	        $clave = $usuarios->encrypt($_POST["nueva"]);
			$usuarios->registrar($_POST["user_validar"], $clave,$_POST["nombre"], $_POST["apellido"],$_POST["email"]);
	}
	
	//------------------------------------------ MODIFICAR USUARIOS----------------------------------------------------------------------	
	if(!empty($_POST["modificar"])){ 
			$usuarios->Modificar($_POST["user_validar"],$_POST["nombre"], $_POST["apellido"],$_POST["email"],$_GET["nombre"]);
	}
		
	//------------------------------------------ CAMBIO DE CLAVE----------------------------------------------------------------------	
	if(!empty($_POST["cambio"])){ 
		if($usuarios->descifrar(($_POST["actual"]),$usuarios->getClave($_SESSION['usuario']))){
			if($_POST["nueva"] == $_POST["confirmacion"]){
				$usuarios->cambioClave($_SESSION['usuario'],$_POST["nueva"]);
			}else{
				echo "<script>
						alert('Las Claves no Coinciden');
						location.href='javascript:history.back(1)';
					</script>";	
			}
		}else{
			echo "<script>
						alert('Clave Actual Incorrecta');
						location.href='javascript:history.back(1)';
					</script>";	
		}
		
	}
	
	//--------------------------------------------CONSULTAR USUARIO--------------------------------------------------------------------	
	if(isset($_GET["consultar"])){
		echo $usuarios->validarUsuario($_GET["param"]);
	}	
		
	
	//--------------------------------------------VERIFICAR REPETIDO--------------------------------------------------------------------	
	if(isset($_GET["comprobar"])){
		if($_GET["nuevo"]== "" or $_GET["confirmacion"]== "" ){
			echo "<div id ='advertencia'><h1 id='msj_user' style='color:orange; ' mce_style='color:orange'><img id = 'icono' src='../images/iconos/ico_advertencia.png' alt='Nuevo' /> Uno de los Campos esta Vacio</h1></div>";
		}elseif($_GET["nuevo"] == $_GET["confirmacion"]){
			echo "<div id ='correcto'><h1 id='msj_user' style='color:green' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_exitoso.png' alt='Nuevo' /> Las Contraseñas Coinciden</h1></div>";
		}else{
			echo "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> Las Contraseñas No Coinciden</h1></div>";
		}
	}
	
	//--------------------------------------------VERIFICAR CLAVE ACTUAL--------------------------------------------------------------------	
	if(isset($_GET["verificar"])){
		if($_GET["param"]== ""){
			echo "<div id ='advertencia'><h1 id='msj_user' style='color:orange; ' mce_style='color:orange'><img id = 'icono' src='../images/iconos/ico_advertencia.png' alt='Nuevo' /> Campo Vacío</h1></div>";
		}elseif($usuarios->descifrar(($_GET["param"]),$usuarios->getClave($_SESSION['usuario']))){
			echo "<div id ='correcto'><h1 id='msj_user' style='color:green' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_exitoso.png' alt='Nuevo' /> La Contraseña Actual es Correcta</h1></div>";
		}else{
			echo "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> La Contraseña Actual es Incorrecta</h1></div>";
		}
	}	
	
	//-------------------------------------------- REINICIAR CONTRASEÑA ----------------------------------------------------------------------	
	if(isset($_GET["reiniciar"])){
	?>
		<script>
			confirmar=confirm("\xbfEsta seguro de Reiniciar la Contraseña?");
		if(confirmar){
			location.href="../control/usuarios.php?confirmacionR=si&nombre=<?php echo $_GET["nombre"]; ?>";
		}else{
			location.href="../vistas/seguridadR.php";
		}
		</script>
	<?php
	}
	
	
	if(isset($_GET["confirmacionR"])){
		$usuarios->reiniciar($_GET["nombre"]);
	}	
	
	//-------------------------------------------- DESACTIVAR CUENTA ----------------------------------------------------------------------	
	if(isset($_GET["desactivar"])){
	?>
		<script>
			confirmar=confirm("\xbfEsta seguro de Desactivar la Cuenta?");
		if(confirmar){
			location.href="../control/usuarios.php?confirmacionD=si&nombre=<?php echo $_GET["nombre"]; ?>";
		}else{
			location.href="../vistas/seguridadB.php";
		}
		</script>
	<?php
	}
	
	
	if(isset($_GET["confirmacionD"])){
		$usuarios->desactivar($_GET["nombre"]);
	}	
	
	//----------------------------------------------- ACTIVAR CUENTA ----------------------------------------------------------------------	
	if(isset($_GET["activar"])){
	?>
		<script>
			confirmar=confirm("\xbfEsta seguro de Activar la Cuenta?");
		if(confirmar){
			location.href="../control/usuarios.php?confirmacionA=si&nombre=<?php echo $_GET["nombre"]; ?>";
		}else{
			location.href="../vistas/seguridadB.php";
		}
		</script>
	<?php
	}
	
	
	if(isset($_GET["confirmacionA"])){
		$usuarios->activar($_GET["nombre"]);
	}	
?>