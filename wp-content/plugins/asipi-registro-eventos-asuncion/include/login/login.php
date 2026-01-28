<?php

add_action('the_content', 'are_login');
function are_login( $content ){
    if(is_page('login')){
        if ( is_singular() && in_the_loop() && is_main_query() ) {
            echo '<form id="form-verify-socios" class="form" action="/asipivirtual2020/login">                            
                <div class="form-group">
                    <label for="email_socio">Email</label>
                    <input type="email" class="form-control" name="email_socio" id="email_socio" required aria-describedby="emailHelp" placeholder="">
                    <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="" required>
                </div>
                <div class="form-group">
                    <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;">Olvidó la contraseña</a>
                </div>
                <div id="mensajeErrorLogin" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                <div class="espacio-boton"><br><a type="submit" class="btn-comprar">Entrar</a></div>
            </form>';
        }
    }else{
        return $content;
    }
}

//Devolver datos a archivo js
add_action('wp_ajax_are_ajax_login_socio','are_login_socio');

//$asipiPath = $_SERVER['DOCUMENT_ROOT'];
//require ( $asipiPath . '/wp-load.php');

function are_login_socio()
{
	//add_action( 'wp_login_failed', 'login_failed' );
	$asipiPath = $_SERVER['DOCUMENT_ROOT'];
	require ( $asipiPath . '/wp-load.php');
	global $wpdb;
	global $blog_id;
	$res = new stdClass();
	$status = 'error';
	$mensaje = 'no entro';
	$user_id = '0';
	$userType = false;
	
	
	if (isset($_REQUEST["email"]) and $_REQUEST["email"]!='') {
		$email = $_REQUEST["email"];

		$user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

		if($user_id == NULL){
			// NO REGISTRADO (NO SOCIO - ESTUDIANTE)
			$userType = "unregistered";
			$status = 'error';
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
					$status = 'error';
					$mensaje = 'Usuario no socio';
				}
				
			}else{
				// ES MIEMBRO
				$userType = "member";
			}
		}

	} else {
		$userType = false;
		$status = 'error';
		$mensaje = 'Introdúzca un email válido';
	}
	
	if ( $userType and (!isset($_REQUEST['password']) or $_REQUEST['password']=='') ) {
		$userType = false;
		$status = 'error';
		$mensaje = 'Introdúzca una contraseña';
	}else {
		$password = $_REQUEST['password'];
		$email = $_REQUEST["email"];
		if ( $userType and (  $userType == "member" ) ) { //$userType == "nonMember" or
			$query = 'SELECT id, user_login FROM pwisa_users WHERE user_email="'.$email.'" limit 1;';
			$result = get_object_vars( $wpdb->get_row( $query ) );
			
			$user_login = $result['user_login'];

			$creds = array();
			$creds['user_login'] = $user_login;
			$creds['user_password'] = $password;
			$creds['remember'] = false;
			//wp_logout();
			$user = wp_authenticate( $creds['user_login'], $creds['user_password'] ); 
			//$user = wp_signon( $creds, false );

			if ( is_wp_error($user) ){
					if($_POST['lang'] == 'en-US'){
						$status = 'error';
						$mensaje = 'Invalid email or password';
					}else{
						$status = 'error';
						$mensaje = 'Contraseña o email incorrecto';
					}
			}else{	
				wp_set_current_user($user->ID);
				$secure_cookie = apply_filters( 'secure_signon_cookie', $secure_cookie, $creds );
 
                global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie().
                $auth_secure_cookie = $secure_cookie;
                wp_set_auth_cookie( $user->ID, $creds['remember'], $secure_cookie );
				$user_id = $user->ID;
				
				$queryTeso = 'select saldo from pwisa_teso_cuenta where pwisa_users_ID ='.$user_id;
				$saldo = 0 + $wpdb->get_var($queryTeso);

				$cobra_deuda = $wpdb->get_var("SELECT * FROM `evento_meta` WHERE `clave` LIKE 'cobra_deuda' and evento_id='".$blog_id."'");
				if((double)$saldo > 0 and $cobra_deuda=='si'){
					$status = 'deuda';
					$mensaje = 'El usuario posee deuda de $'.$saldo.' <br>';
					$mensaje.= 'Debe <a href="/statement/" target="_blank"><span>cancelar aquí</span></a> para inscribirse.';
				}else{
					$status = 'on-line';
					$mensaje = 'usuario aceptado';//.implode(',',$creds);	
				}

				// verificar que el usuario no este registrado en este evento
				
				$registro_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible='1' and evento_id='".$blog_id."' and pwisa_users_id='".$user_id."' ");
				if($registro_id>0){
					$status = 'error';
					$mensaje = 'Ya esta registrado en este evento';
				}
				
				$_SESSION["user_id"] = $user_id;
			}
			
		} 
	} 
	
	$res->status = $status;
	$res->mensaje = $mensaje;
	$res->user_id = $user_id;
	
	echo json_encode($res);
}

?>