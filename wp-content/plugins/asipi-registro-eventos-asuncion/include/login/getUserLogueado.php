<?php
//Devolver datos a archivo js
add_action('wp_ajax_nopriv_are_ajax_datos_user','are_datos_user');
add_action('wp_ajax_are_ajax_datos_user','are_datos_user');


function are_datos_user()
{
    

    
    /*error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    $asipiPath = $_SERVER['DOCUMENT_ROOT'];
    require ( $asipiPath . '/wp-load.php');*/
    global $wpdb;
    global $blog_id;
    $user_id = (isset($_REQUEST['id_user'])) ? $_REQUEST['id_user'] : get_current_user_id() ;
    
   // $headers = array();
	//$headers[] = 'Content-Type: text/html; charset=UTF-8';
//	$headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" ;
    //$headers = array('Content-Type: text/html; charset=UTF-8');
   // $enviado = wp_mail('irwinhernandezj@gmail.com', "subject", "body", $headers);
    
   //  print_r(json_encode("envio el mail:",$enviado));die;
    //$user_id = ;
    //require ( $asipiPath . '/asipi-helper/montevideo2020/_config.php' );
    //$event_id = 17;

    /*$role = 'subscriber';
    if ( !is_user_member_of_blog( $user_id, $event_id ) ) {
        add_user_to_blog( $event_id, $user_id, $role );	
    }*/

    //require ( $asipiPath . '/asipi-helper/montevideo2020/_config.php');
    $orden_id = $wpdb->get_var('SELECT id FROM evento_orden WHERE evento_id = '.$blog_id.' AND pwisa_users_id = '.$user_id); //visible=1 AND

    $isMember=$wpdb->get_var('SELECT COUNT(A.user_id) AS result FROM pwisa_usermeta AS A WHERE A.meta_key LIKE "pwisa_capabilities" AND A.meta_value like "%member%" AND A.user_id='.$user_id);	

    $email_user = $wpdb->get_var('SELECT user_email FROM pwisa_users WHERE id='.$user_id);
    
    

    // verificar si aplicapara descuento 
    /*$count_registers_by_company =0;
    $allow = array("gmail.com","hotmail.com","claro.cl","yahoo.com"); //dominios no válidos
    $dom = explode("@",$email_user)[1];
    
    if(!in_array($dom,$allow)){
        $cu->count_registers_by_company = $wpdb->get_var('SELECT count(pwisa_users.ID) as result FROM pwisa_users, evento_orden where pwisa_users.ID = evento_orden.pwisa_users_ID and evento_orden.evento_id ='.$blog_id.' and pwisa_users.user_email like "%'.$dom.'%" and evento_orden.subnumero =1 ');
    }*/

 
    #$tipo = $wpdb->get_var("SELECT tipo FROM evento_orden WHERE id=" . $orden_id);

    #$numero = $wpdb->get_var("SELECT numero FROM evento_orden WHERE id=" . $orden_id);

    //$estatus = $wpdb->get_var("SELECT status FROM evento_orden WHERE id=" . $orden_id);

    $lenguaje = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=14" );

    $exento_expresident = $wpdb->get_var('SELECT count(*) FROM exentos where tipo=3 AND pwisa_users_ID =' . $user_id);
    $exento_directivo = $wpdb->get_var('SELECT count(*) FROM exentos where tipo=2 AND pwisa_users_ID =' . $user_id);
    
   

    /*$query = "SELECT * FROM pwisa_bp_xprofile_data WHERE user_id='".$user_id."'";
    $result = $wpdb->get_results( $query );
    echo json_encode($result);
    exit();*/
    if($lenguaje=='Inglés' || $lenguaje=='English'){
        $lang='en';
    }else if($lenguaje=='Portugués' || $lenguaje=='Portuguese'){
        $lang='en';
    }else {
        $lang='es';
    }
    // Obtener nombre y apellido
    $cu = new stdClass();
    
      
    #$cu->registers_by_company = $count_registers_by_company ;
    $cu->id_user = $user_id;
    $cu->isMember = $isMember;
    $cu->exento_expresident= $exento_expresident;
    $cu->exento_directivo= $exento_directivo;
    $cu->email = $email_user;
    $cu->ordenId = $orden_id;
    #$cu->tipo = $tipo;
    #$cu->numero = $numero;

    $campos = array(
        '1' => 'name',
        '2' => 'last',
        '12' => 'persCompany',
        '47' => 'persUniversity',
        '18' => 'persGenner',
        '28' => 'billEmail',
        '31' => 'billState',
        '32' => 'billCity',
        '33' => 'billZip',
        '46' => 'billNit',
        '45' => 'billName',
        '3' => 'persAddress',
        '7' => 'persCountry',
        '9' => 'persCity',
        '8' => 'persState',
        '6' => 'persZip',
        '34'=> 'fechaNacimiento',
        '29'=> 'billAddress',
        '30'=> 'billCountry'
    );

    foreach ($campos as $key => $value) {
        #$data = bp_get_profile_field_data( array('user_id'	=> $user_id,'field'	=> $key));
        $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = $key order by id desc limit 1";
        $data = $wpdb->get_var($sql);
        if($key==7 and is_numeric($data)){ // si es el campo de pais y el valor es numerico busca el nombre del pais
            $cu->$value = $wpdb->get_var("SELECT name_".$lang." FROM country_names WHERE id = " . $data);
        }if($key==34){ // si es el campo de pais y el valor es numerico busca el nombre del pais
            $cu->$value = $data;
            $cu->dianacimiento = isset($data) ? substr($data,8,2): null;
            $cu->mesnacimiento = isset($data) ? substr($data,5,2): null;
            $cu->anonacimiento = isset($data) ? substr($data,0,4): null;
        }else{ // asigna el valor de data a la clave especifica
           $cu->$value =(isset($data)) ? $data : '';
        }
    }

    //datos de facturacion
    #$data =  bp_get_profile_field_data( array('user_id'	=> $user_id,'field'	=> 29));
    $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = 29 order by id desc limit 1";
    $data = $wpdb->get_var($sql);
    if($data!=""){
        $cu->billing = 1;
        $cu->billAddress = ($data!='undefined') ? $data : '' ;

        #$data =  bp_get_profile_field_data( array('user_id'	=> $user_id,'field'	=> 30) );
        $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = 30 order by id desc limit 1";
        $data = $wpdb->get_var($sql);
        if(is_numeric($data)){
            $countryName = $wpdb->get_var("SELECT name_".$lang." FROM country_names WHERE id = " . $data);
        }else{
            $countryName = $data;
        }
        
        $cu->billCountry = $countryName;
        $cu->countryId = $data;

    }

    ## buscar acompañante

    /*$cu->acomp = $wpdb->get_var('SELECT count(*) FROM evento_orden_concepto where evento_concepto_id=3 AND visible=1 AND evento_orden_id ='.$orden_id);
    if((int)$cu->acomp){
        $cu->compName = $wpdb->get_var('SELECT nombre FROM evento_acomp WHERE evento_id = '.$event_id.' AND pwisa_users_id ='.$user_id);
        $cu->compLast = $wpdb->get_var('SELECT apellido FROM evento_acomp WHERE evento_id = '.$event_id.' AND pwisa_users_id ='.$user_id);
    }*/

    ## buscar saldo del usuario
    $cu->sql = $queryTeso = 'select saldo from pwisa_teso_cuenta where pwisa_users_ID ='.$user_id;
    $saldo = $wpdb->get_var($queryTeso);

    $cu->saldodeuda = ($saldo > 0) ? $saldo : 0 ;

    $cu->saldoafavor = ($saldo < 0) ? $saldo : 0 ;
    //$cu->saldoafavor = -200;
    
    /*$cu->count_actividad_1 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional WHERE evento_id ='.$blog_id.' and ((clave = "actividad_1" and valor!=0) or (clave = "companion_actividad_1" and valor="SI" ))');
    $cu->count_actividad_2 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional WHERE evento_id ='.$blog_id.' and ((clave = "actividad_2" and valor!=0) or (clave = "companion_actividad_2" and valor="SI" ))');
    $cu->count_actividad_4 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional WHERE evento_id ='.$blog_id.' and ((clave = "actividad_4" and valor!=0) or (clave = "companion_actividad_4" and valor="SI" ))');
    $cu->count_actividad_5 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional WHERE evento_id ='.$blog_id.' and ((clave = "actividad_5" and valor!=0) or (clave = "companion_actividad_5" and valor="SI" ))');
    // $cu->count_actividad_1=6;
    //  $cu->count_actividad_2=6;
     //  $cu->count_actividad_3=6;
       // $cu->count_actividad_4=6;*/
    $cu->count_actividad_1 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_1" and valor!=0 and evento_orden.visible =1) or (clave = "companion_actividad_1" and valor="SI" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' ');
    $cu->count_actividad_2 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_2" and valor!=0 and evento_orden.visible =1) or (clave = "companion_actividad_2" and valor="SI" and evento_orden.visible =1 )) and evento_orden.evento_id ='.$blog_id.' ');
    $cu->count_actividad_3 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_3" and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='.$blog_id.' ');
    $cu->count_actividad_4 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_4" and valor!=0 and evento_orden.visible =1) or (clave = "companion_actividad_4" and valor="SI" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' ');
    $cu->count_actividad_5 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_5" and valor!=0 and evento_orden.visible =1) or (clave = "companion_actividad_5" and valor="SI" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' ');
    $cu->count_golf        =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_6" and valor=60 and evento_orden.visible =1) or (clave = "companion_actividad_6" and valor="60" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_futbol      =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_6" and valor=59 and evento_orden.visible =1) or (clave = "companion_actividad_6" and valor="59" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_tenis       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_6" and valor=58 and evento_orden.visible =1) or (clave = "companion_actividad_6" and valor="58" and evento_orden.visible =1))  and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_padel       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_6" and valor=57 and evento_orden.visible =1) or (clave = "companion_actividad_6" and valor="57" and evento_orden.visible =1)) and evento_orden.evento_id ='.$blog_id.' '); 
   
    $cu->count_t1a       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=63 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t1b       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=64 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    #$cu->count_t1c       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=67 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2a       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_2" and valor=65 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2b       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_2" and valor=66 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2c       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_2" and valor=68 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 

    /*$cu->count_t1c       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=51 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2a       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=55 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2b       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=53 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    $cu->count_t2c       =  $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and (clave = "taller_turno_1" and valor=54 and evento_orden.visible =1) and evento_orden.evento_id ='.$blog_id.' '); 
    
    $cu->count_actividad_7 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_7" and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='.$blog_id.' ');
  */ 
  $cu->count_actividad_8 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_8" and valor!=0 and evento_orden.visible =1) ) and evento_orden.evento_id ='.$blog_id.' ');

    $cu->count_actividad_9 = $wpdb->get_var('SELECT count(*) FROM evento_info_adicional,evento_orden WHERE evento_info_adicional.orden_id= evento_orden.id and ((clave = "actividad_9" and valor!=0 and evento_orden.visible =1) or (clave = "companion_actividad_9" and valor="SI" and evento_orden.visible =1) ) and evento_orden.evento_id ='.$blog_id.' ');


 //$cu->telefono = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=23" );
    /*contar registro con correo empresa*/
    /*$allow = array("gmail.com","hotmail.com","yopmail.com","yahoo.com","outlook.com","icloud.com","aol.com"); //dominios no válidos
    $dom = explode("@",$email_user)[1];
    if(!in_array($dom,$allow)){

        /*verifica el pais del navegador*/
        /*$data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        $country_act = $countryName ?? $data['geoplugin_countryName'];
        $ip = $data['geoplugin_request'];
        //echo $country," ",$ip,"<br/>";
        //print_r($data);
        
        $cu->count_registers_by_company = $wpdb->get_var('SELECT count(pwisa_users.ID) as result FROM pwisa_users, evento_orden, pwisa_bp_xprofile_data where pwisa_users.ID = evento_orden.pwisa_users_ID and evento_orden.evento_id ='.$blog_id.' and pwisa_users.user_email like "%'.$dom.'%" and evento_orden.subnumero =1 and evento_orden.estado ="C" AND pwisa_bp_xprofile_data.user_id= pwisa_users.ID AND pwisa_bp_xprofile_data.field_id=7 AND pwisa_bp_xprofile_data.value="'. $country_act .'"');
        
        
        //$cu->count_registers_by_company ="4";
    }else{
        $cu->count_registers_by_company ="0";
    }*/
    
 
    echo json_encode($cu);
    
 
    
    
    
}


?>
