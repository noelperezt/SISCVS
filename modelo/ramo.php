<?php
	require_once "../conexion/conexion.php";
	require_once "../modelo/ramo.php";
	class ramo{
		var $conn;
		var $conexion;

		function ramo(){
			$this->conexion= new  Conexion();				
			$this->conn=$this->conexion->conectarse();
		}
		
		function conexion(){
		return $this->conn;
		}
		
		function registrar($cod, $descripcion){
			$queryRegistrar = "insert into ramo (codigo, descripcion) 
								values ('".$cod."', '".$descripcion."')";			
			$registrar = mysqli_query($this->conn, $queryRegistrar) or die(mysqli_error($this->conn));

			if($registrar){
				echo "<script>
				alert('Registro Exitoso');
				window.location.href='../vistas/L_ramo.php';
				</script>";
			}else{
				echo '<script>
					alert("\xa1Campos Incompletos!");
					location.href="../vistas/L_ramo.php";
					</script>';
			}
		}
		
		function listar(){
			$_pagi_sql = "SELECT * FROM ramo";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 30; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  summary='ramo'>
						<caption>Listado de Ramos</caption>
						<thead>
							<tr>
								<th width='20%'> Código</th>
								<th width='60%'>Descripción</th>
								<th width='20%' colspan='2'>Acción <a href='../vistas/R_ramo.php' title='Nuevo'><img id ='agregar' src='../images/iconos/ico_agregar.png' alt='Nuevo' /></a></th>
							</tr>
						</thead>
					<tbody>";
			$i=0;
			if(mysqli_num_rows($rs)<1){
				echo "<tr>
						<td colspan='7' align='center'>La consulta no devolvió registros</td>
				      </tr>";
			}else{
				while ($row = mysql_fetch_array($_pagi_result)){
					echo "<tr>
							<td align='center'>
								".$row["codigo"]."
							</td>         
							<td align='center'>
								".$row["descripcion"]." 
							</td>
							<td width='8%' align='center'>
								<a href='../vistas/M_ramo.php?nro=".$row["codigo"]."' title='Editar'>
									<img src='../images/iconos/ico_editar.png' alt='Editar' />
								</a>
							</td>
							<td  width='8%'align='center'>
								<a href='../vistas/E_ramo.php?nro=".$row["codigo"]."' title='Eliminar'>
									<img src='../images/iconos/ico_eliminar.png' alt='Eliminar' />
								</a>
							</td>
						</tr>";
					$i++; 
				}
			}
			echo "	</tbody>
				</table>
				</div>";
			echo"<center><p>".$_pagi_navegacion."</p></center>";

		}
		
		function modificar($cod, $descripcion, $clave){
			$queryUpdate = "update ramo set codigo = '".$cod."', descripcion = '".$descripcion."' where codigo = ".$clave;
			$update =mysqli_query($this->conn, $queryUpdate);

			if($update){
				echo '<script>
					alert("Modificaci\xf3n Exitosa");
					location.href="../vistas/L_ramo.php";
					</script>';
			}else{
				echo "Error de Actualización";
			}
		}
		
		function eliminar($clave){
			$queryDelete = "delete from ramo where codigo = '".$clave."'";
			$delete =mysqli_query($this->conn, $queryDelete);

			if($delete){						
				echo '<script>
						alert("Eliminaci\xf3n Exitosa");
						location.href="../vistas/L_ramo.php";
				</script>';						
			}else{
				echo '<script>
						alert("\xa1No se puede eliminar existen Registros Asociados!");
						location.href="../vistas/L_ramo.php";
				</script>';	
			}
		}
	
		function MostrarRegistro($clave){
			$sql= "SELECT * FROM ramo WHERE codigo = '".$clave."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			echo "<div class='general'>
					<table  summary='ramo'>
						<caption>ELIMINAR REGISTRO DE RAMOS</caption>
						<tbody>
							<tr>
								<th align='right' width='20%'>Código:</th>
								<td>
									".$row["codigo"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Descripción:</th>
								<td>
									".$row["descripcion"]."
								</td>
							</tr>
						</tbody>
		            </table>
                 </div>";

		}
		
		
		function CargarFormulario($nro){
			$sql= "SELECT * FROM ramo WHERE codigo = '".$nro."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			   echo '<label>Codigo:
							<span class="small">Codigo del Ramo(*)</span>
						</label>
						<input type="number" name="cod" id="cod" min = "100" max = "100000000"  value ="'.$row["codigo"].'" required="required" onKeyPress="return checkIt(event)" onblur="document.getElementById('."'".'status_usr'."'".').style.display='."'".'none'."'".';"
						onkeyup="verificarCodigo(); document.getElementById('."'".'status_usr'."'".').style.display='."'".'block'."'".'; this.focus(); return false;" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<label>Descripción:
							<span class="small">Descripcion del Ramo(*)</span>
						</label>
						<textarea name="descripcion" rows="4" cols="74" maxlength = "100" required="required">'.$row["descripcion"].'</textarea>';

		}
		
		function validarCodigo($clave){
			 if ( preg_match("/\s/",$clave) == 1){  
				return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Se Permiten Espacios</h1></div>";  
			}else{  
				$sql = "SELECT * FROM ramo WHERE codigo = '".$clave."'";  
				$rs = mysqli_query($this->conn, $sql);  
              
				if($clave == ""){   
					return "<div id ='advertencia'><h1 id='msj_user' style='color:orange; ' mce_style='color:orange'><img id = 'icono' src='../images/iconos/ico_advertencia.png' alt='Nuevo' /> Campo Vacío</h1></div>";  
				}elseif(mysqli_num_rows($rs)<1 ){  
					  	return "<div id ='correcto'><h1 id='msj_user' style='color:green' mce_style='color:green'><img id = 'icono' src='../images/iconos/ico_exitoso.png' alt='Nuevo' /> Disponible</h1></div>"; 
				}else{  
					return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Disponible</h1></div>";
				}  
			}

		}
		
	}
?>