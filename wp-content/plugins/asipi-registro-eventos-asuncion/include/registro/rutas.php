<?php
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require($asipiPath . '/wp-load.php');
global $wpdb;
global $blog_id;
/*echo '<pre>';
#	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id();
	$user_id ="3104";
	echo $user_id;
$is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id ='.$user_id);
	
var_dump($is_member);
echo '<pre>';
die;
*/
$lang = qtranxf_getLanguage();
if (is_user_logged_in()) {
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
	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id();

	$is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id =' . $user_id);
	$order_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE subnumero=1 AND visible=1 AND evento_id='" . $blog_id . "' AND pwisa_users_id='" . $user_id . "'");
	$email_user = $wpdb->get_var('SELECT user_email FROM pwisa_users WHERE id=' . $user_id);
	if (isset($order_id) && !empty($order_id) || $is_member) {

		$first_name = $wpdb->get_var("SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=" . $user_id . " AND field_id=1");
		$last_name = $wpdb->get_var("SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=" . $user_id . " AND field_id=2");
		#$email_user = $wpdb->get_var('SELECT user_email FROM pwisa_users WHERE id=' . $user_id);
		//$sqlnumorden = "SELECT numero FROM evento_orden WHERE id=" . $order_id;
		//$numero = $wpdb->get_var($sqlnumorden);
		$country = $wpdb->get_var("SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=" . $user_id . " AND field_id=30");
		if ($country == "") {
			$country = $wpdb->get_var("SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=" . $user_id . " AND field_id=7");
		}
		if (is_numeric($country)) {
			$country = $wpdb->get_var("SELECT name_$lang as name FROM country_names WHERE id = '$country'");
		}
		/*if(isset($_REQUEST['data'])){
		$order_number = base64_decode( base64_decode( base64_decode( $_GET['data'] ) ) );
	}else{
		echo 'error';exit();
	}*/
	} else {
		$order_id = '';
		$first_name = '';
		$last_name = '';
		$country = '';
	}
	/*
		$table_orders =  'evento_orden';
		$table_invoice = 'evento_pago';
		$table_profile = 'pwisa_bp_xprofile_data';
		$sqlInvoice = "SELECT * FROM $table_orders where id='$order_number'";
		$queryInvoice = $wpdb->get_results($sqlInvoice);

		$sql = "SELECT DISTINCT t2.value FROM pwisa_bp_xprofile_data t2 
	INNER JOIN pwisa_usermeta t1 ON t1.user_id = t2.user_id
	where t1.meta_key = 'pwisa_capabilities' AND t1.meta_value LIKE '%member%'
	and t2.field_id=12 ORDER BY value asc";
		$queryResult = $wpdb->get_results($sql);
		$queryResult = json_decode(json_encode($queryResult), true);*/ // ojo comente esto

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

		if ($value['clave'] == 'socios_exentos') {
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
	if ($_SERVER['SERVER_NAME'] == 'staging.asipi.org') {
		$url_form = 'https://form.jotform.com/222486595566370?id_usuario=' . $user_id;
	} else {
		$url_form = 'https://form.jotform.com/222516484247660?id_usuario=' . $user_id;
	}

	$url_form = $url_form . '&namey=' . $first_name . ' ' . $last_name;
	$url_form = $url_form . '&email=' . $email_user;
	$url_form = $url_form . '&country=' . $country;
	$url_form = $url_form . '&numero_orden=' . $order_id;
	$url_form = $url_form . '&is_member=' . $is_member;

?>
<br>
<div id="bloque-titulo" style="text-align: center">
    <h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>
    <h5 style="font-size: x-large;"><?php echo __($descripcion_evento[$lang]) ?></b></h5>
    <h3 style="text-align: center">

</div>
<!--
	<div class="alerta">
		<h2><?php echo __("<!--:es-->CUPO COMPLETO
<!--:-->
<!--:en-->REGISTRATION AT FULL CAPACITY
<!--:-->") ?></h2>
<p><?php echo __("<!--:es-->En base a las medidas sanitarias requeridas y a la disponibilidad de la Sede, informamos que el cupo máximo de inscripciones al Evento ha sido alcanzado<!--:--><!--:en-->Based on the required sanitary measures and the availability of the Venue, we inform that the maximum number of registrations for the event has been reached.<!--:-->") ?>
</p>
</div>
-->
<style>
.alerta {
    TEXT-ALIGN: center;
    background-color: #efe67a;
    padding: 15px;
    margin: 40px;
    color: #f00;
}

.alerta h2 {
    color: #f00;
    font-weight: bold;
}

.soldout {
    color: #f00;
    font-weight: bold;
}

.btn_waiting {
    background-color: #009e4a;
    padding: 10px;
    color: #fff;
}
</style>
<?php require_once plugin_dir_path(__FILE__) . 'jotform-rutas.php'; ?>
<?php //echo do_shortcode( '[are_planesmedellin2022]' ); 
	?>


<style>
.card-body {
    /*min-height: 200px !important;*/
}
</style>
<?php


} else {
    $textos = array(
		'es' => array(
			'course' => 'Curso',
			'registry' => 'Registro', 
			'free' => 'Sin Costo',
			'register_with_email_asipi' => 'Debe ingresar con su correo registrado en ASIPI<br><spam style="font-size:10px">Estar al día con la membresía</spam>', 
			'register' => 'Registrarse', 
			'members_firm_tit' => 'Miembros de Firma<br>con Socios en ASIPI', 
			'members_firm_tit_form' => 'Miembros de Firma<br>con Socios en ASIPI', 
			'members_firm_nota' => 'Debe ingresar el correo registrado en ASIPI del Socio', 
			'non_member' => 'No Socios', 
			'student' => 'Estudiantes',
			'member' => 'Socios',
			'enter_email_asipi' => 'Ingrese su correo registrado en ASIPI', 
			'password' => 'Contraseña',
			'new_password' => 'Nueva Contraseña',
			'enter_password' => 'Ingrese la contraseña',
			'repeat_password' => 'Repita la contraseña',
			'forgot_password' => 'Olvidó Contraseña',
			'continue' => 'Continuar',
			'please_enter_email' => 'Por favor ingrese su correo electrónico',
			'enter_email' => 'Ingrese su correo electrónico',
			'please_enter_email_asipi_nota' => 'Por favor ingresar el correo electrónico del socio de ASIPI miembro en su firma', 
			'please_enter_email_asipi' => 'Ingresar correo del socio de ASIPI', 
			'company' => 'Compañia', 
			'select_company' => 'Seleccione Compañia', 
	
		), 
		'en' => array(
			'course' => 'Course',
			'registry' => 'Registry', 
			'free' => 'Free',
			'register_with_email_asipi' => 'Use your email registered in ASIPI',
			'register' => 'Register',
			'members_firm_tit' => 'Non-members with<br>partners in ASIPI',
			'members_firm_tit_form' => 'Non-members with partners in ASIPI', 
			'members_firm_nota' => 'You need the partner´s email registered in ASIPI',
			'non_member' => 'Non Members',
			'student' => 'student',
			'member' => 'Members',
			'enter_email_asipi' => 'Enter your email registered in ASIPI',
			'password' => 'Password',
			'new_password' => 'New Password',
			'enter_password' => 'Enter password',
			'repeat_password' => 'Repeat password',
			'forgot_password' => 'Forgot Password',
			'continue' => 'next',
			'please_enter_email' => 'Please enter your email',
			'enter_email' => 'Enter your email',
			'please_enter_email_asipi_nota' => 'Please enter a valid email address (ASIPI Members use your email registered with us)',
			'please_enter_email_asipi' => 'Enter email from ASIPI partner',
			'company' => 'Company',
			'select_company' => 'Select Company',
		), 
	);
?>
 <div class="four columns" style="padding-top: 0px" id="">
     </div>

 <div class="four columns" style="padding-top: 0px" id="bloque-izquierdo">
                     <div id="rutas" class="divform">
            
            <h1><?php echo $textos[$lang]['rutas'] ?></h1>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-email-rutas" class="form" action="javascript:veryfy()">
                        <div class="form-group">
                            <label for="email_rutas"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                            <input type="email" class="form-control" name="email_rutas" id="email_rutas" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                            <small id="emailHelp" class="form-text text-muted"></small>
                            <input type="hidden" id="typeLogin_rutas" name="typeLogin_rutas" value="verify">
                        </div>
                        <div class="password_rutas" style="display: none;">
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                <input type="password" class="form-control" name="password_rutas" id="password_rutas" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                            </div>
                            <div class="form-group">
                                <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?> </a>
                            </div>
                        </div>
                        <div class="newpassword_rutas" style="display: none;">
                            <br>
                            <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>
                                <input type="password" class="form-control" name="newpassword_rutas" id="newpassword_rutas" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>
                                <input type="password" class="form-control" name="repeatpassword_rutas" id="repeatpassword_rutas" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>
                            </div>
                        </div>
                        <div id="mensajeError_rutas" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="veryfy_rutas"><?php echo $textos[$lang]['continue'] ?></a></div>
                    </form>
                </div>
            </div>
        </div>
     </div>

<style>
.btnlogincont {

    cursor: pointer;

    padding: 8px;

    border: 1px solid #9D268F;

    margin-top: 10px;

    margin-bottom: 20px;

}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
jQuery("document").ready(function() {
    jQuery("#loginlik").click(function() {
        jQuery(".login-button").trigger("click");
    });
});
</script>
<?php
}
?>