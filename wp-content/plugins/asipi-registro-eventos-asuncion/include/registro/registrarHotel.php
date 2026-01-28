<?php

global $wpdb;
global $blog_id;

$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$fechahora = $dt->format('Y-m-d H:i:s');

/*echo '<pre>';
var_dump($_REQUEST);
echo '<pre>';
//die();
//extract($array);
/*
submission_id = 5349442757321916002
formID = 222366398631159
ip = 190.74.106.237
numero_orden = 822
id_usuario = 2616
namey = Jose Con Deuda
email = josedeuda@ipdeer.com
ingresesu =
country = Colombia
tipohabitacion = Hab. Standard Sencilla - Cama matrimonial 1 persona ($135)
acompanante =
noches1 = 04 December 05 December 06 December
noches2 =
dias_03_2camas =
dias_04_2camas =
dias_05_2camas =
dias_06_2camas =
dias_07_2camas =
dias_02_matrimonial =
dias_03_matrimonial =
dias_04_matrimonial = 1
dias_05_matrimonial = 1
dias_06_matrimonial = 1
dias_07_matrimonial =
dias_08_matrimonial =
dias_matrimonial = 3
dias_2camas = 0
cantidadnoches = 3
costo_habitacion = 135
total = 405
flightnumber28 = 4141411
solicitudesespeciales =
typea = Accepted
traslado =
*/

if($_POST)
{
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post)
     {
      $$key_post = $_POST[$key_post];
      //echo ("$key_post = ".$_POST[$key_post]."<br>");
     }
}

//exit();
$sql_orden = "SELECT * FROM `evento_orden` WHERE `id` = '$numero_orden'";
$queryResult = $wpdb->get_results($sql_orden);
  foreach($queryResult as $row){
    $ordenOriginal = $row;
  }
  //var_dump($ordenOriginal->id);
  
if(isset($_REQUEST['formID'])){     
    
    $user_id = $ordenOriginal->pwisa_users_ID;
    $sn = explode(" Difference:", $select_noches);
    $select_noches1=$sn[0];

    //$registro_hotel_v= $wpdb->get_var("SELECT COUNT(*) FROM `evento_info_adicional` WHERE `evento_id`='".$blog_id."' and `user_id`='".$user_id."' and `clave`='cantidad_noches' and `valor`!=''");
    $registro_hotel_v= $wpdb->get_var("SELECT COUNT(*) FROM `evento_info_adicional` WHERE `evento_id`='".$blog_id."' and `user_id`='".$user_id."' and `clave`='fecha_habitacion' and `valor`='".$select_noches1."'");
    
    //var_dump('Es aquiiii======>'.$noches1.$noches2);
    
 
    
if ($registro_hotel_v> 0){
    //var_dump('Ya tiene registro de hotel');
    
}else{

      ## asigna el numero de factura a la orden del evento
        $sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."' AND visible=1 AND numero='".$ordenOriginal->numero."'";
        $actual = $wpdb->get_var($sqlMaior);
        $actual = ($actual == null) ? 0 : $actual;
        $numeroVigente = $actual+1;
      ## fin numero factura
    
      ## estatus de pago
      if( isset($_REQUEST['misproductos']['transactionID']) ){
        $status = 'C';
      }else{
        $status = 'P';
      }
    
      // Crear orden del evento
      $sqlActivites = "INSERT INTO evento_orden 
          (pwisa_users_ID, 
          evento_id, 
          estado, 
          numero, 
          subnumero,
          visible, 
          paso, 
          fecha, 
          fecha_vencimiento, 
          tipo
          ) 
        VALUES (
          '".$ordenOriginal->pwisa_users_ID."', 
          '".$blog_id."', 
          '".$status."', 
          '".$ordenOriginal->numero."',
          '".$numeroVigente."',
          '1', 
          '4', 
          '".$fechahora."', 
          '".date('Y-m-d', strtotime("+5 days") )."',
          '".$ordenOriginal->tipo."'
        );";
    //echo $sqlActivites;
    $insertOrden = $wpdb->get_results($sqlActivites);
    $user_id = $ordenOriginal->pwisa_users_ID;
    //exit();
    
    /*$orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");
    
    //if($insertOrden){
    if(!$orden_id){
    }else{*/
    $orden_id = $wpdb->insert_id;
    
    /*$tipo_asistencia = $_REQUEST['tipo_asistencia'];
    $talla = $_REQUEST['talla'];
    $tipo_habitacion = (isset($_REQUEST['id_tipo_habitacion'])) ? $_REQUEST['id_tipo_habitacion'] : '' ;
    $fechahab = (isset($_REQUEST['estadia'])) ? $_REQUEST['estadia'] : '' ;
    $tipo_carrera = (isset($_REQUEST['actividad1_tipo_carrera'])) ? $_REQUEST['actividad1_tipo_carrera'] : '' ;
    $companion_actividad_1 = (isset($_REQUEST['escribauna191'])) ? 'SI' : '' ;
    $companion_actividad_2 = (isset($_REQUEST['acompanante_actividad_2'])) ? 'SI' : '' ;*/
    
    /*$adicionales = array(
    "tipo_habitacion" => $tipohabitacion , 
    "fecha_habitacion" => $noches1.$noches2, 
    "tipo_asistencia" => 'presencial', 
    "cantidad_noches" => $cantidadnoches, 
    "numero_vuelo" => $flightnumber28 , 
    "companion" => $acompanante ,  
    "pasaporte" => $pasaporte ,
    "fecha_nac" => $fecha_nac['year'].'-'.$fecha_nac['month'].'-'.$fecha_nac['day'],
    "pasaporte_companion"=> $pasaporte_companion,
    "fecha_nac_companion" => $fecha_nac_companion['year'].'-'.$fecha_nac_companion['month'].'-'.$fecha_nac_companion['day'],
    );*/
    
    if ($pais_companion==""){
        $pais_acompanante=$country_companion;
    }
    
    if ($country_companion==""){
        $pais_acompanante=$pais_companion;
    }
    


    $adicionales = array(
    "tipo_habitacion" => $tipohabitacion , 
    "fecha_habitacion" => $select_noches1, 
    "tipo_asistencia" => 'presencial', 
    "cantidad_noches" => $cantidad_noches, 
    "numero_vuelo" => $flightnumber28 , 
    "companion" => $acompanante ,  
    "pasaporte" => $pasaporte ,
    "fecha_nac" => $fecha_nac['year'].'-'.$fecha_nac['month'].'-'.$fecha_nac['day'],
    "pasaporte_companion"=> $pasaporte_companion,
    "fecha_nac_companion" => $fecha_nac_companion['year'].'-'.$fecha_nac_companion['month'].'-'.$fecha_nac_companion['day'],
    "pais_companion" => $pais_acompanante ,
    );
    
    foreach ($adicionales as $key => $value) {
    $arrayColumnas = array(
    'orden_id' => $orden_id,
    'evento_id' => $blog_id,						
    'user_id' => $user_id,
    'clave' => $key,
    'valor' => $value
    );				
    $wpdb->insert(
    'evento_info_adicional', 
    $arrayColumnas
    );
    }
    //exit();
    
    
    
    //$code = base64_encode(base64_encode(base64_encode($orden_id)));
    // se agregan los detalles de la orden
    /*
    44 Hab. Standard Sencilla - Cama matrimonial  1 perso
    45 Hab. Standard Doble  - Cama matrimonial 2 personas
    46 Hab. Standard Sencilla -  2 camas
    47 Hab. Standard Doble - 2 camas
    */
    
    $nombreConcepto = $wpdb->get_var("SELECT nombre_es FROM evento_concepto WHERE id = '$id_concepto_hab'");
    $nombreConcepto_hf = $wpdb->get_var("SELECT nombre_es FROM evento_concepto WHERE id = '$id_hotel_fee'");
    #$conceptos[] = array('id' => $id_concepto_hab,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $total );
    $conceptos = array(['id' => $id_concepto_hab,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $subtotal],
                       ['id' => $id_hotel_fee,'titulo' => $nombreConcepto_hf,'orden_id' => $orden_id,'costo' => $hotel_fee]);

    foreach ($conceptos as $key => $value) {
      are_insertConcept($value['id'], $orden_id, $value['costo']);
    }
    if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria'] and $_REQUEST['costo']>0){
      //pendiente
      $pago = false;
    }else{
      
    }
    if(!isset($_REQUEST['misproductos']['transactionID'])){ //
      //require ( '../invoice/invoice.php' );
      //teso_send_invoice_evento($orden_id, false);
      $tipoDocumento = 'Invoice';
      $formaPagoMail = 'Transferencia';
      $pago = false;
      $code = base64_encode(base64_encode(base64_encode($orden_id)));
    }else{
      //pagado
      $tipoDocumento = 'Receipt';
      $formaPagoMail = 'Paypal';
      $ordenOriginal_n = $ordenOriginal->id;
    
       $pago = are_pagar($_REQUEST, $orden_id, $fechahora, $ordenOriginal_n);
       #$pago = are_pagar($_REQUEST, $ordenOriginal->id, $fechahora);
      
      $code = base64_encode(base64_encode(base64_encode($pago)));
    }
    //no se envia porque es una reserva
    //are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, 'Hotel', $code);
    
    // guardar acompañante
    $companion = are_companion($orden_id);

}

}

if($_REQUEST["tesoreria"]){
  //are_notificacion('soporte@asipi.org',$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
  echo '<div style="padding: 20px">';
  echo '<br><br><p>Usuario ('.$_REQUEST['namey'].' '.$_REQUEST['nombre'][1].') registrado en el hotel</p>';
  echo '<p><a href="/wp-admin/admin.php?page=teso-settings&tab=5">Volver a Tesorería.</a></p><br><br>';
  echo '</div>';
  exit();
}


function are_verifyConcept($id_concepto = '', $orden_id = '')
{
  global $wpdb;
		$verificar = $wpdb->get_var('SELECT evento_concepto_id FROM evento_orden_concepto WHERE evento_concepto_id = '.$id_concepto.' and evento_orden_id = '.$orden_id);
		if (!$verificar) {
			return false;
		} else {
			return $verificar;
		}		
}
function are_insertConcept($id_concepto = '', $orden_id = '', $monto = 0)
{
  global $wpdb;
		if ( !are_verifyConcept( $id_concepto , $orden_id ) ) {
			$arrayColumnas = array(
				'evento_concepto_id' => $id_concepto,
				'evento_orden_id' => $orden_id,
				'costo' => $monto
			);
			$insertConcepto = $wpdb->insert(
				'evento_orden_concepto', 
				$arrayColumnas
			);
		}	
}

function are_pagar($request, $orden_id, $today,$ordenOriginal=null)
{
  global $wpdb;
  


  $pay_status = 'C';
  //if (isset($request['misproductos']['transactionID'])) {
    $referencia = $request['misproductos']['transactionID'];
    $pay_mode = 5;//'Paypal';
  /*  
  }else{
    if($_REQUEST['forma_pago']=='Transferencia'){
      $referencia = '';//$_REQUEST['num_referencia'];
      $pay_status = 'P';
      $pay_mode = 1;// 'Transferencia Bancaria';
    }else{
      $referencia = 'free';
      $pay_mode = 4;// 'Tesoreria';
    }
      
  }*/
  $request['input110']['transactionID'];
  
  
  //if (isset($request['misproductos']['transactionID'])) {
    //if (isset($request['total'])) {
        $numero_f = $wpdb->get_var("SELECT numero FROM evento_orden WHERE id = ".$orden_id);
        //calcular numero de pago
        $pagos = $wpdb->get_var('SELECT count(*) FROM evento_pago WHERE evento_orden_id="' . $orden_id . '"');
        #$pagos = $wpdb->get_var('SELECT max(subnumero) FROM `evento_pago` where evento_orden_id >= "' . $orden_id . '" and numero = (select numero from evento_pago where evento_orden_id ="' . $orden_id . '" limit 1)');
        
         if(isset($ordenOriginal) && $ordenOriginal!= null){
            $subnumero = $wpdb->get_var('SELECT max(subnumero) FROM `evento_pago` where evento_orden_id >= "' . $ordenOriginal . '" and numero = (select numero from evento_pago where evento_orden_id ="' . $ordenOriginal. '" limit 1)');
            $subnumero = $subnumero +1;
            
        }else{
            $subnumero =1;
        }
        

        if ((int) $pagos > 0) {
            $suffix = $pagos + 1;
            $numeroReceipt = $numero_f . '-' . $suffix;
            $last_payment = $wpdb->get_var('SELECT numero FROM evento_pago where evento_orden_id = ' . $orden_id . ' order by id desc limit 1');
            if (strcmp($numeroReceipt, $last_payment) == 0) {
                $suffix += 1;
                $numeroReceipt = $numero_f . '-' . $suffix;
            }
        } else {
            $numeroReceipt = $numero_f;
        }
        /*$arrayColumnas = array(
            'numero' => $numeroReceipt,
            'evento_orden_id' => $orden_id,
            'tipo' => $pay_mode,
            'monto' => $request['total'],
            'descripcion' => $referencia,
            'estado' => $pay_status,
            'fecha' => $today,
            'visible' => 1
        );*/
        $arrayColumnas = array(
            'numero' => $numeroReceipt,
            'subnumero' => $subnumero, 
            'evento_orden_id' => $orden_id,
            'tipo' => $pay_mode,
            'monto' => $request['total'],
            'descripcion' => $referencia,
            'estado' => $pay_status,
            'fecha' => $today,
            'visible' => 1
        );
        
        
        if ($request['payment-date'] != "") {
            $fpago = new DateTime($request['payment-date']);
            $arrayColumnas['fecha'] = date_format($fpago, 'Y-m-d');
        }
        $insertPago = $wpdb->insert(
                'evento_pago', $arrayColumnas
        );

        ///$pago_id = $wpdb->insert_id;
        $sql = "SELECT id FROM evento_pago WHERE visible=1 and numero='$numeroReceipt' and evento_orden_id=$orden_id";
        $pago_id = $wpdb->get_var( $sql );
        
        if (!$insertPago) {
            return 0;
        } else {
            // Success
            // Si el pago se marca como completado se resta
            if ( $pay_status == "C" ) {
                // Restar saldo de eventos
                
                $payment_user = $wpdb->get_var("SELECT pwisa_users_ID FROM evento_orden WHERE id = ".$orden_id);
                //evento_modificar_saldo($payment_user, $request['total'], true);
                //are_actualizarTesoCuenta($orden_id, $payment_user);
                //Verificar si la orden esta completada
                //teso_verificar_orden_completa_evento($orden_id);
              
            }
            return $pago_id;
        }
    //}
  //}
}
function are_actualizarTesoCuenta($orden_id, $user_id)
{
    global $wpdb;
    $mtoFavor = false;
    $total = 0;
    $queryResult = $wpdb->get_results('SELECT evento_concepto_id, costo FROM evento_orden_concepto where evento_orden_id =' . $orden_id);
    if (count($queryResult) > 0) {
        foreach ($queryResult as $data) {
            if ($data->evento_concepto_id == 6) {
                $mtoFavor = $data->costo;
            }
            $total+=$data->costo;
        }
    }

    if ($mtoFavor and $total >= 0) {
        //echo 'pone saldo a favor en teso';
        $wpdb->update( 
                'pwisa_teso_cuenta', 
                array( 'saldo' => 0),
                array( 'pwisa_users_ID' => $user_id )
            );
    }
}
function are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, $tipoAsistenciaMail, $code){

  global $wpdb;
  global $blog_id;
  $user_id = $_REQUEST['id_usuario'];
  $event_id = $blog_id;

  #$nombre = ucwords(strtolower($_REQUEST['nombre']['first'].' '.$_REQUEST['nombre']['last'])); 
  $nombre = ucwords(strtolower($_REQUEST['namey'])); 

  /*Busco los parametros de configuración (plantillas en ingles y español y la ruta de la carpeta de archivos pdf */
  $qry = "SELECT value FROM pwisa_bp_xprofile_data where field_id='14' AND user_id=".$user_id;
  if($idioma = $wpdb->get_var($qry)){
    
    if(!strcmp($idioma,'Español') || !strcmp($idioma,'Portugués') ){
        $lang = 'es';
    }else{
        $lang = 'en';
    }
  }
  else{
      $idioma = "Español";
      $lang = 'es';
  }
  
  
  $strTipoEmail = 'event'.$tipoDocumento;
  $strTipoEmail = 'eventInvoice';
  $queryResult = $wpdb->get_results("select * from teso_config where clave in ('".$strTipoEmail."subject-es','".$strTipoEmail."subject-en','".$strTipoEmail."body-es','".$strTipoEmail."body-en','pdf-folder')");
  
  

  $nombre_evento = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'name_".$lang."'");
  $nombre_evento_largo = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'description_".$lang."'");

  $tesorero = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = '".$event_id."' AND clave = 'email_tesorero'");
  //$header_factura = get_home_url();
  $header_factura = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'header_".$lang."'");
  $fields = array();  
  foreach($queryResult as $row){
      $fields[$row->clave] = $row->valor;
  }

  
  #$destinatario = $_REQUEST["billemail"];
  $destinatario = $_REQUEST["email"];
  
  // SUJETO DEL MAIL
  $subject = $fields[$strTipoEmail.'subject-'.$lang];
  // BODY DEL MAIL
  $claveBody = 'emailBody-'.$lang.'-'.$tipoDocumento.'-'.$tipoAsistenciaMail.'-'.$formaPagoMail; //emailBody-es-invoice-presencial-transferencia
  $body = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = '".$claveBody."'");

  
  $asipiPath = $_SERVER['DOCUMENT_ROOT'];
  //$code = base64_encode(base64_encode(base64_encode($orden_id)));
  //dlInvoiceEvento.php o dlReceiptEvento.php
  $link2='';
  if(strcmp($formaPagoMail,'Paypal') === 0){
         $code_link2 = base64_encode(base64_encode(base64_encode($orden_id)));
         $link2 = 'https://asipi.org/asipi-helper/dlInvoiceEvento.php?&data='. $code_link2;
    }
  $link_factura = 'https://asipi.org/asipi-helper/dl'.$tipoDocumento.'Evento.php?&data='.$code;
  /*$folder = $asipiPath.'wp-content/uploads/facturas/send/';    // $fields['pdf-folder'] .
  if ($carpeta!=''){
      $folder.=$carpeta;
  }
  $link_factura = 
  

  $attachments = array($folder.$nombreArchivo);*/
  //var_dump($attachments);

  /*Reemplazo %%SOCIO%% de la plantilla por el nombre y apellido */
  $body = str_replace("%%SOCIO%%",$nombre,$body);
  /*Reemplazo %%Fecha%% de la plantilla por el año actual */
  $body = str_replace("%%FECHA%%",date("Y"),$body);
  $subject = str_replace("%%FECHA%%",date("Y"),$subject);
  $body = str_replace("%%EVENTO%%",$nombre_evento_largo,$body);
  $subject = str_replace("%%EVENTO%%",$nombre_evento,$subject);
  $body = str_replace("%%HEADER%%",$header_factura,$body);
  $body = str_replace("%%LINK%%",$link_factura,$body);
  $body = str_replace("%%TESORERO%%",$tesorero,$body);
  
  $body = str_replace("%%LINK2%%",$link2,$body);
  #$headers = array('Content-Type: text/html; charset=UTF-8','From: no-reply@asipi.org');
  #$headers = array('Content-Type: text/html; charset=UTF-8');
  #$headers = implode( PHP_EOL, $headers );
  $headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  
  /*Envío el correo en formato html con los attachments*/
  //print_r($group_emails)
  
  //$enviado = mail($destinatario, $subject, $body, $headers);

  #$enviado = wp_mail($destinatario, $subject, $body, $headers);
  $enviado = wp_mail('mpalenciap@gmail.com', $subject, $body, $headers);
  $enviado = wp_mail('wilder@ztgroupcorp.com', $subject, $body, $headers);
  $enviado = wp_mail('elisa@ztgroupcorp.com', $subject, $body, $headers);
 
  return $enviado;
}

function are_notificacion($email, $alumno, $lang)
{
    //$folder2 = $asipiPath.'wp-content/uploads/facturas/'.$documentTitle;    // $fields['pdf-folder'] .
    $attachments = '';//array($folder2);

    $formatoCorreo["subject-es"]= 'Confirmación Registro Seminario Virtual ASIPI 2021';
    $formatoCorreo["subject-en"]= 'Confirmación Registro Seminario Virtual ASIPI 2021';
    
    $formatoCorreo["body-es"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/seminario2021/wp-content/uploads/sites/23/2021/03/header-facturas_es.jpg" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>
      <div style="width:640px; text-align: center;">

        
        <p><b>CONFIRMACIÓN DE REGISTRO</b></p>
        <p><b>ASIPI</b></p>
        <p><b>Seminario Virtual 2021</b></p>
        <p><strong>&ldquo;M&aacute;s all&aacute; de un A&ntilde;o de Cambios&rdquo;</strong></p>
      </div>
      <p>Estimado/a %%SOCIO%%,<br></p>
      <p>Gracias por tu registro para participar en nuestro Seminario Virtual de ASIPI entre el 23 al 25 de Mayo de 2021, &iexcl;te esperamos!</p>
      <p>Luego de nuestras primeras jornadas virtuales celebradas con mucho &eacute;xito entre el 6-9 de Diciembre de 2020, volvemos con un formato virtual para nuestro seminario con una serie de charlas y paneles que buscan el an&aacute;lisis de lo que viene y de su impacto para la Propiedad Intelectual y para sus profesionales luego de un a&ntilde;o hist&oacute;rico, lleno de retos y cambios. Al igual que todos, ASIPI se ha adaptado a estos cambios y se complace presentar su seminario anual, esta vez por v&iacute;a digital con invitados de lujo con temas de actualidad e inter&eacute;s. Estamos seguro el seminario tendr&aacute; mucha concurrencia y generar&aacute; mucho inter&eacute;s, en el podr&aacute;s escuchar nuevas ideas, conectarte con otros e inspirarte en lo que viene.</p>

      <p>¡Las instrucciones y recordatorios de acceso a las reuniones virtuales se enviarán en correos electrónicos desde nuestra plataforma en las próximas semanas!</p>
      <p><br></p>      
      
            <p>Atentamente,<br></p><br> <p><strong>Matías Noetinger</strong><br><strong>Tesorero – ASIPI</strong>
            <br><br>Calle 50, Edificio Plaza Banco General, Piso 24<br>Apartado Postal 0816-1771<br>Panamá, Panamá<br>Tel.:(5411) 4315 9200
            <br>Email: mnoetingertesorero@asipi.org<br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';
    $formatoCorreo["body-en"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/seminario2021/wp-content/uploads/sites/23/2021/03/header-facturas_es.jpg" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>
      <div style="width:640px; text-align: center;">

        
        <p><b>CONFIRMACIÓN DE REGISTRO</b></p>
        <p><b>ASIPI</b></p>
        <p><b>Seminario Virtual 2021</b></p>
        <p><strong>&ldquo;M&aacute;s all&aacute; de un A&ntilde;o de Cambios&rdquo;</strong></p>
      </div>
      <p>Estimado/a %%SOCIO%%,<br></p>
      <p>Gracias por tu registro para participar en nuestro Seminario Virtual de ASIPI entre el 23 al 25 de Mayo de 2021, &iexcl;te esperamos!</p>
      <p>Luego de nuestras primeras jornadas virtuales celebradas con mucho &eacute;xito entre el 6-9 de Diciembre de 2020, volvemos con un formato virtual para nuestro seminario con una serie de charlas y paneles que buscan el an&aacute;lisis de lo que viene y de su impacto para la Propiedad Intelectual y para sus profesionales luego de un a&ntilde;o hist&oacute;rico, lleno de retos y cambios. Al igual que todos, ASIPI se ha adaptado a estos cambios y se complace presentar su seminario anual, esta vez por v&iacute;a digital con invitados de lujo con temas de actualidad e inter&eacute;s. Estamos seguro el seminario tendr&aacute; mucha concurrencia y generar&aacute; mucho inter&eacute;s, en el podr&aacute;s escuchar nuevas ideas, conectarte con otros e inspirarte en lo que viene.</p>

      <p>¡Las instrucciones y recordatorios de acceso a las reuniones virtuales se enviarán en correos electrónicos desde nuestra plataforma en las próximas semanas!</p>
      <p><br></p>      
      
            <p>Atentamente,<br></p><br> <p><strong>Matías Noetinger</strong><br><strong>Tesorero – ASIPI</strong>
            <br><br>Calle 50, Edificio Plaza Banco General, Piso 24<br>Apartado Postal 0816-1771<br>Panamá, Panamá<br>Tel.:(5411) 4315 9200
            <br>Email: mnoetingertesorero@asipi.org<br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';
            
    $destinatario = $email;
    $body = $formatoCorreo["body-".$lang];	
    $body = str_replace("%%SOCIO%%",$alumno,$body);
    //$nombre_curso = str_replace("Inscripción Curso: ","",__($nombre_curso));
    //$body = str_replace("%%EVENTO%%",__($nombre_curso),$body);
    $subject = $formatoCorreo["subject-".$lang];
    $headers = array('Content-Type: text/html; charset=UTF-8');//,'Reply-To: tesoreria@asipi.org'
   	
    //$enviado = wp_mail($destinatario, $subject, $body, $headers, $attachments);	
}

function are_companion($orden_id)
{
    global $wpdb;
    global $blog_id;
    $user_id = $_REQUEST['id_usuario'];
		//$userType = verify_email(false);
		if ( $_REQUEST['llevarcompanion'] == "Si" ) {
      //$companion = explode(" ", $_REQUEST['nombrey']);
      
      // se agrega como participante a eventos de asipi
      $sql = "INSERT INTO evento_acomp ( pwisa_users_ID, evento_id, nombre ) VALUES ( '".$user_id."' , '".$blog_id."' , '".$_REQUEST['nombrey']."' )";
      $queryResult = $wpdb->get_results($sql);

      $arrayColumnas = array(
        'orden_id' => $orden_id,
        'evento_id' => $blog_id,
            'user_id' => $user_id,
        'clave' => "tipo_acomp",
        'valor' => 1
      );				
      $wpdb->insert(
        'evento_info_adicional', 
        $arrayColumnas
      );
				
      return true;
			
		}else {
      if($_REQUEST['conquien157']!=''){
        $arrayColumnas = array(
          'orden_id' => $orden_id,
          'evento_id' => $blog_id,						
              'user_id' => $user_id,
          'clave' => "compartir_hab",
          'valor' => ucwords(strtolower($_REQUEST['conquien157']))
        );				
        $wpdb->insert(
          'evento_info_adicional', 
          $arrayColumnas
        );
        return true;
      }else{
        return '0';
      }
			
		}
}





?>