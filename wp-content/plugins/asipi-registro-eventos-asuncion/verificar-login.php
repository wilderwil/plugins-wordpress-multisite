<?php
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require($asipiPath . '/wp-load.php');

global $wpdb;
global $blog_id;
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

$numero_orden= $wpdb->get_var("SELECT numero FROM evento_orden WHERE pwisa_users_ID= $user_id AND subnumero=1 AND visible=1 and evento_id=35 and tipo in (1,2)");
//quitar cuando manden a activar
//echo '1';
if (empty(get_current_user_id())) {

  echo "1";

}else{
   if((!is_null($numero_orden) && !empty($numero_orden) && $numero_orden!='')){
		echo "2";
  }else{
  echo "1";
  }
}