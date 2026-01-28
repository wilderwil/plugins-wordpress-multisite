<?php
/**
 * Plugin Name:       Asipi - Registro de Usuarios en Asunción 2025
 * Description:       Registro de usuarios a Asunción.
 * Version:           2.0.0
 * Author:            ZT Group Corp Team
 */

## PASO 1 - Identificacion del usuario y formulario de jotform
add_action('the_content', 'are_paso1_registro_eventos');
function are_paso1_registro_eventos( $content ){
    if(is_page('registro-evento')){ #echo "singular". is_singular();echo "in the loop". in_the_loop();echo "main query". is_main_query();
        if ( is_singular() /*&& in_the_loop()*/ && is_main_query() ) {
            wp_enqueue_style( 'are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css',false,'1.8','all');
            include('include/paso1.php');
        }
    }else{
        return $content;
    }
}
/*
## RECIBO / CERTIFICADO -  Muestra de recibo y certificado en formato PDF
add_action('get_header', 'are_invoice_registro_eventos');
function are_invoice_registro_eventos( $output ){
    if(is_page('registro-evento-recibo')){
        if (isset($_GET['numero']) and isset($_GET['tipo'])) {
            include('include/invoice/dlInvoice.php');
        }elseif ( isset($_GET['certificado']) ) {
            include('include/certificado/certificado.php');
        } 
    }else{
        return $output;
    }
}
*/
## PASO 2 - Guardar registro y confirmacion

add_action('the_content', 'are_paso2_registro_eventos');
function are_paso2_registro_eventos( $content ){
    if(is_page('registro-evento-recibo')){
        //var_dump($_REQUEST);
        if ( is_singular() /*&& in_the_loop()*/ && is_main_query() ) {
           // var_dump($_REQUEST);
            if (isset($_REQUEST['email'])) {
                    include('include/registro/registrar.php');
                    wp_enqueue_style( 'are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css',false,'1.4','all');
                    include('paso2.php');
            }else{
                $asipiPath = $_SERVER['DOCUMENT_ROOT'];
                require ( $asipiPath . '/wp-load.php');
                global $wpdb;
                global $blog_id;
                $event_url = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave = 'url' and evento_id = $blog_id");

                return '<br><br><a href="'.$event_url.'registro-evento" class="btn btn-success">Volver</a>';
            }
        }
    }else{
        return $content;
    }
}

add_filter( 'login_url', 'my_login_url' );
function my_login_url( $url ) {
    //echo $url;
    /*$login_page = 'https://dev.asipi.com/congreso2021/ingresar/';
    //echo wpmem_login_url();
    
    $redirect_to = get_permalink();
    wp_redirect( home_url('ingresar') );
    //exit();
    return add_query_arg( 'redirect_to', $redirect_to, $login_page );*/
}
/*
add_shortcode('are_hotel', 'are_registroHotel'); 
function are_registroHotel() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/hotel.php';
}
add_shortcode('are_running', 'are_registroRunning'); 
function are_registroRunning() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/running.php';
}

add_shortcode('are_rutas', 'are_registroRutas');
function are_registroRutas()
{
       wp_enqueue_style('are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css', false, '1.8', 'all');
         
    require_once plugin_dir_path(__FILE__) . 'include/registro/rutas.php';
}
add_shortcode('are_confirmacionRutas', 'are_confirmacionRutas');
function are_confirmacionRutas()
{
    require_once plugin_dir_path(__FILE__) . 'include/registro/registrarRutas.php';
    wp_enqueue_style('are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css', false, '1.4', 'all');
    require_once plugin_dir_path(__FILE__) . 'paso4.php';
}*/
add_shortcode('are_invitadosEspeciales', 'are_invitadosEspeciales');
function are_invitadosEspeciales()
{
       wp_enqueue_style('are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css', false, '1.8', 'all');
         
    require_once plugin_dir_path(__FILE__) . 'include/registro/invitados.php';
}
/*
add_shortcode('are_confirmacionHotel', 'are_confirmacionHotel'); 
function are_confirmacionHotel() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/registrarHotel.php';
    wp_enqueue_style( 'are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css',false,'1.4','all');
    require_once plugin_dir_path(__FILE__) . 'paso3.php';
}
*/
add_shortcode('are_edicion', 'are_registroEdicion'); 
function are_registroEdicion() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/edicion.php';
}

add_shortcode('are_confirmacionEdicion', 'are_confirmacionEdicion'); 
function are_confirmacionEdicion() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/registrarEdicion.php';
    wp_enqueue_style( 'are_styles', '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css',false,'1.4','all');
    require_once plugin_dir_path(__FILE__) . 'paso4.php';
}
/*
add_shortcode('are_planes', 'are_planescostos'); 
function are_planescostos() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/planes.php';
}
*/
add_shortcode('are_planesasuncion2025', 'are_planescostosasuncion2025'); 
function are_planescostosasuncion2025() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/planesasuncion2025.php';
}

//Insertar Javascript js y enviar ruta admin-ajax.php
add_action('wp_enqueue_scripts', 'are_insertar_js');
function are_insertar_js(){
        $my_plugin = plugin_dir_url( __FILE__ ).'js/script.js';
        wp_register_script('are_miscript', $my_plugin, array('jquery'), rand(0, 99), true );
        wp_enqueue_script('are_miscript');
        wp_localize_script('are_miscript','dcms_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
}

function asipi_registro_evento_init() {
    add_menu_page('ASIPI Config Evento', 'ASIPI Config Evento', 'manage_options' ,'asipi-config-evento', 'asipi_config_registro_lista', 'dashicons-wordpress');
    /* add_submenu_page('asipi-cursos', 'Agregar Curso', 'Agregar Curso', 'manage_options', 'asipi-cursos-agregar', 'asipi_cursos_crear');
    add_submenu_page(null, 'Actualizar Curso', 'Actualizar Curso', 'manage_options', 'asipi-cursos-actualizar', 'asipi_cursos_actualizar');
    add_submenu_page(null, 'Agregar Módulo', 'Editar Modulo', 'manage_options', 'asipi-cursos-agregar-modulo', 'asipi_cursos_agregar_modulo');
    add_submenu_page(null, 'Editar Módulo', 'Editar Módulo', 'manage_options', 'asipi-cursos-editar-modulo', 'asipi_cursos_editar_modulo');
    add_submenu_page(null, 'Editar Módulo', 'Editar Módulo', 'manage_options', 'asipi-cursos-editarmodulo', 'asipi_cursos_editarmodulo'); */
}
add_action('admin_menu', 'asipi_registro_evento_init');

add_shortcode('arc_config_eventos', 'arc_lista_registrados'); 
function arc_lista_registrados() {
    //return 'Esto es la lista de registrados a los cursos';
    require_once plugin_dir_path(__FILE__) . 'include/tesoreria/core.php';
}
require_once plugin_dir_path(__FILE__) . 'include/tesoreria/config_lista.php';
//require_once plugin_dir_path(__FILE__) . 'include/tesoreria/verificarEmail.php';
require_once plugin_dir_path(__FILE__) . 'include/login/socio.php';
require_once plugin_dir_path(__FILE__) . 'include/login/miembro.php';
require_once plugin_dir_path(__FILE__) . 'include/login/nosocio.php';
require_once plugin_dir_path(__FILE__) . 'include/login/invitados.php';
require_once plugin_dir_path(__FILE__) . 'include/login/rutas.php';
require_once plugin_dir_path(__FILE__) . 'include/login/getUserLogueado.php';

## Listado de Participantes y formulario de contacto
require_once plugin_dir_path(__FILE__) . 'include/participantes/listado.php';

add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2 );
function add_extra_item_to_nav_menu( $items, $args ) {
#    $item = '<li style="padding-top:13px"><a href="/asuncion2025/registro-evento/?t=presencial">'.__("<!--:es-->Registro<!--:--><!--:en-->Register<!--:-->").'</a>';
    if (is_user_logged_in()) {
        global $wpdb;
	      global $blog_id;
        $event_id = $blog_id;

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        #$sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and estado IN ('C','E','R') and evento_id = '$event_id'";
        $sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and visible = 1 and evento_id = '$event_id'";
        $user_id_2 = $wpdb->get_var($sql_user);
        $admin = false;
        if ( current_user_can('manage_options') ) {
        //el usuario actual es administrador
        $admin = true;
        }
        $user_is_secretaria = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND (meta_value LIKE "%tesoreria%" or meta_value LIKE "%secretaria%")  AND user_id ='.$user_id);
        if($user_is_secretaria>0){
             //el usuario actual es secretaria
            $admin = true;
        }
      
       if($user_id_2 > 0 || $admin){
            $item3 = '<li ><a href="/asuncion2025/listado-de-participantes">'.__("<!--:es-->Participantes<!--:--><!--:en-->List of Participants<!--:-->").'</a></li>';
           #$item2 = '<li><a href="/asuncion2025/registro-edicion">'.__("<!--:es-->Edición<!--:--><!--:en-->Edit<!--:-->").'</a>';
    
        }   

        $sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and subnumero=1 and visible=1 and estado IN ('C','P') and evento_id = '$event_id'";
        $user_id_2 = $wpdb->get_var($sql_user);
        
        if($user_id_2 > 0){
          # $item2 = '<li style="padding-top:13px;padding-left: 20px;padding-right: 20px;"><a href="/asuncion2025/registro-edicion">'.__("<!--:es-->Editar registro<!--:--><!--:en-->Register edit<!--:-->").'</a>';
			  #$item2 = '<li><a href="/asuncion2025/registro-edicion">'.__("<!--:es-->Edición<!--:--><!--:en-->Edit<!--:-->").'</a>';
    
          #           $item4 = '<li style="padding-top:13px"><a href="/asuncion2025/registro-hotel">'.__("<!--:es-->Hotel<!--:--><!--:en-->Hotel<!--:-->").'</a>';
        }
        
    }
    
    /*$items .= $item.$item2;
    $items .= $item2;
    
    
    if ($admin==true) {
        $new_item =  $item;
        $menu_items = explode( '</li>', $items );
        array_splice( $menu_items, -2, 0, $new_item );
        $items = implode( '</li>', $menu_items );
     
    }*/
    
    
    
    #$admin=false;
    if ($admin==true) {
        $new_item =  $item;
        $new_item .= $item2;
 #       $new_item .= $item4;
        $new_item .= $item3;
        $menu_items = explode( '</li>', $items );
        array_splice( $menu_items, -2, 0, $new_item );
        $items = implode( '</li>', $menu_items );
        #$items .= $item2;
        

    }else{
        if($user_id_2 > 0){
           $items .= $item2;
            $items .= $item3;
  #          $items .= $item4;
        
        
        }else{
  #          $items .= $item;
        }


    }
    
    
    
    return $items;
}

?>
