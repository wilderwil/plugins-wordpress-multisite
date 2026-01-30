<br>panama

<div id="bloque-titulo">

    <h3 style="text-align: center"><?php echo __("<!--:es-->Registro Virtual<!--:--><!--:en-->Virtual Registration<!--:-->") ?></h3>

    <h4 style="font-size: x-large;"><?php echo __($nombre_evento[$lang]) ?></b></h4>

    <p style="font-size: 20px;"><b><a href="/quito2023/planes-y-costos/" target="_blank"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></a></b></p>

</div>

<div class="container  paso1">

    <div class="four columns" id="card_socio">

        <div class="card">

            <div class="card-header">

                <p><?php echo $textos[$lang]['member'] ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    <?php echo $textos[$lang]['free'] ?>

                </h1>

                <br>

                <!-- <a class="btn-comprar" id="btn_socio"><?php echo $textos[$lang]['register'] ?></a> -->

                <p class="card-text"><?php echo __("<!--:es-->Todos los socios al día con la cuota de membresía recibirán sus credenciales de acceso para la plataforma virtual unos días antes del evento<!--:--><!--:en-->All members up to date with the membership fee will receive their access credentials for the virtual platform a few days before the event<!--:-->") ?></p>

            </div>

        </div>

    </div>

    

    <!-- <div class="three columns" id="card_miembro">

        <div class="card">

            <div class="card-header">

                <p><?php echo $textos[$lang]['members_firm_tit'] ?></p>

            </div>



            <div class="card-body">

                <h1 class="card-title pricing-card-title">$<?php echo $costo_miembro?> <small class="text-muted"></small></h1>

                <br>

                <a class="btn-comprar" id="btn_miembro"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php echo $textos[$lang]['members_firm_nota'] ?><br></p>

            </div>

        </div>

    </div> -->



    <div class="four columns" id="card_nosocio">

        <div class="card">

            <div class="card-header">

                <p><?php echo $textos[$lang]['non_member'] ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    US$ <?php echo $costos['non_member_virtual_full_price']?>

                </h1>

                <br>

                <a class="btn-comprar" id="btn_nosocio"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php echo __("<!--:es--><!--:--><!--:en--><!--:-->") ?></p>

            </div>

        </div>

    </div>

    <div class="four columns" id="card_student">

        <div class="card">

            <div class="card-header">

                <p><?php echo $textos[$lang]['student'] ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    US$<?php echo $costos['student_virtual_full_price']?>

                </h1>

                <br>

                <a class="btn-comprar" id="btn_student"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php echo $textos[$lang]['student_nota'] ?></p>

            </div>

        </div>

    </div>



    <div class="four columns" id="card_guest">

        <div class="card">

            <div class="card-header">

                <p><?php echo $textos[$lang]['guest'] ?></p>

            </div>

            <div class="card-body">

                <h1 class="card-title pricing-card-title">

                    US$<?php echo $costos['guest_virtual_full_price']?>

                </h1>

                <br>

                <a class="btn-comprar" id="btn_guest"><?php echo $textos[$lang]['register'] ?></a>

                <p class="card-text"><?php echo $textos[$lang]['guest_nota'] ?></p>

            </div>

        </div>

    </div>



    <div class="six columns" style="padding-top: 0px" id="bloque-izquierdo">

        <!-- FORMULARIO SOCIO -->

        <div id="socio" class="divform">

            <h1><?php echo $textos[$lang]['member'] ?></h1>

            <div class="row">

                <div class="col-md-12">

                    <form id="form-verify-socios" class="form" action="javascript:verifySocio()">                            

                        <div class="form-group">

                            <label for="email_socio"><?php echo $textos[$lang]['enter_email_asipi'] ?></label>

                            <input type="email" class="form-control" name="email_socio" id="email_socio" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">

                            <small id="emailHelp" class="form-text text-muted"></small>

                        </div>

                        <div class="form-group">

                            <label for="password"><?php echo $textos[$lang]['password'] ?></label>

                            <input type="password" class="form-control" id="password" placeholder="<?php echo $textos[$lang]['password'] ?>" required>

                        </div>

                        <div class="form-group">

                            <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>

                        </div>

                        <div id="mensajeErrorLogin" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>

                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="verifySocio"><?php echo $textos[$lang]['continue'] ?></a></div>

                    </form>

                </div>

            </div>

        </div>



        <!-- FORMULARIO MIEMBRO DE FIRMA -->

        <div id="miembro" class="divform">

            <h1><?php echo $textos[$lang]['member_firm_tit_form'] ?></h1>

            <div class="row">

                <div class="col-md-12">

                    <form id="form-verify-miembros" class="form" action="javascript:veryfyMiembro()">                        

                        <div class="form-group">

                            <label for="email_miembro"><?php echo $textos[$lang]['please_enter_email'] ?></label>

                            <input type="email" class="form-control" name="email_miembro" id="email_miembro" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">

                            <small id="emailHelp" class="form-text text-muted"></small>

                        </div>    

                        <div class="form-group">

                            <label for="email"><?php echo $textos[$lang]['please_enter_email_asipi_nota'] ?></label>

                            <input type="email" class="form-control" name="email_fiador" id="email_fiador" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['please_enter_email_asipi'] ?>">

                            <small id="emailHelp" class="form-text text-muted"></small>

                        </div>

                        <div class="form-group">

                            <label for="company"><?php echo $textos[$lang]['company'] ?></label>

                                <select type="select" name="company" id="company" class="form-control">

                                    <option value=""><?php echo $textos[$lang]['select_company'] ?></option>

                                    <?php

                                    foreach ($queryResult as $key => $value) {

                                        ?>

                                        <option value="<?php echo $value['value']?>"><?php echo $value['value']?></option>

                                        <?php

                                    }

                                    ?>

                                </select>

                        </div>

                        <div class="form-group" id="olvidoC">

                        </div>

                        <div id="mensajeErrorMiembro" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>

                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="veryfyMiembro"><?php echo $textos[$lang]['continue'] ?></a></div>

                    </form>

                </div>

            </div>

        </div>



        <!-- FORMULARIO NO SOCIO -->

        <div id="nosocio" class="divform">

            <a href="" class="cambiar_plan">< Cambiar plan</a>

            <h1><?php echo $textos[$lang]['non_member'] ?></h1>

            <div class="row">

                <div class="col-md-12">

                    <form id="form-verify-email-nosocio" class="form" action="javascript:veryfyNoSocio()">

                        <div class="form-group">

                            <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>

                            <input type="email" class="form-control" name="email_nosocio" id="email_nosocio" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">

                            <small id="emailHelp" class="form-text text-muted"></small>

                            <input type="hidden" id="typeLogin_nosocio" name="typeLogin_nosocio" value="verify">

                        </div>

                        <div class="password_nosocio" style="display: none;">

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['password'] ?></label>

                                <input type="password" class="form-control" name="password_nosocio" id="password_nosocio" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>

                            </div>

                            <div class="form-group">

                                <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>

                            </div>

                        </div>

                        <div class="newpassword_nosocio" style="display: none;">

                            <br>

                            <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>

                                <input type="password" class="form-control" name="newpassword_nosocio" id="newpassword_nosocio" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>

                            </div>

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>

                                <input type="password" class="form-control" name="repeatpassword_nosocio" id="repeatpassword_nosocio" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>

                            </div>

                        </div>

                        <div id="mensajeError_nosocio" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>

                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="veryfy_nosocio"><?php echo $textos[$lang]['continue'] ?></a></div>

                    </form>

                </div>

            </div>

        </div>



        <!-- FORMULARIO ESTUDIANTE -->

        <div id="student" class="divform">

            <a href="" class="cambiar_plan">< Cambiar plan</a>

            <h1><?php echo $textos[$lang]['student'] ?></h1>

            <div class="row">

                <div class="col-md-12">

                    <form id="form-verify-email-student" class="form" action="javascript:veryfyStudent()">

                        <div class="form-group">

                            <label for="email_student"><?php echo $textos[$lang]['please_enter_email'] ?></label>

                            <input type="email" class="form-control" name="email_student" id="email_student" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">

                            <small id="emailHelp" class="form-text text-muted"></small>

                            <input type="hidden" id="typeLogin_student" name="typeLogin_student" value="verify">

                        </div>

                        <div class="password_student" style="display: none;">

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['password'] ?></label>

                                <input type="password" class="form-control" name="password_student" id="password_student" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>

                            </div>

                            <div class="form-group">

                                <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>

                            </div>

                        </div>

                        <div class="newpassword_student" style="display: none;">

                            <br>

                            <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>

                                <input type="password" class="form-control" name="newpassword_student" id="newpassword_student" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>

                            </div>

                            <div class="form-group">

                                <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>

                                <input type="password" class="form-control" name="repeatpassword_student" id="repeatpassword_student" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>

                            </div>

                        </div>

                        <div id="mensajeError_student" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>

                        <div class="espacio-boton"><br><a type="submit" class="btn-comprar" id="veryfy_student"><?php echo $textos[$lang]['continue'] ?></a></div>

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



    <?php require_once plugin_dir_path(__FILE__) . 'jotform.php'; ?>



    <div class="container">

        <div class="twelve columns" style="text-align: justify;">

            <div class="cont_list">

                <p><b><?php echo $textos[$lang]['policies_title'] ?></b></p> 

                <?php if($lang!='en'){ ?>

                    <ul>

                        <li>Cancelaciones recibidas hasta el <b>15 de Octubre inclusive</b>, tendrán una devolución total menos un <b>10%</b> por gastos administrativos.**</li>

                        <li>Cancelaciones recibidas entre el <b>16 de Octubre al 7 de Noviembre inclusive</b>, tendrán una devolución del <b>50%. **</b></li>

                        <li>Cancelaciones recibidas a partir del <b>8 de noviembre, no tienen devolución.</b></li>

                    </ul>

                    <br>

                    <p><b>Cancelación del Evento por Parte de ASIPI:</b></p> 

                    <p>En caso que ASIPI considere conveniente postergar el evento para el año 2022, velando por la seguridad de sus participantes, el importe abonado por concepto de registro completo (inscripción + alojamiento), será honrado para la nueva fecha que se confirme el Congreso en la misma Sede el próximo año.</p>

                <?php }else{ ?>

                    <ul>

                        <li>Cancellations received until <b>October 15 inclusive</b>, will receive a total refund minus <b>10%</b> for administrative expenses. **</li>

                        <li>Cancellations received between <b>October 16 to November 7 inclusive</b>, will receive a <b>50%</b> refund. **</li>

                        <li>Cancellations received after <b>November 8</b>, will not be refunded.</li>

                    </ul>

                    <br>

                    <p><b>Cancellation of The Event by ASIPI</b></p> 

                    <p>In the event that ASIPI considers convenient to postpone the event for the year 2022, ensuring the safety of its participants, the amount paid for full registration (registration + accommodation) will be honored for the new date of the Congress in the same venue next year.</p>

                <?php } ?>

            </div>

        </div>

    </div>

<style>

    iframe{

        display:none;

    }

    .card-body {

        min-height: 170px !important;

    }

</style>

<script>

    var tipo_asistencia='Virtual';

</script>









