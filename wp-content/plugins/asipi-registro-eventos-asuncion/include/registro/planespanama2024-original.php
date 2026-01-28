<?php 

$asipiPath = $_SERVER['DOCUMENT_ROOT'];

require ( $asipiPath . '/wp-load.php');

global $wpdb;

global $blog_id;
$lang = qtranxf_getLanguage();
$sql = "SELECT * FROM evento_meta where evento_id = '$blog_id'";
$qryEvento = $wpdb->get_results($sql);
$qryEvento = json_decode(json_encode($qryEvento), true);
$costos = array();

foreach ($qryEvento as $key => $value) {
    $posicion_coincidencia = strpos($value['clave'], '_price');
    //se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
    if ($posicion_coincidencia !== false) {
        $costos[$value['clave']] = $value['valor'];
    }
}
?>
<div class="container">
    <br>
     <br>
    <h2 style="text-align: center;"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></h2>
    <div class="twelve columns">
        <div class="subtitulo">
            <!-- <h3><?php echo __("<!--:es-->Participación Presencial<!--:--><!--:en-->Face-to-face Participation<!--:--><!--:pb-->Participación Presencial<!--:-->") ?></h3>
            <p><?php echo __("<!--:es-->Cupos limitados<!--:--><!--:en-->Limited places<!--:--><!--:pb-->Cupos limitados<!--:-->") ?></p> -->
        </div>
    </div>
    <div class="col twelve columns">
        <div class="caja">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"><?php echo __("") ?></th>
                        <th class="title1" scope="col"><?php echo __('<!--:es-->Early Bird:<br>hasta el 25 de abril<br> <span style="font-size:12px;">(12pm hora EST. USA)</span><!--:--><!--:en-->Early bird:<br>until April 25  <br><span style="font-size:12px;">(12pm US Eastern Time)</span><!--:-->') ?></th> 
                        <th class="title1" scope="col"><?php echo __("<!--:es-->Tarifa Full:<br>hasta el 24 de mayo<!--:--><!--:en-->Full Price:<br>until May 18<!--:-->") ?></th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Socio<!--:--><!--:en-->Member<!--:--><!--:pb-->Socio<!--:-->") ?></td>
                        <td>US$ <?php echo $costos['member_simple_early_bird_price'];?></td>
                        <td>US$ <?php echo $costos['member_simple_full_price'];?></td>

                    </tr>
                    <tr>
                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->No Socio<!--:--><!--:en-->Non Member<!--:--><!--:pb-->Não Membro<!--:-->") ?></td>
                        <td>US$ <?php echo $costos['non_member_simple_early_bird_price'];?></td>
                        <td>US$ <?php echo $costos['non_member_simple_full_price'];?></td>

                    </tr>
                    <tr>
                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Acompañante<!--:--><!--:en-->Companion<!--:--><!--:pb-->Pessoa acompanhante<!--:-->") ?></td>
                        <td>US$ <?php echo $costos['companion_doble_early_bird_price'];?></td>
                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                    </tr>
                    <tr>
                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Estudiantes<!--:--><!--:en-->Student<!--:--><!--:pb-->Não Membro<!--:-->") ?></td>
                        <td>US$ <?php echo $costos['student_simple_early_bird_price'];?></td>
                        <td>US$ <?php echo $costos['student_simple_full_price'];?></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        <div class="twelve columns">
            <div class ="caja">
             <?php if($lang!='en'){?>
             <p>Quien desee registrarse a partir del 25 de mayo deberá realizarlo en forma presencial en el Evento, manteniéndose la tarifa FULL.</p>
              <h3 class="title_wight"><?php echo __("<!--:es-->Acompañante<!--:--><!--:en-->Companion<!--:--><!--:pb-->Acompañante<!--:-->") ?></h3>
                   <p>Podrán registrarse bajo esta categoría cualquier persona que no sea socia de ASIPI, que no se dedique a la práctica de Propiedad Intelectual y/o que no forme parte de la misma firma o empresa del participante principal.</p>
             <h3 class="title_wight"><?php echo __("<!--:es-->Descuento Especial<!--:-->") ?></h3>
                   <p>A partir del cuarto inscrito de una misma firma se aplicará un descuento del 20% sobre la tarifa que corresponda (socio o no socio). El primero, segundo y tercer participante de una misma firma pagarán tarifa completa.
<br/><br/>Para obtener la aplicación de este descuento, los interesados deberán ponerse en contacto directo con nuestra Tesorería <a href="mailto:tesoreria@asipi.org">(tesoreria@asipi.org)</a>, quien se encargará de procesar el/los registro(s).</p>
             
                <?php }else{ ?>
                <p>Those who wish to register after May 25 must do so in person at the event, maintaining the full rate.</p>
                 <h3 class="title_wight"><?php echo __("<!--:es-->Acompañante<!--:--><!--:en-->Companion<!--:--><!--:pb-->Acompañante<!--:-->") ?></h3>
                <p>Anyone who is not a member of ASIPI, is not engaged in the practice of Intellectual Property and is not part of the same firm or company of the main participant, can register under this category.</p>
                <h3 class="title_wight"><?php echo __("<!--:en-->Special discount<!--:--><!--:pb-->Special discount<!--:-->") ?></h3>
                   <p>Starting with the fourth participant of the same firm a 20% discount will be applied on the corresponding rate (member or non member). The first, second and third participant of the same firm will pay the full rate.
<br/><br/>Those interested in obtaining this discount, please contact our Treasury <a href="mailto:tesoreria@asipi.org">(tesoreria@asipi.org)</a>, who will be in charge of processing the registration(s).</p>

                <?php } ?>
            </div>
        </div>
    
    
    <div class="twelve columns">
        <div class="col six columns">
            <?php if($lang!='en'){?>
                <div class="cont_list">
                    <h3 class="title1"><?php echo __("<!--:es-->¿Qué incluye la inscripción?<!--:--><!--:en-->What does registration include?<!--:--><!--:pb-->What does registration include?<!--:-->") ?></h3>
                    <ul>
                        <li>Área académica:
                            <ul>
                                <li>Plenarias del 2,3 y 4 de diciembre.</li>
                                <li>Material del evento.</li>
                            </ul>
                        </li>
                        <li>Alimentación: 
                            <ul>
                                <li>Servicio de café permanente del 2 al 5 de diciembre en áreas del evento.</li>
                                <li>Almuerzo y coffee breaks del 1 de diciembre, en caso que usted participe en las reuniones de Consejo de Administración y Comités de Trabajo/Programas Especiales.</li>
                                <li>Coffee breaks del 2,3 y 4 de diciembre.</li>
                                <li>Almuerzo del 2,3 y 4 de diciembre.</li>
                            </ul>
                        </li>
                        <li>Área social:
                            <ul>
                                <li>Domingo 2 de junio: Cóctel de Inauguración en el Convento Capuchinas.</li>
                                <li>Lunes 3 de junio: Cóctel de los Estudios en Tenedor del Cerro Santo Domingo.</li>
                                <li>Martes 4 de junio: Cierre del Evento con un After en Jardines del Hotel Casa Santo Domingo.</li>
                            </ul>
                        </li>
                        <li>Reuniones:
                            <ul>
                                <li>Área de Networking con servicio de café del 2 al 5 de diciembre.</li>
                                <li> Acceso a la exposición comercial.</li>

                            </ul>
                        </li>
                    </ul>
                    </div>
            <?php }else{ ?>
                <div class="cont_list">
                    <h3 class="title1"><?php echo __("<!--:es-->¿Qué incluye la inscripción?<!--:--><!--:en-->What does registration include?<!--:--><!--:pb-->¿Que Incluye la inscripción?<!--:-->") ?></h3>
  <ul>
                        <li>Academic Area:
                            <ul>
                                <li>Plenary sessions on June 3 and 4.</li>
                                <li>Event material.</li>
                            </ul>
                        </li>
                        <li>Meals: 
                            <ul>
                                <li>Permanent coffee service from June 2 to 4  in the event areas.</li>
                                <li>Lunch and coffee breaks on June 2, in case you participate in the Administrative Council meeting and Working Committees/Special Programs meeting.</li>
                                <li>Coffee breaks on June 3 and 4.</li>
                                <li>Lunch on June 3 and 4.</li>
                            </ul>
                        </li>
                        <li>Social Area:
                            <ul>
                                <li>Sunday June 2:  Opening Cocktail at the Convento Capuchinas.</li>
                                <li>Monday June 3: Local Law Studios Cocktail party at the Tenedor del Cerro Santo Domingo.</li>
                                <li>Tuesday June 4: Event closing with an After in the gardens of the Hotel Casa Santo Domingo.</li>
                            </ul>
                        </li>
                        <li>Networking:
                            <ul>
                                <li>Networking area with coffee service from June 2 to 4.</li>
                                <li>Access to the Commercial exhibition.</li>

                            </ul>
                        </li>
                    </ul>
                
                  <!--  <h3>Accommodation cancellation policies</h3>
                    <ul>
                        <li>Cancellations received until <b>October 28</b>, will have a full refund except <b>10%</b> of the total stay, for administrative expenses</li>
                        <li>Cancellations received until <b>November 20</b>, will have a <b>50%</b> refund</li>
                        <li>Cancellations received from <b>November 21</b>, do not have a refund</li>
                    </ul> -->
                    </div>
            <?php } ?>
        </div>
        <div class="col six columns">
            <?php if($lang!='en'){?>
                <div class="cont_list">
                    <h3 class="title1">Inscripción acompañante</h3>
                    <ul>
                        <li>Área social:
                            <ul>
                                <li>Domingo 2 de junio: Cóctel de Inauguración en el Convento Capuchinas.</li>
                                <li>Lunes 3 de junio: Cóctel de los Estudios en Tenedor del Cerro Santo Domingo.</li>
                                <li>Martes 4 de junio: Cierre del Evento con un After en Jardines del Hotel Casa Santo Domingo.</li>
                            </ul>
                        </li>
                    </ul> 
                    <h3 class="title1">Inscripción estudiante</h3>
                    <ul>
                        <li>Área académica:
                            <ul>
                                <li>Plenarias del 3 y 4 de junio.</li>
                            </ul>
                        </li>
                        <li>Alimentación: 
                            <ul>
                                <li>Coffee breaks del 3 y 4 de junio.</li>
                            </ul>
                        </li>
                    </ul> 
                   
                    <!-- <p>* <b>Nota</b>: En caso de dar positivo durante el evento, será aislado en una habitación private pool por 14 noches. Las 14 noches son sin costo, a partir de la fecha prevista del check out original. Se le incluye comidas y bebidas a la habitación. Se le otorgará kit de limpieza personal, pero el personal del Hotel no podrá ingresar a la habitación para realizar la limpieza de la misma. Tendrá la opción de poder quedar en la habitación con un acompañante también en cortesía, sin éste poder salir de la habitación hasta que no finalice la cuarentena. A los 14 días al realizarse un nuevo PCR (a costo del pasajero), si da negativo podrá realizar el check out, en caso de dar positivo nuevamente, el hotel le brindará una tarifa especial para la siguiente cuarentena.</p> -->
    
                </div>
            <?php }else{ ?>
                <div class="cont_list">
                      <h3 class="title1">Companion registration</h3>
                      <ul>
                        <li>Social Area:
                            <ul>
                                 <li>Sunday June 2:  Opening Cocktail at the Convento Capuchinas.</li>
                                <li>Monday June 3: Local Law Studios Cocktail party at the Tenedor del Cerro Santo Domingo.</li>
                                <li>Tuesday June 4: Event closing with an After in the gardens of the Hotel Casa Santo Domingo.</li>
                            </ul>
                        </li>
                    </ul> 

                    <h3 class="title1">Student registration</h3>
                    <ul>
						 <li>Academic Area:
                            <ul>
                                <li>Access to the Plenary - June 3 and 4.</li>
                            </ul>
                        </li>
                        <li>Meals: 
                            <ul>
                                <li>Coffee Break - June 3 and 4.</li>
                            </ul>
                        </li>
                        
                    </ul> 
                    <!-- <p>* <b>Nota</b>: En caso de dar positivo durante el evento, será aislado en una habitación private pool por 14 noches. Las 14 noches son sin costo, a partir de la fecha prevista del check out original. Se le incluye comidas y bebidas a la habitación. Se le otorgará kit de limpieza personal, pero el personal del Hotel no podrá ingresar a la habitación para realizar la limpieza de la misma. Tendrá la opción de poder quedar en la habitación con un acompañante también en cortesía, sin éste poder salir de la habitación hasta que no finalice la cuarentena. A los 14 días al realizarse un nuevo PCR (a costo del pasajero), si da negativo podrá realizar el check out, en caso de dar positivo nuevamente, el hotel le brindará una tarifa especial para la siguiente cuarentena.</p> -->

                </div>
            <?php } ?>
        </div>
    </div>

      
        <div class="col twelve columns">
            <?php if($lang!='en'){?>
                <div class="cont_list">
                      <h3 class="title1">Políticas de Cancelación</h3>
                    <ul>
                        <li>Cancelaciones recibidas antes del <b>25 de marzo</b>, tendrán una devolución del <b>50%</b>.**</li>
                        <li>Cancelaciones recibidas hasta el <b>17 de mayo</b>, tendrán una devolución del <b>10%</b>**</li>
                    </ul>
                      <p class="p-weight">** Las devoluciones que realice ASIPI corresponde exclusivamente al pago por el registro en el evento y no por alojamiento, en cuyo caso deben observarse las condiciones establecidas por el Hotel</p>
                </div>
            <?php }else{ ?>
                <div class="cont_list">
                 
                    <h3 class="title1">Registration cancellation policies</h3>
                    <ul>
                        <li>Cancellations received before <b>March 25</b>, will have a <b>50%</b> refund **</li>
                        <li>Cancellations received until <b>May 19</b>, will have a <b>10%</b> refund **</li>
                    </ul>
                            <p class="p-weight">** Refunds from ASIPI only apply to registration fees to the event and not for accommodation, in which case the conditions established by the Hotel must be observed.</p>
                
              
                </div>
            <?php } ?>
        </div>
       
</div>

<style>
    h1, h2, h3, h4, h5, h6 {
        font-family: "Raleway";
    }
    .nota_presencial{
        text-align: justify;
    }
    .cont_list{
        padding: 30px;
        text-align: justify;
    }
    .dl_formsalud{
        text-align: right;
    }
    .dl_formsalud small{
        font-size: small;
    }
    .cont_list h3{
        text-align: center;
        border-bottom: 1px solid #001E48;
        line-height: 60px;
        font-size: large;
    }
    .subtitulo{
        text-align: center;
        margin-top: 40px;
        margin-bottom: 15px;
    }
    .caja{
        margin-bottom: 15px;
        padding: 45px;
    }
    .descripcion_plan{
        text-align: left;
        padding-left: 30px;
        width: 50%;
    }
    .container h2{
        font-size: 36px;
        margin-bottom: 0px;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1;
        letter-spacing: 4px;
        padding: 30px;
    }
    table tr th {
        background-color: #001E48;
    }

    @media (max-width: 768px) {
        .container h2 {
            font-size: 22px;
            line-height: 0;
            padding: 0px;

        }
        .table {
            font-size: 12px;
        }
        .table tr th {
            padding: 10px 5px;
            font-size: 11px;
        }
        .descripcion_plan {
            text-align: left;
            padding-left: 15px;
            width: auto;
        }
        .table tr td {
            padding: 15px;
        }
        ul, ol {
            margin-bottom: 20px;
            margin-left: 15px;
        }
    }
    .col{
        min-width: 200px;
    }
    .caja {
            padding: 18px;
    }
</style>
