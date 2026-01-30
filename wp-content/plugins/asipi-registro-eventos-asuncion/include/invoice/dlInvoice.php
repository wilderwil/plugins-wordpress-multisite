<?php

//ob_start();

$asipiPath = $_SERVER['DOCUMENT_ROOT'];

//require ( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

global $wpdb;



//require_once( $asipiPath .'/TCPDF-master/tcpdf.php');



$table_orders = $wpdb->prefix . 'teso_orden';

$table_invoice = $wpdb->prefix . 'teso_pago';

$table_profile = $wpdb->prefix . 'bp_xprofile_data';

$tipo = 'file';

if (isset($_GET['tipo'])) {

	$tipo = $_GET['tipo'];

}

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

		$mesesEsp = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

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



//$number = 3;

if (isset($number)) {

} else {

	//$number = base64_decode( base64_decode( base64_decode( $_GET['numero'] ) ) );

	$number = $_GET['numero'];

}



$order_number = $refer = $number;



	$order_user = $wpdb->get_var( "SELECT pwisa_users_id FROM asipi_cursos_registros where id=".$order_number );



	$lenguaje = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=14" );



	

	if($lenguaje=='Inglés' || $lenguaje=='English'){

		$lang='en';

		$documentTitle=$refer.'-ASIPI-Academy-Receipt.pdf';

	}else if($lenguaje=='Portugués' || $lenguaje=='Portuguese'){

		$lang='en';

		$documentTitle=$refer.'-ASIPI-Academy-Receipt.pdf';

	}else {

		$lang='es';

		$documentTitle=$refer.'-Recibo-ASIPI-Academy.pdf';

	}



	$sqlInvoice='SELECT *, YEAR(fecha) as year FROM asipi_cursos_registros where id='.$number;

	$queryInvoice = $wpdb->get_results($sqlInvoice);

	if (count($queryInvoice) > 0) {



		foreach($queryInvoice as $invoice){



            if($invoice->pwisa_users_ID>0){

                $first_name = $invoice->nombres;//$wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=1" );

                $last_name = $invoice->apellidos;//$wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=2" );

                $firm = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=12" );

                $razonSocial = $wpdb->get_var("SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=45" );



                if(isset($razonSocial) && $razonSocial!=NULL && $razonSocial!=""){

                    $campoNombre = $razonSocial;

                }else{

                    $campoNombre = $first_name." ".$last_name;

                }

                $campoNombre = ucwords(strtolower($campoNombre));



                    $campoNombre = limpiarCaracteresEspeciales( $campoNombre );



                $NIT = $wpdb->get_var("SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=46" );

                if(!isset($NIT) || $NIT==NULL || $NIT==""){

                    $NIT = limpiarCaracteresEspeciales($firm);

                }



                $profile = false;



                $billAddress = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=29" );



                if($billAddress==""){

                    $profile = true;

                    $arrayAddress = array();

                    $temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=3" );

                    if($temp!=""){

                        $arrayAddress[] = $temp;

                    }



                    $temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=4" );

                    if($temp!=""){

                        $arrayAddress[] = $temp;

                    }



                    $temp = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=5" );

                    if($temp!=""){

                        $arrayAddress[] = $temp;

                    }



                    $billAddress = implode(", ", $arrayAddress);

                }



                $city =  $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=32" );

                if($city==""){

                    $city =  $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=31" );

                }

                if($profile){

                    $city =  $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=9" );

                }



                if($city==""){

                    $line2="";

                }else{

                    $line2=$city.", ";

                }



                $country = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=30" );

                if($profile){

                    $country = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=7" );

                }

                if (is_numeric($country)) {

                    $country = $wpdb->get_var( "SELECT name_$lang as name FROM country_names WHERE id = '$country'" );

                } 			



                $line2.=$country;



                $zipCode = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=33" );

                if($profile){

                    $zipCode = $wpdb->get_var( "SELECT value FROM ".$table_profile." WHERE user_id=".$order_user." AND field_id=6" );

                }

            }else{

                $campoNombre = ucwords(strtolower($invoice->bill_razon));

                $billAddress = ucwords(strtolower($invoice->bill_address));

                $NIT = $invoice->bill_nit;

                $line2 = ucwords(strtolower( $invoice->bill_city.', '.$invoice->bill_state.', '.$invoice->bill_country ));
https://asipi.org
                $zipCode = $invoice->bill_zipcode;

			}  

			$alumno = limpiarCaracteresEspeciales( $invoice->nombres.' '.$invoice->apellidos );   

			$alumno = ucwords(strtolower($alumno));https://asipi.org



            if ($invoice->tipo_curso=='C') {

                $sql = "SELECT nombre FROM pwisa_asipi_cursos WHERE id='".$invoice->curso_id."' limit 1";

                $qryCurso = $wpdb->get_results($sql);

                $qryCurso = json_decode(json_encode($qryCurso), true);

				$antCurso = ($lang=='es') ? 'Inscripción Curso: ' : 'Course registration: ' ;

				$nombre_curso = __($antCurso.$qryCurso[0]['nombre']);

            } else {

                $sql = "SELECT titulo,id_asipi_cursos FROM pwisa_asipi_cursos_modulo WHERE id='".$invoice->curso_id."' limit 1";

                $qryModulo = $wpdb->get_results($sql);

                $qryModulo = json_decode(json_encode($qryModulo), true);



                $sql = "SELECT nombre FROM pwisa_asipi_cursos WHERE id='".$qryModulo[0]['id_asipi_cursos']."' limit 1";

                $qryCurso = $wpdb->get_results($sql);

                $qryCurso = json_decode(json_encode($qryCurso), true);

                $curso = __($qryCurso[0]['nombre']);

				$antCurso = ($lang=='es') ? 'Inscripción Modulo: ' : 'Module Registration: ' ;

                $nombre_curso = __($antCurso.$qryModulo[0]['titulo']).' ('.$curso.')';

            }

            

   



			$stringConcepto.='<table style="font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">

									<tr style="background-color: #ccc;">

										<td>'.__($nombre_curso).'</td>

										<td class="montosFactura">'.number_format((float)$invoice->costo, 2, '.', '').'</td>

									</tr>

								</table>';

				

			$ftotal = number_format((float)$invoice->costo, 2, '.', '');

			$metodo = $invoice->pay_mode;

    

			//Espacios

				$espacios = "<p></p>

							<p></p>

							<p></p>

							<p></p>

							<p></p>";

			

			



			$fecha_factura = textoFecha($lang, $invoice->fecha);

			$fvencimiento = textoFecha($lang, $invoice->fecha);

			$email = $invoice->email;



			if ($lang=='en' || $lang=='pb') {

				# cambio de idioma a ingles de la factura

				require ( $asipiPath . '/asipi-helper/lang/en.php');

		        $textovencimineto ="Payment due date: $fvencimiento.<br><br>";

			} else {

				# cambio de idioma a español de la factura

				require ( $asipiPath . '/asipi-helper/lang/es.php');

				$textovencimineto ="Fecha límite de pago: $fvencimiento. <br><br>";

			}



			// variables de idioma

			extract($idioma['receipt'], EXTR_PREFIX_ALL, 'lang');



			//$fecha_factura=strftime("%d de %B de %Y",strtotime($invoice->fecha));

			//$fvencimiento=strftime("%d de %B de %Y",strtotime($invoice->vencimiento));



			// aqui se modifica el diseño de la factura

			require ( 'invoice-design.php');

			

		}

	}





	// create new PDF document

	$pdf = new MyPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



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

	//$pdf->SetDefaultMonospacedFont('helvetica');



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



	$pdf->writeHTML($content, true, false, true, false, '');



	ob_clean();





		$folder = '';

		$uploadPath = ABSPATH.'wp-content/uploads/facturas/';

		if($folder!=''){

			$uploadPath=$uploadPath.$folder;

		}

		$doc = $uploadPath.$documentTitle;

		//echo '<br>'. $doc;

		$fechaDocumento = $invoice->fecha;



		$pdf->Output($doc, 'F');

		

		if ($tipo=='file') {

			/*echo '<div class="updated notice">

			<a href="/asipi-helper/cursos/dlInvoice.php?numero='.$numero.'&tipo=invoice" class="btn-comprar" target="_blank">Ver Recibo</a>

			</div>';*/

			//ob_end_clean();

		}

		if ($tipo=='view' or $tipo=='invoice') {

			$pdf->Output($documentTitle, 'I');

		}



		if ($tipo=='invoice' or $tipo=='file') {

			$folder2 = $asipiPath.'wp-content/uploads/facturas/'.$documentTitle;    // $fields['pdf-folder'] .

			$attachments = array($folder2);



			$formatoCorreo["subject-es"]= 'Recibo ASIPI Academia';

			$formatoCorreo["subject-en"]= 'ASIPI Academia Receipt';

			$formatoCorreo["body-es"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/wp-content/uploads/2020/02/Header_logo_3_lang.png" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>

							<p>Estimado/a %%SOCIO%%,<br></p>

							<p>Nos complace informarle que ya se ha completado su registro en el curso: %%EVENTO%%.<br></p>

							<p>Se adjunta recibo de pago.<br></p>

							<p>Atentamente,<br></p><br> <p><strong>Matías Noetinger</strong><br><strong>Tesorero – ASIPI</strong>

							<br><br>Calle 50, Edificio Plaza Banco General, Piso 24<br>Apartado Postal 0816-1771<br>Panamá, Panamá<br>Tel.:(5411) 4315 9200

							<br>Email: mnoetingertesorero@asipi.org<br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';

			$formatoCorreo["body-en"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/wp-content/uploads/2020/02/Header_logo_3_lang.png" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>

							<p>Dear %%SOCIO%%,<br></p>

							<p>We are pleased to inform you that your registration has already been completed successfully at the event %%EVENTO%%.<br></p>

							<p>Payment receipt is attached.<br></p>

							<p>Best,<br></p><br> <p><strong>Matías Noetinger</strong><br><strong>Tesorero – ASIPI</strong>

							<br><br>Calle 50, Edificio Plaza Banco General, Piso 24<br>Apartado Postal 0816-1771<br>Panamá, Panamá<br>Tel.:(5411) 4315 9200

							<br>Email:mnoetingertesorero@asipi.org<br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';

			$destinatario = $email;

			$body = $formatoCorreo["body-".$lang];	

			$body = str_replace("%%SOCIO%%",$alumno,$body);

			$nombre_curso = str_replace("Inscripción Curso: ","",__($nombre_curso));

			$body = str_replace("%%EVENTO%%",__($nombre_curso),$body);

			$subject = $formatoCorreo["subject-".$lang];

			$headers = array('Content-Type: text/html; charset=UTF-8','Reply-To: tesoreria@asipi.org');

			$enviado = wp_mail($destinatario, $subject, $body, $headers, $attachments);	

		}



		



	unset($pdf);





	

			  



?>