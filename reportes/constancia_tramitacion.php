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
		$this->SetY(-30);
		$this->SetX(18);
		$this->SetFont('timesI','BI',14);
		$html = '<p align="center" style="color:#0B0B61">¡Fortaleciendo la Prevención!</p>';
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$this->SetFont('helvetica','N',7);
		$html = '<p align="center" style="color:#0B0B61">CARRETERA UPATA-GUASIPATI, SECTOR SANTO DOMINGO II, UPATA, MUNICIPIO PIAR, ESTADO BOLÍVAR<br>
		TELÉFONOS (0288) 414.80.93, 414.94.67 (414.50.66 emergencia)<br>
		e-mailL:  bomberosupata@cantv.net
		</p>';
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SISCVS');
$pdf->SetTitle('CONSTANCIA DE TRAMITACIÓN');


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
$pdf->SetFont('helvetica', '', 8);

$sql="select solicitud.codigo, empresa.representante, empresa.nombre, empresa.ced_representante, empresa.direccion from empresa, solicitud where solicitud.codigo = '".$solicitud."' and solicitud.rif_empresa = empresa.rif";
$rs=mysqli_query($conexion->conectarse(),$sql);
$row = mysqli_fetch_array($rs);

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



$pdf->SetY(40);

$pdf->SetFont('helvetica', 'N', 12);
$tbl= '<p ><strong>'.$row["codigo"].'</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, false, '', false);

$pdf->SetFont('helvetica', 'N', 12);
$pdf->SetY(50);
$html = '<p align = "center"><strong>CONSTANCIA  DE  TRAMITACIÓN<br>DE  VARIABLE  DE  SEGURIDAD</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY(65);
$pdf->SetFont('helvetica', 'N', 11);
$tbl= '<p align = "justify" style = "line-height: 20em; text-transform: uppercase;">POR MEDIO DE LA PRESENTE SE  HACE CONSTAR QUE  <strong>'.$row["nombre"].'</strong>, UBICADO EN LA '.$row["direccion"].', UPATA, MUNICIPIO PIAR, 
ESTADO BOLÍVAR, REPRESENTADO POR EL(LA) CIUDADANO(A) <strong>'.$row["representante"].'</strong>, TITULAR DE LA CÉDULA DE IDENTIDAD <strong>'.number_format($row["ced_representante"],0,",",".").'</strong>, ESTÁ EN TRAMITACIÓN Y EJECUCIÓN  PARA  DAR  CUMPLIMIENTO  AL DECRETO CON FUERZA DE LEY DE LOS CUERPOS DE BOMBEROS Y BOMBERAS Y 
ADMINISTRACIÓN DE EMERGENCIAS DE CARÁCTER CIVIL Nº 1533, RESOLUCIÓN 597 (SUMINISTRO E INSTALACIÓN DE EQUIPOS ANTI-INCENDIOS POR EMPRESAS Y PERSONAL AUTORIZADOS), DECRETO 2195 (REGLAMENTO ANTI-INCENDIOS), NORMATIVA COVENIN-FONDONORMA VIGENTE Y DISPOSICIONES LEGALES Y NORMAS APLICABLES.<br><br>
<strong>CONSTANCIA,</strong> QUE SE EXPIDE, FIRMA Y SELLA A SOLICITUD DE LA PARTE INTERESADA EN UPATA A LOS <strong>'.rtrim($numero->toWord(date("d"))).'</strong> días del mes de <strong>'.$numero->mes(date("m")).'</strong> del año <strong>'.rtrim($numero->toWord(date("Y"))).'.-</strong></p>';
	
$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+7);
$html = '<p align="center"><strong>“DISCIPLINA Y ABNEGACIÓN”</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+25);
$pdf->SetFont('helvetica', 'N', 10);
$html = '<p align="center"><strong>MAYOR (B) HUMBERTO DASILVA VERA<br>PRIMER COMANDANTE</strong></p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', 'N', 8);
$html = '<p align="center">DIRECTOR DEL CUERPO DE BOMBEROS<br>RESOLUCIÓN: DA-465-2014<br>FECHA: 08/10/2014</p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()-20);
$pdf->SetX(105);
$pdf->SetFont('helvetica', 'N', 10);
$html = '<p align="center"><strong>CAPITÁN (B) ALEXANDER JOSÉ NAVARRO<br>INSPECTOR ACTUANTE</strong></p>';
$pdf->writeHTMLCell(80, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetFont('helvetica', 'N', 11);
$pdf->SetY($pdf->GetY()+15);
$html = '<p align="left"><strong>HDV/AJN/mdp.-</strong></p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+2);
$html = '<p align="center">“VALIDA POR TREINTA (30) DÍAS A PARTIR DE LA FECHA DE EMISIÓN”</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->SetY($pdf->GetY()+2);
$html = '<p align="justify">NOTA: ESTE DOCUMENTO NO CERTIFICA EL ACTUAL CUMPLIMIENTO DE LAS VARIABLES DE SEGURIDAD ANTI-INCENDIOS.-”</p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


$pdf->Output('constancia_tramitacion.pdf', 'I');


