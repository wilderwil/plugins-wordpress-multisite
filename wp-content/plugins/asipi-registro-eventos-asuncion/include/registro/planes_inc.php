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

    <p><?php echo __('<!--:es--> Traslados no están incluido en el registro. Para contratar este servicio hacer <a href="/asuncion2026/traslados/" target="_blank">click aquí</a><!--:--><!--:en--> Transfers are not included in the registration. To hire this service  <a href="/asuncion2026/traslados/" target="_blank">click here</a><!--:-->') ?></p>

    <br>

    <h2 style="text-align: center;"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></h2>

    <div class="twelve columns">

        <div class="subtitulo">

            <h3><?php echo __("<!--:es-->Participación Presencial<!--:--><!--:en-->Face-to-face Participation<!--:--><!--:pb-->Participación Presencial<!--:-->") ?></h3>

            <p><?php echo __("<!--:es-->Cupos limitados<!--:--><!--:en-->Limited places<!--:--><!--:pb-->Cupos limitados<!--:-->") ?></p>

        </div>

    </div>

    <div class="col twelve columns">

        <div class="caja">

            <table class="table">

                <thead>

                    <tr>

                        <th scope="col"><?php echo __("") ?></th>

                        <th scope="col"><?php echo __("<!--:es-->Early Bird: 25 de Abril<!--:--><!--:en-->Early bird: April 25th<!--:-->") ?></th>

                        <th scope="col"><?php echo __("<!--:es-->Tarifa Full<!--:--><!--:en-->Tarifa Full<!--:-->") ?></th>

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

                        <td>US$ <?php echo $costos['member_doble_early_bird_price'];?></td>

                        <td>US$ <?php echo $costos['member_doble_full_price'];?></td>

                    </tr>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Acompañante<!--:--><!--:en-->Companion<!--:--><!--:pb-->Pessoa acompanhante<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    

    <div class="twelve columns">

        <div class="col six columns">

            <?php if($lang!='en'){?>

                <div class="cont_list">

                    <h3><?php echo __("<!--:es-->¿Qué Incluye la inscripción?<!--:--><!--:en-->What does the inscription include?<!--:--><!--:pb-->¿Que Incluye la inscripción?<!--:-->") ?></h3>

                    <ul>

                        <li>Acceso a la Plenaria.</li>

                        <li>Material del Seminario.</li>

                        <li>Alimentación: Coffee break am y pm, standing lunch - 6 y 7 de Junio.</li>

                        <li>Actividades Sociales: Coctel de Inauguración - 5 de Junio.</li>

                        <li>Coctel de los Estudios - 6 de Junio.</li>

                        <li>Sunset - 7 de Junio.</li>

                        <li>ASIPI FIT: Yoga - 7 de Junio.</li>

                    </ul>

                    <!-- <p>* <b>Nota</b>: En caso de dar positivo durante el evento, será aislado en una habitación private pool por 14 noches. Las 14 noches son sin costo, a partir de la fecha prevista del check out original. Se le incluye comidas y bebidas a la habitación. Se le otorgará kit de limpieza personal, pero el personal del Hotel no podrá ingresar a la habitación para realizar la limpieza de la misma. Tendrá la opción de poder quedar en la habitación con un acompañante también en cortesía, sin éste poder salir de la habitación hasta que no finalice la cuarentena. A los 14 días al realizarse un nuevo PCR (a costo del pasajero), si da negativo podrá realizar el check out, en caso de dar positivo nuevamente, el hotel le brindará una tarifa especial para la siguiente cuarentena.</p> -->

                </div>

            <?php }else{ ?>

                <div class="cont_list">

                    <h3><?php echo __("<!--:es-->¿Qué Incluye la inscripción?<!--:--><!--:en-->What does the inscription include?<!--:--><!--:pb-->¿Que Incluye la inscripción?<!--:-->") ?></h3>

                    <ul>

                        <li>Access to conferences.</li>

                        <li>Seminar Material.</li>

                        <li>Food: Coffee break am and pm, standing lunch - June 6 and 7.</li>

                        <li>Social Activities: Opening Cocktail - June 5.</li>

                        <li>Local Law Firm Cocktail - June 6.</li>

                        <li>Sunset - June 7.</li>

                        <li>ASIPI FIT: Yoga - June 7.</li>

                    </ul>

                    <!-- <p>* <b>Nota</b>: En caso de dar positivo durante el evento, será aislado en una habitación private pool por 14 noches. Las 14 noches son sin costo, a partir de la fecha prevista del check out original. Se le incluye comidas y bebidas a la habitación. Se le otorgará kit de limpieza personal, pero el personal del Hotel no podrá ingresar a la habitación para realizar la limpieza de la misma. Tendrá la opción de poder quedar en la habitación con un acompañante también en cortesía, sin éste poder salir de la habitación hasta que no finalice la cuarentena. A los 14 días al realizarse un nuevo PCR (a costo del pasajero), si da negativo podrá realizar el check out, en caso de dar positivo nuevamente, el hotel le brindará una tarifa especial para la siguiente cuarentena.</p> -->

                </div>

            <?php } ?>

        </div>

        <div class="col six columns">

            <?php if($lang!='en'){?>

                <div class="cont_list">

                    <h3>Políticas de Cancelación</h3>

                    <ul>

                        <li>Cancelaciones recibidas antes del <b>25 de Abril</b>, tendrán una devolución  del <b>50%</b>.**</li>

                        <li>Cancelaciones recibidas hasta el <b>22 de Mayo</b>, tendrán una devolución del <b>10%</b>**</li>

                    </ul>

                    <p>** Las devoluciones que realice ASIPI corresponde exclusivamente al pago por el registro en el evento y no por alojamiento, en cuyo caso deben observarse las condiciones establecidas por el Hotel</p>

                </div>

            <?php }else{ ?>

                <div class="cont_list">

                    <h3>Cancellation Policy</h3>

                    <ul>

                        <li>Cancellations received until <b>April 25 inclusive</b>, will receive a total refund minus <b>50%</b> for administrative expenses. **</li>

                        <li>Cancellations received until <b>May 22</b>, will receive a <b>10%</b> refund. **</li>

                    </ul>

                    <p>** The refunds made by ASIPI correspond exclusively to the event registration and not for accommodation, in which case the conditions established by the Hotel must be observed.</p>

                </div>

            <?php } ?>

        </div>

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

        border-bottom: 1px solid #009e4a;

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

        background-color: #009e4a;

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

            padding: 10px 0px;

            font-size: 14px;

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

</style>

