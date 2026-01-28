<?php 
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require ( $asipiPath . '/wp-load.php');
global $wpdb;
global $blog_id;

if(is_user_logged_in()){
    //wp_logout();

	/*$creds = array();
				$creds['user_login'] = 'sociocarlos';
				$creds['user_password'] = '123456';
				$creds['remember'] = false;*/
	//wp_logout();
	//$user = wp_authenticate( $creds['user_login'], $creds['user_password'] ); 
	//$user = wp_signon( $creds, true );
	//exit();

	//$lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;
	$lang = qtranxf_getLanguage();

	//$user_id = ($_REQUEST['id_usuario']) ? $_REQUEST['id_usuario'] : 9999 ;
	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id() ;

	$order_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE subnumero=1 AND visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");

	if(isset($order_id) && !empty($order_id)){

	$first_name = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=1" );
	$last_name = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=2" );
	$telefono = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=23" );
	$email_user = $wpdb->get_var('SELECT user_email FROM pwisa_users WHERE id='.$user_id);
	$sqlnumorden = "SELECT numero FROM evento_orden WHERE id=" . $order_id;
	$numero = $wpdb->get_var($sqlnumorden);
	$country = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=30" );
	if($country==""){
		$country = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=7" );
	}
	if (is_numeric($country)) {
		$country = $wpdb->get_var( "SELECT name_$lang as name FROM country_names WHERE id = '$country'" );
	} 
	/*if(isset($_REQUEST['data'])){
		$order_number = base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) );
	}else{
		echo 'error';exit();
	}*/

	$table_orders =  'evento_orden';
	$table_invoice = 'evento_pago';
	$table_profile = 'pwisa_bp_xprofile_data';
	$sqlInvoice="SELECT * FROM $table_orders where id='$order_number'";
	$queryInvoice = $wpdb->get_results($sqlInvoice);

	$sql = "SELECT DISTINCT t2.value FROM pwisa_bp_xprofile_data t2 
	INNER JOIN pwisa_usermeta t1 ON t1.user_id = t2.user_id
	where t1.meta_key = 'pwisa_capabilities' AND t1.meta_value LIKE '%member%'
	and t2.field_id=12 ORDER BY value asc";
	$queryResult = $wpdb->get_results($sql);
	$queryResult = json_decode(json_encode($queryResult), true);

	$nombre_evento['es'] = '';
	$nombre_evento['en'] = '';
	$socios_exentos = '';
	# Datos del evento
		//$sql = "SELECT id, nombre, costo_socio, costo_miembro, costo_nosocio, cant_modulos, cupos FROM pwisa_asipi_cursos WHERE id=$idcurso limit 1";
		$sql = "SELECT * FROM evento_meta where evento_id = '$blog_id'";
		$qryEvento = $wpdb->get_results($sql);
		$qryEvento = json_decode(json_encode($qryEvento), true);
		$costos = array();

		foreach ($qryEvento as $key => $value) {

			$posicion_coincidencia = strpos($value['clave'], '_price');
			
			//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
			if ($posicion_coincidencia !== false) {
				$costos[$value['clave']] = $value['valor'];
			}

			if($value['clave']=='socios_exentos'){
				$socios_exentos = $value['valor'];
			}
			switch ($value['clave']) {
				case "name_es":
					$nombre_evento['es'] = $value['valor'];
					break;
				case "name_en":
					$nombre_evento['en'] = $value['valor'];
					break;
				case "description_es":
					$descripcion_evento['es'] = $value['valor'];
					break;
				case "description_en":
					$descripcion_evento['en'] = $value['valor'];
					break; 
			}
		}
		$companion = $wpdb->get_var('SELECT count(*) FROM evento_orden_concepto where evento_concepto_id=3 AND visible=1 AND evento_orden_id ='.$order_id);
		$companion = ($companion>0) ? 'si' : 'no' ;
		if(strcmp($companion,'si') === 0){
		    $companion_name = $wpdb->get_var("SELECT nombre,apellido FROM evento_acomp where pwisa_users_ID=".$user_id." and evento_id =".$blog_id." order by id desc limit 1;");
		} 
		if($_SERVER['SERVER_NAME']=='staging.asipi.org'){ 
			$url_form = 'https://form.jotform.com/240285969262668?id_usuario='.$user_id;
		
		}else{
			$url_form = 'https://form.jotform.com/241085897598174?id_usuario='.$user_id;
		}
		
		$url_form = $url_form . '&namey='.$first_name.' '.$last_name;
		$url_form = $url_form . '&email='.$email_user;
		$url_form = $url_form . '&country='.$country;
		$url_form = $url_form . '&numero_orden='.$order_id;
		$url_form = $url_form . '&companion='.$companion;
		$url_form = $url_form . '&nombreAcompanante='.$companion_name;
	    #$url_form = $url_form . '&telefono='.urlencode($telefono);
	if (isset($_REQUEST['tesoreria'])) {
			$url_form = $url_form . '&tesoreria=true';
		}

	?>
	<br>
	<div id="bloque-titulo"  style="text-align: center">
		<h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>
		<h5 style="font-size: x-large;"><?php echo __($descripcion_evento[$lang]) ?></b></h5>
		<h3 style="text-align: center"><?php echo __("<!--:es-->Registro Running Tour<!--:--><!--:en-->Running Tour Registration<!--:-->") ?></h3>
	</div>
	<!--
	<div class="alerta">
		<h2><?php echo __("<!--:es-->CUPO COMPLETO<!--:--><!--:en-->REGISTRATION AT FULL CAPACITY<!--:-->") ?></h2>
		<p><?php echo __("<!--:es-->En base a las medidas sanitarias requeridas y a la disponibilidad de la Sede, informamos que el cupo máximo de inscripciones al Evento ha sido alcanzado<!--:--><!--:en-->Based on the required sanitary measures and the availability of the Venue, we inform that the maximum number of registrations for the event has been reached.<!--:-->") ?></p>
	</div>
	-->
	<style>
		.alerta{
			TEXT-ALIGN: center;
			background-color: #efe67a;
			padding: 15px;
			margin: 40px;
			color: #f00;
		}
		.alerta h2{
			color: #f00;
			font-weight: bold;
		}
		.soldout{
			color: #f00;
			font-weight: bold;
		}
		.btn_waiting{
			background-color: #009e4a;
			padding: 10px;
			color: #fff;
		}
		</style>
		<?php require_once plugin_dir_path(__FILE__) . 'jotform-running.php'; ?>
		<?php //echo do_shortcode( '[are_planesmedellin2022]' ); ?>
		

	<style>
		.card-body {
			/*min-height: 200px !important;*/
		}
	</style>
<?php

	}

	else{

		?>
	<div class="row accrestr">
        <br>
        <div class="grid-1-3" style="text-align: center;">
            <h3><?php echo  __('[:es]Acceso no permitido[:en]Access denied[:]'); ?></h3>
			<br><br>
            <span class="btnlogincont"><?php echo  __('[:es]Para registrarse en esta actividad se debe registrar primero en el evento[:en]To register in this activity you must first register in the event.[:]'); ?></span>
			<br><br>
            <a  class="btn btn_certificado" href="/asuncion2025/registro-evento/?t=presencial"><?php echo  __('[:es]Regístrate aquí[:en]Register Here[:]'); ?></a>
        </div>
		<br><br><br>
    </div>
	
	<?php

	}
	
	
}else{
	?>
	<div class="row accrestr">
        <br>
        <div class="grid-1-3" style="text-align: center;">
            <h3><?php echo  __('[:es]Acceso no permitido[:en]Access denied[:]'); ?></h3>
			<br><br>
            <span class="btnlogincont" id="loginlik"><?php echo  __('[:es]Iniciar Sesión[:en]Login[:]'); ?></span>
			<br><br>
            <a  class="btn btn_certificado" href="/asuncion2025/">Ir a Inicio</a>
        </div>
		<br><br><br>
    </div>
	<style>
		.btnlogincont{

cursor: pointer;

padding: 8px;

border: 1px solid #9D268F;

margin-top: 10px;

margin-bottom: 20px;

}
	</style>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
	jQuery( "document" ).ready( function() { 
		jQuery( "#loginlik" ).click( function() { 
			jQuery( ".login-button" ).trigger( "click" ); 
		} ); 
	} ); 
	</script>
	<?php
}
?>

