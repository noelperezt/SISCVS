<?php 
    
	require_once("../modelo/ramo.php");
	$ramo = new ramo();
	
	//------------------------------------------ REGISTRAR RAMO----------------------------------------------------------------------	
	if(!empty($_POST["ramo"])){ 
		$ramo->registrar($_POST["cod"],$_POST["descripcion"]);
	}
	
	//------------------------------------------ MODIFICAR RAMO----------------------------------------------------------------------	
	if(!empty($_POST["modificar"])){ 
		$ramo->modificar($_POST["cod"],$_POST["descripcion"],$_GET["nro"]);
	}

	//--------------------------------------------ELIMINAR RAMO----------------------------------------------------------------------	
	if(isset($_GET["eliminar"])){
		?>
			<script>
				confirmar=confirm("\xbfEst\xe1 Seguro de Eliminar el Ramo?");
				if(confirmar){
					location.href="../control/ramo.php?eliminacion=si&nro=<?php echo $_GET["nro"]; ?>";
				}else{
					location.href="../vistas/L_ramo.php";
				}
				</script>
		<?php
	}	
	
	if(isset($_GET["eliminacion"])){
		$ramo->eliminar($_GET["nro"]);
	}
	
	//--------------------------------------------CONSULTAR CODIGO--------------------------------------------------------------------	
	if(isset($_GET["verificar"])){
		echo $ramo->validarCodigo($_GET["param"]);
	}
	


?>