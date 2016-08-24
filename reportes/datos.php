<?php
require_once ("../modelo/usuarios.php");
require_once ("../conexion/conexion.php");
require_once('../mail/class.phpmailer.php');
require '../mail/PHPMailerAutoload.php';

$conexion= new  Conexion();				
$conn= $conexion->conectarse();
$usuarios = new usuarios();		

$codigo = $_POST["user"];


$sql= "SELECT * FROM usuario WHERE user_name = '".$codigo."'";
$rs=mysqli_query($conn,$sql);
$row = mysqli_fetch_array($rs);
$correo = $row["correo_elec"];
$destinatario = $row["apellido"]." ".$row["nombre"];

date_default_timezone_set('America/Caracas');

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $conexion->email;
$mail->Password = $conexion->email_contrasena;
$mail->setFrom($conexion->email, 'SISCVS');
$mail->addReplyTo($conexion->email, 'SISCVS');
$mail->addAddress($correo, $destinatario);
$mail->Subject = '.::Recuperacion de Clave::.';
$cuerpo = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; ">
<title>Título</title>
</head>
 
<body>
<center>
<table   id = "tabla"  cellpadding="0" cellspacing="0">
<tr style="border: inset 0pt;  color: white;">
<td align="center" style="border: inset 0pt; border-radius: 30px;">
</td>
<td width="700" height ="10" align="center" >
</td>
</tr>
<tr>
<td align="center" colspan = "2">
<h2 style = "font-family: "lucida sans unicode", "lucida grande", sans-serif;
font-size: 24x; color: #787373;
text-transform: uppercase;">Datos de Usuario SISCVS</h2>
<p style = "font-family: arial, sans-serif;
color: #050505;font-size: 14px;"><strong>Usuario:</strong>'.$row["user_name"].', <strong>clave:</strong>'.$usuarios->decrypt($row["clave"]).'</p>
<p style = "font-family: arial, sans-serif;
color: #050505;
font-size: 14px;">Si no reconoce esta transaccion comuniquese con la administracion.</p>
</td>
</tr>
<tr >
<td align="center" colspan = "2">
</td>
</tr>
</table>
</center>
</body>
</html>';
$mail->msgHTML($cuerpo);
if (!$mail->send()) {
    echo "<script>
			alert('No se pudo Enviar el correo revise su nombre de usuario');
			 location.href='../vistas/login.php';
		</script>";
} else {
	echo "<script>
			alert('Datos Enviados al Correo: ".$row["correo_elec"]."');
			 location.href='../vistas/login.php';
		</script>";
}
