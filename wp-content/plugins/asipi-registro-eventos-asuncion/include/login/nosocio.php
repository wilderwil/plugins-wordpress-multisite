<?php
//Devolver datos a archivo js
add_action('wp_ajax_nopriv_are_ajax_login_nosocio','are_login_nosocio');
add_action('wp_ajax_are_ajax_login_nosocio','are_login_nosocio');

function are_login_nosocio()
{

    
    $asipiPath = $_SERVER['DOCUMENT_ROOT'];
	require ( $asipiPath . '/wp-load.php');
    global $wpdb;
    global $blog_id;
    $res = new stdClass();
    $status = 'error';
    $mensaje = 'Error';
    $user_id = '0';
    $userType = false;

    if (isset($_REQUEST["email"]) and $_REQUEST["email"]!='') {
        $email = $_REQUEST["email"];

        $user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

        if($user_id == NULL){
            // NO REGISTRADO (NO SOCIO - ESTUDIANTE)
            $userType = "unregistered";
            $status = 'activo';
            $mensaje = 'Usuario no registrado';
        }else{
            $user_is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id ='.$user_id);

            if($user_is_member==0){
                // NO ES MIEMBRO
                // se chequea que no este dado de baja
                $blocked = $wpdb->get_var('SELECT COUNT(A.user_id) AS result
                    FROM pwisa_usermeta AS A
                    WHERE A.meta_key LIKE "pwisa_capabilities"
                    AND (A.meta_value LIKE "%baja%" AND A.meta_value NOT LIKE "%otros%")
                    AND A.user_id = (SELECT ID FROM pwisa_users WHERE user_email = "' . $email . '")');

                if ($blocked) {			
                    $userType = "blocked";
                    $status = 'error';
                    $mensaje = 'Usuario Bloqueado';
                    
                } else {
                    $userType = "nonMember";
                    $status = 'activo';
                    $mensaje = 'Usuario no socio';
                }
                
            }else{
                // ES MIEMBRO
                $userType = "member";
                $status = 'error';
                $mensaje = 'Usuario socio asipi';
            }
        }

    } else {
        # code...
        $userType = false;
        $status = 'error';
        $mensaje = 'Introdúzca un email válido';
    }
    
    if ( $userType and ($_REQUEST['password']=='') ) {
        //$userType = false;
        //$status = 'error';
        //$mensaje = 'Introdúzca una contraseña';*/
    }else { 
         if(isset($_REQUEST['coupon_code']) ){
            $coupon = $_REQUEST['coupon_code'];
            $coupon_code= $wpdb->get_var('SELECT id from evento_coupons where coupon ="' . $coupon . '" and status = "0" ');
            #$coupon_code = $wpdb->get_results($sql);
            json_encode($coupon_code);
         }
        
        if(isset($_REQUEST['coupon_code'])  && $coupon_code == NULL){
            $status = 'error';
            $mensaje = 'Invalid Coupon code';  
        }else{
        $password = $_REQUEST['password'];
        $email = $_REQUEST["email"];
        if (isset($_REQUEST['tipo_password']) and $_REQUEST['tipo_password']=='new'){
            ## NUEVO USUARIO ##

            // extraer nombre de USERNAME
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
                'role'   =>  ''
            );
        
            // se agrega al nuevo usuario 
            $user_id = wp_insert_user( $userdata ) ;
        
            if ($user_id>0) {
                // se agrega como participante a eventos de asipi
                $sql = "INSERT INTO asipi_events_attendees ( user_id, event_id ) VALUES ( '".$user_id."' , '".$blog_id."' )";
                $queryResult = $wpdb->get_results($sql);

                // se agrega la propiedad de lenguaje al usuario nuevo
                $field_lang = '14';
                $idioma = ( $_POST['lang']=='en-US' || $_POST['lang']=='en' ) ? 'Inglés' : 'Español' ;

                $sql = "INSERT INTO pwisa_bp_xprofile_data ( user_id, field_id, value ) VALUES ( ".$user_id.", ".$field_lang.", '".$idioma."' )";
                $queryResult = $wpdb->get_results($sql);

                $sql = "INSERT INTO pwisa_bp_xprofile_data ( user_id, field_id, value ) VALUES ( ".$user_id.", 1, '' )";
                $queryResult = $wpdb->get_results($sql);

                // se agrega al nuevo usuario como suscriptor en el sitio del evento
                //if ( !is_user_member_of_blog( $user_id, $blog_id ) ) {
                    //add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
                //}
                //$ms= '<br>'.$blog_id.'-'.$user_id.'-'.'subscriber'.'<br>';
            //$ms.= 
            //add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
                    add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
            //add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
            //$ms.= '<br>';

            // se quita al usuario como suscriptor del sitio principal de asipi
            $e = remove_user_from_blog($user_id, 1); // el 1 es el id del sitio principal (multisite)

                $userType = "nonMember";
                $status = 'activo';
                $mensaje = 'Usuario no socio';
            } 
        }
        if ( $userType and ( $userType == "nonMember" ) ) {
            # code...
            $query = 'SELECT id, user_login FROM pwisa_users WHERE user_email="'.$email.'" limit 1;';
            $result = get_object_vars( $wpdb->get_row( $query ) );
            //var_dump($result);
            
            $user_login = $result['user_login'];

            $creds = array();
            $creds['user_login'] = $user_login;
            $creds['user_password'] = $password;
            $creds['remember'] = true;
            
            //$user = wp_signon( $creds, false );
            $user = wp_authenticate( $creds['user_login'], $creds['user_password'] ); 

            if ( is_wp_error($user) ){
                    if(isset($_POST['lang']) and $_POST['lang'] == 'en-US'){
                        //echo "Error: Invalid email or password";
                        $status = 'error';
                        $mensaje = 'Invalid email or password';
                    }else{
                        //echo "Error: Contraseña o email incorrecto";
                        $status = 'error';
                        $mensaje = 'Contraseña o email incorrecto';
                    }
                    //return false;
                //return;
            }else{	
                wp_set_current_user($user->ID);
                //$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $creds );
 
                //global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie().
                //$auth_secure_cookie = $secure_cookie;
                wp_set_auth_cookie( $user->ID);

                $user_id = $user->ID;
                
                $queryTeso = 'select saldo from pwisa_teso_cuenta where pwisa_users_ID ='.$user_id;
                $saldo = 0 + $wpdb->get_var($queryTeso);
                //$saldo = 300;

                if((double)$saldo <= 0){
                    //$returnmessage = "Member|".$saldo;
                    //$returnmessage = 'on-line';	
                    $status = 'on-line';
                    $mensaje = 'usuario aceptado';		
                }else{
                    //$returnmessage = "Error: Deuda|".$saldo;
                    $status = 'deuda';
                    $mensaje = 'El usuario posee deuda de $'.$saldo;
                }
                
                $_SESSION["user_id"] = $user_id;

                // verificar que el usuario no este registrado en este evento
				
				$registro_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible='1' and evento_id='".$blog_id."' and pwisa_users_id='".$user_id."' ");
				
				/*$registro_id1 = $wpdb->get_var("SELECT id FROM evento_info_adicional WHERE evento_id='".$blog_id."' and user_id='".$user_id."' AND clave='tipo_habitacion'");
				
				//echo "registro_id1: $registro_id1";
				
				if ($registro_id1>0){
				    $registro_id=0;
				}*/
				
				
				if($registro_id>0){
					$status = 'error';
					$mensaje = 'Ya esta registrado en este evento';
				}
                //$returnmessage = 'on-line';
            }
            //echo "$returnmessage";
        } else {
            //echo('Error: '.$userType);
        }}
    } 
    

    $res->status = $status;
    $res->userType = $userType;
    $res->mensaje = $mensaje;
    $res->user_id = $user_id;
    
    echo json_encode($res);
}
?>
