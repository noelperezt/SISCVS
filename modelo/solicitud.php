<?php
	require_once "../conexion/conexion.php";
	require_once "../modelo/solicitud.php";
	class solicitud{
		var $conn;
		var $conexion;

		function solicitud(){
			$this->conexion= new  Conexion();				
			$this->conn=$this->conexion->conectarse();
		}
		
		function conexion(){
		return $this->conn;
		}
		
		function registrar($cod, $rif, $tipo, $solicitante, $usuario){
			$queryRegistrar = "insert into solicitud (codigo, solicitante, tipo, rif_empresa, user_name) 
								values ('".$cod."', '".$solicitante."', '".$tipo."','".$rif."','".$usuario."')";			
			$registrar = mysqli_query($this->conn, $queryRegistrar) or die(mysqli_error($this->conn));

			if($registrar){
				echo "<script>
				alert('Registro Exitoso');
				window.location.href='../vistas/L_solicitud.php';
				</script>";
			}else{
				echo '<script>
					alert("\xa1Campos Incompletos!");
					location.href="../vistas/L_solicitud.php";
					</script>';
			}
		}
		
		function listarProcesado(){
			$_pagi_sql = "SELECT * FROM solicitud WHERE estado = 1  order by fecha";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 1000; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  class='order-table table' summary='solicitud'>
						<caption>Listado de Solicitudes Procesadas</caption>
						<thead>
							<tr>
								<th width='10%'>Código</th>
								<th width='10%'>Tipo</th>
								<th width='10%'>Fecha</th>
								<th width='10%'>Solicitante</th>
								<th width='5%' colspan='1'>Acción</th>
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
							<td align='center'>";
								if ($row["tipo"] == "1"){
									echo "Inspección";
								}else{
									echo "Re-inspeccion";
								}
					echo"	</td>
							<td align='center'>";
								echo date("d/m/Y",strtotime($row["fecha"]));
					echo "	</td>
							<td align='center'>
								".$row["solicitante"]."
							</td>
							<td width='5%' align='center'>
								<a target='_blank' href='../vistas/M_solicitud.php?nro=".$row["codigo"]."' title='Certificado'>
									<img src='../images/iconos/ico_impresora.png' alt='Certificado' />
								</a>
							</td>
						</tr>";
				}
			}
			echo "	</tbody>
				</table>
				</div>";

		}
		
		function listar(){
			$_pagi_sql = "SELECT solicitud.fecha, solicitud.codigo, empresa.nombre, solicitud.tipo, solicitud.estado FROM solicitud, empresa WHERE solicitud.rif_empresa = empresa.rif order by fecha asc";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 30; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  class='order-table table' summary='solicitud'>
						<caption>Listado de Solicitudes</caption>
						<thead>
							<tr>
								<th width='10%'>Código</th>
								<th width='30%'>Empresa</th>
								<th width='10%'>Tipo</th>
								<th width='10%'>Fecha</th>
								<th width='10%'>Estado</th>
								<th width='9%' colspan='3'>Acción <a href='../vistas/R_solicitud.php' title='Nuevo'><img id ='agregar' src='../images/iconos/ico_agregar.png' alt='Nuevo' /></a></th>
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
								".$row["nombre"]." 
							</td>
							<td align='center'>";
								if ($row["tipo"] == "1"){
									echo "Inspección";
								}else{
									echo "Re-inspeccion";
								}
					echo"	</td>
							<td align='center'>";
								echo date("d/m/Y",strtotime($row["fecha"]));
					echo "	</td>
							<td align='center'>";
								if ($row["estado"] == "0"){
									echo "<strong><font color= 'red'>NO PROCESADO</font></stron>";
								}else{
									echo "<strong><font color= 'green'>PROCESADO</font></stron>";
								}
					echo "	</td>
							<td width='3%' align='center'>
								<a href='../vistas/M_solicitud.php?nro=".$row["codigo"]."' title='Editar'>
									<img src='../images/iconos/ico_editar.png' alt='Editar' />
								</a>
							</td>
							<td  width='3%'align='center'>
								<a href='../vistas/E_solicitud.php?nro=".$row["codigo"]."' title='Eliminar'>
									<img src='../images/iconos/ico_eliminar.png' alt='Eliminar' />
								</a>
							</td>
							<td  width='%'align='center'>";
								if ($row["estado"] == "0"){
									echo "<a target='_blank' href='../reportes/constancia_tramitacion.php?nro=".$row["codigo"]."' title='Constancia de Tramitación'>";
								}else{
									echo "<a target='_blank' href='../reportes/certificado.php?nro=".$row["codigo"]."' title='Certificado'>";
								}
				    echo"	     	<img src='../images/iconos/ico_impresora.png' alt='imprimir' />
								</a>
							</td>
						</tr>";
				}
			}
			echo "	</tbody>
				</table>
				</div>";
			echo"<center><p>".$_pagi_navegacion."</p></center>";

		}
		
		function modificar($codigo, $rif, $tipo, $solicitante, $estado, $clave){
			$queryUpdate = "update solicitud set rif_empresa = '".$rif."', solicitante = '".$solicitante."',  codigo = '".$codigo."', tipo = '".$tipo."', estado = '".$estado."' where codigo = ".$clave;
			$update =mysqli_query($this->conn, $queryUpdate);

			if($update){
				echo '<script>
					alert("Modificaci\xf3n Exitosa");
					location.href="../vistas/L_solicitud.php";
					</script>';
			}else{
				echo "Error de Actualización";
			}
		}
		
		function eliminar($clave){
			$queryDelete = "delete from solicitud where codigo = '".$clave."'";
			$delete =mysqli_query($this->conn, $queryDelete);

			if($delete){						
				echo '<script>
						alert("Eliminaci\xf3n Exitosa");
						location.href="../vistas/L_solicitud.php";
				</script>';						
			}else{
				echo '<script>
						alert("\xa1No se puede eliminar existen Registros Asociados!");
						location.href="../vistas/L_solicitud.php";
				</script>';	
			}
		}
	
		function MostrarRegistro($clave){
			$sql= "SELECT solicitud.codigo, solicitud.fecha, solicitud.rif_empresa, solicitud.tipo, solicitud.estado, solicitud.solicitante, empresa.nombre FROM solicitud, empresa WHERE empresa.rif = solicitud.rif_empresa and codigo = '".$clave."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			echo "<div class='general'>
					<table  summary='solicitud'>
						<caption>ELIMINAR REGISTRO DE SOLICITUD</caption>
						<tbody>
							<tr>
								<th align='right' width='20%'>Código:</th>
								<td>
									".$row["codigo"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Rif:</th>
								<td>
									".$row["rif_empresa"]." - ".$row["nombre"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Tipo:</th>
								<td>";
									if ($row["tipo"] == 1){
										echo "Inspección";
									}else{
										echo "Re-inspección";
									}
			echo"				</td>
							</tr>
							<tr>
								<th align='right'>Estado:</th>
								<td>";
									if ($row["estado"] == 1){
										echo "Procesado";
									}else{
										echo "No Procesado";
									}
			echo"				</td>
							</tr>
							<tr>
								<th align='right'>Fecha:</th>
								<td>";
									echo date("d/m/Y",strtotime($row["fecha"]));
			echo"				</td>
							</tr>
							<tr>
								<th align='right'>Solicitante:</th>
								<td>
									".$row["solicitante"]."
								</td>
							</tr>
						</tbody>
		            </table>
                 </div>";

		}
		
		
		function CargarFormulario($nro){
			$sql= "SELECT * FROM solicitud WHERE codigo = '".$nro."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			   echo '<label>Código:
							<span class="small">Código de la Solicitud(*)</span>
						</label>
						<input type="text" name="cod" readonly="readonly" id="cod" style = "background-color : rgb(243,243,245);" value ="'.$row["codigo"].'" required="required" >
						<label>Rif:
							<span class="small">Rif de la Empresa(*)</span>
						</label>
						<input type="text" name="rif" readonly="readonly" style = "background-color : rgb(243,243,245);" id="rif" value ="'.$row["rif_empresa"].'" required="required" >
						<label>Tipo:
							<span class="small">Tipo de Inspección(*)</span>
						</label>
						<select name="tipo" id ="tipo" required="required">
							<option value="">(Seleccionar)</option>';
							$seleccion = array('1'=>'Inspección','2'=>'Re-inspección');
							foreach ($seleccion as $value => $tipo){
								echo "<option value='".$value."'";
								if ($value == $row["tipo"]){
									echo ' selected>';
								}
								else{ 
									echo '>';
								}
								echo $tipo;
								echo '</option>';
							}
				echo'	</select>
						<label>Estado:
							<span class="small">Estado de la Solicitud(*)</span>
						</label>
						<select name="estado" id ="estado" required="required">
							<option value="">(Seleccionar)</option>';
							$seleccion = array('1'=>'Procesado','0'=>'No Procesado');
							foreach ($seleccion as $value => $estado){
								echo "<option value='".$value."'";
								if ($value == $row["estado"]){
									echo ' selected>';
								}
								else{ 
									echo '>';
								}
								echo $estado;
								echo '</option>';
							}
				echo'		</select>
						<label>Solicitante:
							<span class="small">Nombre y Apellido del Solicitante(*)</span>
						</label>
						<input type="text" name="solicitante" id="solicitante" value ="'.$row["solicitante"].'" maxlength = "100" required="required" />';
		}
		
		function cargarRif(){
			$sql = " SELECT * FROM empresa";
			$rs=mysqli_query($this->conn, $sql);
			if(mysqli_num_rows($rs)>0){
				while ($row = mysqli_fetch_array($rs)){
				echo "<option value='".$row["rif"]."'>
					        ".$row["rif"]." - ".$row["nombre"]." 
					  </option>";
				}
			}
		}
		
		function cargarRifForm($rif){
			$sql = " SELECT * FROM empresa";
			$rs=mysqli_query($this->conn, $sql);
			if(mysqli_num_rows($rs)>0){
				while ($row = mysqli_fetch_array($rs)){
				echo "<option value='".$row["rif"]."'";
						if ($row["rif"] == $rif){
							echo ' selected>';
						}
						else{ 
							echo '>';
						}
					    echo $row["rif"]." - ".$row["nombre"];	
				echo"  </option>";
				}
			}

		}
		
		
		
		function validarCodigo($clave){
			 if ( preg_match("/\s/",$clave) == 1){  
				return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Se Permiten Espacios</h1></div>";  
			}else{  
				$sql = "SELECT * FROM solicitud WHERE codigo = '".$clave."'";  
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