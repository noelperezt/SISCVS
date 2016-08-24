<?php
	require_once "../conexion/conexion.php";
	require_once "../modelo/empresas.php";
	class empresas{
		var $conn;
		var $conexion;

		function empresas(){
			$this->conexion= new  Conexion();				
			$this->conn=$this->conexion->conectarse();
		}
		
		function conexion(){
		return $this->conn;
		}
		
		function registrar($rif, $nombre, $direccion, $representante,$cedula,$tel,$email,$ramo){
			$queryRegistrar = "insert into empresa (rif, nombre, direccion, representante, ced_representante, telefono, correo_electronico, cod_ramo) 
								values ('".$rif."', '".$nombre."','".$direccion."', '".$representante."','".$cedula."','".$tel."','".$email."', '".$ramo."')";			
			$registrar = mysqli_query($this->conn, $queryRegistrar) or die(mysqli_error($this->conn));

			if($registrar){
				echo "<script>
				alert('Registro Exitoso');
				window.location.href='../vistas/L_empresas.php';
				</script>";
			}else{
				echo '<script>
					alert("\xa1Campos Incompletos!");
					location.href="../vistas/L_empresas.php";
					</script>';
			}
		}
		
		function listar(){
			$_pagi_sql = "SELECT * FROM empresa";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 100; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  class='order-table table' summary='empresas'>
						<caption>Listado de Empresas</caption>
						<thead>
							<tr>
								<th width='4%'> Rif</th>
								<th width='30%'>Nombre</th>
								<th width='30%'>Representante</th>
								<th width='5%'>Ramo</th>
								<th width='6%' colspan='3'>Acción <a href='../vistas/R_empresas.php' title='Nuevo'><img id ='agregar' src='../images/iconos/ico_agregar.png' alt='Nuevo' /></a></th>
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
								".$row["rif"]."
							</td>         
							<td align='center'>
								".$row["nombre"]." 
							</td>
							<td align='center'>
								".$row["representante"]."
							</td>
							<td align='center'>
								".$row["cod_ramo"]."
							</td>
							<td width='3%' align='center'>
								<a href='../vistas/D_empresas.php?nro=".$row["rif"]."' title='Detalle'>
									<img src='../images/iconos/ico_detalle.png' alt='Editar' />
								</a>
							</td>
							<td width='3%' align='center'>
								<a href='../vistas/M_empresas.php?nro=".$row["rif"]."' title='Editar'>
									<img src='../images/iconos/ico_editar.png' alt='Editar' />
								</a>
							</td>
							<td  width='3%'align='center'>
								<a href='../vistas/E_empresas.php?nro=".$row["rif"]."' title='Eliminar'>
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
		
		function listarNoProcesados(){
			$_pagi_sql = "SELECT * FROM solicitud WHERE estado = 0  order by fecha";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 20; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  class='order-table table' summary='solicitud'>
						<caption>Solicitudes No Procesadas</caption>
						<thead>
							<tr>
								<th width='10%'>Código</th>
								<th width='10%'>Tipo</th>
								<th width='10%'>Fecha</th>
								<th width='10%'>Solicitante</th>
								<th width='6%' colspan='3'>Acción</th>
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
							<td width='2%' align='center'>
								<a href='../vistas/M_solicitud.php?nro=".$row["codigo"]."' title='Editar'>
									<img src='../images/iconos/ico_editar.png' alt='Editar' />
								</a>
							</td>
							<td  width='2%'align='center'>
								<a href='../vistas/E_solicitud.php?nro=".$row["codigo"]."' title='Eliminar'>
									<img src='../images/iconos/ico_eliminar.png' alt='Eliminar' />
								</a>
							</td>
							<td  width='2%'align='center'>
								<a target='_blank' href='../reportes/constancia_tramitacion.php?nro=".$row["codigo"]."' title='Constancia de Tramitación'>
									<img src='../images/iconos/ico_impresora.png' alt='imprimir' />
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
		
		function listarNoProcesado($clave){
			$_pagi_sql = "SELECT * FROM solicitud WHERE estado = 0 and rif_empresa = '".$clave."' order by fecha";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error()); 
			$_pagi_cuantos = 1000; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  class='order-table table' summary='solicitud'>
						<caption>Listado de Solicitudes No Procesadas</caption>
						<thead>
							<tr>
								<th width='10%'>Código</th>
								<th width='10%'>Tipo</th>
								<th width='10%'>Fecha</th>
								<th width='10%'>Solicitante</th>
								<th width='9%' colspan='3'>Acción</th>
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
							<td  width='3%'align='center'>
								<a target='_blank' href='../reportes/constancia_tramitacion.php?nro=".$row["codigo"]."' title='Constancia de Tramitación'>
									<img src='../images/iconos/ico_impresora.png' alt='imprimir' />
								</a>
							</td>
						</tr>";
				}
			}
			echo "	</tbody>
				</table>
				</div>";

		}
		
		function listarProcesado($clave){
			$_pagi_sql = "SELECT * FROM solicitud WHERE estado = 1 and rif_empresa = '".$clave."' order by fecha";
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
							<td  width='5%'align='center'>
								<a target='_blank' href='../reportes/certificado.php?nro=".$row["codigo"]."' title='Certificado'>
									<img src='../images/iconos/ico_impresora.png' alt='imprimir' />
								</a>
							</td>
						</tr>";
				}
			}
			echo "	</tbody>
				</table>
				</div>";

		}
		
		function modificar($rif, $nombre, $direccion, $representante,$cedula,$tel,$email,$ramo, $clave){
			$queryUpdate = "update empresa set rif = '".$rif."', nombre = '".$nombre."',  direccion = '".$direccion."', representante = '".$representante."',
							correo_electronico = '".$email."', telefono = '".$tel."', ced_representante = '".$cedula."', cod_ramo = '".$ramo."' where rif = ".$clave;
			$update =mysqli_query($this->conn, $queryUpdate);

			if($update){
				echo '<script>
					alert("Modificaci\xf3n Exitosa");
					location.href="../vistas/L_empresas.php";
					</script>';
			}else{
				echo "Error de Actualización";
			}
		}
		
		function eliminar($clave){
			$queryDelete = "delete from empresa where rif = '".$clave."'";
			$delete =mysqli_query($this->conn, $queryDelete);

			if($delete){						
				echo '<script>
						alert("Eliminaci\xf3n Exitosa");
						location.href="../vistas/L_empresas.php";
				</script>';						
			}else{
				echo '<script>
						alert("\xa1No se puede eliminar existen Registros Asociados!");
						location.href="../vistas/L_empresas.php";
				</script>';	
			}
		}
	
		function MostrarRegistro($clave){
			$sql= "SELECT * FROM empresa WHERE rif = '".$clave."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			echo "<div class='general'>
					<table  summary='empresas'>
						<caption>ELIMINAR REGISTRO DE EMPRESAS</caption>
						<tbody>
							<tr>
								<th align='right' width='20%'>Rif:</th>
								<td>
									".$row["rif"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Nombre:</th>
								<td>
									".$row["nombre"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Direccion:</th>
								<td>
									".$row["direccion"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Representante:</th>
								<td>
									".$row["representante"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Cedula:</th>
								<td>
									".$row["ced_representante"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Teléfono:</th>
								<td>
									".$row["telefono"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Correo Eléctronico:</th>
								<td>
									".$row["correo_electronico"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Ramo:</th>
								<td>
									".$row["cod_ramo"]."
								</td>
							</tr>
						</tbody>
		            </table>
                 </div>";

		}
		
		function MostrarDetalle($clave){
			$sql= "SELECT * FROM empresa WHERE rif = '".$clave."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			echo "<div class='general'>
					<table  summary='empresa'>
						<caption>DATOS DE LA EMPRESA</caption>
						<tbody>
							<tr>
								<th align='right' width='20%'>Rif:</th>
								<td>
									".$row["rif"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Nombre:</th>
								<td>
									".$row["nombre"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Dirección:</th>
								<td>
									".$row["direccion"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Ramo:</th>
								<td>
									".$row["cod_ramo"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Representante:</th>
								<td>
									".$row["representante"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Cédula:</th>
								<td>
									".$row["ced_representante"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Teléfono:</th>
								<td>
									".$row["telefono"]."
								</td>
							</tr>
							<tr>
								<th align='right'>Correo Eléctronico:</th>
								<td>
									".$row["correo_electronico"]."
								</td>
							</tr>
						</tbody>
		            </table>
                 </div>";

		}
		
		
		function CargarFormulario($nro){
			$sql= "SELECT * FROM empresa WHERE rif = '".$nro."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			   echo '<label>Rif:
							<span class="small">Rif de la Empresa(*)</span>
						</label>
						<input type="number" name="rif" id="rif" min = "100" max = "100000000" required="required" value ="'.$row["rif"].'" onKeyPress="return checkIt(event)" onblur="document.getElementById('."'".'status_usr'."'".').style.display='."'".'none'."'".';"
						onkeyup="verificarCodigo(); document.getElementById('."'".'status_usr'."'".').style.display='."'".'block'."'".'; this.focus(); return false;" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<label>Nombre:
							<span class="small">Nombres de la Empresa(*)</span>
						</label>
						<input type="text" name="nombre" id="nombre" maxlength = "25" required="required" value ="'.$row["nombre"].'" />
						<label>Ramo:
							<span class="small">Ramo de la Empresa(*)</span>
						</label>
						<select name="ramo" id ="ramo">
							<option value="">(Seleccionar)</option>';
							$this->cargarRamoForm($row["cod_ramo"]);
				echo    '</select>
						<label>Dirección:
							<span class="small">Direccion de la Empresa(*)</span>
						</label>
						<textarea name="direccion" rows="4" cols="74" maxlength = "100" required="required">'.$row["direccion"].'</textarea>
						<label>Representante:
							<span class="small">Representante de la Empresa (*)</span>
						</label>
						<input type="text" name="representante" id="representante" maxlength = "25" required="required" value ="'.$row["representante"].'"/>
						<label>Cédula:
							<span class="small">Cédula del Representante (*)</span>
						</label>
						<input type="number" name="cedula" id="cedula" min = "100" max = "100000000" required="required" value ="'.$row["ced_representante"].'" onKeyPress="return checkIt(event)" onblur="document.getElementById('."'".'status_usr1'."'".').style.display='."'".'none'."'".';"
						onkeyup="verificarCedula(); document.getElementById('."'".'status_usr1'."'".').style.display='."'".'block'."'".'; this.focus(); return false;" />
						<div name="status_usr1" id="status_usr1" style="display:none"></div>
						<label>Teléfono:
							<span class="small">Teléfono Principal (*)</span>
						</label>
						<input type="tel" name="telefono" id="telefono" required="required" value ="'.$row["telefono"].'" />
						<label>Correo Electrónico:
							<span class="small">Correo de la Empresa(*)</span>
						</label>
						<input type="email" name="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="email" maxlength = "50" required="required" value ="'.$row["correo_electronico"].'" />';

		}
		
		function validarCodigo($clave){
			 if ( preg_match("/\s/",$clave) == 1){  
				return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Se Permiten Espacios</h1></div>";  
			}else{  
				$sql = "SELECT * FROM empresa WHERE rif = '".$clave."'";  
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
		
		function cargarRamo(){
			$sql = " SELECT * FROM ramo";
			$rs=mysqli_query($this->conn, $sql);
			if(mysqli_num_rows($rs)>0){
				while ($row = mysqli_fetch_array($rs)){
				echo "<option value='".$row["codigo"]."'>
					        ".$row["codigo"]." - ".$row["descripcion"]." 
					  </option>";
				}
			}
		}
		
		function cargarRamoForm($ramo){
			$sql = " SELECT * FROM ramo";
			$rs=mysqli_query($this->conn, $sql);
			if(mysqli_num_rows($rs)>0){
				while ($row = mysqli_fetch_array($rs)){
				echo "<option value='".$row["codigo"]."'";
						if ($row["codigo"] == $ramo){
							echo ' selected>';
						}
						else{ 
							echo '>';
						}
					    echo $row["codigo"]." - ".$row["descripcion"];	
				echo"  </option>";
				}
			}

		}
		
		function validarCedula($clave){
			 if ( preg_match("/\s/",$clave) == 1){  
				return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Se Permiten Espacios</h1></div>";  
			}else{  
				$sql = "SELECT * FROM empresa WHERE ced_representante = '".$clave."'";  
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