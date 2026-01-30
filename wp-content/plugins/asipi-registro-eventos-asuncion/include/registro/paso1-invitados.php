<br>
<div id="bloque-titulo">
    <h3 style="text-align: center"><?php echo __("<!--:es-->Registro<!--:--><!--:en-->Registration<!--:-->") ?></h3>
    <h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>
    <h5 style="font-size: x-large;"><?php echo __($descripcion_evento[$lang]) ?></b></h5>
    <!--<p style="font-size: 20px;"><b><a href="/costarica2022/planes-y-costos/" target="_blank"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></a></b></p>
    <img src="<?php echo __("<!--:es-->https://asipi.org/costarica2022/wp-content/uploads/sites/27/2022/05/Sold-out.jpg<!--:--><!--:en-->https://asipi.org/costarica2022/wp-content/uploads/sites/27/2022/05/Sold-out-EN.jpg<!--:-->") ?>" alt="sold-out">-->
</div>
<!--
<div class="alerta">
    <h2><?php echo __("<!--:es-->CUPO COMPLETO<!--:--><!--:en-->REGISTRATION AT FULL CAPACITY<!--:-->") ?></h2>
    <p><?php echo __("<!--:es-->En base a las medidas sanitarias requeridas y a la disponibilidad de la Sede, informamos que el cupo máximo de inscripciones al Evento ha sido alcanzado<!--:--><!--:en-->Based on the required sanitary measures and the availability of the Venue, we inform that the maximum number of registrations for the event has been reached.<!--:-->") ?></p>
</div>
-->
<style>
    .alerta{
        TEXT-ALIGN: center;
        background-color: #efe67a;
        padding: 15px;
        margin: 40px;
        color: #f00;
    }
    .alerta h2{
        color: #f00;
        font-weight: bold;
    }
</style>
<div class="container  paso1">
   <div class="four columns" style="padding-top: 0px" id="bloque-izquierdo">

</div>

    <div class="four columns" style="padding-top: 0px" id="">
        
        <!-- FORMULARIO GUEST -->
        <div id="guest" class="divform" style="display:block">
            <a href="" class="cambiar_plan">< Cambiar plan</a>
            <h1><?php echo $textos[$lang]['guest'] ?></h1>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-email-guest" class="form" action="javascript:veryfyGuest()">
                        <div class="form-group">
                            <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                            <input type="email" class="form-control" name="email_guest" id="email_guest" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                            <small id="emailHelp" class="form-text text-muted"></small>
                            <input type="hidden" id="typeLogin_guest" name="typeLogin_guest" value="verify">
                        </div>
                        <div class="coupon_code" style="display: none;">
                            <div class="form-group">
                                <label for="coupon_code"><?php echo $textos[$lang]['coupon'] ?></label>
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="<?php echo $textos[$lang]['enter_coupon'] ?>" >
                            </div>
                           
                        </div>
                        <div class="password_guest" style="display: none;">
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                <input type="password" class="form-control" name="password_guest" id="password_guest" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                            </div>
                            <div class="form-group">
                                <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                            </div>
                        </div>

                        <div class="newpassword_guest" style="display: none;">
                            <br>
                            <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>
                                <input type="password" class="form-control" name="newpassword_guest" id="newpassword_guest" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>
                                <input type="password" class="form-control" name="repeatpassword_guest" id="repeatpassword_guest" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>
                            </div>
                        </div>
                        <div id="mensajeError_guest" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="veryfy_guest"><?php echo $textos[$lang]['continue'] ?></a></div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="clear"></div>
</div>

<div class="row paso1">
    <div class="col-md-3" id="vacio"></div>
</div>

<div class="container">
    <div class="twelve columns">
        <div id="loadingimage" style="text-align:center;display:none;" ><img src="https://asipi.org/wp-content/uploads/2016/05/loading.gif"><p><?php if ($lang == 'en-US'): ?>Please wait...<?php else: ?>Por favor espere...<?php endif ?></p></div>
    </div>
</div>
<?php $event_url = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave = 'url' and evento_id = $blog_id"); ?>
<form action="<?php echo $event_url ?>registro-evento-recibo/" id="formSocio" method="post" hidden>
    <input type="hidden" value="" id="formSocio_id_usuario" name="id_usuario">
    <input type="hidden" value="socio" id="formSocio_user_type" name="user_type">
    <input type="hidden" value="0" id="formSocio_costo" name="costo">
    <input type="hidden" value="0" id="formSocio_saldoafavor" name="saldoafavor">
    <input type="hidden" value="0" id="formSocio_saldodeuda" name="saldodeuda">
    <input type="hidden" value="0" id="formSocio_email" name="email">
    <input type="hidden" value="0" id="formSocio_nombre" name="nombre[]">
    <input type="hidden" value="0" id="formSocio_apellido" name="nombre[]">
</form>

    <style>
    iframe{
        display:none;
    }
    .soldout{
        color: #f00;
        font-weight: bold;
    }
    .btn_waiting{
        background-color: #009e4a;
        padding: 10px;
        color: #fff;
    }
    </style>
    <?php require_once plugin_dir_path(__FILE__) . 'jotform.php'; ?>
    <?php echo do_shortcode( '[are_planesasuncion2025]' ); ?>
    <?php /* ?>
    <div class="container">
        <div class="twelve columns" style="text-align: justify;">
            <div class="cont_list">
                <p><b><?php echo $textos[$lang]['policies_title'] ?></b></p> 
                <?php if($lang!='en'){?>
                    <ul>
                        <li>Cancelaciones recibidas hasta el <b>15 de Octubre inclusive</b>, tendrán una devolución total menos un <b>10%</b> por gastos administrativos.**</li>
                        <li>Cancelaciones recibidas entre el <b>16 de Octubre al 7 de Noviembre inclusive</b>, tendrán una devolución del <b>50%. **</b></li>
                        <li>Cancelaciones recibidas a partir del <b>8 de noviembre, no tienen devolución.</b></li>
                        <li>En caso de obtener un resultado positivo de COVID-19 previo a su viaje al Evento, se realizará la devolución total de la inscripción contra la presentación de un certificado médico que confirme su estado.</li>
                    </ul>
                    <p>** Las devoluciones serán realizadas por la porción de la inscripción correspondiente únicamente a la participación en el evento. Por la porción de alojamiento, ver las condiciones de Hotel.</p>
                    <br>
                    <p><b>Cancelación del Evento por Parte de ASIPI:</b></p> 
                    <p>En caso que ASIPI considere conveniente postergar el evento para el año 2022, velando por la seguridad de sus participantes, el importe abonado por concepto de registro completo (inscripción + alojamiento), será honrado para la nueva fecha que se confirme el Congreso en la misma Sede el próximo año.</p>
                <?php }else{ ?>
                    <ul>
                        <li>Cancellations received until <b>October 15 inclusive</b>, will receive a total refund minus <b>10%</b> for administrative expenses. **</li>
                        <li>Cancellations received between <b>October 16 to November 7 inclusive</b>, will receive a <b>50%</b> refund. **</li>
                        <li>Cancellations received after <b>November 8</b>, will not be refunded.</li>
                        <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund of the registration will be made presenting a medical certificate confirming your status.</li>
                    </ul>
                    <p>** Refunds will be made for the portion of the registration corresponding only to participation in the event. For the accommodation portion, see the Hotel conditions.</p>
                    <br>
                    <p><b>HOTEL</b></p> 
                    <ul>
                        <li>ASIPI is not responsible for reservations, changes, hotel cancellation and/or any other matter related to the hotel regarding the attendees to the Event. All these issues should be dealt directly with Perspectiva M&T (booking@asipi.org).</li>
                        <li>Cancellations received between 60 to 31 days prior to check-in, a penalty of 10% of the total accommodation will be charged.</li>
                        <li>From 30 days prior to check-in, there is no refund.</li>
                        <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund of the registration will be made presenting a medical certificate confirming your status.</li>
                    </ul>
                    <br>
                    <p><b>Cancellation of The Event by ASIPI</b></p> 
                    <p>In the event that ASIPI considers convenient to postpone the event for the year 2022, ensuring the safety of its participants, the amount paid for full registration (registration + accommodation) will be honored for the new date of the Congress in the same venue next year.</p>
                
                <?php } ?>
            </div>
        </div>
    </div>
    <?php */ ?>

<style>
    .card-body {
        min-height: 178px !important;
    }
    .se-main-progress{
        display: none !important;
    }
</style>
<script>
    var tipo_asistencia='Presencial';
</script>


