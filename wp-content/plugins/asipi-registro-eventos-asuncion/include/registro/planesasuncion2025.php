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




<style>
 body, html {
    margin: 0;
    padding: 0;
  }
</style>

<div class="row justify-content-center mb-4">
    <div class="col-md-9 appear-animation evento bg-color-grey" data-appear-animation=""
        data-appear-animation-delay="0">
        <div class="card border-0">
            <div class="card-body text-center bg-color-grey">
                <p>
                    <?php echo __("
                            <!--:es-->Quien desee registrarse a partir del 18 de noviembre deberá realizarlo en forma presencial en el Evento, aplicándose la tarifa <strong>IN SITU.</strong><!--:-->
                            <!--:en-->Anyone wishing to register after November 18 must do so on-site at the Event venue, and the <strong>ON-SITE</strong> will apply.<!--:-->") ?>
                </p>
                <h4>
                    <?php echo __("
                            <!--:es-->Descuento Especial<!--:-->
                            <!--:en-->Special Discount<!--:-->") 
                            ?>
                </h4>
                <p>
                    <?php echo __("
                            <!--:es-->A partir del cuarto inscrito de una misma firma se aplicará un descuento del 20% sobre la tarifa que corresponda (socio o no socio). El primero, segundo y tercer participante de una misma firma pagarán tarifa completa.<!--:-->
                            <!--:en-->As of the fourth registrant from the same firm, a 20% discount will be applied to the corresponding rate (member or non-member). The <strong>first three participants</strong> from the same firm must pay the full rate.<!--:-->") 
                            ?>
                </p>
                <p>
                    <?php 

	echo __("
                            <!--:es-->Para obtener la aplicación de este descuento, los interesados deberán ponerse en contacto directo con nuestra Tesorería (tesoreria@asipi.org), quien se encargará de procesar el/los registro(s).<!--:-->
                            <!--:en-->To obtain this discount, please contact our treasury directly at <a href='mailto:tesoreria@asipi.org' target='_blank' >tesoreria@asipi.org</a>, who will be in charge of processing the registration(s).<!--:-->") 
                            ?>
                </p>
            </div>
        </div>
    </div>
</div>

</div>
</section>


<section class="section section-with-shape-divider border-0 lazyload mb-0">
    <div class="shape-divider shape-divider-reverse-x" style="height: 99px;">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 1920 102" preserveAspectRatio="xMinYMin">
            <path fill="#FFF" d="M1895,78c-56.71-6.03-113.75-12.1-167-17c-75.42-6.94-133.81-10.66-171-13c-62.1-3.91-108.85-5.97-155-8
                     c-35.96-1.58-78.06-3.42-133-5c-59.81-1.72-103.18-2.23-172-3c-92.17-1.03-154.41-1.01-169-1c-69.05,0.05-115.16,0.67-137,1
                     c-43.08,0.65-76.21,1.48-97,2c-28.02,0.7-71.13,1.8-128,4c-16.64,0.64-57.72,2.28-111,5c-26.12,1.33-67.11,3.45-121,7
                     c-21.14,1.39-54.21,3.59-96,7c-19.93,1.63-39.22,3.32-47,4c-16.12,1.41-33.55,2.94-55,5c-26.48,2.54-19.07,2.04-77,8
                     c-19.39,1.99-36.94,3.77-60.59,7.46V103H1923V81C1916.55,80.3,1906.82,79.26,1895,78z" />
        </svg>
    </div>
    <div class="container">
        <div class="row pb-0 mb-0 mt-5 pt-5">
            <h1 class="text-color-dark text-center font-weight-bold line-height-6 mt-0 appear-animation animated  appear-animation-visible"
                data-appear-animation="" data-appear-animation-delay="0">
                <?php echo __("<!--:es-->¿Qué incluye la inscripción?<!--:--><!--:en-->What does registration include?<!--:-->") ?>
            </h1>
            <h2 class="font-weight-bold text-color-tertiary">
                <?php echo __("<!--:es-->Socios<!--:--><!--:en-->Members<!--:-->") ?></h2>

            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-graduation-cap"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área académica<!--:--><!--:en-->Academic Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Ceremonia de Inauguración el 30 de noviembre<!--:--><!--:en-->Opening Ceremony - November 30<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Conferencia Magistral el 30 de noviembre<!--:--><!--:en-->Keynote Conference - November 30<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Plenarias del 1 y 3 de diciembre<!--:--><!--:en-->Plenary Sessions - December 1 and 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Talleres del 2 de diciembre<!--:--><!--:en-->Workshops - December 2<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-users"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Reuniones<!--:--><!--:en-->Networking<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Área de Networking del 1 al 3 de diciembre<!--:--><!--:en-->Networking Area - December 1 to December 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Acceso a Exposición comercial 1 al 3 de diciembre<!--:--><!--:en-->Access to Trade Exhibition - December 1 to December 3<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-utensils"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Alimentación<!--:--><!--:en-->Meals<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Servicio de café permanente del 1 al 3 de diciembre en áreas del evento (Networking, Plenaria, Exposición Comercial)<!--:--><!--:en-->Permanent coffee service available from December 1 to 3 in Networking, Plenary, and Exhibition areas<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Coffee Breaks y Almuerzos del 1 y 3 de diciembre<!--:--><!--:en-->Coffee breaks and lunches on December 1 and 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Coffee Break y Almuerzo del 2 de diciembre, para asistentes a los Talleres<!--:--><!--:en-->Coffee break and lunch on December 2 (only for workshop attendees)<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-star"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área social<!--:--><!--:en-->Social Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es--><strong>Domingo 30 de noviembre:</strong> Cóctel de Inauguración en el Hotel Hilton<!--:--><!--:en--><strong>Sunday, November 30:</strong> Opening Cocktail at the Hilton Hotel<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Lunes 1 de diciembre:</strong> Cóctel de los Estudios en el Yacht Club Puerto Madero<!--:--><!--:en--><strong>Monday, December 1:</strong> Local Law Firms Reception at Yacht Club Puerto Madero<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Miércoles 3 de diciembre:</strong> Cena de Clausura en Alvear Icon<!--:--><!--:en--><strong>Wednesday, December 3:</strong> Closing Dinner at Alvear Icon<!--:-->") ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">

                            <p><?php echo __("<!--:es-->Se incluye el acceso a las siguientes actividades con cupo limitado, teniendo que registrarse previamente si desea participar en ellas:
                        <!--:en-->Participation in the following activities is limited and requires prior registration:<!--:-->");?>
                            </p>
                            <ul class="list">
                                <li><?php echo __("<!--:es--><strong>Tenis:</strong> 02 de diciembre<!--:--><!--:en--><strong>Tennis:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Fútbol:</strong> 02 de diciembre<!--:--><!--:en--><strong>Football:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Padel:</strong> 02 de diciembre<!--:--><!--:en--><strong>Padel:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Yoga:</strong> 03 de diciembre<!--:--><!--:en--><strong>Yoga:</strong> December 3<!--:-->") ?>
                                </li>

                            </ul>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">



                            <p><?php echo __("<!--:es-->Se permite acceder a las siguientes actividades con cupo limitado, teniendo que registrarse con costo aparte, si desea participar en ellas:
                            <!--:en-->Participation in the following activities is limited and requires separate registration with an additional cost:<!--:-->");?>
                            </p>
                            <ul class="list">
                                <li><?php echo __("<!--:es--><strong>Cata de Vinos Y Maridaje:</strong> 29 de noviembre<!--:--><!--:en--><strong>Wine Testing and Pairing:</strong> November 29<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Walking/Running Tour:</strong> 1 de diciembre<!--:--><!--:en--><strong>Walking/Running Tour:</strong> December 1<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Torneo de Golf:</strong> 2 de diciembre<!--:--><!--:en--><strong>Golf Tournament:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>We Respect:</strong> 2 de diciembre<!--:--><!--:en--><strong>We Respect:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Ruta del Vino:</strong> Salida 4 de diciembre<!--:--><!--:en--><strong>Wine Route:</strong> Departure December 4<!--:-->") ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-0 mb-0 mt-5 pt-5">
            <h2 class="font-weight-bold text-color-tertiary">
                <?php echo __("<!--:es-->No Socios<!--:--><!--:en-->Non Members<!--:-->") ?></h2>

            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-graduation-cap"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área académica<!--:--><!--:en-->Academic Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                   <li><?php echo __("<!--:es-->Ceremonia de Inauguración el 30 de noviembre<!--:--><!--:en-->Opening Ceremony - November 30<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Conferencia Magistral el 30 de noviembre<!--:--><!--:en-->Keynote Conference - November 30<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Plenarias del 1 y 3 de diciembre<!--:--><!--:en-->Plenary Sessions - December 1 and 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Talleres del 2 de diciembre<!--:--><!--:en-->Workshops - December 2<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-users"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Reuniones<!--:--><!--:en-->Networking<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Área de Networking del 1 al 3 de diciembre<!--:--><!--:en-->Networking Area - December 1 to December 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Acceso a Exposición comercial 1 al 3 de diciembre<!--:--><!--:en-->Access to Trade Exhibition - December 1 to December 3<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-utensils"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Alimentación<!--:--><!--:en-->Meals<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Servicio de café permanente del 1 al 3 de diciembre en áreas del evento (Networking, Plenaria, Exposición Comercial)<!--:--><!--:en-->Permanent coffee service available from December 1 to 3 in Networking, Plenary, and Exhibition areas<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Coffee Breaks y Almuerzos del 1 y 3 de diciembre<!--:--><!--:en-->Coffee breaks and lunches on December 1 and 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es-->Coffee Break y Almuerzo del 2 de diciembre, para asistentes a los Talleres<!--:--><!--:en-->Coffee break and lunch on December 2 (only for workshop attendees)<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <ul class="list list-icons list-icons-style-3 list-primary">
                                <li><i class="fa-solid fa-star"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área social<!--:--><!--:en-->Social Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                 <li><?php echo __("<!--:es--><strong>Domingo 30 de noviembre:</strong> Cóctel de Inauguración en el Hotel Hilton<!--:--><!--:en--><strong>Sunday, November 30:</strong> Opening Cocktail at the Hilton Hotel<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Lunes 1 de diciembre:</strong> Cóctel de los Estudios en el Yacht Club Puerto Madero<!--:--><!--:en--><strong>Monday, December 1:</strong> Local Law Firms Reception at Yacht Club Puerto Madero<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Miércoles 3 de diciembre:</strong> Cena de Clausura en Alvear Icon<!--:--><!--:en--><strong>Wednesday, December 3:</strong> Closing Dinner at Alvear Icon<!--:-->") ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">

                            <p><?php echo __("<!--:es-->Se incluye el acceso a las siguientes actividades con cupo limitado, teniendo que registrarse previamente si desea participar en ellas:
                        <!--:en-->Participation in the following activities is limited and requires prior registration:<!--:-->");?>
                            </p>
                            <ul class="list">
                                 <li><?php echo __("<!--:es--><strong>Tenis:</strong> 02 de diciembre<!--:--><!--:en--><strong>Tennis:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Fútbol:</strong> 02 de diciembre<!--:--><!--:en--><strong>Football:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Padel:</strong> 02 de diciembre<!--:--><!--:en--><strong>Padel:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Yoga:</strong> 03 de diciembre<!--:--><!--:en--><strong>Yoga:</strong> December 3<!--:-->") ?>
                                </li>

                            </ul>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-4">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">



                            <p><?php echo __("<!--:es-->Se permite acceder a las siguientes actividades con cupo limitado, teniendo que registrarse con costo aparte, si desea participar en ellas:
                            <!--:en--> Participation in the following activities is limited and requires separate registration with an additional cost:<!--:-->");?>
                            </p>
                            <ul class="list">
                                    <li><?php echo __("<!--:es--><strong>Cata de Vinos y Maridaje:</strong> 29 de noviembre<!--:--><!--:en--><strong>Wine Tasting and Pairing:</strong> November 29<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Walking/Running Tour:</strong> 1 de diciembre<!--:--><!--:en--><strong>Walking/Running Tour:</strong> December 1<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Torneo de Golf:</strong> 2 de diciembre<!--:--><!--:en--><strong>Golf Tournament:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>We Respect:</strong> 2 de diciembre<!--:--><!--:en--><strong>We Respect:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Ruta del Vino:</strong> Salida 4 de diciembre<!--:--><!--:en--><strong>Wine Route:</strong> Departure December 4<!--:-->") ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>



        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">
                            <h2 class="font-weight-bold text-color-tertiary">
                                <?php echo __("<!--:es-->Acompañantes<!--:--><!--:en-->Companion<!--:-->") ?></h2>
                            <ul class="list list-icons list-icons-style-3 list-tertiary">
                                <li><i class="fa-solid fa-star"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área social<!--:--><!--:en-->Social Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es--><strong>Domingo 30 de noviembre: </strong> Cóctel de Inauguración en el Hotel Hilton<!--:--><!--:en--><strong>Sunday, November 30:</strong> Opening Cocktail at the Hilton Hotel<!--:-->") ?>
                                </li>
                                 <li><?php echo __("<!--:es--><strong>Lunes 1 de diciembre: </strong> San Telmo: Tango, Asado y un viaje Mágico a los Orígenes de Asunción<!--:--><!--:en--><strong>Monday, December 1:</strong> San Telmo: Tango, Asado and a Magical Journey to the Origins of Asunción<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Lunes 1 de diciembre: </strong> Cóctel de los Estudios en el Yacht Club Puerto Madero<!--:--><!--:en--><strong>Monday, December 1:</strong> Local Law Firms Reception at Yacht Club Puerto Madero<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Miércoles 3 de diciembre: </strong> Arte, Cultura y Arquitectura<!--:--><!--:en--><strong>Wednesday, December 3:</strong> Art, Culture and Architecture<!--:-->") ?>
                                </li>
                               <li><?php echo __("<!--:es--><strong>Miércoles 3 de diciembre: </strong> Cena de Clausura en Alvear Icon<!--:--><!--:en--><strong>Wednesday, December 3:</strong> Closing Dinner at Alvear Icon<!--:-->") ?>
                                </li>
                                


                            </ul>



                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">


                            <p><?php echo __("<!--:es-->Se incluye el acceso a las siguientes actividades con cupo limitado, teniendo que registrarse previamente si desea participar en ellas:
                        <!--:en-->Participation in the following activities is limited and requires prior registration:<!--:-->");?>
                            </p>
                            <ul class="list">
                               <li><?php echo __("<!--:es--><strong>Tenis:</strong> 02 de diciembre<!--:--><!--:en--><strong>Tennis:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Fútbol:</strong> 02 de diciembre<!--:--><!--:en--><strong>Football:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Padel:</strong> 02 de diciembre<!--:--><!--:en--><strong>Padel:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Yoga:</strong> 03 de diciembre<!--:--><!--:en--><strong>Yoga:</strong> December 3<!--:-->") ?>
                                </li>

                            </ul>


                            <p><?php echo __("<!--:es-->Se permite acceder a las siguientes actividades con cupo limitado, teniendo que registrarse con costo aparte, si desea participar en ellas:
                            <!--:en-->  Participation in the following activities is limited and requires separate registration with an additional cost:<!--:-->");?>
                            </p>
                            <ul class="list">
                                   <li><?php echo __("<!--:es--><strong>Cata de Vinos y Maridaje:</strong> 29 de noviembre<!--:--><!--:en--><strong>Wine Tasting and Pairing:</strong> November 29<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Walking/Running Tour:</strong> 1 de diciembre<!--:--><!--:en--><strong>Walking/Running Tour:</strong> December 1<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Torneo de Golf:</strong> 2 de diciembre<!--:--><!--:en--><strong>Golf Tournament:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>We Respect:</strong> 2 de diciembre<!--:--><!--:en--><strong>We Respect:</strong> December 2<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--><strong>Ruta del Vino:</strong> Salida 4 de diciembre<!--:--><!--:en--><strong>Wine Route:</strong> Departure December 4<!--:-->") ?>
                                </li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pricing-table row mb-4 justify-content-center">
                    <div class="row justify-content-center">

                        <div class="col-md-12 col-sm-6 col-lg">
                            <div class="plan plan-featured transform-none">
                                <div class="plan-header bg-tertiary">
                                    <h3><?php echo __("<!--:es-->Tarifa Acompañante<!--:--><!--:en-->Companion rate<!--:-->") ?>
                                    </h3>
                                </div>
                                <div class="plan-price bg-transparent">
                                    <span class="price text-8"><span class="price-unit">US$</span>790</span>
                                    <label class="price-label"></label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 appear-animation evento mb-5" data-appear-animation=""
                data-appear-animation-delay="0">
                <div class="card border-0 bg-color-light">
                    <div class="card-body text-center">
                        <p class="card-text">
                            <?php echo __("
                         <!--:es-->Los acompañantes solo pueden inscribirse al evento a través del registro que efectúe un participante principal ( socio, no socio o invitado).<!--:-->
                         <!--:en-->Companions may register for the event only through the registration of a main participant (member, non-member, or guest).<!--:-->") 
                         ?>

                        </p>
                        <p class="card-text">
                            <?php echo __("
                         <!--:es-->Podrán registrarse bajo esta categoría cualquier persona que no sea socia de ASIPI, que no se dedique a la práctica de Propiedad Intelectual y/o que no forme parte de la misma firma o empresa del participante principal.<!--:-->
                         <!--:en-->This category is for anyone who is not a member of ASIPI, is not engaged in the practice of Intellectual Property, and/or is not part of the same firm or company as the main participant.<!--:-->") 
                         ?>
                        </p>
                    </div>
                </div>
            </div>
            <hr>


            <div class="col-md-12">
                <div class="appear-animation" data-appear-animation="" data-appear-animation-delay="0">
                    <div class="card border-0">
                        <div class="card-body bg-color-grey">



                            <h2 class="font-weight-bold text-color-quaternary">
                                <?php echo __("<!--:es-->Estudiantes<!--:--><!--:en-->Student<!--:-->") ?></h2>
                             <p class="card-text">
                            <?php echo __("
                         <!--:es-->En esta categoría podrán inscribirse solo estudiantes que cursen actualmente programas de pregrado en una universidad. Para procesar su registro deberán acreditar tal condición.<!--:-->
                         <!--:en-->Only students currently enrolled in undergraduate programs at a university may register in this category. Proof of this status must be provided to process their registration.<!--:-->") 
                         ?>

                        </p>
                            <ul class="list list-icons list-icons-style-3 list-quaternary">
                                <li><i class="fa-solid fa-graduation-cap"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Área Académica<!--:--><!--:en-->Academic Area<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->Plenarias del 1 y 3 de diciembre<!--:--><!--:en-->Plenary sessions on December 1 and 3<!--:-->") ?>
                                </li>
                               <li><?php echo __("<!--:es-->Talleres del 2 de diciembre<!--:--><!--:en-->Workshops - December 2<!--:-->") ?>
                              
                            </ul>
                            <ul class="list list-icons list-icons-style-3 list-quaternary">
                                <li><i class="fa-solid fa-utensils"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Alimentación<!--:--><!--:en-->Meals<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es--> Coffee Breaks y Almuerzos del 1 y 3 de diciembre<!--:--><!--:en-->Coffee Breaks on December 1 and 3<!--:-->") ?>
                                </li>
                                <li><?php echo __("<!--:es--> Coffee Break  y Almuerzo del 2 de diciembre, para asistentes a los Talleres<!--:--><!--:en--> Coffee break and lunch on December 2 (only for workshop attendees)<!--:-->") ?>
                                </li>

                            </ul>
                            <ul class="list list-icons list-icons-style-3 list-quaternary">
                                <li><i class="fa-solid fa-star"></i><span
                                        class="font-weight-bold text-5"><?php echo __("<!--:es-->Actividades Sociales<!--:--><!--:en-->Social Activities<!--:-->") ?></span>
                                </li>
                            </ul>
                            <ul class="list">
                                <li><?php echo __("<!--:es-->No están incluidas. Los registrados como ESTUDIANTES no participan en estas actividades<!--:--><!--:en-->Not included. Those registered as STUDENTS do not participate in these activities<!--:-->") ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4 mx-3">

            <div class="col-md-11 appear-animation evento" data-appear-animation="" data-appear-animation-delay="0">
                <div class="card border-0 bg-color-light">
                    <div class="card-body text-center">
                        <h4 class="card-title mt-2 mb-4 text-6 font-weight-bold">
                            <?php echo __("<!--:es-->Políticas de Cancelación<!--:--><!--:en-->Cancellation Policies<!--:-->") ?>
                        </h4>
                        <p class="card-text">
                            <?php echo __("
                                     <!--:es-->Cancelaciones recibidas antes del 30 de Septiembre, tendrán una devolución del 50%.
                                     <br>Cancelaciones recibidas hasta el 16 de noviembre, tendrán una devolución del 10%<!--:-->
                                     <!--:en-->Cancellations received before September 30 will receive a 50% refund.
                                     <br>Cancellations received by November 16 will receive a 10% refund.<!--:-->") 
                                     ?>

                        </p>
                        <p class="text-2">
                            <?php echo __("
                                     <!--:es-->Las devoluciones que realice ASIPI corresponde exclusivamente al pago por el registro en el evento y no por alojamiento, en cuyo caso deben observarse las condiciones establecidas por el Hotel.<!--:-->
                                     <!--:en-->Refunds made by ASIPI apply exclusively to the event registration payment. Accommodation refunds are subject to the terms and conditions established by the Hotel.<!--:-->") 
                                     ?>
                        </p>
                    </div>
                </div>
            </div>

        </div>



                              
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$("#socio1").hide();
$("#miembro1").hide();
$("#nosocio1").hide();
$("#student1").hide();
$("#bt_socio").click(function() {
    alert("The paragraph was clicked.");
    $("#socio1").show();
});
$("#bt_socio").click(function() {
    alert("The paragraph was clicked.");
    $("#socio1").show();
});
$("#bt_nosocio").click(function() {
    alert("The paragraph was clicked1.");
    $("#nosocio1").show();
});
</script>