<?php
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require($asipiPath . '/wp-load.php');

global $wpdb;
global $blog_id;

if ( is_user_logged_in() ) {
$current_user = wp_get_current_user();
$user_id = $current_user->ID;


$numero_orden= $wpdb->get_var("SELECT numero FROM evento_orden WHERE pwisa_users_ID= $user_id AND subnumero=1 AND visible=1 and evento_id=35 and tipo in (1,2)");

  //ojo quitar cuando pidan que la activen 
//$numero_orden='';
 if((!is_null($numero_orden) && !empty($numero_orden) && $numero_orden!='' )){
   $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = 1 order by id desc limit 1";
   $name = $wpdb->get_var($sql);
   $name = explode(" ", $name);
    $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $user_id and field_id = 2 order by id desc limit 1";
   $last = $wpdb->get_var($sql);
   $last = explode(" ", $last);
   $result =trim($numero_orden).','. $name[0] .','. $last[0];
   echo $result;
  
  
  }elseif(empty($numero_orden)){
  	echo "";
  }else {
 echo '';
}
}