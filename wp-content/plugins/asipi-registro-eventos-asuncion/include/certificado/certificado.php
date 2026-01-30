<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

use setasign\Fpdi\Fpdi;
$asipiPath = $_SERVER['DOCUMENT_ROOT'];

require_once($asipiPath . '/asipi-helper/printpdf/fpdf/fpdf.php');
require_once($asipiPath . '/asipi-helper/printpdf/fpdi/src/autoload.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require ( $asipiPath . '/wp-load.php');

$lang='es';

global $wpdb;

if (!function_exists('limpiarCaracteresEspeciales')) {
	function limpiarCaracteresEspeciales($string ){
		$string = htmlentities($string);
		$string = str_replace("\'", "'", $string);
		$string = html_entity_decode($string);

		return $string;
	}
}
if (!function_exists('textoFecha')) {
	function textoFecha($lang, $fecha)
	{
		$mesesEsp = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$mesesIng = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		if ($lang=='en' || $lang=='pb') {
			$fechaFormat = strftime("%B %d, %Y",strtotime($fecha));
			$fechaMod = str_replace($mesesEsp, $mesesIng, $fechaFormat );
		} else {
			$fechaFormat = strftime("%d de %B de %Y",strtotime($fecha));
			$fechaMod = str_replace($mesesIng, $mesesEsp, $fechaFormat );
		}
		return $fechaMod;
	}
}
/*echo $codeOrder = base64_encode(base64_encode( base64_encode(37) ) );
exit();*/
$order_number = (isset($_GET['data'])) ? base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) ) : 0 ;

$sqlInvoice='SELECT *, YEAR(fecha) as year FROM asipi_cursos_registros where id='.$order_number;
$queryInvoice = $wpdb->get_results($sqlInvoice);
if (count($queryInvoice) > 0) {
    foreach($queryInvoice as $invoice){
        $alumno = limpiarCaracteresEspeciales( $invoice->nombres.' '.$invoice->apellidos );   
        $alumno = ucwords(strtolower($alumno));
        if ($invoice->tipo_curso=='C') {
            $sql = "SELECT * FROM pwisa_asipi_cursos WHERE id='".$invoice->curso_id."' limit 1";
            $qryCurso = $wpdb->get_results($sql);
            $qryCurso = json_decode(json_encode($qryCurso), true);
            $antCurso = ($lang=='es') ? 'Concluyó satisfactoriamente el curso: ' : 'Course registration: ' ;
            $nombre_curso = __($qryCurso[0]['nombre']);
            $fecha = 'Realizado desde el '.textoFecha($lang, $qryCurso[0]['fecha_inicio']).' al '.textoFecha($lang, $qryCurso[0]['fecha_fin']);
        } else {
            $sql = "SELECT titulo,id_asipi_cursos FROM pwisa_asipi_cursos_modulo WHERE id='".$invoice->curso_id."' limit 1";
            $qryModulo = $wpdb->get_results($sql);
            $qryModulo = json_decode(json_encode($qryModulo), true);

            $sql = "SELECT * FROM pwisa_asipi_cursos WHERE id='".$qryModulo[0]['id_asipi_cursos']."' limit 1";
            $qryCurso = $wpdb->get_results($sql);
            $qryCurso = json_decode(json_encode($qryCurso), true);
            $curso = __($qryCurso[0]['nombre']);
            $antCurso = ($lang=='es') ? 'Concluyó satisfactoriamente el módulo: ' : 'Module Registration: ' ;
            $nombre_curso = __($qryModulo[0]['titulo']).' ('.$curso.')';
            $fecha = 'Realizado desde el '.textoFecha($lang, $qryCurso[0]['fecha_inicio']).' al '.textoFecha($lang, $qryCurso[0]['fecha_fin']);

        }
        $horas= 'Intensidad horaria: '.$qryCurso[0]['horas_activas'].' horas';
    }
}
/*echo $alumno;
echo '<br>';
echo $nombre_curso;
echo '<br>';
echo $fecha;
echo '<br>';
exit();*/


// initiate FPDI
$pdf = new Fpdi('L','mm','Letter');
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile($asipiPath . '/wp-content/plugins/asipi-registro-cursos/include/certificado/CertificadoAsipiAcademia.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, '', '', 280, 220);

$titulo='CERTIFICADO DE PARTICIPACIÓN';
$linea1='Se certifica que:';

// now write some text above the imported page
$filabase=50;
$pdf->SetFont('helvetica');
$pdf->SetFontSize('30');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(((279 - $pdf->GetStringWidth($titulo)) / 2), $filabase);
$pdf->Write(0, utf8_decode($titulo));
$pdf->SetFontSize('20');
$pdf->SetTextColor(0, 0, 0);
$filabase=$filabase+30;
$pdf->SetXY(((279 - $pdf->GetStringWidth($linea1)) / 2), $filabase);
$pdf->Write(0, utf8_decode($linea1));
$pdf->SetFontSize('25');
$pdf->SetTextColor(36, 55, 121);
$filabase=$filabase+20;
$pdf->SetXY(((279 - $pdf->GetStringWidth($alumno)) / 2), $filabase);
$pdf->Write(0, utf8_decode($alumno));

$pdf->SetFontSize('15');
$pdf->SetTextColor(0, 0, 0);
$filabase=$filabase+20;
$pdf->SetXY(((279 - $pdf->GetStringWidth($antCurso)) / 2), $filabase);
$pdf->Write(0, utf8_decode($antCurso));
$pdf->SetFontSize('25');
$pdf->SetTextColor(36, 55, 121);
$filabase=$filabase+10;
$pdf->SetXY(((279 - $pdf->GetStringWidth($nombre_curso)) / 2), $filabase);
$pdf->Write(0, utf8_decode($nombre_curso));
$pdf->SetFontSize('15');
$pdf->SetTextColor(0, 0, 0);
$filabase=$filabase+20;
$pdf->SetXY(((279 - $pdf->GetStringWidth($fecha)) / 2), $filabase);
$pdf->Write(0, utf8_decode($fecha));
$filabase=$filabase+10;
$pdf->SetXY(((279 - $pdf->GetStringWidth($horas)) / 2), $filabase);
$pdf->Write(0, utf8_decode($horas));
ob_end_clean();
$pdf->Output('I','ASIPIAcademia.pdf');