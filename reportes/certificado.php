<?php
require_once ("../conexion/conexion.php");
require_once ("../modelo/AifLibNumber.php");
require_once('../reportes/tcpdf_include.php');

$conexion= new  Conexion();		
$numero = new AifLibNumber();		
$conn= $conexion->conectarse();
		
class MYPDF extends TCPDF {
	public function Header() {

	}

	public function Footer() {
		$this->SetY(-32);
		$this->SetX(18);
		$this->SetFont('timesI','BI',12);
		$html = '<p align="center" style="color:#0B0B61">¡Fortaleciendo la Prevención!</p>';
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$this->SetFont('helvetica','N',7);
		$html = '<p align="center" style="color:#0B0B61">CARRETERA UPATA-GUASIPATI, SECTOR SANTO DOMINGO II, UPATA, MUNICIPIO PIAR, ESTADO BOLÍVAR<br>
		TELÉFONOS (0288) 414.80.93, 414.94.67 (414.50.66 emergencia)<br>
		e-mailL:  bomberosupata@cantv.net
		</p>';
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$this->SetY($this->GetY()+3);
		$this->SetFont('helvetica', 'N', 14);
		$tbl= '<p align = "center" style="color:rgb(51,102,255);line-height: 18em; text-transform: uppercase;"><strong>COLOQUESE EN UN SITIO VISIBLE</strong></p>';
		$this->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPageOrientation('l');

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SISCVS');
$pdf->SetTitle('CERTIFICADO');


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

$solicitud = $_GET["nro"];

$pdf->SetY(12);
$pdf->SetFont('helvetica', '', 11);

$sql="select solicitud.codigo, empresa.representante, empresa.nombre, empresa.ced_representante, empresa.direccion from empresa, solicitud where solicitud.codigo = '".$solicitud."' and solicitud.rif_empresa = empresa.rif";
$rs=mysqli_query($conexion->conectarse(),$sql);
$row = mysqli_fetch_array($rs);

$vencimiento= date("d/m/Y", time() + (60 * 60 * 24 * 364) );

$tbl= '<p align = "center" style="color:#0B0B61">REPÚBLICA BOLIVARIANA DE VENEZUELA<br>ESTADO BOLÍVAR<br>ALCALDÍA DEL MUNICIPIO PIAR</p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 11);
$tbl='<p align = "center" style="color:#0B0B61">SERVICIO AUTONOMO DE SEGURIDAD CIUDADANA</p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 10);
$tbl='<p align = "center" style="color:#0B0B61"><strong>CUERPO DE BOMBEROS DEL MUNICIPIO PIAR<strong></p>';
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->SetY(36);
$pdf->SetFont('helvetica', '', 8);
$tbl='<p align = "center" style="color:#0B0B61"><strong><u>DEPERTAMENTO TECNICO DE PREVENCION E INVESTIGACIÓN DE INCENDIOS Y OTROS SINIESTROS</u></strong></p>';
$pdf->writeHTML($tbl, true, false, false, false, '');


$pdf->Image(K_PATH_IMAGES.'logo1.jpg', 30, 7, 30, 30, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo2.jpg', 60, 7, 31, 26, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo.jpg', 230, 7, 20, 30, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->Image(K_PATH_IMAGES.'logo3.jpg', 200, 7, 26, 27, 'JPG', '', '', false, 150, '', false, false, 0, false, false, false);



$pdf->SetY(42);
$pdf->SetFont('helvetica', 'N', 18);
$tbl= '<p align = "center" style="color:rgb(51,51,153)"><strong>CERTIFICADO DE CUMPLIMIENTO DE LAS<br>
VARIABLE DE SEGURIDAD
</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);


$pdf->SetFont('helvetica', 'N', 14);
$tbl= '<p align = "center" style="color:rgb(51,51,153)"><strong>N° '.$row["codigo"].'</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 14);
$tbl= '<p align = "center" style="color: rgb(51,51,153)">SE HACE SABER QUE:</p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'B', 21);
$tbl= '<p align = "center" style="color:rgb(51,51,153); text-transform: uppercase; text-shadow: 2px 2px 2px black;"><strong>'.$row["nombre"].'</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p align = "justify" style="color:rgb(51,51,153);line-height: 18em; text-transform: uppercase;"><strong>DIRECCIÓN:</strong>' .$row["direccion"].'</p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p align = "justify" style="color:rgb(51,51,153);line-height: 18em; text-transform: uppercase;"><strong>REPRESENTADO POR LA CIUDADANA: '.$row["representante"].' C. I. Nº '.number_format($row["ced_representante"],0,",",".").'</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p align = "justify" style="color:#0B0B61; line-height: 18em; text-transform: uppercase;"><strong>PARA LA FECHA DE OTORGAMIENTO DE ESTE DOCUMENTO DA CUMPLIMIENTO AL DECRETO PRESIDENCIAL ANTI-INCENDIOS Nº 2.195, 
AL DECRETO CON FUERZA DE LEY DE LOS CUERPOS DE BOMBEROS Y BOMBERAS Y ADMINISTRACIÓN DE EMERGENCIAS DE CARÁCTER CIVIL   Nº 1.533  Y LAS NORMAS COVENIN – FONDONORMA</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p align = "center" style="color:rgb(51,102,255);line-height: 18em; text-transform: uppercase;"><strong>VÁLIDO POR <span style = "background-color:#00FFFF">UN AÑO</span> A PARTIR DE LA FECHA DE EMISIÓN,<br>SI SE MANTIENEN VIGENTES LAS MEDIDAS DE PREVENCIÓN Y PROTECCIÓN CONTRA INCENDIO</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p align = "justify" style="color:#0B0B61;line-height: 18em; text-transform: uppercase;">DE CONSTATARSE EL INCUMPLIMIENTO DE LAS DISPOSICIONES DE SEGURIDAD DE PREVENCIÓN DE INCENDIOS,  SE  REVOCARÁ EL PRESENTE DOCUMENTO</p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('helvetica', 'N', 12);
$html = '<p align="justify" style ="color:#0B0B61; text-transform: uppercase;"><strong><u>FECHA</u> <u>DE</u> <u>EMISIÓN</u>: '.date("d").' DE '.$numero->mes(date("m")).' DE '.date("Y").'</strong></p>';
$pdf->writeHTMLCell(120, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()-6,5);
$pdf->SetX(161);
$pdf->SetFont('helvetica', 'N', 12);
$html = '<p align="justify" style ="color:#0B0B61; text-transform: uppercase;"><strong><u>FECHA</u> <u>DE</u> <u>VENCIMIENTO</u>: '.date("d", time() + (60 * 60 * 24 * 365) ).' DE '.$numero->mes(date("m", time() + (60 * 60 * 24 * 365) )).' DE '.date("Y", time() + (60 * 60 * 24 * 365) ).'</strong></p>';
$pdf->writeHTMLCell(120, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+7);
$pdf->SetFont('helvetica', 'N', 11);
$html = '<p align="center" style= "color: rgb(51,51,153)"><strong>“DISCIPLINA Y ABNEGACIÓN”</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+9);
$pdf->SetFont('helvetica', 'N', 10);
$html = '<p align="center" style="color:#0B0B61"><strong>MAYOR (B) HUMBERTO DASILVA VERA<br>PRIMER COMANDANTE</strong></p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', 'N', 8);
$html = '<p align="center" style="color:#0B0B61">DIRECTOR DEL CUERPO DE BOMBEROS<br>RESOLUCIÓN: DA-465-2014<br>FECHA: 08/10/2014</p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()-21);
$pdf->SetX(190);
$pdf->SetFont('helvetica', 'N', 10);
$html = '<p align="center" style="color:#0B0B61"><strong>MAYOR (B)  LARRY JOSÉ ZABALA<br>INSPECTOR JEFE ACTUANTE</strong></p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('certificado.pdf', 'I');


