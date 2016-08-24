<?php 
    
	require_once("../modelo/solicitud.php");
	session_start();
	$solicitud = new solicitud();
	
	//------------------------------------------ REGISTRAR SOLICITUD----------------------------------------------------------------------	
	if(!empty($_POST["solicitud"])){ 
		$solicitud->registrar($_POST["cod"],$_POST["rif"],$_POST["tipo"],$_POST["solicitante"], $_SESSION['usuario']);
	}
	
	//------------------------------------------ MODIFICAR SOLICITUD----------------------------------------------------------------------	
	if(!empty($_POST["modificar"])){ 
		$solicitud->modificar($_POST["cod"],$_POST["rif"],$_POST["tipo"],$_POST["solicitante"],$_POST["estado"],$_GET["nro"]);
	}

	//--------------------------------------------ELIMINAR SOLICITUD----------------------------------------------------------------------	
	if(isset($_GET["eliminar"])){
		?>
			<script>
				confirmar=confirm("\xbfEst\xe1 Seguro de Eliminar la Solicitud?");
				if(confirmar){
					location.href="../control/solicitud.php?eliminacion=si&nro=<?php echo $_GET["nro"]; ?>";
				}else{
					location.href="../vistas/L_solicitud.php";
				}
				</script>
		<?php
	}	
	
	if(isset($_GET["eliminacion"])){
		$solicitud->eliminar($_GET["nro"]);
	}
	
	//--------------------------------------------CONSULTAR CODIGO--------------------------------------------------------------------	
	if(isset($_GET["verificar"])){
		echo $solicitud->validarCodigo($_GET["param"]);
	}
	

?>