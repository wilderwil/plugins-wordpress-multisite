<?php
$asipiPath = $_SERVER['DOCUMENT_ROOT'];
require ( $asipiPath . '/wp-load.php');
global $wpdb;
global $blog_id;
$event_url = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave = 'url' and evento_id = $blog_id");

$lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;
$textos = array(
    'es' => array(
        'title' => 'Confirmación de registro',
        'msg_confirmacion' => 'Como Socio de ASIPI usted ya está registrado en el evento.  La información de acceso le será enviada en las semanas previas al evento.',
        'confirmation' => 'Reserva del Hotel Completada con exito.',  
        'gotohome' => 'Ir al Inicio',
        'receipt' => 'Ver Recibo'
    ), 
    'en' => array(
        'title' => 'Registration Confirmation',
        'msg_confirmacion' => 'As an ASIPI Member you are already registered in the event.  Login access will be sent a few days prior to the event.',
        'confirmation' => 'Registration Successfully Completed.', 
        'gotohome' => 'Go to Home',
        'receipt' => 'View receipt'
    ), 
);
?>

<div id="bloque-titulo">
    <div>
        <p><b><?php //echo $textos[$lang]['title'];?></b></p>
    </div>
    <br>
    <?php if($pago){?>
        <div class="alert alert-success" role="alert" style="font-size: 17px;">
            <?php echo __('<!--:es-->Reserva de habitación Completada con exito.<!--:--><!--:en-->Room Reservation Completed Successfully.<!--:-->') ?> 
        </div>
    <?php } else{ ?>
        <div class="alert alert-success" role="alert" style="font-size: 17px;">
            <?php echo __('<!--:es-->Estimado Participante:<br>Su solicitud de reserva está siendo procesada.<br>Confirmaremos la misma por esta vía luego de verificar disponibilidad con el hotel y le contactaremos por el pago.<!--:--><!--:en-->Dear Participant:<br>Your reservation request is being processed.<br> We will confirm it after verifying availability with the hotel and will contact you for payment.<!--:-->') ?> 
        </div>
    <?php } ?>

    <?php if( $_REQUEST['user_type']=='socio' ){ ?>

        <?php //echo '<p>'.$textos[$lang]['msg_confirmacion'].'</p>';?>
    <?php } ?>
    <?php /*if( $_REQUEST['tipo_asistencia']=='Presencial' or $_REQUEST['tipo_asistencia']=='Face to face'){ ?>
        <p>
            <?php echo __('<!--:es--><a href="https://asipi.org/congreso2021/wp-content/uploads/sites/25/2021/08/FORMULARIO_DE_SALUD_Y_SEGURIDAD_COVID_19_Esp-1.pdf"  target="_blank">Descargar</a><!--:--><!--:en--><a href="https://asipi.org/congreso2021/wp-content/uploads/sites/25/2021/08/HEALTH_AND_SAFETY_FORM.pdf" target="_blank">Download</a><!--:-->') ?> 
            <?php echo __("<!--:es--> Formulario de Salud<br>(Debe ser llenado y entregarlo en Secretaría del Evento)<!--:--><!--:en--> Health form<br>(It must be filled out and delivered to the Event Secretary)<!--:-->") ?>
        </p>
    <?php }*/ ?>
</div>
<div id="caja-registro" class="row" style="text-align: center;">
    
    <?php if($pago){?>
        <div class="grid-1-2">
            <a href="/asipi-helper/dlReceiptEvento.php?&data=<?php echo $code ?>" class="btn btn-comprar btn-lg btn-block" id="btn_recibo" target="_blank">
                <?php echo $textos[$lang]['receipt'];?>
            </a>
            
        </div>
    <?php } else{ ?>
        <div class="grid-1-2">
            <a href="/asipi-helper/dlInvoiceEvento.php?&data=<?php echo $code ?>" class="btn btn-comprar btn-lg btn-block" id="btn_recibo" target="_blank">
                <?php echo __("<!--:es-->Ver Factura<!--:--><!--:en-->View Invoice<!--:-->") ?>
            </a>

            
        </div>
    <?php } ?>

    <div class="grid-1-2">
        <br>
        <br>
        <a href="<?php echo $event_url ?>" class="btn btn-comprar btn-lg btn-block">
        <?php echo $textos[$lang]['gotohome'];?>
        </a>
    </div>
</div>