<?php

global $wpdb;
global $blog_id;

$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$fechahora = $dt->format('Y-m-d H:i:s');
if(isset($_REQUEST['formID'])){
echo '<pre>';
var_dump($_REQUEST);
echo '<pre>';
exit();
//extract($array);
/*
submission_id = 5349442757321916002
formID = 222073680052650
ip = 190.74.106.237
numero_orden = 822
id_usuario = 2616

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

  ## asigna el numero de factura a la orden del evento
    $sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE visible=1 AND numero='".$ordenOriginal->numero."'";
    $actual = $wpdb->get_var($sqlMaior);
    $actual = ($actual == null) ? 0 : $actual;
    $numeroVigente = $actual+1;
  ## fin numero factura

  ## estatus de pago
  if( isset($_REQUEST['input110']['transactionID']) ){
    $status = 'C';
  }else{
    $status = 'P';
  }
  $visible=1;
    if ((int) $total == 0) {
    $status = 'C';
    $visible = 0;
  }

  // Crear orden del evento

    
      $evento_social_1_id = ($_REQUEST['monto_actividad_1211']>0) ? $_REQUEST['id_actividad_1'] : '0' ; // carrera
      $evento_social_2_id = ($_REQUEST['monto_actividad_2210']>0) ? $_REQUEST['id_actividad_2'] : '0' ; // tour indicaciones
      $evento_social_3_id = ($_REQUEST['id_actividad_3205']>0) ? $_REQUEST['id_actividad_3205'] : '0' ; // deportes
      $evento_social_4_id = ($_REQUEST['id_actividad_4']!='') ? $_REQUEST['id_actividad_4'] : '0' ; // Foro
      $evento_social_5_id = ($_REQUEST['id_actividad_5']!='') ? $_REQUEST['id_actividad_5'] : '0' ; // yoga

      $evento_actividad_id = ($_REQUEST['monto_taller_especial']>0) ? $_REQUEST['id_taller_sabado'] : '0' ;
      $evento_taller_id = ($_REQUEST['numero223']>0) ? $_REQUEST['id_taller_master'] : '0' ;
      $evento_taller2_id = ($_REQUEST['martes6']!='') ? $_REQUEST['id_taller201'] : '0' ;



  
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
      tipo,
      evento_actividad_id,
                evento_taller_id,
                evento_taller_2_id,
                evento_social_1_id,
                evento_social_2_id,
                evento_social_3_id
      ) 
    VALUES (
      '".$ordenOriginal->pwisa_users_ID."', 
      '".$blog_id."', 
      '".$status."', 
      '".$ordenOriginal->numero."',
      '".$numeroVigente."',
      '".$visible."', 
      '4', 
      '".$fechahora."', 
      '".date('Y-m-d', strtotime("+5 days") )."',
      '".$ordenOriginal->tipo."',
      '".$evento_actividad_id."',
                '".$evento_taller_id."',
                '".$evento_taller2_id."',
				'".$evento_social_1_id."',
                '".$evento_social_2_id."',
                '".$evento_social_4_id."'
    );";
//echo $sqlActivites;
$insertOrden = $wpdb->get_results($sqlActivites);
//exit();

/*$orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");

//if($insertOrden){
if(!$orden_id){
}else{*/
$orden_id = $wpdb->insert_id;


if(!$orden_id){
}else{
  $orden_id = $wpdb->insert_id;

  $tipo_asistencia = 'Presencial';
  $talla = $_REQUEST['talla'];
  $talla_companion = $_REQUEST['talla_companion'];
  //$tipo_habitacion = (isset($_REQUEST['id_tipo_habitacion'])) ? $_REQUEST['id_tipo_habitacion'] : '' ;
  //$fechahab = (isset($_REQUEST['estadia'])) ? $_REQUEST['estadia'] : '' ;
  $tipo_carrera = (isset($_REQUEST['actividad1_tipo_carrera'])) ? $_REQUEST['actividad1_tipo_carrera'] : '' ;
  $companion_actividad_1 = (is_array($_REQUEST['escribauna191'])) ? 'SI' : '' ;
  $companion_actividad_2 = (is_array($_REQUEST['acompanante_actividad_2'])) ? 'SI' : '' ;
  //$companion_actividad_4 = (is_array($_REQUEST['acompanante_actividad_4'])) ? 'SI' : '' ;
  $companion_actividad_5 = (is_array($_REQUEST['acompanante_actividad_5'])) ? 'SI' : '' ;
        
  #$companion_citytour = (is_array($_REQUEST['acompanante_citytour'])) ? 'SI' : '' ;
  #$taller_turno_1 = (isset($_REQUEST['id_taller_martes_turno_1'])) ? $_REQUEST['id_taller_martes_turno_1'] : '' ;
  #$taller_turno_2 = (isset($_REQUEST['id_taller_martes_turno_2'])) ? $_REQUEST['id_taller_martes_turno_2'] : '' ;
  #$taller_turno_3 = (isset($_REQUEST['id_taller_martes_turno_3'])) ? $_REQUEST['id_taller_martes_turno_3'] : '' ;

  $adicionales = array(
    #"tipo_habitacion" => $tipo_habitacion, 
    #"fecha_habitacion" => $fechahab, 
    "tipo_asistencia" => $tipo_asistencia, 
    "talla" => $talla,
     "talla_companion" => $talla_companion,
    "tipo_carrera" => $tipo_carrera, 
    "companion_actividad_1" => $companion_actividad_1, 
    "companion_actividad_2" => $companion_actividad_2,  
    #"companion_actividad_4" => $companion_actividad_4,  
    #"companion_actividad_3" => $companion_citytour, 
    "companion_actividad_5" => $companion_actividad_5,
    #"taller_turno_1" => $taller_turno_1, 
    #"taller_turno_2" => $taller_turno_2,  
    #"taller_turno_3" => $taller_turno_3, 
    #"taller_especial" => $evento_actividad_id,  
    #"taller_master" => $evento_taller_id, 
    "actividad_1" => $evento_social_1_id, 
    "actividad_2" => $evento_social_2_id,  
    #"actividad_3" => $evento_social_3_id,   
    "actividad_4" => $evento_social_4_id,
    "actividad_5" => $evento_social_5_id, 
     #"actividad_6" => $evento_social_6_id,
     #"actividad_7" => $evento_social_7_id, 
  );
  foreach ($adicionales as $key => $value) {
            $arrayColumnas = array(
              'orden_id' => $orden_id,
              'evento_id' => $blog_id,						
              'user_id' => $id_usuario,
              'clave' => $key,
              'valor' => $value
            );				
            $wpdb->insert(
              'evento_info_adicional', 
              $arrayColumnas
            );
        }

//exit();
}

$conceptos = are_newConcept($_REQUEST, $orden_id);

foreach ($conceptos as $key => $value) {
  are_insertConcept($value['id'], $orden_id, $value['costo']);
}

if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria'] and $_REQUEST['costo']>0){
  //pendiente
  $pago = false;
}else{
  
}
if(!isset($_REQUEST['input110']['transactionID'])){ //
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
  $pago = are_pagar($_REQUEST, $orden_id, $fechahora,$numeroVigente);
  $code = base64_encode(base64_encode(base64_encode($pago)));
  $message = "User ID: " . $id_usuario;
  $message = $message . "\nNombre: ".$_REQUEST['nombre'];
  $message = $message. "\nReferencia: ". $_REQUEST['input110']['transactionID'];
  $message=$message;
  if ( (int)$evento_social_1_id !=0 ){
      $message = $message . "\nInscripción Carrera/Caminata: $ " . $_REQUEST['monto_actividad_1211'];
  }
    if ( (int)$evento_social_4_id !=0 ){
      $message = $message."\nInscripción Denominación de Origen: $ " . $_REQUEST['monto_actividad_4'];
  }
   #$headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  /*Envío el correo en formato html con los attachments*/
  //print_r($group_emails)
  
  //$enviado = mail($destinatario, $subject, $body, $headers);
  $enviado = wp_mail("wilder@ztgroupcorp.com", "Edición registro", $message, $headers);

}
if((int) $total > 0)
    are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, 'Presencial', $code);

// guardar acompañante
$companion = are_companion($orden_id);

}

if($_REQUEST["tesoreria"]){
  //are_notificacion('soporte@asipi.org',$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
  echo '<div style="padding: 20px">';
  echo '<br><br><p>Usuario ('.$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1].') registrado en el hotel</p>';
  echo '<p><a href="https://asipi.org/wp-admin/admin.php?page=teso-settings&tab=5">Volver a Tesorería.</a></p><br><br>';
  echo '</div>';
  exit();
}

function are_newConcept($request, $orden_id = '')
{
    global $wpdb;
    global $blog_id;
		$concepts = array();
		
    $conceptos_actividades = 
        array(
          'id_concepto_social_1' => $_REQUEST['monto_actividad_1211'], 
          'id_concepto_social_2' => $_REQUEST['monto_actividad_2210'], 
          'id_concepto_social_3' => $_REQUEST['monto_actividad_3209'], 
          'id_concepto_social_4' => $_REQUEST['monto_actividad_4'], 
          'id_concepto_actividad_1' => $_REQUEST['monto_taller_especial'], 
          'id_concepto_taller_1' => $_REQUEST['numero223']
      );
      foreach ($conceptos_actividades as $key => $monto) {
        if($monto > 0){
          if($key=='id_concepto_social_1' and isset($_REQUEST['escribauna191'][0])){
            $key = $key.'_acomp';
          }
          if($key=='id_concepto_social_2' and isset($_REQUEST['acompanante_actividad_2'][0])){
            $key = $key.'_acomp';
          }
          if($key=='id_concepto_social_4' and isset($_REQUEST['acompanante_actividad_4'][0])){
            $key = $key.'_acomp';
          }
          $id_concepto_actividad = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = '$key'");
          $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = '.$id_concepto_actividad);
          $concepts[] = array('id' => $id_concepto_actividad,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $monto );
        }
      }
		return $concepts;
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

function are_pagar($request, $orden_id, $today,$numeroVigente)
{
  global $wpdb;

  $pay_status = 'C';
  //if (isset($request['input110'][3])) {
    $referencia = $request['input110']['transactionID'];
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
  //if (isset($request['input110'][3])) {
    //if (isset($request['total'])) {
        $numero_f = $wpdb->get_var("SELECT numero FROM evento_orden WHERE id = ".$orden_id);
        //calcular numero de pago
        $pagos = $wpdb->get_var('SELECT count(*) FROM evento_pago WHERE evento_orden_id="' . $orden_id . '"');
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
        $arrayColumnas = array(
            'numero' => $numeroReceipt,
            'subnumero'=>$numeroVigente,
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

  $event_id = $blog_id;

  $nombre = ucwords(strtolower($_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1])); 
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
  $queryResult = $wpdb->get_results("select * from teso_config where clave in ('".$strTipoEmail."subject-es','".$strTipoEmail."subject-en','".$strTipoEmail."body-es','".$strTipoEmail."body-en','pdf-folder')");
  
  

  $nombre_evento = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'name_".$lang."'");
  //$header_factura = get_home_url();
  $header_factura = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'header_".$lang."'");
  $fields = array();  
  foreach($queryResult as $row){
      $fields[$row->clave] = $row->valor;
  }

  
  $destinatario = $_REQUEST["billemail"];
 
  // SUJETO DEL MAIL
  $subject = $fields[$strTipoEmail.'subject-'.$lang];
  // BODY DEL MAIL
  $claveBody = 'emailBody-'.$lang.'-'.$tipoDocumento.'-'.$tipoAsistenciaMail.'-'.$formaPagoMail; //emailBody-es-invoice-presencial-transferencia
  $body = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = '".$claveBody."'");

  
  $asipiPath = $_SERVER['DOCUMENT_ROOT'];
  //$code = base64_encode(base64_encode(base64_encode($orden_id)));
  //dlInvoiceEvento.php o dlReceiptEvento.php
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
  $body = str_replace("%%EVENTO%%",$nombre_evento,$body);
  $subject = str_replace("%%EVENTO%%",$nombre_evento,$subject);
  $body = str_replace("%%HEADER%%",$header_factura,$body);
  $body = str_replace("%%LINK%%",$link_factura,$body);
  //$headers = array('Content-Type: text/html; charset=UTF-8','Reply-To: tesoreria@asipi.org');
  $headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  /*Envío el correo en formato html con los attachments*/
  //print_r($group_emails)
  
  //$enviado = mail($destinatario, $subject, $body, $headers);
  $enviado = wp_mail($destinatario, $subject, $body, $headers);
  #$enviado = wp_mail('wilder@ztgroupcorp.com', $subject, $body, $headers);
  
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