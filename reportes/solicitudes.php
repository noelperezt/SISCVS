<?php
require_once ("../conexion/conexion.php");
require_once('../reportes/tcpdf_include.php');

$conexion= new  Conexion();			
$conn= $conexion->conectarse();
		
class MYPDF extends TCPDF {
	public function Header() {

	}

	public function Footer() {

	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SISCVS');
$pdf->SetTitle('LISTADO DE SOLICITUDES');


$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(20, 0, 20, 0);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$pdf->AddPage();

$parametro = $_POST["fecha_c"];
$llegofecha=trim($parametro); 
$cadena=explode("/",$llegofecha);
$fecha = $cadena[2]."-".$cadena[1]."-".$cadena[0];

$pdf->SetY(12);
$pdf->SetFont('helvetica', '', 8);

$sql=" SELECT date_format(solicitud.fecha, '%Y-%m-%d') as fecha, solicitud.codigo, empresa.nombre, solicitud.tipo, solicitud.estado FROM solicitud, empresa WHERE solicitud.rif_empresa = empresa.rif and date_format(solicitud.fecha, '%Y-%m-%d') = '".$fecha."' ";
$rs=mysqli_query($conexion->conectarse(),$sql);

$tbl= '<p align = "center" style="color:#0B0B61">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>ESTADO BOLÍVAR<br>ALCALDÍA DEL MUNICIPIO PIAR</p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 9);
$tbl='<p align = "center" style="color:#0B0B61">SERVICIO AUTONOMO DE SEGURIDAD CIUDADANA</p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 10);
$tbl='<p align = "center" style="color:#0B0B61"><strong>CUERPO DE BOMBEROS DEL MUNICIPIO PIAR<strong></p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetY(31);
$pdf->SetFont('helvetica', '', 7);
$tbl='<p align = "center" style="color:#0B0B61"><strong><u>DEPERTAMENTO TECNICO DE PREVENCION E INVESTIGACIÓN DE INCENDIOS Y OTROS SINIESTROS</u></strong></p>';
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->Image(K_PATH_IMAGES.'logo1.jpg', 10, 7, 23, 23, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo2.jpg', 34, 7, 26, 21, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo.jpg', 180, 7, 15, 23, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo3.jpg', 152, 7, 21, 22, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);


$pdf->SetFont('helvetica', 'N', 15);
$pdf->SetY(40);
$html = '<p align = "center">LISTADO DE SOLICITUDES DEL '.date("d/m/Y", strtotime($fecha)).'</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', 'N', 11);
$pdf->SetY(50);
$cabecera = '<table  nobr="true">
				<thead>
				<tr align="center" style = "border: 1px solid black; background-color:#0B0B61; color:white;">
					<th style = "border: 1px solid black;" width="15%"> Código</th>
					<th style = "border: 1px solid black;" width="45%">Empresa</th>
					<th style = "border: 1px solid black;" width="20%">Tipo</th>
					<th style = "border: 1px solid black;" width="20%">Estado</th>
				</tr>
				</thead>';
if(mysqli_num_rows($rs)<1){
$cuerpo = '<tr>
			<td colspan="4" style = "border: 1px solid black;" align="center">La consulta no devolvió registros</td>
		</tr>';
}else{
	$i = 0;
	$cuerpo = '';
	while($row = mysqli_fetch_array($rs)){
		if ($row["estado"] == 0){
			$estado = 'No Procesado';
		}else{
			$estado = 'Procesado';
		}
		
		if ($row["tipo"] == 1){
			$tipo = 'Inspección';
		}elseif ($row["tipo"] == 2){
			$tipo = 'Re-Inspección';
		}
		$primero = '<tr style = "border: 1px solid black;">
						<td style = "border: 1px solid black;" width="15%" align="center">
						'.$row['codigo'].'
						</td>         
						<td style = "border: 1px solid black;" width="45%" align="center">
						'.$row["nombre"].'
						</td>
						<td style = "border: 1px solid black;" width="20%" align="center">
						'.$tipo.'
						</td>
						<td style = "border: 1px solid black;" width="20%" align="center">
						'.$estado.'
						</td>
					</tr>';
				$cuerpo = $cuerpo.$primero;
		$i++;
	}
}
$pie = '
</table>';

$tbl1 = $cabecera.$cuerpo.$pie;	
$pdf->writeHTML($tbl1, true, false, false, false, '');


$pdf->Output('Listado de Solicitud.pdf', 'I');


