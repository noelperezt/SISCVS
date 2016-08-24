<?php
require "../conexion/conexion.php";
require_once "../modelo/usuarios.php";
$conexion= new  Conexion();
$usuarios = new  usuarios();
mysql_connect($conexion->host,$conexion->usuario,$conexion->contrasena)or die ('Ha fallado la conexión: '.mysql_error());
mysql_select_db($conexion->baseDatos)or die ('Error al seleccionar la Base de Datos: '.mysql_error());
$usuario = isset($_GET['username']) ? $_GET['username'] : null ;
$password = isset($_GET['password']) ? $_GET['password'] : null ;
$result = mysql_query("SELECT * FROM usuario WHERE user_name = '$usuario'");
if($row = mysql_fetch_array($result))
{     
if($usuarios->descifrar($password,$row["clave"])) 
 {
		session_start(); 
		$_SESSION['usuario']  = $usuario;
		header("Location: ../vistas/inicio.php"); 
 }
 else
 {
  ?>
   <script languaje="javascript">
    alert("\xa1Contrase\xf1a Incorrecta!");
    location.href = "../vistas/login.php";
   </script>
  <?php          
 }
}
else
{
?>
 <script languaje="javascript">
  alert("\xa1El Nombre de Usuario es Incorrecto!");
  location.href = "../vistas/login.php";
 </script>
<?php          
}
mysql_free_result($result);
mysql_close();
?>