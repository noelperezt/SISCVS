<?php
	require_once "../conexion/conexion.php";
	require_once("../modelo/usuarios.php");
	$usuarios = new usuarios();
	class usuarios{
		var $conn;
		var $conexion;

		function usuarios(){
			$this->conexion= new  Conexion();				
			$this->conn=$this->conexion->conectarse();
		}
		
		function conexion(){
		return $this->conn;
		}
		
		function usuario($user){
			$sql = "SELECT * FROM usuario WHERE user_name = '".$user."'";  
			$rs = mysqli_query($this->conn, $sql);  
            if(mysqli_num_rows($rs)<1 ){  
				return true;
			}else{  
				return false;
			}  
		}
	
		function getApellidos($usuario){
			$sql= "SELECT * FROM usuario WHERE user_name = '".$usuario."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			if (mysqli_num_rows($rs)>0){
				return $row["apellido"];
			}

		}
		
		
		function cambioClave($usuario,$clave){
			$encriptado = $this->encrypt($clave, $usuario);
			$queryUpdate = "update usuario set clave = '".$encriptado."' where user_name = '".$usuario."'";
			$update =mysqli_query($this->conn, $queryUpdate);

			if($update){
				echo "<script>
						alert('Cambio de Clave Exitoso');
						location.href='../vistas/inicio.php';
                      </script>";
			}else{
				echo "Error Al Actualizar";
				}
		}

		function getClave($usuario){
			$sql= "SELECT * FROM usuario WHERE user_name = '".$usuario."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			if (mysqli_num_rows($rs)>0){
				return $row["clave"];
			}

		}
		
		function getNombres($usuario){
			$sql= "SELECT * FROM usuario WHERE user_name = '".$usuario."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			if (mysqli_num_rows($rs)>0){
				return $row["nombre"];
			}

		}
		
		function registrar($user, $clave, $nombre, $apellido, $correo_elec){
			$queryRegistrar = "insert into usuario (user_name,clave,nombre, apellido,correo_elec) values ('".$user."', '".$clave."', '".$nombre."', '".$apellido."', '".$correo_elec."')";			
			$registrar = mysqli_query($this->conn, $queryRegistrar) or die(mysqli_error($this->conn));
			
			if($registrar){
				echo "<script>
				alert('Registro Exitoso');
				window.location.href='../vistas/L_usuarios.php';
				</script>";
			}else{
				echo '<script>
				alert("\xa1Campos Incompletos!");
				location.href="../vistas/L_usuarios.php";
				</script>';
			}
		}
		
 
		function descifrar($contrasena, $cifrada, $clave = "admin"){
			$descifrado = $this->decrypt($cifrada, $clave);
			if($contrasena ==$descifrado ){
				return true;
			}else{
				return false;
			}	
		}
		
		function encrypt ($cadena, $clave = "admin"){
			$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($clave), $cadena, MCRYPT_MODE_CBC, md5(md5($clave))));
			return $output;
		}
		
		function decrypt ($cadena, $clave = "admin"){
			$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($clave), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($clave))), "\0");
			return $output;
		}
		
		function validarUsuario($user){
			 if ( preg_match("/\s/",$user) == 1){  
				return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Se Permiten Espacios</h1></div>";  
			}else{  
				$sql = "SELECT * FROM usuario WHERE user_name = '".$user."'";  
				$rs = mysqli_query($this->conn, $sql);  
              
				if($user == ""){   
					return "<div id ='advertencia'><h1 id='msj_user' style='color:orange; ' mce_style='color:orange'><img id = 'icono' src='../images/iconos/ico_advertencia.png' alt='Nuevo' /> Campo Vacío</h1></div>";  
				}elseif(mysqli_num_rows($rs)<1 ){  
					  	return "<div id ='correcto'><h1 id='msj_user' style='color:green' mce_style='color:green'><img id = 'icono' src='../images/iconos/ico_exitoso.png' alt='Nuevo' /> Disponible</h1></div>"; 
				}else{  
					return "<div id ='error'><h1 id='msj_user' style='color:red' mce_style='color:red'><img id = 'icono' src='../images/iconos/ico_error.png' alt='Nuevo' /> No Disponible</h1></div>";
				}  
			}

		}
		
		
		function listar(){
			$_pagi_sql = "SELECT * FROM usuario where user_name <> 'admin'";
			$rs=mysqli_query($this->conn, $_pagi_sql);	
			$con = mysql_connect($this->conexion->host,$this->conexion->usuario,$this->conexion->contrasena) or die (mysql_error()); 
			mysql_select_db($this->conexion->baseDatos,$con) or die (mysql_error());
			$_pagi_cuantos = 30; 
			include("paginator.inc.php"); 
			echo "<div class='general'>
					<table  summary='aulas'>
						<caption>Listado de Usuarios</caption>
						<thead>
							<tr>
								<th width = '12%'>Usuario</th>
								<th width = '12%'>Nombre y Apellido</th>
								<th width = '12%'>Correo Electrónico</th>
							</tr>
						</thead>
					<tbody>";
			$i=0;
			if(mysqli_num_rows($rs)<1){
				echo "<tr>
						<td colspan='4' align='center'>La consulta no devolvió registros</td>
				      </tr>";
			}else{
				while ($row = mysql_fetch_array($_pagi_result)){
					echo "<tr>
							<td align='center'>
								".$row["user_name"]."
							</td>         
							<td align='center'>
								".$row["nombre"]." ".$row["apellido"]."
							</td>  
							<td align='center'>
								".$row["correo_elec"]."
							</td> 
						</tr>";
					$i++; 
				}
			}
			echo "	</tbody>
				</table>
				</div>";
			echo"<center><p>".$_pagi_navegacion."</p></center>";

			mysql_close();
		}
		

		
		function CargarFormulario($nombre){
			$sql= "SELECT * FROM usuario WHERE user_name = '".$nombre."'";
			$rs=mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($rs);
			echo '<label>Nombre de Usuario:
							<span class="small">Nombre para acceder a SISCVS(*)</span>
						</label>
						<img id = "img_user"  src=""../images/iconos/ico_usuario.png"">
						<input type="text" value ="'.$row["user_name"].'" onclick= "verificar(); document.getElementById('."'".'status_usr'."'".').style.display='."'".'block'."'".'; this.focus(); return false;" onblur="document.getElementById('."'".'status_usr'."'".').style.display='."'".'none'."'".';"
						onkeyup="verificar(); document.getElementById('."'".'status_usr'."'".').style.display='."'".'block'."'".'; this.focus(); return false;"  name="user_validar" id="user_validar"  value="" maxlength = "25" required="required" />
						<div name="status_usr" id="status_usr" style="display:none"></div>
						<label>Nombres:
							<span class="small">Nombres del Usuario(*)</span>
						</label>
						<input type="text" name="nombre" id="nombre" maxlength = "40" value ="'.$row["nombre"].'" required="required" />
						<label>Apellidos:
							<span class="small">Apellidos del Usuario(*)</span>
						</label>
						<input type="text" name="apellido" id="apellido" maxlength = "40" value ="'.$row["apellido"].'" required="required" />
						<label>Correo Electrónico:
							<span class="small">Correo del Usuario(*)</span>
						</label>
						<input type="email" name="email" value ="'.$row["correo_elec"].'" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" id="email" maxlength = "50" required="required" />';
		}
		
		function modificar($user, $nombre, $apellido, $email, $clave){
			$queryUpdate = "update usuario set user_name = '".$user."', nombre = '".$nombre."', apellido = '".$apellido."', correo_elec = '".$email."' where user_name = '".$clave."'";
			$update =mysqli_query($this->conn, $queryUpdate);

			if($update){
				echo "<script>
				      alert('Modificacion Exitosa');
                      location.href='../vistas/inicio.php';
                      </script>";
			}else{
				echo "Error de Actualización";
				}
		}
	}
?>	