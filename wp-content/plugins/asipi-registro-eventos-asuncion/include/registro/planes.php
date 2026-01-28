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

    <h2 style="text-align: center;"><?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?></h2>

    <div class="twelve columns">

        <div class="subtitulo">

            <p class="dl_formsalud">

                <?php echo __('<!--:es--><a href="https://asipi.org/congreso2021/wp-content/uploads/sites/25/2021/08/FORMULARIO_DE_SALUD_Y_SEGURIDAD_COVID_19_Esp-1.pdf" target="_blank">Descargar</a><!--:--><!--:en--><a href="https://asipi.org/congreso2021/wp-content/uploads/sites/25/2021/08/HEALTH_AND_SAFETY_FORM.pdf" target="_blank">Download</a><!--:-->') ?> 

                <?php echo __("<!--:es--> Formulario de Salud<!--:--><!--:en--> Health form<!--:-->") ?>

                <small><?php echo __("<!--:es--> <br>(Debe ser llenado y entregado en Secretaría del Evento)<!--:--><!--:en--> <br>(It must be filled out and delivered to the Event Secretary)<!--:-->") ?></small>

            </p>

            <h3><?php echo __("<!--:es-->Participación Presencial<!--:--><!--:en-->Face-to-face Participation<!--:--><!--:pb-->Participación Presencial<!--:-->") ?></h3>

            <p><?php echo __("<!--:es-->Cupos limitados<!--:--><!--:en-->Limited places<!--:--><!--:pb-->Cupos limitados<!--:-->") ?></p>

        </div>

    </div>

    <div class="col twelve columns">

        <div class="caja">

            <table class="table">

                <thead>

                    <tr>

                        <th scope="col"><?php echo __("<!--:es-->Socio<!--:--><!--:en-->Member<!--:--><!--:pb-->Socio<!--:-->") ?></th>

                        <th scope="col"><?php echo __("<!--:es-->Early bird hasta el 24/09/2021<!--:--><!--:en-->Early bird until 09/24/2021<!--:-->") ?></th>

                        <th scope="col"><?php echo __("<!--:es-->Precio Full desde 25/09/2021<!--:--><!--:en-->Full Price from 09/25/2021<!--:-->") ?></th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Socio - Hab. Sencilla<!--:--><!--:en-->Member - Single Room<!--:--><!--:pb-->Socio - Hab. Sencilla<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['member_simple_early_bird_price'];?></td>

                        <td>US$ <?php echo $costos['member_simple_full_price'];?></td>

                    </tr>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Socio - Hab. Doble<!--:--><!--:en-->Member - Double Room<!--:--><!--:pb-->Socio - Hab. Doble<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['member_doble_early_bird_price'];?></td>

                        <td>US$ <?php echo $costos['member_doble_full_price'];?></td>

                    </tr>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Acompañante - Hab. Doble<!--:--><!--:en-->Companion - Double Room<!--:--><!--:pb-->Acompañante - Hab. Doble<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="col twelve columns">

        <div class="caja">

            <table class="table">

                <thead>

                    <tr>

                    <th scope="col"><?php echo __("<!--:es-->No Socio<!--:--><!--:en-->Non Member<!--:--><!--:pb-->No Socio<!--:-->") ?></th>

                    <th scope="col"><?php echo __("<!--:es-->Early bird hasta el 24/09/2021<!--:--><!--:en-->Early bird until 09/24/2021<!--:-->") ?></th>

                    <th scope="col"><?php echo __("<!--:es-->Precio Full desde 25/09/2021<!--:--><!--:en-->Full Price from 09/25/2021 until 11/20<!--:-->") ?></th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->No Socio - Hab. Sencilla<!--:--><!--:en-->Non Member - Simple Room<!--:--><!--:pb-->No Socio - Hab. Sencilla<!--:-->") ?></td>

                        <td><?php echo __("<!--:es-->No Disponible<!--:--><!--:en-->Not Available<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['non_member_simple_full_price'];?></td>

                    </tr>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->No Socio - Hab. Doble<!--:--><!--:en-->Non Member - Double Room<!--:--><!--:pb-->No Socio - Hab. Doble<!--:-->") ?></td>

                        <td><?php echo __("<!--:es-->No Disponible<!--:--><!--:en-->Not Available<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['non_member_doble_full_price'];?></td>

                    </tr>

                    <tr>

                        <td scope="row" class="descripcion_plan"><?php echo __("<!--:es-->Acompañante - Hab. Doble<!--:--><!--:en-->Companion - Double Room<!--:--><!--:pb-->Acompañante - Hab. Doble<!--:-->") ?></td>

                        <td><?php echo __("<!--:es-->No Disponible<!--:--><!--:en-->Not Available<!--:-->") ?></td>

                        <td>US$ <?php echo $costos['companion_doble_full_price'];?></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div class="twelve columns">

        <p class="nota_presencial">

            <?php echo __("<!--:es-->La salud y el bienestar de nuestra membresía y la de todos los participantes, serán nuestra prioridad. Por este motivo y respetando el aforo del hotel sede Secret Royal Beach Punta Cana, tendremos un número limitado de participantes. Abriremos el registro primero para nuestros miembros y luego al público en general hasta que completemos el cupo máximo permitido. <!--:--><!--:en-->The health and well-being of our members and all participants will be our priority. For this reason and respecting the capacity of the host hotel Secret Royal Beach Punta Cana, we will have a limited number of participants. We will open registration first to our members and then to the general public until we complete the maximum capacity allowed.<!--:-->") ?>

        </p>

    </div>

    <div class="twelve columns">

        <div class="subtitulo">

            <h3><?php echo __("<!--:es-->Participación Virtual<!--:--><!--:en-->Virtual Participation<!--:--><!--:pb-->Participación Virtual<!--:-->") ?></h3>

            <p><?php echo __("<!--:es-->Plataforma Virtual de ASIPI<!--:--><!--:en-->ASIPI Virtual Platform<!--:--><!--:pb-->Plataforma Virtual de ASIPI<!--:-->") ?></p>

        </div>

    </div>

    <div class="twelve columns">

        <table class="table">

            <thead>

                <tr>

                <th scope="col"></th>

                <th scope="col"><?php echo __("<!--:es-->Precio Full<!--:--><!--:en-->Full price<!--:--><!--:pb-->Precio Full<!--:-->") ?></th>

                </tr>

            </thead>

            <tbody>

                <tr>

                <td scope="row"><?php echo __("<!--:es-->Socio - Virtual<!--:--><!--:en-->Member - Virtual<!--:--><!--:pb-->Socio - Virtual<!--:-->") ?></td>

                <td>US$ <?php echo $costos['member_virtual_full_price'];?></td>

                </tr>

                <tr>

                <td scope="row"><?php echo __("<!--:es-->No Socio - Virtual<!--:--><!--:en-->Non Member - Virtual<!--:--><!--:pb-->No Socio - Virtual<!--:-->") ?></td>

                <td>US$ <?php echo $costos['non_member_virtual_full_price'];?></td>

                </tr>

                <tr>

                <td scope="row"><?php echo __("<!--:es-->Estudiantes - Virtual<!--:--><!--:en-->Student - Virtual<!--:--><!--:pb-->Estudiantes - Virtual<!--:-->") ?></td>

                <td>US$ <?php echo $costos['student_virtual_full_price'];?></td>

                </tr>

            </tbody>

        </table>

    </div>

    <div class="twelve columns">

        <br><br><br><br>

        <div class="col six columns">

            <?php if($lang!='en'){?>

                <div class="cont_list">

                    <h3><?php echo __("<!--:es-->¿Qué Incluye el Registro Presencial?<!--:--><!--:en-->What does the Face-to-Face Registration include?<!--:--><!--:pb-->¿Que Incluye el Registro Presencial?<!--:-->") ?></h3>

                    <ul>

                        <li>Acceso a Plenaria y Talleres</li>

                        <li>Material del Congreso</li>

                        <li>Coffee breaks </li>

                        <li>Cóctel de Bienvenida - 27 de noviembre</li>

                        <li>Cóctel de Inauguración - 28 de noviembre</li>

                        <li>Cóctel de los Estudios - 29 de noviembre</li>

                        <li>Cóctel ASIPI CLUBS - 30 de noviembre</li>

                        <li>Cena de Clausura - 1 de diciembre</li>

                        <li>4 noches de alojamiento en categoría Jr. Suite Tropical View en el Hotel Secrets Royal Beach Punta Cana: check in 27 de noviembre con check out 1 de diciembre, o check in 28 de noviembre con check out 2 de diciembre. </li>

                        <li>Desayuno completo, almuerzo, cena y refrigerios todos los días.</li>

                        <li>Variedad de restaurantes que incluyen restaurantes buffet y a la carta y grill de playa.</li>

                        <li>Jugos de frutas naturales y refrescos ilimitados.</li>

                        <li>Bebidas alcohólicas ilimitadas de marcas nacionales e internacionales</li>

                        <li>Mini-bar abastecido diariamente con cerveza, jugo, refrescos y agua embotellada</li>

                        <li>Room service 24 horas</li>

                        <li>Servicios de Internet</li>

                        <li>20% de descuento en Spa (no incluye salón de belleza ni compra de productos)</li>

                        <li>Entretenimiento nocturno (según el programa del hotel)</li>

                        <li>Bares (incluyendo 1 bar en la piscina, bar en la playa y lobby bar en cada hotel).</li>

                        <li>Gimnasio con equipamiento deportivo de alta calidad</li>

                        <li>Programa de actividades diarias: 2 canchas de tenis, 1 pista de paddle, voleibol de playa, 3 mesas de billar, aeróbicos y aeróbicos acuáticos, clases de baile, clases de español, películas de pantalla grande en la playa, deportes acuáticos no motorizados, buceo con Snorkeling, clases introductorias de buceo en la piscina, Vela, Windsurf, Kayaks, por nombrar algunos.</li>

                        <li>Todos los impuestos y propinas.</li>

                        <li>Seguro COVID en el Hotel, en caso de dar positivo *</li>

                    </ul>

                    <p>* <b>Nota</b>: En caso de dar positivo durante el evento, será aislado en una habitación private pool por 14 noches. Las 14 noches son sin costo, a partir de la fecha prevista del check out original. Se le incluye comidas y bebidas a la habitación. Se le otorgará kit de limpieza personal, pero el personal del Hotel no podrá ingresar a la habitación para realizar la limpieza de la misma. Tendrá la opción de poder quedar en la habitación con un acompañante también en cortesía, sin éste poder salir de la habitación hasta que no finalice la cuarentena. A los 14 días al realizarse un nuevo PCR (a costo del pasajero), si da negativo podrá realizar el check out, en caso de dar positivo nuevamente, el hotel le brindará una tarifa especial para la siguiente cuarentena.</p>

                    

                </div>

            <?php }else{ ?>

                <div class="cont_list">

                    <h3><?php echo __("<!--:es-->¿Que Incluye el Registro Presencial?<!--:--><!--:en-->What does the Face-to-Face Registration include?<!--:--><!--:pb-->¿Que Incluye el Registro Presencial?<!--:-->") ?></h3>

                    <ul>

                        <li>Access to Plenary and Workshops</li>

                        <li>Congress material</li>

                        <li>Coffee breaks </li>

                        <li>Welcome Cocktail - November 27</li>

                        <li>Opening Cocktail - November 28</li>

                        <li>Studies Cocktail - November 29</li>

                        <li>ASIPI CLUBS Cocktail - November 30</li>

                        <li>Closing Dinner - December 1</li>

                        <li>4 nights accommodation in the Jr. Suite Tropical View category at the Hotel Secrets Royal Beach Punta Cana: check in on November 27 with check out on December 1, or check in on November 28 with check out on December 2.</li>

                        <li>Full breakfast, lunch, dinner, and snacks every day.</li>

                        <li>Variety of restaurants including buffet and a la carte restaurants and beach grill.</li>

                        <li>Unlimited natural fruit juices and soft drinks.</li>

                        <li>Unlimited alcoholic beverages of national and international</li>

                        <li>brands Mini-bar stocked daily with beer, juice, soft drinks and bottled water</li>

                        <li>24 hour room service</li>

                        <li>Internet services</li>

                        <li>20% discount in Spa (does not include beauty salon or purchase of products)</li>

                        <li>Evening entertainment (depending on the program of the hotel)</li>

                        <li>Bars (including 1 pool bar, beach bar and lobby bar in each hotel).</li>

                        <li>Gym with high quality sports equipment</li>

                        <li>Daily activities program: 2 tennis courts, 1 paddle court, beach volleyball, 3 pool tables, aerobics and water aerobics, dance classes, Spanish classes, big screen movies on the beach, non-motorized water sports, Snorkeling, Introductory Pool Diving Classes, Sailing, Windsurfing, Kayaks, to name a few. </li>

                        <li>All taxes and tips.</li>

                        <li>COVID insurance at the Hotel, in case of testing positive *</li>

                    </ul>

                    <p>* <b>Note:</b> If you test positive during the event, you will be isolated in a private pool room for 14 nights. The 14 nights are free of charge, starting from the scheduled date of the original check out. Food and drinks are included. You will be given a personal cleaning kit, but the Hotel staff will not be able to enter the room to clean it. You will have the option of staying at the room with a companion, also courtesy, without the latter being able to leave the room until the quarantine ends. After 14 days when a new PCR is carried out (at the guest's expense), if it tests negative, you can check out, in case of testing positive again, the hotel will offer you a special rate for the next quarantine period.</p>

                    

                </div>

            <?php } ?>

        </div>

        <div class="col six columns">

            <?php if($lang!='en'){?>

            <div class="cont_list">

                <h3><?php echo __("<!--:es-->Noches Adicionales<!--:--><!--:en-->Additional Nights<!--:--><!--:pb-->Noches Adicionales<!--:-->") ?></h3>

                    <p><?php echo __("<!--:es-->El paquete básico de registro contempla 4 noches de alojamiento.<!--:en-->The basic registration package includes  4 nights of accommodation.<!--:-->") ?></p>

                    <p><?php echo __("<!--:es-->Si desea adicionar la noche del 27 de noviembre (Cocktail de Bienvenida) o la noche del 01 de diciembre (Cena de Clausura), puede solicitar la extensión enviando un correo a <a href='mailto:booking@asipi.org'>booking@asipi.org. </a>Sujeto a disponibilidad.<!--:en-->If you want to add the night of November 27 (Welcoming Cocktail) or the night of December 1 (Closing Dinner), you can request the extension by sending an email to <a href='mailto:booking@asipi.org'>booking@asipi.org. </a>Subject to availability.<!--:-->") ?></p>

                    <!-- <p><?php echo __("<!--:es-->Costo noche adicional en base single USD 339<!--:en-->Additional night cost in single basis USD 339<!--:-->") ?></p>

                    <p><?php echo __("<!--:es-->Costo noche adicional en base doble USD 424<!--:en-->Additional night cost in double occupancy USD 424<!--:-->") ?></p> -->

                <h3>Políticas de Cancelación</h3>

                <ul>

                    <li>Cancelaciones recibidas hasta el <b>15 de Octubre inclusive</b>, tendrán una devolución total menos un <b>10%</b> por gastos administrativos.**</li>

                    <li>Cancelaciones recibidas entre el <b>16 de Octubre al 7 de Noviembre inclusive</b>, tendrán una devolución del <b>50%. **</b></li>

                    <li>Cancelaciones recibidas a partir del <b>8 de noviembre, no tienen devolución.</b></li>

                    <li>En caso de obtener un resultado positivo de COVID-19 previo a su viaje al Evento, se realizará la devolución total de la inscripción contra la presentación de un certificado médico que confirme su estado.</li>

                </ul>

                <p>** Las devoluciones serán realizadas por la porción de la inscripción correspondiente únicamente a la participación en el evento. Por la porción de alojamiento, ver las condiciones de Hotel.</p>

                <br>

                <h3>Cancelación del Evento por Parte de ASIPI:</h3>

                <p>En caso que ASIPI considere conveniente postergar el evento para el año 2022, velando por la seguridad de sus participantes, el importe abonado por concepto de registro completo (inscripción + alojamiento), será honrado para la nueva fecha que se confirme el Congreso en la misma Sede el próximo año.</p>



                <h3>Política Menores de Edad</h3>

                    <p>El Hotel Secrets es exclusivo para adultos.</p>

                    <p>En caso de viajar con menores, consultar con <a href="mailto:booking@asipi.org">booking@asipi.org</a> </p>

            </div>

            <?php }else{ ?>

            <div class="cont_list">

                <h3><?php echo __("<!--:es-->Noches Adicionales<!--:--><!--:en-->Additional Nights<!--:--><!--:pb-->Noches Adicionales<!--:-->") ?></h3>

                    <p><?php echo __("<!--:es-->El paquete básico de registro contempla 4 noches de alojamiento.<!--:en-->The basic registration package includes  4 nights of accommodation.<!--:-->") ?></p>

                    <p><?php echo __("<!--:es-->Si desea adicionar la noche del 27 de noviembre (Cocktail de Bienvenida) o la noche del 01 de diciembre (Cena de Clausura), puede solicitar la extensión enviando un correo a <a href='mailto:booking@asipi.org'>booking@asipi.org. </a>Sujeto a disponibilidad.<!--:en-->If you want to add the night of November 27 (Welcoming Cocktail) or the night of December 1 (Closing Dinner), you can request the extension by sending an email to <a href='mailto:booking@asipi.org'>booking@asipi.org. </a>Subject to availability.<!--:-->") ?></p>

                    <!-- <p><?php echo __("<!--:es-->Costo noche adicional en base single USD 339<!--:en-->Additional night cost in single basis USD 339<!--:-->") ?></p>

                    <p><?php echo __("<!--:es-->Costo noche adicional en base doble USD 424<!--:en-->Additional night cost in double occupancy USD 424<!--:-->") ?></p> -->

                <h3>Cancellation Policy</h3>

                <ul>

                    <li>Cancellations received until <b>October 15 inclusive</b>, will receive a total refund minus <b>10%</b> for administrative expenses. **</li>

                    <li>Cancellations received between <b>October 16 to November 7 inclusive</b>, will receive a <b>50%</b> refund. **</li>

                    <li>Cancellations received after <b>November 8</b>, will not be refunded.</li>

                    <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund of the registration will be made presenting a medical certificate confirming your status.</li>

                </ul>

                <p>** Refunds will be made for the portion of the registration corresponding only to participation in the event. For the accommodation portion, see the Hotel conditions.</p>

                <br>

                <h3 style="font-size: large;">Hotel:</h3>

                <ul>

                    <li>ASIPI is not responsible for reservations, changes, hotel cancellation and/or any other matter related to the hotel regarding the attendees to the Event. All these issues should be dealt directly with Perspectiva M&T (booking@asipi.org).</li>

                    <li>Cancellations received between 60 to 31 days prior to check-in, a penalty of 10% of the total accommodation will be charged.</li>

                    <li>From 30 days prior to check-in, there is no refund.</li>

                    <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund of the registration will be made presenting a medical certificate confirming your status.</li>

                </ul>

                <br>

                <h3>Cancellation of The Event by ASIPI:</h3>

                <p>In the event that ASIPI considers convenient to postpone the event for the year 2022, ensuring the safety of its participants, the amount paid for full registration (registration + accommodation) will be honored for the new date of the Congress in the same venue next year.</p>

                <h3>Minors Policy</h3>

                    <p>The Secrets Hotel is exclusively for adults.</p>

                    <p>In case of traveling with minors, contact <a href="mailto:booking@asipi.org">booking@asipi.org</a> </p>

            </div>

            <?php } ?>

        </div>

        <div class="subtitulo">

                       

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

</style>

