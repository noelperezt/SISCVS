<?php 
    
	require_once("../modelo/empresas.php");
	$empresas = new empresas();
	
	//------------------------------------------ REGISTRAR EMPRESAS----------------------------------------------------------------------	
	if(!empty($_POST["empresa"])){ 
		$empresas->registrar($_POST["rif"],$_POST["nombre"],$_POST["direccion"],$_POST["representante"],$_POST["cedula"],$_POST["telefono"],$_POST["email"],$_POST["ramo"]);
	}
	
	//------------------------------------------ MODIFICAR EMPRESAS----------------------------------------------------------------------	
	if(!empty($_POST["modificar"])){ 
		$empresas->modificar($_POST["rif"],$_POST["nombre"],$_POST["direccion"],$_POST["representante"],$_POST["cedula"],$_POST["telefono"],$_POST["email"],$_POST["ramo"],$_GET["nro"]);
	}

	//--------------------------------------------ELIMINAR EMPRESAS----------------------------------------------------------------------	
	if(isset($_GET["eliminar"])){
		?>
			<script>
				confirmar=confirm("\xbfEst\xe1 Seguro de Eliminar la Empresa?");
				if(confirmar){
					location.href="../control/empresas.php?eliminacion=si&nro=<?php echo $_GET["nro"]; ?>";
				}else{
					location.href="../vistas/L_empresas.php";
				}
				</script>
		<?php
	}	
	
	if(isset($_GET["eliminacion"])){
		$empresas->eliminar($_GET["nro"]);
	}
	
	//--------------------------------------------CONSULTAR RIF--------------------------------------------------------------------	
	if(isset($_GET["verificar"])){
		echo $empresas->validarCodigo($_GET["param"]);
	}
	
	//--------------------------------------------CONSULTAR CEDULA--------------------------------------------------------------------	
	if(isset($_GET["cedula"])){
		echo $empresas->validarCedula($_GET["param"]);
	}

?>