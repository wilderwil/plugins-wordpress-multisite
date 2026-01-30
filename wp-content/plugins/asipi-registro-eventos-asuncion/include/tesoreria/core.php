<?php 
    //var_dump($data);exit();
	global $wpdb;
	if ($_GET['new']) { 
        require_once 'nuevo_registro.php';
        exit();
    }
    if (isset($_POST['email'])) {
    	//var_dump($_POST);exit();
        include(plugin_dir_path(__DIR__) .'registro/registrar.php');
        //$numero='';
        $tipo='file';
        //include(plugin_dir_path(__DIR__) .'invoice/dlInvoice.php');
        echo '<div class="updated notice">
			Nuevo Registro completado con exito. <br>
			<a href="/asipi-helper/cursos/dlInvoice.php?numero='.$numero.'&tipo=invoice" class="btn-comprar" target="_blank">Ver y enviar Recibo</a>
		</div>';
    }
	if ($_GET['del'] and $_GET['del']>=0) { 
		$Delete = "UPDATE asipi_cursos_registros SET estado = '0' WHERE id = '".$_GET['del']."'";
		$queryResult = $wpdb->get_results($Delete);
		echo '<div class="updated notice">
			Registro "'.$_GET['del'].'" eliminado con exito.
		</div>';
    }  
    if ($_GET['new']) { 
        require_once 'nuevo_registro.php';
        exit();
    }
    if ($_GET['certificado'] or $_POST['certificado']) { 
        require_once 'enviar_certificado.php';
        //exit();
    }
    if ($_GET['config']) { 
        require_once 'config_lista.php';
        //exit();
    }
    require_once 'lista_registros.php';
 ?>