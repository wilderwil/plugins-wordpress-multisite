<?php
//Devolver datos a archivo js
add_action('wp_ajax_nopriv_arc_ajax_verifyEmailNew','arc_verifyEmailNew');
add_action('wp_ajax_arc_ajax_verifyEmailNew','arc_verifyEmailNew');

function arc_verifyEmailNew()
{
	//$asipiPath = $_SERVER['DOCUMENT_ROOT'];
	//require ( // . '/wp-load.php');
	global $wpdb;
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
			$status = 'success';
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
					$user_id = NULL;
					$userType = "blocked";
					$status = 'error';
					$mensaje = 'Usuario Bloqueado';
					
				} else {
					$userType = "nonMember";
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
	
		if ( $userType and ( $userType == "nonMember" or $userType == "member" ) ) { 
			
				$queryTeso = 'select saldo from pwisa_teso_cuenta where pwisa_users_ID ='.$user_id;
				$saldo = 0 + $wpdb->get_var($queryTeso);
				//$saldo = 300;

				if((double)$saldo <= 0){
					$status = 'success';
					$mensaje = 'usuario aceptado';		
				}else{
					$status = 'deuda';
					$mensaje = 'El usuario posee deuda de $'.$saldo.' <br>';
					$mensaje.= 'Debe <a href="/statement/"><span>cancelar aquí</span></a> para inscribirse.';
				}
			}
		 
	
	// verificar que el usuario no este registrado en este curso
	$id_curso = $_REQUEST['id_curso'];
	$tipo_curso = $_REQUEST['tipo_curso'];
	$registro_id = $wpdb->get_var('SELECT id FROM asipi_cursos_registros WHERE estado=1 and tipo_curso = "' . $tipo_curso . '" and curso_id = "' . $id_curso . '" and email = "' . $email . '"');
	if($registro_id>0){
		$status = 'error';
		$mensaje = 'Ya esta registrado en este curso';
	}
	
	$res->status = $status;
	$res->mensaje = $mensaje;
	$res->user_id = $user_id;
	
	echo json_encode($res);
}
?>