<?php 
//Devolver datos a archivo js
add_action('wp_ajax_nopriv_are_ajax_new_user','are_new_user');
add_action('wp_ajax_are_ajax_new_user','are_new_user');

function are_new_user()
{
    global $blog_id;
    $asipiPath = $_SERVER['DOCUMENT_ROOT'];
	require ( $asipiPath . '/wp-load.php');
    global $wpdb;
    $res = new stdClass();
    $status = 'error';
    $mensaje = 'Error';
    $user_id = '0';
    $userType = false;

        $password = $_REQUEST['password'];
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
            'role'   =>  ''
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
            if ( !is_user_member_of_blog( $user_id, $blog_id ) ) {
                add_user_to_blog( $blog_id, $user_id, 'subscriber' );	
            }
            // se quita al usuario como suscriptor del sitio principal de asipi
            $e = remove_user_from_blog($user_id, 1); // el 1 es el id del sitio principal (multisite)

            // loguear al nuevo usuario.
            //$idlogin = are_login();
            return $user_id;//are_login();
        } else {
            return '0';
        }
}