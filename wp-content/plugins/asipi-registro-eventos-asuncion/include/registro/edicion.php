<?php 
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require ( $asipiPath . '/wp-load.php');
global $wpdb;
global $blog_id;

if(is_user_logged_in()){

	$lang = qtranxf_getLanguage();

	$user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id() ;
	$order_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE subnumero=1 AND estado in('C','P') and  visible=1 AND evento_id='".$blog_id."' AND pwisa_users_id='".$user_id."'");
    if(isset($order_id) && !empty($order_id)){
	$first_name = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=1" );
	$last_name = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=2" );
	$firm = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=12" );
	$razonSocial = $wpdb->get_var("SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=45" );
	$email_user = $wpdb->get_var('SELECT user_email FROM pwisa_users WHERE id='.$user_id);
	$numero = $wpdb->get_var("SELECT numero FROM evento_orden WHERE id=" . $order_id);
	$user_type = $wpdb->get_var("SELECT tipo FROM evento_orden WHERE id=" . $order_id);
	$country = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=30" );
	if($country==""){
		$country = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=7" );
	}
	if (is_numeric($country)) {
		$country = $wpdb->get_var( "SELECT name_$lang as name FROM country_names WHERE id = '$country'" );
	} 
	
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
		// acompañante
		#$companion = $wpdb->get_var('SELECT count(*) FROM evento_orden_concepto where evento_concepto_id=3 AND visible=1 AND evento_orden_id ='.$order_id);
		$companion = $wpdb->get_var("SELECT o.pwisa_users_ID FROM evento_orden o JOIN evento_orden_concepto oc ON o.id = oc.evento_orden_id WHERE oc.evento_concepto_id = 3 AND o.pwisa_users_ID = ".$user_id." AND evento_id =".$blog_id." AND o.visible=1");
    
        $companion = ($companion>0) ? 'si' : 'no' ;
		if(strcmp($companion,'si') === 0){
		    $companion_name = $wpdb->get_var("SELECT nombre,apellido FROM evento_acomp where pwisa_users_ID=".$user_id." and evento_id =".$blog_id." order by id desc limit 1;");
		} 
		if($_SERVER['SERVER_NAME']=='staging.asipi.org'){ 
		    //desarrollo
			$url_form = 'https://form.jotform.com/252154118618152?id_usuario='.$user_id;
		}else{
		    //produccion
			$url_form = 'https://form.jotform.com/252023962027148?id_usuario='.$user_id;
		}
	    
	   	$url_form = $url_form . '&nombre[first]='.$first_name;
	   	$url_form = $url_form . '&nombre[last]='.$last_name;
	   	$url_form = $url_form . '&can_edit=no';
		$url_form = $url_form . '&email='.$email_user;
		$url_form = $url_form . '&country='.$country;
		$url_form = $url_form . '&numero_orden='.$order_id;
		$url_form = $url_form . '&companion='.$companion;
		$url_form = $url_form . '&llevarcompanion='.$companion;
    	$url_form = $url_form . '&companion_name='.$companion_name;

        $adicionales = array(
          "companion_actividad_1" => 'ed_companion_actividad_1', //acompañante 1 
          "taller_turno_1" => 'ed_taller_turno_1', //taller turno 1
          "taller_turno_2" => 'ed_taller_turno_2', //taller turno 2
          "actividad_1" => 'ed_actividad_1', // Carrera Caminata 54
          "actividad_2" => 'ed_actividad_2', //  Ruta indicaciones Geograficas 56
          "actividad_3" => 'ed_actividad_3', // // city Tour 52
          "actividad_4" => 'ed_actividad_4', // Come as You are 55
          "actividad_5" => 'ed_actividad_5', // yoga 53
          "actividad_6" => 'ed_actividad_6',//Deportiva Verificar el concepto de la actividad
          "actividad_7" => 'ed_actividad_7',//¡Buen provecho! Hoy almorzamos una Especialidad Tradicional Garantizada 61
          "actividad_8" => 'ed_actividad_8',//Desayuno Concurso Innovación Verde 75
          "actividad_9" => 'ed_actividad_9',//Cata de vino y maridaje
        );

        foreach ($adicionales as $key => $campo_form) {
            $valor='';
            #$valor = $wpdb->get_var( "SELECT valor FROM evento_info_adicional WHERE clave = '$key' and orden_id = '$order_id'" );
           
            $valor = $wpdb->get_var( 'SELECT valor FROM evento_info_adicional WHERE orden_id= "'.$order_id.'" and clave = "'.$key.'" and valor != "" and valor !="0" and user_id="'.$user_id.'" and evento_id= "'.$blog_id.'"  order by id desc limit 1');
            if ($valor!='') {
                $url_form = $url_form . '&'.$campo_form.'='.$valor;
            }
        }
        
        /*$sql="SELECT count(id) as registros,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_1' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_1,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_2' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_2,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_3' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_3,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_4' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_4,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_5' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_5,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_6' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_6,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'actividad_7' and valor != '' and valor !='0' and evento_id= '$blog_id') as actividad_7,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_1' and valor = '43' and evento_id= '$blog_id') as taller_1,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_1' and valor = '44' and evento_id= '$blog_id') as taller_2,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_2' and valor = '45' and evento_id= '$blog_id') as taller_3,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_2' and valor = '47' and evento_id= '$blog_id') as taller_4,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_3' and valor = '46' and evento_id= '$blog_id') as taller_5,
			(SELECT count(id) FROM evento_info_adicional WHERE clave = 'taller_turno_3' and valor = '48' and evento_id= '$blog_id') as taller_6
			FROM `evento_orden`
			where evento_id = '".$blog_id."' and visible = '1'";*/
		 
			/*$sql="SELECT count(id) as registros,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_1' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_1' and valor='SI' )) and evento_orden.evento_id ='$blog_id' ) as actividad_1,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_2' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_2,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_3' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_3,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_4' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_4,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_5' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_5,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'actividad_6' and valor = 60 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as actividad_6_golf,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'actividad_6' and valor = 59 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as actividad_6_futbol,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'actividad_6' and valor = 58 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as actividad_6_tenis,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'actividad_6' and valor = 57 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as actividad_6_padel,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=49 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1a,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=50 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1b,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=51 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1c,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=52 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2a,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=53 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2b,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=54 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2c,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_7' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_7,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_8' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_8,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_9' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_9
			
			FROM `evento_orden` 
			where evento_id = '".$blog_id."' and visible = '1'";*/
			
			$sql="SELECT count(id) as registros,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_1' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_1' and valor='SI' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id' ) as actividad_1,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_2' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_2' and valor='SI' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id' ) as actividad_2,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_3' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_3,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_4' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_4' and valor='SI' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id' ) as actividad_4,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_5' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_5' and valor='SI' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id' ) as actividad_5,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_6' and valor = 60 and evento_orden.visible =1) or (clave = 'companion_actividad_6' and valor='60' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id') as actividad_6_golf,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_6' and valor = 59 and evento_orden.visible =1) or (clave = 'companion_actividad_6' and valor='59' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id') as actividad_6_futbol,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_6' and valor = 58 and evento_orden.visible =1) or (clave = 'companion_actividad_6' and valor='58' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id') as actividad_6_tenis,
       		(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_6' and valor = 57 and evento_orden.visible =1) or (clave = 'companion_actividad_6' and valor='57' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id') as actividad_6_padel,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=63 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1a,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=64 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1b,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=67 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1c,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=65 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2a,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=66 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2b,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_2' and valor=68 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_2c,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_7' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_7,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_8' and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='$blog_id' ) as actividad_8,
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = 'actividad_9' and valor!=0 and evento_orden.visible =1) or (clave = 'companion_actividad_9' and valor='SI' and evento_orden.visible =1)) and evento_orden.evento_id ='$blog_id' ) as actividad_9
			
			FROM `evento_orden` 
			where evento_id = '".$blog_id."' and visible = '1'";
			
			/*$sql="SELECT count(id) as registros,
			
			(SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and clave = 'taller_turno_1' and valor=55 and evento_orden.visible =1 and evento_orden.evento_id ='$blog_id') as taller_turno_1a
			
			FROM `evento_orden` 
			where evento_id = '".$blog_id."' and visible = '1'";*/
			
			
			
			
		$qryregistro = $wpdb->get_results($sql);
		$qryregistro = json_decode(json_encode($qryregistro), true);
		
		foreach ($qryregistro as $key => $dataReg) {
			$url_form = $url_form . '&count_act_1='.$dataReg['actividad_1'];
			$url_form = $url_form . '&count_act_2='.$dataReg['actividad_2'];
    		$url_form = $url_form . '&count_act_3='.$dataReg['actividad_3'];
			$url_form = $url_form . '&count_act_4='.$dataReg['actividad_4'];
			$url_form = $url_form . '&count_act_5='.$dataReg['actividad_5'];
            $url_form = $url_form . '&count_golf='.$dataReg['actividad_6_golf'];
            $url_form = $url_form . '&count_tenis='.$dataReg['actividad_6_tenis'];
            $url_form = $url_form . '&count_futbol='.$dataReg['actividad_6_futbol'];
            $url_form = $url_form . '&count_padel='.$dataReg['actividad_6_padel']; 
            $url_form = $url_form . '&count_t1a='.$dataReg['taller_turno_1a'];
            $url_form = $url_form . '&count_t1b='.$dataReg['taller_turno_1b'];
            $url_form = $url_form . '&count_t1c='.$dataReg['taller_turno_1c'];
            $url_form = $url_form . '&count_t2a='.$dataReg['taller_turno_2a'];
            $url_form = $url_form . '&count_t2b='.$dataReg['taller_turno_2b'];
            $url_form = $url_form . '&count_t2c='.$dataReg['taller_turno_2c'];
            /*$url_form = $url_form . '&count_act_7='.$dataReg['actividad_7'];*/
            $url_form = $url_form . '&count_act_8='.$dataReg['actividad_8'];
            $url_form = $url_form . '&count_act_9='.$dataReg['actividad_9'];

		}

switch ($user_type) {
  case 1:
    $tipoUsuario = 'socio';
    break;
  case 3:
    $tipoUsuario = 'student';
    break;
  default:
    $tipoUsuario = 'nosocio';
    break;
}
 $url_form = $url_form . '&ed_type_user='.$tipoUsuario;
 
    //$sqlMaior = "SELECT MAX(subnumero), visible FROM evento_orden WHERE visible=1 and evento_id='".$blog_id."' AND numero='".$numero."'";
    //$sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE visible=1 and evento_id='".$blog_id."' AND numero='".$numero."'";
     $sqlMaior = "SELECT MAX(subnumero) FROM evento_orden WHERE evento_id='".$blog_id."' AND numero='".$numero."'";
     $actual = $wpdb->get_var($sqlMaior);
     $actual = ($actual == null) ? 0 : $actual;

     $numeroVigente = $actual+1;
  
    
 
  $url_form = $url_form . '&subnumero='.$numeroVigente;
 
 
	?>
<br>
<div id="bloque-titulo" style="text-align: center">
    <h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>
    <h5 style="font-size: x-large;"><?php echo __($descripcion_evento[$lang]) ?></b></h5>
    <h3 style="text-align: center">
        <?php echo __("<!--:es-->Edición de Registro<!--:--><!--:en-->Edit your registration<!--:-->") ?></h3>
    <h5 style="text-align: center">
        <?php echo __("<!--:es-->(Agregue actividades)<!--:--><!--:en-->(Add activities)<!--:-->") ?></h5>
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
<?php require_once plugin_dir_path(__FILE__) . 'jotform-edicion.php'; ?>
<?php //echo do_shortcode( '[are_planesmedellin2022]' ); ?>


<style>
.card-body {
    /*min-height: 200px !important;*/
}
</style>
<?php
}else{
    ?>
<div class="row accrestr">
    <br>
    <div class="grid-1-3" style="text-align: center;">
        <h3><?php echo  __('[:es]Acceso no permitido[:en]Access denied[:]'); ?></h3>
        <br><br>
        <span
            class="btnlogincont"><?php echo  __('[:es]Para editar su registro, primero debe completar la inscripción al evento[:en]To edit your registration, you must first complete the event registration[:]'); ?></span>
        <br><br>
        <a class="btn btn_certificado"
            href="/asuncion2025/registro-evento/?t=presencial"><?php echo  __('[:es]Regístrate aquí[:en]Register Here[:]'); ?></a>
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
        <a class="btn btn_certificado" href="/asuncion2025/">Ir a Inicio</a>
    </div>
    <br><br><br>
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