<?php

//ob_start();
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
//require ( $asipiPath . '/wp-load.php');
global $wpdb;

require_once( $asipiPath .'/TCPDF-master/tcpdf.php');	
$documentTitle = 'hola mundo';


class MyPDF2 extends TCPDF {
    public function Footer() {
        $this->SetY(-15);
        $this->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 25, 54)));
        $this->AddFont('avenirbook','','avenirbook.php');
		$this->SetFont('avenirbook', '', 12);
        $this->Cell(10, 12,
                    'Tesorería ASIPI ',
                    'T', false, 'L', 0, '',
                    0, false, 'T', 'M');
        $this->SetFont('avenirbook', '', 20);
        $this->Cell(0, 12,
                    $this->getAliasNumPage(),
                    'T', 0, 'R', 0, '',
                    0, false, 'T', 'M');
    }
}

$table_orders =  'evento_orden';
$table_invoice = 'evento_pago';
$table_profile = 'pwisa_bp_xprofile_data';
$order_number = base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) );
if (isset($number)) {
	//$number = base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) );
} else {
	$number = base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) );
}
$order_number = $number;


	
$mon='USD';

//if ( is_user_logged_in() || is_network_admin() || $_SESSION["user_id"] )
//{	
	$order_user = $wpdb->get_var( "SELECT pwisa_users_id FROM ".$table_orders." where id=".$order_number );	
	$sqlInvoice='SELECT * FROM '.$table_orders.' where id='.$order_number;	
	$queryInvoice = $wpdb->get_results($sqlInvoice);

	if (count($queryInvoice) > 0) 
	{				
		foreach($queryInvoice as $invoice)
		{
            
			$number = $invoice->numero;
			$lenguaje = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=14" );

				if($lenguaje=='Inglés' || $lenguaje=='English')
				{
					$lang='en';
					$documentTitle=$invoice->numero.'-ASIPI-Invoice.pdf';
				}
				else if($lenguaje=='Portugués' || $lenguaje=='Portuguese')
				{
					$lang='en';
					$documentTitle=$invoice->numero.'-ASIPI-Invoice.pdf';
				}
				else 
				{
					$lang='es';
					$documentTitle=$invoice->numero.'-Factura-ASIPI.pdf';
				}

			$event_id = $invoice->evento_id;
			$numero_fact = $invoice->numero;
			$nombre_evento = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave='name_".$lang."' AND evento_id = ".$event_id);
			$first_name = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=1" );
			$last_name = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=2" );
			$firm = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=12" );
			$razonSocial = $wpdb->get_var("SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=45" );

			if(isset($razonSocial) && $razonSocial!=NULL && $razonSocial!=""){
				$campoNombre = $razonSocial;
			}else{
				$campoNombre = $first_name." ".$last_name;
			}
		
            //echo '<br>documento: '.$documentTitle.'<br>';
            if (!function_exists('limpiarCaracteresEspeciales')) {
				function limpiarCaracteresEspeciales($string ){
					$string = htmlentities($string);
					$string = str_replace("\'", "'", $string);
					$string = html_entity_decode($string);
			
					return $string;
				}
			}

				$campoNombre = limpiarCaracteresEspeciales( $campoNombre );
                //echo '<br>documento: '.$documentTitle.'<br>';
			$NIT = $wpdb->get_var("SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=46" );

			if(!isset($NIT) || $NIT==NULL || $NIT=="")
				$NIT = "";
			
			$profile = false;
			$billAddress = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=29" );

			if($billAddress=="")
			{
				$profile = true;
				$arrayAddress = array();

				$temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=3" );
				if($temp!="")
				{
					$arrayAddress[] = $temp;	
				}
				
				$temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=4" );
				if($temp!="")
				{
					$arrayAddress[] = $temp;	
				}

				$temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=5" );
				if($temp!="")
				{
					$arrayAddress[] = $temp;	
				}
								
				$billAddress = implode(", ", $arrayAddress);
			}

			
			$city =  $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=32" );
			if($city==""){
				$city =  $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=9" );
			}
			if($city==""){
				$line2="";
			}else{
				$line2=$city.", ";
			}

			$country = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=30" );
			if($country==""){
				$country = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=7" );
			}
			if (is_numeric($country)) {
				$country = $wpdb->get_var( "SELECT name_$lang as name FROM country_names WHERE id = '$country'" );
			} 
			$line2.=$country;


			$zipCode = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=33" );
			if($profile)
			{
				$zipCode = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=6" );					
			}

			//Si esta pendiente obtener el numero de la orden asipi
			$orderASIPI = '';
			if($invoice->estado == 'P')
			{
				$sqlASIPIOrder = "SELECT * from pwisa_teso_orden WHERE pwisa_users_id = " . $order_user ." AND estado = 'P' AND visible = 1";
					//echo $sqlASIPIOrder;
				$queryASIPIOrder = $wpdb->get_results($sqlASIPIOrder);
				if (count($queryASIPIOrder) > 0) 
				{
					foreach($queryASIPIOrder as $dataASIPIOrder)
					{
						if($lang == 'es')
							$orderASIPI = 'Orden de ASIPI #' . $dataASIPIOrder->id . '';
							
						else	
							$orderASIPI = 'ASIPI Order #' . $dataASIPIOrder->id . '';
					}	  
				}
			}	
            
			
			$sqlConcepto = 'SELECT A.evento_concepto_id as id, A.costo as cost, 
							(select nombre_'.$lang.' FROM evento_concepto B where B.id=evento_concepto_id) as concepto 
							FROM evento_orden_concepto A
							WHERE A.visible = 1 AND A.evento_orden_id='.$order_number;

			$queryConcepto = $wpdb->get_results($sqlConcepto);
			var_dump($queryConcepto);exit();
			$penaltyYear = date('Y');
			$overdueYear = date('Y');
            
			if (count($queryConcepto) > 0)
			{
				$stringConcepto = '';
				$suma=0;

				foreach ($queryConcepto as $resultado)
				{					
					$suma+=$resultado->cost;
					
					if($resultado->id == 5)
					{
						$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
											<tr style="background-color: #ccc;">
												<td>'.$resultado->concepto.' ' . $orderASIPI . '</td>
												<td class="montosFactura">'.number_format((float)$resultado->cost, 2, '.', '').'</td>	
											</tr>
										</table>';
					}
					else
					{
						/*if($resultado->id != 10)
						{*/						
							$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
											<tr style="background-color: #ccc;">
												<td>'.$resultado->concepto.'</td>
												<td class="montosFactura">'.number_format((float)$resultado->cost, 2, '.', '').'</td>	
											</tr>
										</table>';
						/*}
						else
						{
							$suma -= $resultado->cost;
						}*/
					}					
				}//foreach queryconcepto
			}//cont($queryconcepto)

			//talleres 1
			$sqlTalleres = 'SELECT A.id, A.evento_taller_id, B.nombre_' .$lang .' as concepto FROM evento_orden AS A, evento_taller AS B WHERE A.id = ' . $order_number . ' AND A.evento_taller_id = B.id';
					$queryTalleres = $wpdb->get_results($sqlTalleres);

					if(count($queryTalleres) > 0)
					{
						foreach ($queryTalleres as $resultadoTalleres) 
						{
							//$suma+=$resultadoTalleres->precio;
							$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
											<tr style="background-color: #ccc;">
												<td>'.$resultadoTalleres->concepto.'</td>
													
											</tr>
										</table>';	
						}//foreach
					}//if talleres
                        
                    //talleres 2
                    $sqlTalleres_2 = 'SELECT A.id, A.evento_taller_2_id, B.nombre_' .$lang .' as concepto FROM evento_orden AS A, evento_taller AS B WHERE A.id = ' . $order_number . ' AND A. evento_taller_2_id = B.id';
					$queryTalleres_2 = $wpdb->get_results($sqlTalleres_2);

					if(count($queryTalleres_2) > 0)
					{
						foreach ($queryTalleres_2 as $resultadoTalleres_2) 
						{
							//$suma+=$resultadoTalleres->precio;
							$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
											<tr style="background-color: #ccc;">
												<td>'.$resultadoTalleres_2->concepto.'</td>
													
											</tr>
										</table>';	
						}
					}

			$sqlActividades = 'SELECT A.id, A.evento_actividad_id, B.nombre_' .$lang .' as concepto, B.precio, B.precio_reales, A.evento_actividad_id FROM evento_orden AS A, evento_actividad AS B WHERE A.id = ' . $order_number . ' AND A.evento_actividad_id = B.id';
			$queryActividades = $wpdb->get_results($sqlActividades);

			if(count($queryActividades) > 0)
			{
				foreach ($queryActividades as $resultadoActividades) 
				{
					if($invoice->estado != 'E')
					{
						$pre=0;

					
						//if($countryName=='Brasil' || $countryName=='Brazil')
						//{
						//	$pre=$resultadoActividades->precio_reales;
						//}
						//else
						//{
							$pre+=$resultadoActividades->precio;
						//}

						$pre = $wpdb->get_var('SELECT costo FROM evento_orden_concepto where evento_concepto_id = 10 and evento_orden_id=' . $resultadoActividades->id);
						$suma+=$pre;
					}//if estado ! e

					if($resultadoActividades->evento_actividad_id != 7)
					{
						$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
									<tr style="background-color: #ccc;">
										<td>'.$resultadoActividades->concepto.'</td>
										<td class="montosFactura">'.number_format((float)$pre, 2, '.', '').'</td>	
									</tr>
								</table>';
					}//if evento ! 7	
				}//foreach
			}//count actividades
			
			// Ordenes solo talleres


			$ftotal=number_format((float)$suma, 2, '.', '');
			
			//Espacios			
			if(count($queryConcepto)<2)
			{
				$espacios = "";
			}
			else if(count($queryConcepto)>3)
			{
				$espacios = "";
			}
			else
			{
				$espacios = "";
			}

			$invoiceHeader = get_home_url();
			$Header = $wpdb->get_var('SELECT valor FROM evento_meta WHERE clave = "header_'.$lang.'" AND evento_id = '.$event_id);
			$invoiceHeader = (stripos($Header, '://')) ? $Header : get_home_url().$Header ;

			if ($lang=='en' || $lang=='pb') {
				# code...
				require ( $asipiPath . '/asipi-helper/lang/en.php');
			} else {
				# code...
				require ( $asipiPath . '/asipi-helper/lang/es.php');
			}
			// variables de idioma
			extract($idioma['invoice'], EXTR_PREFIX_ALL, 'lang');

			if ($lang=='en' || $lang=='pb') {
				# code...
				require ( $asipiPath . '/asipi-helper/lang/en.php');
				$fecha_factura=strftime("%B %d, %Y",strtotime($invoice->fecha));
				$fvencimiento=strftime("%B %d, %Y",strtotime($invoice->vencimiento));

				$fecha_factura = str_replace(
		            array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"),
		            array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
		            $fecha_factura
		        );
				$fvencimiento = str_replace(
		            array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"),
		            array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
		            $fvencimiento
		        );
		        $textovencimineto ="Payment due date: $fvencimiento.<br><br>";
			} else {
				# code...
				require ( $asipiPath . '/asipi-helper/lang/es.php');
				$fecha_factura=strftime("%d de %B de %Y",strtotime($invoice->fecha));
				$fvencimiento=strftime("%d de %B de %Y",strtotime($invoice->vencimiento));

				$fecha_factura = str_replace(
		            array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
		            array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"),
		            $fecha_factura
		        );
				$fvencimiento = str_replace(
		            array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
		            array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"),
		            $fvencimiento
		        );
				$textovencimineto ="Fecha límite de pago: $fvencimiento. <br><br>";
			}

			
				# header para las facturas desde el 01/11/2019...
				require ( $asipiPath . '/asipi-helper/invoiceEvent/invoice-page1-v2.php');


		}//foreach $queryInvoice
	}//if $queryInvoice
    
	

	// create new PDF document
	$pdf = new MyPDF2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('ASIPI');
	$pdf->SetTitle($documentTitle);
	$pdf->SetSubject('Factura ASIPI');
	$pdf->SetKeywords('ASIPI, factura');

	// remove default header
	$pdf->setPrintHeader(false);
	//$pdf->setPrintFooter(false);

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// ---------------------------------------------------------

	// set font
	if (strtotime($invoice->fecha) < strtotime('2019-10-29 00:00:00')) {
		$pdf->SetFont('dejavusans', '', 10);
	} else {
		$pdf->AddFont('candara','','candara.php');
		$pdf->AddFont('avenirbook','','avenirbook.php');
		$pdf->AddFont('font','','font.php');
		//$pdf->SetFont('candara','',12,'10');
		$pdf->SetFont('avenirbook', '', 12);
	}

	// add a page
	$pdf->AddPage();
	//echo $content;exit();
	// output the HTML content
	//$pdf->writeHTML('hola', true, false, true, false, '');
	//$content=utf8_encode($content);
	$pdf->writeHTML($content, true, false, true, false, '');
	//echo $content;
	// ---------------------------------------------------------

	$lastPage = $pdf->getPage();
	if($lastPage == 2)
		$pdf->deletePage($lastPage);	
	$pdf->AddPage();

	// output the HTML content
	$pdf->writeHTML($pag2, true, false, true, false, '');

	//Close and output PDF document
	ob_clean();

	if (isset($type)) {
		
		$uploadPath = ABSPATH.'wp-content/uploads/facturas/';
		if($folder!=''){
			$uploadPath=$uploadPath.$folder;
		}
		$doc = $uploadPath.$documentTitle;
		//echo '<br>'. $doc;
		$fechaDocumento = $invoice->fecha;
		//$pdf->Output($doc, $type);
	} else {
		//ob_end_clean();
		//$pdf->Output($documentTitle, 'I');
	}
	
	unset($pdf);

/**/
?>