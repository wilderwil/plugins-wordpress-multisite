<?php
//Devolver datos a archivo js
add_action('wp_ajax_nopriv_are_ajax_login_miembro','are_login_miembro');
add_action('wp_ajax_are_ajax_login_miembro','are_login_miembro');

function are_login_miembro()
{

    
    
    global $wpdb;
    $res = new stdClass();
    $status = 'error';
    $mensaje = 'Error no entro';
    $user_id = '0';

    /* Chequear tipo de usuario por email */
    $email = trim($_POST['email']);
    $email_invitado = $_POST['email_miembro'];
    if ($email=='') {
        $status = 'error';
        $res->userType = "no email";
        $mensaje = 'No Email';
    }else{
        
        $user_id = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email . '"');

        if($user_id == NULL){
            // NO REGISTRADO (NO SOCIO - ESTUDIANTE)
            $status = 'error';
            $mensaje = 'usuario no registrado en ASIPI';	
            $userType = "unregistered";
        }else{
            
            $user_is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%member%" AND user_id ='.$user_id);

            if($user_is_member==0){
                // NO ES MIEMBRO
                	
                $blocked = $wpdb->get_var('SELECT COUNT(A.user_id) AS result
                    FROM pwisa_usermeta AS A
                    WHERE A.meta_key LIKE "pwisa_capabilities"
                    AND (A.meta_value LIKE "%baja%" AND A.meta_value NOT LIKE "%otros%")
                    AND A.user_id = (SELECT ID FROM pwisa_users WHERE user_email = "' . $email . '")');

                if ($blocked) {	
                    $status = 'error';
                    $mensaje = 'El socio esta bloqueado';		
                    $userType = "blocked";
                } else {
                    $status = 'error';
                    $mensaje = 'No es Socio ASIPI';
                    $userType = "nonMember";
                }
                
            }else{
                // ES MIEMBRO
                
                if (isset($_POST['company'])) {
                    #$data =  bp_get_profile_field_data( array('user_id'	=> $user_id,'field'	=> 12 ) );
                    $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = 12 order by id desc limit 1";
                    $data = $wpdb->get_var($sql);
                    //$sql = "SELECT value FROM pwisa_bp_xprofile_data WHERE field_id=12 and user_id=$user_id";
                    $userType = "member";
                    if (html_entity_decode($data) == html_entity_decode($_POST['company'])) {
                        
                            $partsEmail = explode('@', $email);
                            $domainEmail = array_pop($partsEmail);

                            $partsEmailInvitado = explode('@', $email_invitado);
                            $domainEmailInvitado = array_pop($partsEmailInvitado);

                            // Check if the domain is in our list
                            if ( $domainEmail == $domainEmailInvitado )
                            {
                                $status = 'on-line';
                                $mensaje = 'usuario activo';
                            }else{
                                $status = 'error';
                                $mensaje = 'No pertenecen a la misma compañia ';
                            }

                    } else {
                        $status = 'error';
                        $mensaje = 'El socio indicado no pertenece a esta compañia ';
                    }
                    
                } else {
                    $userType = "member";
                    $status = 'error';
                    $mensaje = 'No se verifico la compañia';
                }
            }
            $res->user_id = $user_id;
        }
    }

    // verificar que el usuario no este registrado en este evento
    global $blog_id;
    $user_id_invitado = $wpdb->get_var('SELECT id FROM pwisa_users WHERE user_email = "' . $email_invitado . '"');
    $registro_id = $wpdb->get_var("SELECT id FROM evento_orden WHERE visible='1' and evento_id='".$blog_id."' and pwisa_users_id='".$user_id_invitado."' ");
    if($registro_id>0){
        $status = 'error';
        $mensaje = 'Ya esta registrado en este evento';
    }

    $res->status = $status;
    $res->userType = $userType;
    $res->mensaje = $mensaje;
    $res->user_id = $user_id;

    echo json_encode($res);
}

?>