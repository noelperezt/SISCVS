<?php 
		class Conexion{
			var $host;
			var $usuario;
			var $contrasena;
			var $baseDatos;
			var $email;
			var $email_contrasena;
		
			function Conexion(){
				$this->host="localhost";
				$this->usuario="root"; 
				$this->contrasena=""; 
				$this->baseDatos="siscvs"; 
				$this->email = "siscvs.piar@gmail.com";
				$this->email_contrasena = "plataforma";
			}
			
			
			function conectarse(){
				$enlace = mysqli_connect($this->host, $this->usuario, $this->contrasena, $this->baseDatos);
				if($enlace){
					
				}else{
					die('Error de Conexión (' . mysqli_connect_errno() . ') '.mysqli_connect_error());
				}
				return($enlace);
				mysqli_close($enlace); 
			}
		}

?>
