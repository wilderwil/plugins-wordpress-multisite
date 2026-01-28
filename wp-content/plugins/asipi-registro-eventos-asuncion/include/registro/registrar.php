<?php

global $wpdb;
global $blog_id;
/*
echo  '<pre>';
var_dump($_REQUEST);
echo '<pre>';
die;*/
//fecha de registro
if(isset($_REQUEST['formID'])){

$tz = 'America/New_York';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$fechahora = $dt->format('Y-m-d H:i:s');
$day = $dt->format('Y-m-d');
$isvalid=false;
$lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;
$numero_orden = $_REQUEST['numero_orden'];

$subnumero = $_REQUEST['subnumero'];

$numero_factura= $wpdb->get_var("SELECT numero FROM evento_orden WHERE id = $numero_orden");

$numeroVigente1= $wpdb->get_var("SELECT count(*) FROM evento_orden WHERE subnumero = $subnumero and numero= $numero_factura and evento_id='".$blog_id."'");

$numeroVigente = $subnumero;


/*Edicion Formulario*/
if($numero_orden!='' and $numeroVigente1==0){
    
    $isvalid =true;
    ///////////////////////////////////////////////////////////////////////////////////////////////
    $sql_orden = "SELECT * FROM `evento_orden` WHERE `id` = '$numero_orden'";
$queryResult = $wpdb->get_results($sql_orden);
  foreach($queryResult as $row){
    $ordenOriginal = $row;
  }

  ## asigna el numero de factura a la orden del evento
    /*$sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE visible=1 and evento_id='".$blog_id."' AND numero='".$ordenOriginal->numero."'";
    $actual = $wpdb->get_var($sqlMaior);
    $actual = ($actual == null) ? 0 : $actual;
    $numeroVigente = $actual+1;*/
  ## fin numero factura

  ## estatus de pago
  if( isset($_REQUEST['misproductos']['transactionID']) ){
    $status = 'C';
  }else{
    $status = 'P';
  }
  $visible=1;
    if ((int)  $_REQUEST['total']  == 0) {
    $status = 'C';
    $visible = 0;
  }

  // Crear orden del evento

    
      $evento_social_1_id = ($_REQUEST['monto_actividad_1211']>0) ? $_REQUEST['id_actividad_1'] : '0' ; // Carrera Caminata 54
      $evento_social_2_id = ($_REQUEST['monto_actividad_2210']>0) ? $_REQUEST['id_actividad_2'] : '0' ; // Ruta indicaciones Geograficas 56
      $evento_social_3_id = ($_REQUEST['monto_actividad_3']>0) ? $_REQUEST['id_actividad_3'] : '0' ; // city Tour 52
      $evento_social_4_id = ($_REQUEST['id_actividad_4']!='') ? $_REQUEST['id_actividad_4'] : '0' ; // Come as You are 55
      $evento_social_5_id = ($_REQUEST['id_actividad_5']!='') ? $_REQUEST['id_actividad_5'] : '0' ; // yoga 53
      $evento_actividad_id = ($_REQUEST['id_actividad_6']!='') ? $_REQUEST['id_actividad_6'] : '0' ; //Deportiva Verificar el concepto de la actividad
      $evento_taller_id = ($_REQUEST['id_taller_1']!='') ? $_REQUEST['id_taller_1'] : '0' ;
      $evento_taller2_id = ($_REQUEST['id_taller_2']!='') ? $_REQUEST['id_taller_2'] : '0' ;
      $evento_social_7_id = ($_REQUEST['id_actividad_7']!='') ? $_REQUEST['id_actividad_7'] : '0' ; // ¡Buen provecho! Hoy almorzamos una Especialidad Tradicional Garantizada 61
      $evento_social_8_id = ($_REQUEST['id_actividad_8']!='') ? $_REQUEST['id_actividad_8'] : '0' ; // Desayuno Concurso Innovación Verde 75   	
      $evento_social_9_id = ($_REQUEST['id_actividad_9']!='') ? $_REQUEST['id_actividad_9'] : '0' ; // Cata de vino y maridaje
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
								'0',
                '".$evento_taller_id."',
                '".$evento_taller2_id."',
				'".$evento_social_1_id."',
                '".$evento_social_2_id."',
                '".$evento_social_3_id."'
							);";
              //echo $sqlActivites;
			$insertOrden = $wpdb->get_results($sqlActivites);
            $orden_id = $wpdb->insert_id;

if(!$orden_id){
}else{
  $orden_id = $wpdb->insert_id;

        $tipo_asistencia = $_REQUEST['tipo_asistencia'];
        //$talla = $_REQUEST['tallacamisa'];
        //$talla_companion = $_REQUEST['talla_companion'];
        $tipo_carrera = (isset($_REQUEST['actividad1_tipo_carrera'])) ? $_REQUEST['actividad1_tipo_carrera'] : '' ;
        $tipo_carrera_companion = (isset($_REQUEST['actividad1_tipo_carrera_companion'])) ? $_REQUEST['actividad1_tipo_carrera_companion'] : '' ;
        $companion_actividad_1 = (is_array($_REQUEST['escribauna191'])) ? 'SI' : '' ;
        $companion_actividad_2 = (isset($_REQUEST['companion_name1']) and $_REQUEST['companion_name1']!="") ? 'SI' : '' ;
        $companion_actividad_9 = (is_array($_REQUEST['acompanante_actividad_9'])) ? 'SI' : '';
        $companion_actividad_4 = (is_array($_REQUEST['acompanante_actividad_4'])) ? 'SI' : '' ;
        $companion_actividad_5 = (is_array($_REQUEST['acompanante_actividad_5'])) ? 'SI' : '' ;
  if(isset($_REQUEST['acompanantegolf']) &&  $_REQUEST['acompanantegolf']!=""){
    $companion_actividad_6 =  '60';
  }
  if(isset($_REQUEST['acompanantepadel']) &&  $_REQUEST['acompanantepadel']!=""){
    $companion_actividad_6 =  '57';
  }
    if(isset($_REQUEST['acompanantefutbol']) &&  $_REQUEST['acompanantefutbol']!=""){
    $companion_actividad_6 =  '59';
  }
      if(isset($_REQUEST['acompanantetenis']) &&  $_REQUEST['acompanantetenis']!=""){
    $companion_actividad_6 =  '58';
  }
  
       # $companion_actividad_6 = (isset($_REQUEST['acompanantegolf'])) ? 'SI' : '' ;
        
        $taller_turno_1 = (isset($_REQUEST['id_taller_1'])) ? $_REQUEST['id_taller_1'] : '' ;
        $taller_turno_2 = (isset($_REQUEST['id_taller_2'])) ? $_REQUEST['id_taller_2'] : '' ;
        $mentor =  (isset($_REQUEST['mentor'])) ? $_REQUEST['mentor'] : ''; 
         $tipo_companion_ruta="";
        if(isset($_REQUEST['acompante_registrado'])){
              $tipo_companion_ruta = $_REQUEST['acompante_registrado'];
          }elseif(isset($_REQUEST['acompanante_inscrito'])){
                 $tipo_companion_ruta = $_REQUEST['acompanante_inscrito'];
          }elseif(isset($_REQUEST['acompanante_otro'])){
                 $tipo_companion_ruta = $_REQUEST['acompanante_otro'];
          }
        $adicionales = array(
          "tipo_asistencia" => $tipo_asistencia, 
        //  "talla" => $talla, 
        //  "talla_companion" => $talla_companion,
          "tipo_carrera" => $tipo_carrera, 
          "tipo_carrera_companion" => $tipo_carrera_companion, 
          "companion_actividad_1" => $companion_actividad_1,
          "companion_actividad_2" => $companion_actividad_2,
          "companion_actividad_9" => $companion_actividad_9,
          "companion_actividad_4" => $companion_actividad_4,
          "companion_actividad_5" => $companion_actividad_5,
          "companion_actividad_6" => $companion_actividad_6,
          "companion_name_actividad2" => $_REQUEST['companion_name1'],
          "tipo_companion_ruta"=>$tipo_companion_ruta,
          "taller_turno_1" => $taller_turno_1, 
          "taller_turno_2" => $taller_turno_2,  
          "actividad_1" => $evento_social_1_id, 
          "actividad_2" => $evento_social_2_id,  
          "actividad_3" => $evento_social_3_id,   
          "actividad_4" => $evento_social_4_id,
          "actividad_5" => $evento_social_5_id, 
          "actividad_6" => $evento_actividad_id,
          #"actividad_7" => $evento_social_7_id,
          "actividad_8" => $evento_social_8_id,
          "actividad_9" => $evento_social_9_id,
          "mentor" => $mentor,
        );

  foreach ($adicionales as $key => $value) {

      	if ($value!='' && $value!='0') {
			$existe = $wpdb->get_var("SELECT * FROM evento_info_adicional WHERE orden_id = '".$numero_orden."' and clave = '".$key."' ");
			if($existe==NULL){
			    $arrayColumnas = array(
                  'orden_id' => $numero_orden,
                  'evento_id' => $blog_id,						
                  'user_id' => $ordenOriginal->pwisa_users_ID,
                  'clave' => $key,
                  'valor' => $value
            );				
			     $wpdb->insert(
                    'evento_info_adicional', 
                     $arrayColumnas
                );
			}else{
            $wpdb->update( 
                'evento_info_adicional', 
                array( 'valor' => $value), 
                array( 'clave' => $key, 'orden_id' => $numero_orden)		
                );
        }}
  }
  
  

//exit();
}

    ////////////////////////////////////////////////////////////////////////////////////////////////
    
}else{
/*Registro Nuevo*/

$email = $_REQUEST["email"];
$user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

$orden_verificar = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");


if ($orden_verificar==NULL){
    
  
    
$coupon_code = isset($_REQUEST['coupon_code']) ? $_REQUEST['coupon_code'] : ''; 
//echo $coupon_code;

$is_valid_coupon = $wpdb->get_var('SELECT id FROM evento_coupons WHERE coupon = "' . $coupon_code . '" and status = 0');

 //echo $is_valid_coupon;

    if( ($_REQUEST["user_type"] != 'guest' && !$is_valid_coupon) || ($_REQUEST["user_type"] == 'guest' && $is_valid_coupon) ){
  $isvalid =true;

switch ($_REQUEST["user_type"]) {
  case 'socio':
    $id_concepto = 1;
    $tipoUsuario = 1;
    break;
  case 'student':
    $id_concepto = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = 'id_concepto_student'");
    $tipoUsuario = 3;
    break;
  default:
    $id_concepto = 2;
    $tipoUsuario = 2;
    break;
}	
// identificacion del usuario
if ( $_REQUEST['id_usuario'] == "0" ) {
	$email = $_REQUEST["email"];
	$user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

	if($user_id == NULL){
		// NO REGISTRADO (NO SOCIO - ESTUDIANTE)
		$user_id = are_newUser();
	}
  	$_REQUEST['id_usuario'] = $user_id;
}
$user_id = $_REQUEST['id_usuario'];

if ( !is_user_member_of_blog( $user_id, $blog_id ) ) {				
  add_user_to_blog( $blog_id, $user_id, 'subscriber' );
}

if (isset($_REQUEST['tesoreria']) and $_REQUEST['tesoreria']) {

}else{
    $_SESSION["user_id"] = $_REQUEST['id_usuario'];
    wp_set_auth_cookie( $_REQUEST['id_usuario'] );
    wp_set_current_user( $_REQUEST['id_usuario'] );
}
	

//echo $user_id = get_current_user_id();

are_guardarDatosPersonales($_REQUEST);
are_guardarDatosFacturacion($_REQUEST);




// se crea la nueva orden
$orden_id = are_newOrden($tipoUsuario, $fechahora);
//$code = base64_encode(base64_encode(base64_encode($orden_id)));

 
}

}
}

if ($isvalid){
// se agregan los detalles de la orden
$conceptos = are_newConcept($_REQUEST, $orden_id);
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
  $pago = are_pagar($_REQUEST, $orden_id, $fechahora,$ordenOriginal->id);
  $code = base64_encode(base64_encode(base64_encode($pago)));
}
$total = (int)  $_REQUEST['total'];
if( $total > 0)
    are_enviarfact($user_id, $orden_id, $tipoDocumento, $formaPagoMail, $_REQUEST['tipo_asistencia'], $code);

// guardar acompañante
$companion = are_companion($orden_id);
if ($is_valid_coupon) {
  //echo 'pone saldo a favor en teso';
  $wpdb->update(
    'evento_coupons',
    array('status' => 1, 'order_id' => $orden_id),
    array('coupon' => $coupon_code, 'id' => $is_valid_coupon)
  );
}

if($_REQUEST["user_type"]=='socio'){
  //are_notificacion($_REQUEST['email'],$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
}

if($_REQUEST["tesoreria"]){
  //are_notificacion('soporte@asipi.org',$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1], $lang);
  echo '<div style="padding: 20px">';
  echo '<br><br><p>Usuario ('.$_REQUEST['nombre'][0].' '.$_REQUEST['nombre'][1].') registrado en el evento</p>';
  echo '<p><a href="https://asipi.org/wp-admin/admin.php?page=teso-settings&tab=5">Volver a Tesorería.</a></p><br><br>';
  echo '</div>';
  exit();
}
}



    /*if (isset($_POST['curriculum']) and $_POST['curriculum']!='') {
      $curriculum = 'https://www.jotform.com/uploads/eezozaya/'.$_POST["formID"].'/'.$_POST["submission_id"].'/'.$_POST['curriculum'];
    }*/
}
function are_newUser()
{
    global $wpdb;
    global $blog_id;
		//$userType = verify_email(false);
		if ( $_REQUEST['id_usuario'] == "0" ) {
      $password = rand();// $_REQUEST['password'];
      //rand();  //$_REQUEST['password'];
      //$_REQUEST['password'] = $password;
			$email = $_REQUEST["email"];

			// Transform email into username
			$array=explode("@",$email);
			$arrayStr=explode(".",$array[0]);
			$username=implode("", $arrayStr);
			$arrayStr=explode("-",$username);
			$username=implode("", $arrayStr);

			if( null != username_exists( $username ) ) {
				// username is already registered!
				do{
					$username = $username. rand(1,100);
				}while(username_exists($username));
			}

			$userdata = array(
			    'user_login'  =>  esc_sql( $username ),
			    'user_email'  =>  esc_sql( $email ),
			    'user_pass'   =>  $password,
			    'role'   =>  'subscriber'
      );
      //var_dump($userdata);
      //return 0;
      
			// se agrega al nuevo usuario 
      $user_id = wp_insert_user( $userdata ) ;
      //var_dump($user_id) ;
      //return $user_id;
      
			if ($user_id>0) {
				// se agrega como participante a eventos de asipi
				$sql = "INSERT INTO asipi_events_attendees ( user_id, event_id ) VALUES ( '".$user_id."' , '".$blog_id."' )";
				$queryResult = $wpdb->get_results($sql);

				// se agrega la propiedad de lenguaje al usuario nuevo
				$field_lang = '14';
				$idioma = ( $_POST['lang']=='en-US' || $_POST['lang']=='en' ) ? 'Inglés' : 'Español' ;

				$sql = "INSERT INTO pwisa_bp_xprofile_data ( user_id, field_id, value ) VALUES ( ".$user_id.", ".$field_lang.", '".$idioma."' )";
				$queryResult = $wpdb->get_results($sql);

				// se agrega al nuevo usuario como suscriptor en el sitio del evento
				//if ( !is_user_member_of_blog( $user_id, $blog_id ) ) {
					add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
				//}
				// se quita al usuario como suscriptor del sitio principal de asipi
				//$e = remove_user_from_blog($user_id, 1); // el 1 es el id del sitio principal (multisite)

        // loguear al nuevo usuario.
        //$idlogin = are_login();
        return $user_id;//are_login();
			} else {
				return '0';
      }
      
			
		}else {
			return '0';
		}
}
function are_login()
{
    global $wpdb;
		if (!isset($_REQUEST['password']) or $_REQUEST['password']=='') {
			return 'Error: no existe';
		} 
		$password = $_REQUEST['password'];
		$email = $_REQUEST["email"];
			$query = 'SELECT id, user_login FROM pwisa_users WHERE user_email="'.$email.'" limit 1;';
			$result = get_object_vars( $wpdb->get_row( $query ) );
			//var_dump($result);
			//$user_id = $result['id'];
			$user_login = $result['user_login'];

			$creds = array();
			$creds['user_login'] = $user_login;
			$creds['user_password'] = $password;
      $creds['remember'] = false;
      //var_dump($creds);
      //return 0;
      $user = wp_authenticate( $creds['user_login'], $creds['user_password'] ); 
			//$user = wp_signon( $creds, false );				

			if ( is_wp_error($user) ){
					return false;
      } else {
          wp_set_current_user($user->ID);
          //$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $creds );
          //global $auth_secure_cookie;
          //$auth_secure_cookie = $secure_cookie;
          wp_set_auth_cookie( $user->ID );

          //$user = wp_signon( $creds, false );
          $_REQUEST['id_usuario']=$user->ID;
          return $user->ID;
      }
}
function are_newOrden($tipoUsuario, $today) 
{ // user_type, email
    global $wpdb;
    global $blog_id;
    //$user_id = ($_REQUEST['id_usuario']>0) ? $_REQUEST['id_usuario'] : get_current_user_id() ;
    $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999 ;

		$orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");
	
		if(!$orden_id){
			## asigna el numero de factura a la orden del evento
				$sqlMaior = "SELECT MAX(numero) FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."'";
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

      if( $_REQUEST['total']==0 ){
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

      

      $evento_social_1_id = ($_REQUEST['monto_actividad_1211']>0) ? $_REQUEST['id_actividad_1'] : '0' ; // Carrera Caminata 54
      $evento_social_2_id = ($_REQUEST['monto_actividad_2210']>0) ? $_REQUEST['id_actividad_2'] : '0' ; // Ruta indicaciones Geograficas 56
      $evento_social_3_id = ($_REQUEST['monto_actividad_3']>0) ? $_REQUEST['id_actividad_3'] : '0' ; // city Tour 74
      $evento_social_4_id = ($_REQUEST['id_actividad_4']!='') ? $_REQUEST['id_actividad_4'] : '0' ; // Come as You are 55
      $evento_social_5_id = ($_REQUEST['id_actividad_5']!='') ? $_REQUEST['id_actividad_5'] : '0' ; // yoga 53
      $evento_actividad_id = ($_REQUEST['id_actividad_6']!='') ? $_REQUEST['id_actividad_6'] : '0' ; //Deportiva Verificar el concepto de la actividad
      $evento_taller_id = ($_REQUEST['id_taller_1']!='') ? $_REQUEST['id_taller_1'] : '0' ;
      $evento_taller2_id = ($_REQUEST['id_taller_2']!='') ? $_REQUEST['id_taller_2'] : '0' ;
      $evento_social_7_id = ($_REQUEST['id_actividad_7']!='') ? $_REQUEST['id_actividad_7'] : '0' ; // ¡Buen provecho! Hoy almorzamos una Especialidad Tradicional Garantizada 61
      $evento_social_8_id = ($_REQUEST['id_actividad_8']!='') ? $_REQUEST['id_actividad_8'] : '0' ; // Desayuno Concurso Innovación Verde 75
      $evento_social_9_id = ($_REQUEST['id_actividad_9']!='') ? $_REQUEST['id_actividad_9'] : '0' ; // Cata de vino y maridaje
   
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
								'".$user_id."', 
								'".$blog_id."', 
								'".$status."', 
								'".$numeroVigente."',
								'1', 
								'4', 
								'".$today."', 
								'".date('Y-m-d', strtotime("+5 days") )."',
								'".$tipoUsuario."',
								'0',
                '".$evento_taller_id."',
                '".$evento_taller2_id."',
				'".$evento_social_1_id."',
                '".$evento_social_2_id."',
                '".$evento_social_3_id."'
							);";
              //echo $sqlActivites;
			$insertOrden = $wpdb->get_results($sqlActivites);
      $orden_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");

      //if($insertOrden){
      if(!$orden_id){
      }else{
        $orden_id = $wpdb->insert_id;

        $tipo_asistencia = $_REQUEST['tipo_asistencia'];
        //$talla = $_REQUEST['tallacamisa'];
        //$talla_companion = $_REQUEST['talla_companion'];
        $tipo_habitacion = (isset($_REQUEST['ruta_tipo_hab'])) ? $_REQUEST['ruta_tipo_hab'] : '' ;
        //$fechahab = (isset($_REQUEST['estadia'])) ? $_REQUEST['estadia'] : '' ;
        $tipo_carrera = (isset($_REQUEST['actividad1_tipo_carrera'])) ? $_REQUEST['actividad1_tipo_carrera'] : '' ;
        $tipo_carrera_companion = (isset($_REQUEST['actividad1_tipo_carrera_companion'])) ? $_REQUEST['actividad1_tipo_carrera_companion'] : '' ;
        $companion_actividad_1 = (is_array($_REQUEST['escribauna191'])) ? 'SI' : '' ;
        $companion_actividad_2 = (isset($_REQUEST['companion_name1']) and $_REQUEST['companion_name1']!="") ? 'SI' : '' ;
        $companion_actividad_9 = (is_array($_REQUEST['acompanante_actividad_9'])) ? 'SI' : '';
        $companion_actividad_4 = (is_array($_REQUEST['acompanante_actividad_4'])) ? 'SI' : '' ;
        $companion_actividad_5 = (is_array($_REQUEST['acompanante_actividad_5'])) ? 'SI' : '' ;
   if(isset($_REQUEST['acompanantegolf']) &&  $_REQUEST['acompanantegolf']!=""){
    $companion_actividad_6 =  '60';
  }
  if(isset($_REQUEST['acompanantepadel']) &&  $_REQUEST['acompanantepadel']!=""){
    $companion_actividad_6 =  '57';
  }
    if(isset($_REQUEST['acompanantefutbol']) &&  $_REQUEST['acompanantefutbol']!=""){
    $companion_actividad_6 =  '59';
  }
      if(isset($_REQUEST['acompanantetenis']) &&  $_REQUEST['acompanantetenis']!=""){
    $companion_actividad_6 =  '58';
  }
  
        $companion_citytour = (is_array($_REQUEST['acompanante_citytour'])) ? 'SI' : '' ;
        $taller_turno_1 = (isset($_REQUEST['id_taller_1'])) ? $_REQUEST['id_taller_1'] : '' ;
        $taller_turno_2 = (isset($_REQUEST['id_taller_2'])) ? $_REQUEST['id_taller_2'] : '' ;
        $mentor =  (isset($_REQUEST['mentor'])) ? $_REQUEST['mentor'] : ''; 
        //$tipo_companion_ruta="";
        if(isset($_REQUEST['acompante_registrado'])){
              $tipo_companion_ruta = $_REQUEST['acompante_registrado'];
          }elseif(isset($_REQUEST['acompanante_inscrito'])){
                 $tipo_companion_ruta = $_REQUEST['acompanante_inscrito'];
          }elseif(isset($_REQUEST['acompanante_otro'])){
                 $tipo_companion_ruta = $_REQUEST['acompanante_otro'];
          }
          
   
        $adicionales = array(
          "tipo_habitacion" => $tipo_habitacion, 
          //"fecha_habitacion" => $fechahab, 
          "tipo_asistencia" => $tipo_asistencia, 
          #"talla" => $talla, 
          #"talla_companion" => $talla_companion,
          "tipo_carrera" => $tipo_carrera, 
          "tipo_carrera_companion" => $tipo_carrera_companion,
          "companion_actividad_1" => $companion_actividad_1, 
          "companion_actividad_2" => $companion_actividad_2,
          "companion_actividad_9" => $companion_actividad_9,
          "companion_name_actividad2" => $_REQUEST['companion_name1'],
          "tipo_companion_ruta"=>$tipo_companion_ruta,
          "companion_actividad_6" => $companion_actividad_6, 
          "companion_actividad_4" => $companion_actividad_4,  
          #"companion_actividad_3" => $companion_citytour, 
          "companion_actividad_5" => $companion_actividad_5, 
          "taller_turno_1" => $taller_turno_1, 
          "taller_turno_2" => $taller_turno_2,  
          #"taller_especial" => $evento_actividad_id,  
          #"taller_master" => $evento_taller_id, 
          "actividad_1" => $evento_social_1_id, 
          "actividad_2" => $evento_social_2_id,  
          "actividad_3" => $evento_social_3_id,   
          "actividad_4" => $evento_social_4_id,
          "actividad_5" => $evento_social_5_id, 
          "actividad_6" => $evento_actividad_id,
          #"actividad_7" => $evento_social_7_id,
          "actividad_8" => $evento_social_8_id,
          "actividad_9" => $evento_social_9_id,
          "mentor" => $mentor,
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
		$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = '.$id_concepto);
		$concepts[] = array('id' => $id_concepto,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["costo_final_usuario"] );

		// agrega conceptos de saldos a favor o deuda
		if($request["saldoafavor"] < 0){
			// Insertar concepto de saldo a favor del user a la orden
			$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 6');
			$concepts[] = array('id' => 6,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["saldoafavor"] );
    }
    if($request["saldodeuda"] > 0){
			// Insertar concepto de deuda del user a la orden
			$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 5');
			$concepts[] = array('id' => 5,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["saldodeuda"] );
		}
    if($request["costo_final_companion"] > 0){
			// Insertar concepto por acompañante a la orden
			$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 3');
			$concepts[] = array('id' => 3,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["costo_final_companion"] );
		}
	if($request["descuento"] < 0){
			// Insertar concepto de saldo a favor del user a la orden
			$nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = 51');
			$concepts[] = array('id' => 51,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $request["descuento"] );
    }
  if($_REQUEST['monto_donacion'] === 'Otro monto'){
   $monto_donacion = $_REQUEST['otro_donacion'];
  }else{
  $monto_donacion = str_replace('USD ', '', $_REQUEST['monto_donacion']);
  } 
    $conceptos_actividades = 
        array(
          'id_concepto_social_1' => $_REQUEST['monto_actividad_1211'], // carrera 
          'id_concepto_social_2' => $_REQUEST['monto_actividad_2210'], //ruta
          'id_concepto_social_3' => $_REQUEST['monto_actividad_3'], //city tour
          'id_concepto_social_4' => $_REQUEST['monto_actividad_6'], // Golf
          'id_concepto_social_5' => $_REQUEST['monto_actividad_4'], // we
          'id_concepto_social_9' => $_REQUEST['monto_actividad_9'], // cata de vino y maridaje
        //'id_concepto_actividad_1' => $_REQUEST['monto_taller_especial'], 
        //'id_concepto_taller_1' => $_REQUEST['numero223'],
  		 'id_concepto_donacion' =>$monto_donacion,
  		 'id_concepto_gorra' => $_REQUEST['subtotal_gorra'],
         'id_concepto_termo' => $_REQUEST['subtotal_termo'],
  		'id_concepto_bolso' => $_REQUEST['subtotal_bolso'],
  'id_concepto_vaso' => $_REQUEST['subtotal_vaso'],
      );
  //print_r( $conceptos_actividades);die;
      foreach ($conceptos_actividades as $key => $monto) {
        if($monto > 0){
          if($key=='id_concepto_social_1' and isset($_REQUEST['escribauna191'][0])){
            $key = $key.'_acomp'; 
          }
          if($key=='id_concepto_social_2' and (isset($_REQUEST['companion_name1']) and $_REQUEST['companion_name1'] !="") ){
            $key = $key.'_acomp';
          }
         if ($key == 'id_concepto_social_9' and (isset($_REQUEST['acompanante_actividad_9']) and $_REQUEST['acompanante_actividad_9'] != "")) {
            $key = $key.'_acomp';
          }
          if ($key == 'id_concepto_social_5' and (isset($_REQUEST['acompanante_actividad_4']) and $_REQUEST['acompanante_actividad_4'] != "")) {
            $key = $key.'_acomp';
          }
          
          $id_concepto_actividad = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = $blog_id and clave = '$key'");
          $nombreConcepto = $wpdb->get_var('SELECT nombre_es FROM evento_concepto WHERE id = '.$id_concepto_actividad);
          $concepts[] = array('id' => $id_concepto_actividad,'titulo' => $nombreConcepto,'orden_id' => $orden_id,'costo' => $monto );
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
function are_guardarDatosPersonales($request=array())
{
    global $wpdb;
    //$user_id = get_current_user_id();
    $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999 ;
		if($user_id!=''){
			// El usuario está registrado en la base de datos pero no deberia entrar aquí

			// Insert details on buddypress xprofile
      //$sql = 'SELECT id FROM country_names WHERE name_es = "'.$_POST['country'].'" OR name_en = "'.$_POST['country'].'"';
      $country = '';
      $id_country = '';
      
      //if($_REQUEST['user_type']!='socio'){
          if ( $_REQUEST["pais"] != '' ) {
              $country =  $_REQUEST["pais"];
              $variable_nombre_pais = 'name_es';
          }elseif( $_REQUEST["country"]!='' ){
              $country =  $_REQUEST["country"];
              $variable_nombre_pais = 'name_en';
          }
          $sql = 'SELECT id FROM country_names WHERE '.$variable_nombre_pais.' = "'.$country.'"';
          $id_country = $wpdb->get_var($sql);
	        //$country = $request["bill_address"][5];
	    //}
			
            $telefono = $_REQUEST['telefono'];
			$fecha_nacimiento = $request["fecha_nacimiento"]['year'].'-'.$request["fecha_nacimiento"]['month'].'-'.$request["fecha_nacimiento"]['day'];

			$campos = array(
				'first_name' => 		  array('field_id' => '1',	'value' => $_REQUEST['nombre']['first'], ),
				'last_name' => 			  array('field_id' => '2',	'value' => $_REQUEST['nombre']['last'], ),
				'city' => 				    array('field_id' => '9',	'value' => $request["direccion"]['city'], ),
				'country' => 			    array('field_id' => '7',	'value' => $country, ),
				//'company' => 			    array('field_id' => '12',	'value' => $request["compania"], ),
				'gender' => 			    array('field_id' => '18',	'value' => $_REQUEST["genero"], ),
				'id_country' => 		  array('field_id' => '44',	'value' => $id_country, ),
				'personal-address' => array('field_id' => '3',	'value' => $request["direccion"]['addr_line1'], ),
				'personal-state' => 	array('field_id' => '8',	'value' => $request["direccion"]['state'], ),
				'personal-zip' => 		array('field_id' => '6',	'value' => $request["direccion"]['postal'], ),
				'fecha-nacimiento' => array('field_id' => '34',	'value' => $fecha_nacimiento, ),
				'telefono' => array('field_id' => '23',	'value' => $telefono, ),
			);
      if (isset($request["compania"])) {
        if($request["compania"] != ''){
          $campos['company'] = array('field_id' => '12',	'value' => $request["compania"], );
        }
      }
      if (isset($request["universidad"])) {
        if($request["universidad"] != ''){
          $campos['univ'] = array('field_id' => '47',	'value' => $request["universidad"], );
        }
      }
          //var_dump($campos);
      


			foreach ($campos as $nombreCampo => $datos) {
				if ($datos['value']!='') {
					$qry = "SELECT COUNT(*) FROM pwisa_bp_xprofile_data where field_id='".$datos['field_id']."' AND user_id=".$user_id;
					
					
					$verify = $wpdb->get_var($qry);
					if(!$verify){
						//echo "entro aqui 1  ";
						$wpdb->query( $wpdb->prepare( 
							"INSERT INTO pwisa_bp_xprofile_data (user_id , field_id, value) VALUES (%d, %d, %s)", 
							$user_id,
							$datos['field_id'],
							$datos['value']
							) 
						);
					}else{
						
            if($datos['field_id']!=7 && $datos['field_id']!=44){
              // si el campo a actualizar es distinto a pais
              $wpdb->update( 
                'pwisa_bp_xprofile_data', 
                array( 'value' => $datos['value']), 
                array( 'field_id' => $datos['field_id'],
                  'user_id' => $user_id )		
                );
            }
					}
				}
					
			}
			return "guardado";
		}else{
				
			return "error";
		}
}
function are_guardarDatosFacturacion($request=array())
{
  global $wpdb;
    //$user_id = get_current_user_id();
    $user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999 ;
		if($user_id!=''){
			// El usuario está registrado en la base de datos pero no deberia entrar aquí

			// Insert details on buddypress xprofile
			//$sql = 'SELECT id FROM country_names WHERE name_es = "'.$_POST['country'].'" OR name_en = "'.$_POST['country'].'"';
			//$sql = 'SELECT name_es FROM country_names WHERE id = "'.$request["bill_address"][5].'"';
			//$id_country = $wpdb->get_var($sql);

			$country = '';
		    $id_country = '';
		    //if($_REQUEST['user_type']!='socio'){
		    	if ( $request["pais"] != '' ) {
				    $country =  $request["pais"];
				    $variable_nombre_pais = 'name_es';
          }elseif( $request["country"]!= '' ){
            $country =  $request["country"];
            $variable_nombre_pais = 'name_en';
          }
				$sql = 'SELECT id FROM country_names WHERE '.$variable_nombre_pais.' = "'.$country.'"';
				$id_country = $wpdb->get_var($sql);
		        //$country = $request["bill_address"][5];
		    //}

			//echo $id_country.' - ';
			//echo $sql;
			$campos = array(
				'billemail' => 		array('field_id' => '28',	'value' => $request["billemail"], ),
				'bill-name' => 		array('field_id' => '45',	'value' => $request["razonsocial"], ),
				'bill-city' => 		array('field_id' => '32',	'value' => $request["bill_address"]['city'], ),
				'bill-nit' => 		array('field_id' => '46',	'value' => $request["nit"], ),
				'bill-country' => array('field_id' => '30',	'value' => $country, ),
				'bill_address' => array('field_id' => '29',	'value' => $request["bill_address"]['addr_line1'], ),
				'bill-state' => 	array('field_id' => '31',	'value' => $request["bill_address"]['state'], ),
				'bill-zip' => 		array('field_id' => '33',	'value' => $request["bill_address"]['postal'], ),
			);

			foreach ($campos as $nombreCampo => $datos) {
				if ($datos['value']!='') {
					$qry = "SELECT COUNT(*) FROM pwisa_bp_xprofile_data where field_id='".$datos['field_id']."' AND user_id=".$user_id;
					//echo '   '.$qry.'<br>';
					
					$verify = $wpdb->get_var($qry);
					if(!$verify){
						//echo "entro aqui 1  ";
						$wpdb->query( $wpdb->prepare( 
							"INSERT INTO pwisa_bp_xprofile_data (user_id , field_id, value) VALUES (%d, %d, %s)", 
							$user_id,
							$datos['field_id'],
							$datos['value']
							) 
						);
					}else{
						//echo "entro aqui 2  ";
						$wpdb->update( 
							'pwisa_bp_xprofile_data', 
							array( 'value' => $datos['value']), 
							array( 'field_id' => $datos['field_id'],
								'user_id' => $user_id )		
							);
					}
				}
					
			}
			return "guardado";
		}else{
				
			return "error";
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
  //if (isset($request['misproductos']['transactionIDactionID'])) {
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

  $event_id = $blog_id;

  $nombre = ucwords(strtolower($_REQUEST['nombre']['first'].' '.$_REQUEST['nombre']['last'])); 
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
  $nombre_evento_largo = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'name_".$lang."'");

  $tesorero = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = '".$event_id."' AND clave = 'email_tesorero'");
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
  //$headers = array('Content-Type: text/html; charset=UTF-8','Reply-To: tesoreria@asipi.org');
  #$headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  #$headers = array('Content-Type: text/html; charset=UTF-8');
  $headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
  $body = str_replace("%%LINK2%%",$link2,$body);
  /*Envío el correo en formato html con los attachments*/
  //print_r($group_emails)
  
  $enviado = wp_mail($destinatario, $subject, $body, $headers);
  #$enviado = wp_mail('wilder@ztgroupcorp.com', $subject, $body, $headers);
  #$enviado = wp_mail('mpalenciap@gmail.com', $subject, $body, $headers);
  #$enviado = wp_mail('elisa@ztgroupcorp.com', $subject, $body, $headers);
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
		if ( $_REQUEST['llevarcompanion'] === "Sí" ) {
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
