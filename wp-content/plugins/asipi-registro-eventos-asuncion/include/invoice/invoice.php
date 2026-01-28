<?php


function teso_send_invoice_evento($order_number) {
    global $wpdb;
    //$order_user = $wpdb->get_var("SELECT pwisa_users_id FROM evento_orden where id=" . $order_number);
    echo $order_number;
    /*$event_id = $wpdb->get_var("SELECT evento_id FROM evento_orden WHERE id = ". $order_number);
    $dataDocumento = teso_generate_invoice_evento($order_number, 'F', 'sent/');
   
    //$result = enviaFactura($nombreArchivo, $order_user, 'sent/', 8, $event_id);
    $status = $wpdb->get_var("SELECT estado FROM evento_orden WHERE id = ".$order_number);
    //if($status=="P"){
        //$result = enviaFactura2($order_user, 'sent/', 8, $event_id);
        $result = enviaFactura2($order_user, 'sent/', 8, $dataDocumento['documentTitle'], $event_id);
        if ($result) {
            echo '<div class="updated notice">
                    <p>Mensaje enviado aqui</p>
                </div>';
        } else {
            //Fail          
            echo '<div class="error notice">
                <p>Ha ocurrido un error, intente de nuevo</p>
            </div>';
        }
    /*}
    else{
        echo 'Orden Completada';
    }*/
   
}

function teso_generate_invoice_evento($number,$type,$folder){
    $asipiPath = $_SERVER['DOCUMENT_ROOT'];
    require ( $asipiPath . 'asipi-helper/dlInvoiceEvento.php');

    $data = array('documentTitle' => $documentTitle, 'fechaDocumento' => $fechaDocumento);
    //var_dump($data);exit();
    return $data;
}
function enviaFactura2($user_id,$carpeta,$tipoEmail,$nombreArchivo,$event_id){  
    global $wpdb;   
    
    //$strTipoEmail = 'eventInvoice';
    if($tipoEmail==1){
        $strTipoEmail = 'billingemail';
    }else if($tipoEmail==2){
        $strTipoEmail = 'newmember';
    }else if($tipoEmail==3){
        $strTipoEmail = 'receiptemail';
    }else if($tipoEmail==4){
        $strTipoEmail = 'reminder';
    }else if($tipoEmail==5){
        $strTipoEmail = 'info';
    }else if($tipoEmail==6){
        $strTipoEmail = 'penalty';
    }else if($tipoEmail==7){
        $strTipoEmail = 'duereminder';
    }else if($tipoEmail==8){
        $strTipoEmail = 'eventInvoice';
    }else if($tipoEmail==9){
        $strTipoEmail = 'eventReceipt';
    }

    $n_country = $wpdb->get_var( "SELECT value FROM pwisa_bp_xprofile_data WHERE user_id=".$user_id." AND field_id=7" );
     
    $group_emails = array();
    $correo_facturacion = xprofile_get_field_data(28,$user_id); 
    /*Obtengo el correo de facturación
    Si no está configurado, tomo el correo del usuario */
    if($correo_facturacion!= ""){
        $destinatario = xprofile_get_field_data(28,$user_id);
        array_push($group_emails, $destinatario);
    }
    if(xprofile_get_field_data(14,$user_id)!= ""){
        $idioma = xprofile_get_field_data(14,$user_id);
        if(!strcmp($idioma,'Español')){
            $lang = 'es';
        }else{
            $lang='en';
        }
    }
    else{
        $idioma = "Español";
        $lang = 'es';
    }
    $user_info = get_userdata($user_id);    
    $destinatario = $user_info->user_email;
    if(strcmp($destinatario,$correo_facturacion)!=0)
        array_push($group_emails, $destinatario);       
    
    //$destinatario = $user_info->user_email;
    //echo 'destinatario ' . $destinatario;
    /*Obtengo el nombre y apellido (en Camel Case)*/
    $nombre = ucwords(strtolower(xprofile_get_field_data(1,$user_id).' '.xprofile_get_field_data(2,$user_id))); 
    /*Busco los parametros de configuración (plantillas en ingles y español y la ruta de la carpeta de archivos pdf */
    $queryResult = $wpdb->get_results("select * from teso_config where clave in ('".$strTipoEmail."subject-es','".$strTipoEmail."subject-en','".$strTipoEmail."subject-pt','".$strTipoEmail."body-es','".$strTipoEmail."body-en','".$strTipoEmail."body-pt','pdf-folder')");
    
    $nombre_evento = $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'name_".$lang."'");
    //$header_factura = get_home_url();
            
    $header_factura .= $wpdb->get_var("SELECT valor FROM evento_meta WHERE evento_id = ".$event_id." AND clave = 'header_".$lang."'");
    $fields = array();  
    foreach($queryResult as $row){
        $fields[$row->clave] = $row->valor;
    }
    //if(!strcmp($idioma,'Portugués') || ($n_country=='Brasil' || $n_country=='Brazil'))
    //{
    //  $subject = $fields[$strTipoEmail.'subject-pt'];
    //  $body = $fields[$strTipoEmail.'body-pt'];               
    //}
    //else if(!strcmp($idioma,'Español'))
    if(!strcmp($idioma,'Español') || !strcmp($idioma,'Portugués') )
    {
        $subject = $fields[$strTipoEmail.'subject-es'];
        $body = $fields[$strTipoEmail.'body-es'];
    }
    else{
        $subject = $fields[$strTipoEmail.'subject-en'];
        $body = $fields[$strTipoEmail.'body-en'];       
    }

    //$folder = $fields['pdf-folder'] . 'facturas/';    
    /*/if ($carpeta!=''){
        $folder.=$carpeta;  
    }/*/
    $asipiPath = $_SERVER['DOCUMENT_ROOT'];
    $folder = $asipiPath.'wp-content/uploads/facturas/';    // $fields['pdf-folder'] .
    if ($carpeta!=''){
        $folder.=$carpeta;
    }
    

    $attachments = array($folder.$nombreArchivo);
    //var_dump($attachments);
    if( $tipoEmail == 1 || $tipoEmail == 2 || $tipoEmail == 8){
        //array_push($attachments, '/web_app/pdf/ASIPI-TDC-CC.pdf');
    }
    /*Reemplazo %%SOCIO%% de la plantilla por el nombre y apellido */
    $body = str_replace("%%SOCIO%%",$nombre,$body);
    /*Reemplazo %%Fecha%% de la plantilla por el año actual */
    $body = str_replace("%%FECHA%%",date("Y"),$body);
    $subject = str_replace("%%FECHA%%",date("Y"),$subject);
    $body = str_replace("%%EVENTO%%",$nombre_evento,$body);
    $subject = str_replace("%%EVENTO%%",$nombre_evento,$subject);
    $body = str_replace("%%HEADER%%",$header_factura,$body);
    $headers = array('Content-Type: text/html; charset=UTF-8','Reply-To: tesoreria@asipi.org');
    //$headers = 'From: no-reply@asipi.org'. "\r\n" . 'Content-Type: text/html; charset=UTF-8'. "\r\n" . 'Reply-To: tesoreria@asipi.org' . "\r\n" ;
    /*Envío el correo en formato html con los attachments*/
    //print_r($group_emails)
    //echo $body;exit();
    
    //$enviado = mail($destinatario, $subject, $body, $headers);
    //$enviado = wp_mail($destinatario, $subject, $body, $headers);
    $enviado = wp_mail($destinatario, $subject, $body, $headers, $attachments);
    //$enviado = wp_mail('sistemasbasalo@gmail.com', $subject, $body, $headers, $attachments);
    
    return $enviado;

}
?>