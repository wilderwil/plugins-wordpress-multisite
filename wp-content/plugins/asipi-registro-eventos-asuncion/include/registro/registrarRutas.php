<?php

global $wpdb;
global $blog_id;

$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$fechahora = $dt->format('Y-m-d H:i:s');
if(isset($_REQUEST['formID'])){
if ($_POST) {
  $keys_post = array_keys($_POST);
  foreach ($keys_post as $key_post) {
    $$key_post = $_POST[$key_post];
    //echo ("$key_post = ".$_POST[$key_post]."<br>");
  }
}

//exit();
if (isset($numero_orden) && $numero_orden != '') {
  $sql_orden = "SELECT * FROM `evento_orden` WHERE `id` = '$numero_orden'";
  $queryResult = $wpdb->get_results($sql_orden);
  foreach ($queryResult as $row) {
    $ordenOriginal = $row;
  }
  //var_dump($ordenOriginal);

  ## asigna el numero de factura a la orden del evento
  #$sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE visible=1 AND numero='" . $ordenOriginal->numero . "'";
  $sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."' AND visible=1 AND numero='".$ordenOriginal->numero."'";
  $actual = $wpdb->get_var($sqlMaior);
  $actual = ($actual == null) ? 0 : $actual;
  $numeroVigente = $actual + 1;
  ## fin numero factura

  ## estatus de pago

  if (isset($_REQUEST['misproductos']['transactionID'])) {
    $status = 'C';
  } else {
    $status = 'P';
  }

  // Crear orden del evento
  $evento_actividad_id = null;
  $sqlActivites = "INSERT INTO evento_orden 
      (evento_actividad_id,
      pwisa_users_ID, 
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
      '" . $evento_actividad_id . "', 
      '" . $ordenOriginal->pwisa_users_ID . "', 
      '" . $blog_id . "', 
      '" . $status . "', 
      '" . $ordenOriginal->numero . "',
      '" . $numeroVigente . "',
      '1', 
      '4', 
      '" . $fechahora . "', 
      '" . date('Y-m-d', strtotime("+5 days")) . "',
      '" . $ordenOriginal->tipo . "'
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

  $adicionales = array(
    "tipo_habitacion" => $tipohabitacion,
    //"fecha_habitacion" => $noches1.$noches2, 
    "tipo_asistencia" => 'presencial',
    "cantidad_noches" => $cantidadnoches,
    //"numero_vuelo" => $flightnumber28 , 
    "companion" => $acompanante,
    "pasaporte" => $pasaporte,
    "socio_referente" => $socioreferente,
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
  $id_concepto_rutas = 41;
  
  $nombreConcepto = $wpdb->get_var("SELECT nombre_es FROM evento_concepto WHERE id = '$id_concepto_rutas'");
  $conceptos[] = array('id' => $id_concepto_rutas, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $total);

  foreach ($conceptos as $key => $value) {
    are_insertConcept($value['id'], $orden_id, $value['costo']);
  }
  if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria'] and $_REQUEST['costo'] > 0) {
    //pendiente
    $pago = false;
  } else {
  }
  if (!isset($_REQUEST['misproductos']['transactionID'])) { //
    //require ( '../invoice/invoice.php' );
    //teso_send_invoice_evento($orden_id, false);
    $tipoDocumento = 'Invoice';
    $formaPagoMail = 'Transferencia';
    $pago = false;
    $code = base64_encode(base64_encode(base64_encode($orden_id)));
  } else {
    //pagado
    $tipoDocumento = 'Receipt';
    $formaPagoMail = 'Paypal';
    $pago = are_pagar($_REQUEST, $orden_id, $fechahora);
    $code = base64_encode(base64_encode(base64_encode($pago)));
  }

  are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, 'Rutas', $code);

  // guardar acompañante
  #$companion = are_companion($orden_id);



  if ($_REQUEST["tesoreria"]) {
    //are_notificacion('soporte@asipi.org',$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
    echo '<div style="padding: 20px">';
    echo '<br><br><p>Usuario (' . $_REQUEST['nombre'][0] . ' ' . $_REQUEST['nombre'][1] . ') registrado en el hotel</p>';
    echo '<p><a href="https://asipi.org/wp-admin/admin.php?page=teso-settings&tab=5">Volver a Tesorería.</a></p><br><br>';
    echo '</div>';
    exit();
  }
} else {
/*
  echo '<pre>';
  #	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id();
  #$user_id ="3104";
  #echo $user_id;
  #$is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id ='.$user_id);

  var_dump($_REQUEST);
  echo '<pre>';
  die;
*/
  if ($_REQUEST['id_usuario'] == "0") {
    $email = $_REQUEST["email"];
    $user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

    if ($user_id == NULL) {
      // NO REGISTRADO (NO SOCIO - ESTUDIANTE)
      $user_id = are_newUser();
    }
    $_REQUEST['id_usuario'] = $user_id;
  }
  $user_id = $_REQUEST['id_usuario'];

  if (!is_user_member_of_blog($user_id, $blog_id)) {
    add_user_to_blog($blog_id, $user_id, 'subscriber');
  }

  if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria']) {
  } else {
    $_SESSION["user_id"] = $_REQUEST['id_usuario'];
    wp_set_auth_cookie($_REQUEST['id_usuario']);
    wp_set_current_user($_REQUEST['id_usuario']);
  }


  //echo $user_id = get_current_user_id();
  if ($_REQUEST['is_member'] == '0') {
    are_guardarDatosPersonales($_REQUEST);
    are_guardarDatosFacturacion($_REQUEST);
  }
  // se crea la nueva orden
  $tipoUsuario = 5;
  $orden_id = are_newOrden($tipoUsuario, $fechahora);
  //$code = base64_encode(base64_encode(base64_encode($orden_id)));
  // se agregan los detalles de la orden

  $adicionales = array(
    "tipo_habitacion" => $tipohabitacion,
    //"fecha_habitacion" => $noches1.$noches2, 
    "tipo_asistencia" => 'presencial',
    "cantidad_noches" => $cantidadnoches,
    //"numero_vuelo" => $flightnumber28 , 
    "companion" => $acompanante,
    "pasaporte" => $pasaporte,
    "socio_referente" => $socioreferente,
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


  $id_concepto_rutas = 41;
  $nombreConcepto = $wpdb->get_var("SELECT nombre_es FROM evento_concepto WHERE id = '$id_concepto_rutas'");
  $conceptos[] = array('id' => $id_concepto_rutas, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $total);

  foreach ($conceptos as $key => $value) {
    are_insertConcept($value['id'], $orden_id, $value['costo']);
  }

/*
 echo '<pre>';
  #	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id();
  #$user_id ="3104";
  #echo $user_id;
  #$is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id ='.$user_id);

  var_dump($_REQUEST);
  echo '<pre>';
  echo 'Orden_id '.  $orden_id;
  echo '</pre>';
 */

  if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria'] and $_REQUEST['costo'] > 0) {
    //pendiente
    $pago = false;
  } else {
  }
  if (!isset($_REQUEST['misproductos']['transactionID'])) { //
    
    //require ( '../invoice/invoice.php' );
    //teso_send_invoice_evento($orden_id, false);
    $tipoDocumento = 'Invoice';
    $formaPagoMail = 'Transferencia';
    $pago = false;
    $code = base64_encode(base64_encode(base64_encode($orden_id)));
  } else {
    //pagado
   
    $tipoDocumento = 'Receipt';
    $formaPagoMail = 'Paypal';
    $pago = are_pagar($_REQUEST, $orden_id, $fechahora);
    $code = base64_encode(base64_encode(base64_encode($pago)));
  }
  are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, 'Rutas', $code);




  if ($_REQUEST["user_type"] == 'socio') {
    //are_notificacion($_REQUEST['email'],$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
  }

  if ($_REQUEST["tesoreria"]) {
    //are_notificacion('soporte@asipi.org',$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
    echo '<div style="padding: 20px">';
    echo '<br><br><p>Usuario (' . $_REQUEST['nombre'][0] . ' ' . $_REQUEST['nombre'][1] . ') registrado en el evento</p>';
    echo '<p><a href="https://asipi.org/wp-admin/admin.php?page=teso-settings&tab=5">Volver a Tesorería.</a></p><br><br>';
    echo '</div>';
    exit();
  }
}
}
function are_verifyConcept($id_concepto = '', $orden_id = '')
{
  global $wpdb;
  $verificar = $wpdb->get_var('SELECT evento_concepto_id FROM evento_orden_concepto WHERE evento_concepto_id = ' . $id_concepto . ' and evento_orden_id = ' . $orden_id);
  if (!$verificar) {
    return false;
  } else {
    return $verificar;
  }
}
function are_insertConcept($id_concepto = '', $orden_id = '', $monto = 0)
{
  global $wpdb;
  if (!are_verifyConcept($id_concepto, $orden_id)) {
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

function are_pagar($request, $orden_id, $today)
{
  global $wpdb;
 
  $pay_status = 'C';
  //if (isset($request['misproductos']['transactionID'])) {
  $referencia = $request['misproductos']['transactionID'];
  $pay_mode = 5; //'Paypal';
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
  //if (isset($request['misproductos']['transactionID'])) {
  //if (isset($request['total'])) {
  $numero_f = $wpdb->get_var("SELECT numero FROM evento_orden WHERE id = " . $orden_id);
 
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
    'evento_pago',
    $arrayColumnas
  );
  
  ///$pago_id = $wpdb->insert_id;
  $sql = "SELECT id FROM evento_pago WHERE visible=1 and numero='$numeroReceipt' and evento_orden_id=$orden_id";
  $pago_id = $wpdb->get_var($sql);

  if (!$insertPago) {
    return 0;
  } else {
    // Success
    // Si el pago se marca como completado se resta
    if ($pay_status == "C") {
      // Restar saldo de eventos

      $payment_user = $wpdb->get_var("SELECT pwisa_users_ID FROM evento_orden WHERE id = " . $orden_id);
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
      $total += $data->costo;
    }
  }

  if ($mtoFavor and $total >= 0) {
    //echo 'pone saldo a favor en teso';
    $wpdb->update(
      'pwisa_teso_cuenta',
      array('saldo' => 0),
      array('pwisa_users_ID' => $user_id)
    );
  }
}
function are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, $tipoAsistenciaMail, $code)
{

  global $wpdb;
  global $blog_id;
  $user_id = $_REQUEST['id_usuario'];
  $event_id = $blog_id;

  #$nombre = ucwords(strtolower($_REQUEST['nombre']['first'].' '.$_REQUEST['nombre']['last'])); 
  $nombre = ucwords(strtolower($_REQUEST['namey']));

  /*Busco los parametros de configuración (plantillas en ingles y español y la ruta de la carpeta de archivos pdf */
  $qry = "SELECT value FROM pwisa_bp_xprofile_data where field_id='14' AND user_id=" . $user_id;
  if ($idioma = $wpdb->get_var($qry)) {

    if (!strcmp($idioma, 'Español') || !strcmp($idioma, 'Portugués')) {
      $lang = 'es';
    } else {
      $lang = 'en';
    }
  } else {
    $idioma = "Español";
    $lang = 'es';
  }


  $strTipoEmail = 'event' . $tipoDocumento;
  $strTipoEmail = 'eventInvoice';
  $queryResult = $wpdb->get_results("select * from teso_config where clave in ('" . $strTipoEmail . "subject-es','" . $strTipoEmail . "subject-en','" . $strTipoEmail . "body-es','" . $strTipoEmail . "body-en','pdf-folder')");



  $nombre_evento = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = " . $event_id . " AND clave = 'name_" . $lang . "'");
  $nombre_evento_largo = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = " . $event_id . " AND clave = 'description_" . $lang . "'");

  $tesorero = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = '" . $event_id . "' AND clave = 'email_tesorero'");
  //$header_factura = get_home_url();
  $header_factura = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = " . $event_id . " AND clave = 'header_" . $lang . "'");
  $fields = array();
  foreach ($queryResult as $row) {
    $fields[$row->clave] = $row->valor;
  }


  #$destinatario = $_REQUEST["billemail"];
  $destinatario = $_REQUEST["email"];
  #$destinatario = "wilder@ztgroupcorp.com";
  // SUJETO DEL MAIL
  $subject = $fields[$strTipoEmail . 'subject-' . $lang];
  // BODY DEL MAIL
  $claveBody = 'emailBody-' . $lang . '-' . $tipoDocumento . '-' . $tipoAsistenciaMail . '-' . $formaPagoMail; //emailBody-es-invoice-presencial-transferencia
  $body = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = " . $event_id . " AND clave = '" . $claveBody . "'");


  $asipiPath = $_SERVER['DOCUMENT_ROOT'];
  //$code = base64_encode(base64_encode(base64_encode($orden_id)));
  //dlInvoiceEvento.php o dlReceiptEvento.php
  $link2 = '';
  if (strcmp($formaPagoMail, 'Paypal') === 0) {
    $code_link2 = base64_encode(base64_encode(base64_encode($orden_id)));
    $link2 = 'https://asipi.org/asipi-helper/dlInvoiceEvento.php?&data=' . $code_link2;
  }
  $link_factura = 'https://asipi.org/asipi-helper/dl' . $tipoDocumento . 'Evento.php?&data=' . $code;
  /*$folder = $asipiPath.'wp-content/uploads/facturas/send/';    // $fields['pdf-folder'] .
  if ($carpeta!=''){
      $folder.=$carpeta;
  }
  $link_factura = 
  

  $attachments = array($folder.$nombreArchivo);*/
  //var_dump($attachments);

  /*Reemplazo %%SOCIO%% de la plantilla por el nombre y apellido */
  $body = str_replace("%%SOCIO%%", $nombre, $body);
  /*Reemplazo %%Fecha%% de la plantilla por el año actual */
  $body = str_replace("%%FECHA%%", date("Y"), $body);
  $subject = str_replace("%%FECHA%%", date("Y"), $subject);
  $body = str_replace("%%EVENTO%%", $nombre_evento_largo, $body);
  $subject = str_replace("%%EVENTO%%", $nombre_evento, $subject);
  $body = str_replace("%%HEADER%%", $header_factura, $body);
  $body = str_replace("%%LINK%%", $link_factura, $body);
  $body = str_replace("%%TESORERO%%", $tesorero, $body);

  $body = str_replace("%%LINK2%%", $link2, $body);
  #$headers = array('Content-Type: text/html; charset=UTF-8','From: no-reply@asipi.org');
  $headers = array('Content-Type: text/html; charset=UTF-8');
  #$headers = implode( PHP_EOL, $headers );
  #$headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  /*Envío el correo en formato html con los attachments*/
  //print_r($group_emails)

  //$enviado = mail($destinatario, $subject, $body, $headers);

  $enviado = wp_mail($destinatario, $subject, $body, $headers);

  #$enviado = wp_mail('saul@ztgroupcorp.com', $subject, $body, $headers);

  return $enviado;
}

function are_notificacion($email, $alumno, $lang)
{
  //$folder2 = $asipiPath.'wp-content/uploads/facturas/'.$documentTitle;    // $fields['pdf-folder'] .
  $attachments = ''; //array($folder2);

  $formatoCorreo["subject-es"] = 'Confirmación Registro Seminario Virtual ASIPI 2021';
  $formatoCorreo["subject-en"] = 'Confirmación Registro Seminario Virtual ASIPI 2021';

  $formatoCorreo["body-es"] = '<div style="width:640px; text-align: center;"><img src="https://asipi.org/seminario2021/wp-content/uploads/sites/23/2021/03/header-facturas_es.jpg" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>
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
  $formatoCorreo["body-en"] = '<div style="width:640px; text-align: center;"><img src="https://asipi.org/seminario2021/wp-content/uploads/sites/23/2021/03/header-facturas_es.jpg" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>
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
  $body = $formatoCorreo["body-" . $lang];
  $body = str_replace("%%SOCIO%%", $alumno, $body);
  //$nombre_curso = str_replace("Inscripción Curso: ","",__($nombre_curso));
  //$body = str_replace("%%EVENTO%%",__($nombre_curso),$body);
  $subject = $formatoCorreo["subject-" . $lang];
  $headers = array('Content-Type: text/html; charset=UTF-8'); //,'Reply-To: tesoreria@asipi.org'
  //$enviado = wp_mail($destinatario, $subject, $body, $headers, $attachments);	
}

function are_newUser()
{
  global $wpdb;
  global $blog_id;
  //$userType = verify_email(false);
  if ($_REQUEST['id_usuario'] == "0") {
    $password = rand(); // $_REQUEST['password'];
    //rand();  //$_REQUEST['password'];
    //$_REQUEST['password'] = $password;
    $email = $_REQUEST["email"];

    // Transform email into username
    $array = explode("@", $email);
    $arrayStr = explode(".", $array[0]);
    $username = implode("", $arrayStr);
    $arrayStr = explode("-", $username);
    $username = implode("", $arrayStr);

    if (null != username_exists($username)) {
      // username is already registered!
      do {
        $username = $username . rand(1, 100);
      } while (username_exists($username));
    }

    $userdata = array(
      'user_login'  =>  esc_sql($username),
      'user_email'  =>  esc_sql($email),
      'user_pass'   =>  $password,
      'role'   =>  'subscriber'
    );
    //var_dump($userdata);
    //return 0;

    // se agrega al nuevo usuario 
    $user_id = wp_insert_user($userdata);
    //var_dump($user_id) ;
    //return $user_id;

    if ($user_id > 0) {
      // se agrega como participante a eventos de asipi
      $sql = "INSERT INTO asipi_events_attendees ( user_id, event_id ) VALUES ( '" . $user_id . "' , '" . $blog_id . "' )";
      $queryResult = $wpdb->get_results($sql);

      // se agrega la propiedad de lenguaje al usuario nuevo
      $field_lang = '14';
      $idioma = ($_POST['lang'] == 'en-US' || $_POST['lang'] == 'en') ? 'Inglés' : 'Español';

      $sql = "INSERT INTO pwisa_bp_xprofile_data ( user_id, field_id, value ) VALUES ( " . $user_id . ", " . $field_lang . ", '" . $idioma . "' )";
      $queryResult = $wpdb->get_results($sql);

      // se agrega al nuevo usuario como suscriptor en el sitio del evento
      //if ( !is_user_member_of_blog( $user_id, $blog_id ) ) {
      add_user_to_blog($blog_id, $user_id, 'subscriber');
      //}
      // se quita al usuario como suscriptor del sitio principal de asipi
      //$e = remove_user_from_blog($user_id, 1); // el 1 es el id del sitio principal (multisite)

      // loguear al nuevo usuario.
      //$idlogin = are_login();
      return $user_id; //are_login();
    } else {
      return '0';
    }
  } else {
    return '0';
  }
}
function are_newOrden($tipoUsuario, $today)
{ // user_type, email
  global $wpdb;
  global $blog_id;
  //$user_id = ($_REQUEST['id_usuario']>0) ? $_REQUEST['id_usuario'] : get_current_user_id() ;
  $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999;

  $orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='" . $blog_id . "' AND pwisa_users_id='" . $user_id . "'");

  if (!$orden_id) {
    ## asigna el numero de factura a la orden del evento
    $sqlMaior = "SELECT MAX(numero) FROM evento_orden WHERE visible=1 AND evento_id='" . $blog_id . "'";
    $actual = $wpdb->get_var($sqlMaior);
    $actual = ($actual == null) ? 0 : $actual;
    $numeroVigente = $actual + 1;
    ## fin numero factura

    ## estatus de pago
    if (isset($_REQUEST['misproductos']['transactionID'])) {
      $status = 'C';
    } else {
      $status = 'P';
    }

    if ($_REQUEST['total'] == 0) {
      $status = 'C';
    }
    // si hay referencia de paypal status Completado
    // viene por tesoreria o por transferencia bancaria status Pendiente

    /* if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria'] and $_REQUEST['costo']>0){
        //pendiente
        $status = 'P';
      }else{
        //pagado
        $status = 'C';
      } */



    $evento_social_1_id = ($_REQUEST['monto_actividad_1211'] > 0) ? $_REQUEST['id_actividad_1'] : '0'; // carrera
    $evento_social_2_id = ($_REQUEST['monto_actividad_2210'] > 0) ? $_REQUEST['id_actividad_2'] : '0'; // tour indicaciones
    $evento_social_3_id = ($_REQUEST['id_actividad_3205'] > 0) ? $_REQUEST['id_actividad_3205'] : '0'; // deportes
    $evento_social_4_id = ($_REQUEST['monto_actividad_4'] > 0) ? $_REQUEST['id_actividad_4'] : '0'; // taller Vitivinícola
    $evento_social_5_id = ($_REQUEST['actividad_5'] != '') ? $_REQUEST['id_actividad_5'] : '0'; // yoga

    #$evento_actividad_id = ($_REQUEST['monto_taller_especial']>0) ? $_REQUEST['id_taller_sabado'] : '0' ;
    $evento_actividad_id = null;
    $evento_taller_id = ($_REQUEST['numero223'] > 0) ? $_REQUEST['id_taller_master'] : '0';
    $evento_taller2_id = ($_REQUEST['martes6'] != '') ? $_REQUEST['id_taller201'] : '0';

    // Crear orden del evento
    $sqlActivites = "INSERT INTO evento_orden 
                (pwisa_users_ID, 
                evento_id, 
                estado, 
                numero, 
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
								'" . $user_id . "', 
								'" . $blog_id . "', 
								'" . $status . "', 
								'" . $numeroVigente . "',
								'1', 
								'4', 
								'" . $today . "', 
								'" . date('Y-m-d', strtotime("+5 days")) . "',
								'" . $tipoUsuario . "',
								'" . $evento_actividad_id . "',
                '" . $evento_taller_id . "',
                '" . $evento_taller2_id . "',
								'" . $evento_social_1_id . "',
                '" . $evento_social_2_id . "',
                '" . $evento_social_3_id . "'
							);";
    //echo $sqlActivites;
    $insertOrden = $wpdb->get_results($sqlActivites);
    $orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='" . $blog_id . "' AND pwisa_users_id='" . $user_id . "'");

    //if($insertOrden){
    if (!$orden_id) {
    } else {
      $orden_id = $wpdb->insert_id;

      $tipo_asistencia = $_REQUEST['tipo_asistencia'];
      $talla = $_REQUEST['talla'];
      $tipo_habitacion = (isset($_REQUEST['id_tipo_habitacion'])) ? $_REQUEST['id_tipo_habitacion'] : '';
      $fechahab = (isset($_REQUEST['estadia'])) ? $_REQUEST['estadia'] : '';
      $tipo_carrera = (isset($_REQUEST['actividad1_tipo_carrera'])) ? $_REQUEST['actividad1_tipo_carrera'] : '';
      $companion_actividad_1 = (isset($_REQUEST['escribauna191'])) ? 'SI' : '';
      $companion_actividad_2 = (isset($_REQUEST['acompanante_actividad_2'])) ? 'SI' : '';
      $companion_actividad_4 = (isset($_REQUEST['acompanante_actividad_4'])) ? 'SI' : '';
      $companion_citytour = (isset($_REQUEST['acompañante_citytour'])) ? 'SI' : '';
      $taller_turno_1 = (isset($_REQUEST['id_taller_martes_turno_1'])) ? $_REQUEST['id_taller_martes_turno_1'] : '';
      $taller_turno_2 = (isset($_REQUEST['id_taller_martes_turno_2'])) ? $_REQUEST['id_taller_martes_turno_2'] : '';
      $taller_turno_3 = (isset($_REQUEST['id_taller_martes_turno_3'])) ? $_REQUEST['id_taller_martes_turno_3'] : '';

      $adicionales = array(
        "tipo_habitacion" => $tipo_habitacion,
        "fecha_habitacion" => $fechahab,
        "tipo_asistencia" => $tipo_asistencia,
        "talla" => $talla,
        "tipo_carrera" => $tipo_carrera,
        "companion_actividad_1" => $companion_actividad_1,
        "companion_actividad_2" => $companion_actividad_2,
        "companion_actividad_4" => $companion_actividad_4,
        "companion_actividad_3" => $companion_citytour,
        "taller_turno_1" => $taller_turno_1,
        "taller_turno_2" => $taller_turno_2,
        "taller_turno_3" => $taller_turno_3,
        "taller_especial" => $evento_actividad_id,
        "taller_master" => $evento_taller_id,
        "actividad_1" => $evento_social_1_id,
        "actividad_2" => $evento_social_2_id,
        "actividad_3" => $evento_social_3_id,
        "actividad_4" => $evento_social_4_id,
        "actividad_5" => $evento_social_5_id,
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
    }
  }

  return ($orden_id);
}
function are_newConcept($request, $orden_id = '')
{
  global $wpdb;
  global $blog_id;
  $concepts = array();

  $conceptos_inscripcion = array(
    'socio' => 1,
    'student' => $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = 'id_concepto_student'"),
    'invitado' => 8,
    'Panelista' => 8,
    'guest' => 8,
    'no_socio' => 2,
    'nosocio' => 2,
    'miembro' => 2,
  );
  $id_concepto = $conceptos_inscripcion[$request["user_type"]];
  /*switch ($request["user_type"]) {
      case 'socio':
        $id_concepto = 1;
        break;
      case 'student':
        //$id_concepto = 14;
        $id_concepto = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = 'id_concepto_student'");
        break;
      case 'invitado':
        //$id_concepto = 14;
        $id_concepto = 8;
        break;
      case 'Panelista':
        //$id_concepto = 14;
        $id_concepto = 8;
        break;
      default:
        $id_concepto = 2;
        break;
    }	*/

  // se agrega el concepto correspondiente
  $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = ' . $id_concepto);
  $concepts[] = array('id' => $id_concepto, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $request["costo_final_usuario"]);

  // agrega conceptos de saldos a favor o deuda
  if ($request["saldoafavor"] < 0) {
    // Insertar concepto de saldo a favor del user a la orden
    $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 6');
    $concepts[] = array('id' => 6, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $request["saldoafavor"]);
  }
  if ($request["saldodeuda"] > 0) {
    // Insertar concepto de deuda del user a la orden
    $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 5');
    $concepts[] = array('id' => 5, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $request["saldodeuda"]);
  }
  if ($request["costo_final_companion"] > 0) {
    // Insertar concepto por acompañante a la orden
    $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 3');
    $concepts[] = array('id' => 3, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $request["costo_final_companion"]);
  }

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
    if ($monto > 0) {
      if ($key == 'id_concepto_social_1' and isset($_REQUEST['escribauna191'][0])) {
        $key = $key . '_acomp';
      }
      if ($key == 'id_concepto_social_2' and isset($_REQUEST['acompanante_actividad_2'][0])) {
        $key = $key . '_acomp';
      }
      if ($key == 'id_concepto_social_4' and isset($_REQUEST['acompanante_actividad_4'][0])) {
        $key = $key . '_acomp';
      }
      $id_concepto_actividad = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = '$key'");
      $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = ' . $id_concepto_actividad);
      $concepts[] = array('id' => $id_concepto_actividad, 'titulo' => $nombreConcepto, 'orden_id' => $orden_id, 'costo' => $monto);
    }
  }
  /*if($request["monto_actividad"] > 0){
			// Insertar concepto por acompañante a la orden
      $id_concepto_actividad_2 = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = 'id_concepto_actividad_2'");
			$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = '.$id_concepto_actividad_2);
			$concepts[] = array('id' => $id_concepto_actividad_2,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["monto_actividad"] );
		}*/
  //var_dump($concepts);
  return $concepts;
}
function are_guardarDatosPersonales($request = array())
{
  global $wpdb;
  //$user_id = get_current_user_id();
  $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999;
  if ($user_id != '') {
    // El usuario está registrado en la base de datos pero no deberia entrar aquí

    // Insert details on buddypress xprofile
    //$sql = 'SELECT id FROM country_names WHERE name_es = "'.$_POST['country'].'" OR name_en = "'.$_POST['country'].'"';
    $country = '';
    $id_country = '';


    if ($_REQUEST["pais"] != '') {
      $country =  $_REQUEST["pais"];
      $variable_nombre_pais = 'name_es';
    } elseif ($_REQUEST["country1"] != '') {
      $country =  $_REQUEST["country1"];
      $variable_nombre_pais = 'name_en';
    }
    if ($_REQUEST["country"] != '') {
      $country =  $_REQUEST["country"];
    }
    $sql = 'SELECT id FROM country_names WHERE name_es = "' . $country . '" or name_en = "' . $country . '"';
    $id_country = $wpdb->get_var($sql);
    //$country = $request["bill_address"][5];
    //}


    //$fecha_nacimiento = $request["fecha_nacimiento"][0].'-'.$request["fecha_nacimiento"][1].'-'.$request["fecha_nacimiento"][2];

    $campos = array(
      'first_name' =>       array('field_id' => '1',  'value' => $_REQUEST['nombre']['first'],),
      'last_name' =>         array('field_id' => '2',  'value' => $_REQUEST['nombre']['last'],),
      //'city' => 				    array('field_id' => '9',	'value' => $request["direccion"][2], ),
      'country' =>           array('field_id' => '7',  'value' => $country,),
      //'company' => 			    array('field_id' => '12',	'value' => $request["compania"], ),
      #'gender' => 			    array('field_id' => '18',	'value' => $_REQUEST["genero"], ),
      'id_country' =>       array('field_id' => '44',  'value' => $id_country,),
      //'univ' => 				    array('field_id' => '47',	'value' => $request["universidad"], ),
      //'personal-address' => array('field_id' => '3',	'value' => $request["direccion"][0], ),
      //'personal-state' => 	array('field_id' => '8',	'value' => $request["direccion"][3], ),
      //'personal-zip' => 		array('field_id' => '6',	'value' => $request["direccion"][4], ),
      //'fecha-nacimiento' => array('field_id' => '34',	'value' => $fecha_nacimiento, ),
    );
    if (isset($request["compania"])) {
      if ($request["compania"] != '') {
        $campos['company'] = array('field_id' => '12',  'value' => $request["compania"],);
      }
    }
    if (isset($request["universidad"])) {
      if ($request["universidad"] != '') {
        $campos['univ'] = array('field_id' => '47',  'value' => $request["universidad"],);
      }
    }
    //var_dump($campos);


    foreach ($campos as $nombreCampo => $datos) {
      if ($datos['value'] != '') {
        $qry = "SELECT COUNT(*) FROM pwisa_bp_xprofile_data where field_id='" . $datos['field_id'] . "' AND user_id=" . $user_id;
        //echo '   '.$qry.'<br>';

        $verify = $wpdb->get_var($qry);
        if (!$verify) {
          //echo "entro aqui 1  ";
          $wpdb->query(
            $wpdb->prepare(
              "INSERT INTO pwisa_bp_xprofile_data (user_id , field_id, value) VALUES (%d, %d, %s)",
              $user_id,
              $datos['field_id'],
              $datos['value']
            )
          );
        } else {
          //echo "entro aqui 2  ";
          if ($datos['field_id'] != 7 && $datos['field_id'] != 44) {
            // si el campo a actualizar es distinto a pais
            $wpdb->update(
              'pwisa_bp_xprofile_data',
              array('value' => $datos['value']),
              array(
                'field_id' => $datos['field_id'],
                'user_id' => $user_id
              )
            );
          }
        }
      }
    }
    return "guardado";
  } else {

    return "error";
  }
}
function are_guardarDatosFacturacion($request = array())
{
  global $wpdb;
  //$user_id = get_current_user_id();
  $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999;
  if ($user_id != '') {
    // El usuario está registrado en la base de datos pero no deberia entrar aquí

    // Insert details on buddypress xprofile
    //$sql = 'SELECT id FROM country_names WHERE name_es = "'.$_POST['country'].'" OR name_en = "'.$_POST['country'].'"';
    //$sql = 'SELECT name_es FROM country_names WHERE id = "'.$request["bill_address"][5].'"';
    //$id_country = $wpdb->get_var($sql);

    $country = '';
    $id_country = '';
    //if($_REQUEST['user_type']!='socio'){
    if ($request["pais"] != '') {
      $country =  $request["pais"];
      $variable_nombre_pais = 'name_es';
    } elseif ($request["country1"] != '') {
      $country =  $request["country1"];
      $variable_nombre_pais = 'name_en';
    }
    if ($_REQUEST["country"] != '') {
      $country =  $_REQUEST["country"];
    }
    $sql = 'SELECT id FROM country_names WHERE name_es = "' . $country . '" or name_en = "' . $country . '"';
    $id_country = $wpdb->get_var($sql);
    //$country = $request["bill_address"][5];
    //}

    //echo $id_country.' - ';
    //echo $sql;
    $campos = array(
      'billemail' =>     array('field_id' => '28',  'value' => $request["billemail"],),
      'bill-name' =>     array('field_id' => '45',  'value' => $request["razonsocial"],),
      'bill-city' =>     array('field_id' => '32',  'value' => $request["bill_address"]['city'],),
      'bill-nit' =>     array('field_id' => '46',  'value' => $request["nit"],),
      #'bill-country' => array('field_id' => '30',  'value' => $id_country,),
      'bill-country' => array('field_id' => '30',  'value' => $country,),
      
      'bill_address' => array('field_id' => '29',  'value' => $request["bill_address"]['addr_line1'],),
      'bill-state' =>   array('field_id' => '31',  'value' => $request["bill_address"]['state'],),
      'bill-zip' =>     array('field_id' => '33',  'value' => $request["bill_address"]['postal'],),
    );

    foreach ($campos as $nombreCampo => $datos) {
      if ($datos['value'] != '') {
        $qry = "SELECT COUNT(*) FROM pwisa_bp_xprofile_data where field_id='" . $datos['field_id'] . "' AND user_id=" . $user_id;
        //echo '   '.$qry.'<br>';

        $verify = $wpdb->get_var($qry);
        if (!$verify) {
          //echo "entro aqui 1  ";
          $wpdb->query(
            $wpdb->prepare(
              "INSERT INTO pwisa_bp_xprofile_data (user_id , field_id, value) VALUES (%d, %d, %s)",
              $user_id,
              $datos['field_id'],
              $datos['value']
            )
          );
        } else {
          //echo "entro aqui 2  ";
          $wpdb->update(
            'pwisa_bp_xprofile_data',
            array('value' => $datos['value']),
            array(
              'field_id' => $datos['field_id'],
              'user_id' => $user_id
            )
          );
        }
      }
    }
    return "guardado";
  } else {

    return "error";
  }

}