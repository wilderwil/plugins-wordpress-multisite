 <!-- Intro -->
 <section class="section-height-2 section-with-shape-divider border-0  pt-5 pb-0">
     <div class="container">
         <div class="row justify-content-center pb-2 mb-5 align-items-end">

             <div class="col text-center">
                 <h1 class="font-weight-bold text-dark">
                     <?php echo __($nombre_evento[$lang]) ?>
                 </h1>
                 <h2 class="font-weight-bold text-dark" id="h2-plan">
                     <?php echo __("<!--:es-->Planes y Costos<!--:--><!--:en-->Plans and Costs<!--:-->") ?>
                 </h2>
             </div>

             <?php
$sql = "SELECT valor FROM evento_meta where evento_id = '$blog_id' and clave='early_bird'";
$earlyBird = $wpdb->get_var('SELECT valor FROM evento_meta WHERE clave = "early_bird" AND evento_id ='.$blog_id);
$insitu = $wpdb->get_var('SELECT valor FROM evento_meta WHERE clave = "in_situ" AND evento_id ='.$blog_id);
date_default_timezone_set('America/Argentina/Buenos_Aires');
$today = date("Y-m-d");
//echo date("Y-m-d H-i-s");

//$today = date("Y-m-d",strtotime($today."+ 3 days")); 
?>

             <div class="tabs tabs-bottom tabs-center tabs-simple">
                 <ul class="nav nav-tabs" id="nav-tabs">
                     <li class="nav-item" >
                         <a class="nav-link <?php if($today<=$earlyBird) echo 'active' ?>" href="#tabsNavigationSimple1"
                             data-bs-toggle="tab"><?php echo __("<!--:es-->Early Bird<!--:--><!--:en-->Early Bird<!--:-->") ?></a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link <?php if($today<=$insitu && $today>$earlyBird ) echo 'active' ?>"
                             href="#tabsNavigationSimple2"
                             data-bs-toggle="tab"><?php echo __("<!--:es-->Tarifa Online<!--:--><!--:en-->Online Rate<!--:-->") ?></a>
                     </li>
                     <li class="nav-item" >
                         <a class="nav-link <?php if($today>$insitu) echo 'active' ?>" href="#tabsNavigationSimple3"
                             data-bs-toggle="tab"><?php echo __("<!--:es-->In Situ<!--:--><!--:en-->In Situ<!--:-->") ?></a>
                     </li>
                 </ul>
                 <div class="tab-content">
                     <div class="tab-pane <?php if($today<=$earlyBird) echo 'active' ?> " id="tabsNavigationSimple1">
                         <div class="pricing-table row mb-4 justify-content-center" >
                             <h2 class="text-color-dark text-center text-4 font-weight-bold line-height-6 mt-0 appear-animation animated  appear-animation-visible"
                                 data-appear-animation="" data-appear-animation-delay="200"
                                 style="animation-delay: 200ms;">
                                 <?php echo __("<!--:es-->Tarifa Early Bird válida hasta el 25/09/25<!--:--><!--:en-->Early Bird rate valid until 09/25/25<!--:-->") ?>
                             </h2>

                             <div class="row">
                                 <div class="col-sm-6 col-lg" id="card_socio">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-primary">
                                             <h3><?php echo __("<!--:es-->Socio<!--:--><!--:en-->Member<!--:--><!--:pb-->Socio<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['member_simple_early_bird_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 25 de septiembre<!--:--><!--:en-->until September 25 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_member=='si' && $today<=$earlyBird){ ?>
                                             <a id="btn_socio" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="" data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>

                                     </div>
                                 </div>
                                 <div class="col-sm-6 col-lg" id="card_nosocio">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-secondary">
                                             <h3><?php echo __("<!--:es-->No Socio<!--:--><!--:en-->Non Member<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['non_member_simple_early_bird_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 25 de septiembre<!--:--><!--:en-->until September 25 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_nosocio=='si' && $today<=$earlyBird){ ?>
                                             <a id="btn_nosocio" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="" data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>

                                     </div>
                                 </div>
                                 <div class="col-sm-6 col-lg" id="card_student">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-tertiary">
                                             <h3><?php echo __("<!--:es-->Estudiantes<!--:--><!--:en-->Student<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['student_simple_early_bird_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 25 de septiembre<!--:--><!--:en-->until September 25 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_student=='si' && $today<=$earlyBird){ ?>
                                             <a id="btn_student" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="" data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>


                                     </div>
                                 </div>

                                 <div class="col-sm-6 col-lg" id="card_guest">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-quaternary">
                                             <h3><?php echo __("<!--:es-->Invitado<!--:--><!--:en-->Guest<!--:--><!--:pb-->Guest<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span class="price-unit">&nbsp;</span>&nbsp;
                                             </span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->Código requerido<!--:--><!--:en-->Required Code <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_guest=='si' && $today<=$earlyBird){ ?>
                                             <a id="btn_guest" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="" data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>


                                     </div>
                                 </div>


                             </div>
                         </div>
                     </div>
                     <div class="tab-pane <?php if($today<=$insitu && $today>$earlyBird) echo 'active' ?>"
                         id="tabsNavigationSimple2">
                         <div class="pricing-table row mb-4 justify-content-center">
                             <h2 class="text-color-dark text-center text-4 font-weight-bold line-height-6 mt-0 appear-animation animated  appear-animation-visible"
                                 data-appear-animation="" data-appear-animation-delay="200"
                                 style="animation-delay: 200ms;">
                                 <?php echo __("<!--:es-->Tarifa Online válida hasta el 18/11/25<!--:--><!--:en-->Online Rate valid until 11/18/25<!--:-->") ?>
                             </h2>

                             <div class="row justify-content-center">
                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-primary">
                                             <h3><?php echo __("<!--:es-->Socio<!--:--><!--:en-->Member<!--:--><!--:pb-->Socio<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent ">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['member_simple_full_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 18 de noviembre<!--:--><!--:en-->until Nov 18 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_member=='si' && $today<=$insitu && $today>$earlyBird){ ?>
                                             <a id="btn_socio" style="margin-top: 5px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="fadeInUpShorter"
                                                 data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-secondary">
                                             <h3><?php echo __("<!--:es-->No Socio<!--:--><!--:en-->Non Member<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['non_member_simple_full_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 18 de noviembre<!--:--><!--:en-->until Nov 18 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_nosocio=='si' && $today<=$insitu && $today>$earlyBird){ ?>
                                             <a id="btn_nosocio" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="fadeInUpShorter"
                                                 data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-tertiary">
                                             <h3><?php echo __("<!--:es-->Estudiantes<!--:--><!--:en-->Student<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['student_simple_full_price'];?></span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->hasta el 18 de noviembre<!--:--><!--:en-->until Nov 18 <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_student=='si' && $today<=$insitu && $today>$earlyBird){ ?>
                                             <a id="btn_student" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="fadeInUpShorter"
                                                 data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-quaternary">
                                             <h3><?php echo __("<!--:es-->Invitado<!--:--><!--:en-->Guest<!--:--><!--:pb-->Guest<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span class="price-unit">&nbsp;</span>&nbsp;
                                             </span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->Código requerido<!--:--><!--:en-->Required Code <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_guest=='si'  && $today<=$insitu && $today>$earlyBird){ ?>
                                             <a id="btn_guest" style="margin-top: 30px; margin-bottom: 30px;"
                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation"
                                                 data-hash data-hash-offset="0" data-hash-offset-lg="32"
                                                 data-appear-animation="fadeInUpShorter"
                                                 data-appear-animation-delay="300"
                                                 data-appear-animation-duration="1.7s">
                                                 <?php echo $textos[$lang]['register'] ?></a>
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>


                             </div>
                         </div>
                     </div>
                     <div class="tab-pane <?php if($today>$insitu) echo 'active' ?>" id="tabsNavigationSimple3"
                         >
                         <div class="pricing-table row mb-4 justify-content-center">
                             <h2 class="text-color-dark text-center text-4 font-weight-bold line-height-6 mt-0 appear-animation animated  appear-animation-visible"
                                 data-appear-animation="" data-appear-animation-delay="200"
                                 style="animation-delay: 200ms;">
                                 <?php echo __("<!--:es-->Tarifa en sede física del evento<!--:--><!--:en-->Fee at the physical location of the event<!--:-->") ?>
                             </h2>

                             <div class="row justify-content-center">
                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-primary">
                                             <h3><?php echo __("<!--:es-->Socio<!--:--><!--:en-->Member<!--:--><!--:pb-->Socio<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['member_simple_in_situ_price'];?></span>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_member=='si' && $today>$insitu){ ?>
                                             <!-- <a id="btn_socio" style="margin-top: 30px; margin-bottom: 30px;" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" data-appear-animation-duration="1.7s">
                                        <?php echo $textos[$lang]['register'] ?></a> -->
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-secondary">
                                             <h3><?php echo __("<!--:es-->No Socio<!--:--><!--:en-->Non Member<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['non_member_simple_in_situ_price'];?></span>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_nosocio=='si' && $today>$insitu){ ?>
                                             <!--  <a id="btn_nosocio" style="margin-top: 30px; margin-bottom: 30px;" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" data-appear-animation-duration="1.7s">
                                        <?php echo $textos[$lang]['register'] ?></a> -->
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-tertiary">
                                             <h3><?php echo __("<!--:es-->Estudiantes<!--:--><!--:en-->Student<!--:--><!--:pb-->Não Membro<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">US$</span><?php echo $costos['student_simple_in_situ_price'];?></span>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_student=='si' && $today>$insitu){ ?>
                                             <!--  <a id="btn_student" style="margin-top: 30px; margin-bottom: 30px;" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" data-appear-animation-duration="1.7s">
                                            <?php echo $textos[$lang]['register'] ?></a> -->
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-sm-4 col-lg">
                                     <div class="plan plan-featured transform-none">
                                         <div class="plan-header bg-quaternary">
                                             <h3><?php echo __("<!--:es-->Invitado<!--:--><!--:en-->Guest<!--:--><!--:pb-->Guest<!--:-->") ?>
                                             </h3>
                                         </div>
                                         <div class="plan-price bg-transparent">
                                             <span class="price text-8"><span
                                                     class="price-unit">&nbsp;</span>&nbsp;</span>
                                             <label
                                                 class="price-label"><?php echo __("<!--:es-->Código requerido<!--:--><!--:en-->Required Code <!--:-->") ?></label>
                                         </div>
                                         <div class="col-12 text-center">
                                             <?php if($registro_guest=='si'  && $today>$insitu ){ ?>
                                             <!--   <a id="btn_guest" style="margin-top: 30px; margin-bottom: 30px;" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" data-appear-animation-duration="1.7s">
                                            <?php echo $textos[$lang]['register'] ?></a> -->
                                             <?php } ?>
                                         </div>
                                     </div>
                                 </div>


                             </div>

                         </div>
                     </div>
                 </div>
             </div>



             <!--<div id="bloque-titulo">
    <!--<h3 style="text-align: center"><?php //echo __("<!--:es-->Registro<!--:--><!--:en-->Registration<!--:-->") ?></h3>-->
             <!--<h1 class="font-weight-bold text-dark"><?php echo __($nombre_evento[$lang]) ?> </h1>
     <h5 style="font-size: x-large;  font-weight: 500;"><?php echo __($descripcion_evento[$lang]) ?></b></h5>
    <!--<p style="font-size: 20px;"><b><a href="/costarica2022/planes-y-costos/" target="_blank"><?php echo __("<!--:es-->Planes
             y Costos
             <!--:-->
             <!--:en-->Plans and Costs
             <!--:-->") ?></a></b></p>
             <img src="<?php echo __("<!--:es-->https://asipi.org/costarica2022/wp-content/uploads/sites/27/2022/05/Sold-out.jpg<!--:--><!--:en-->https://asipi.org/costarica2022/wp-content/uploads/sites/27/2022/05/Sold-out-EN.jpg<!--:-->") ?>"
                 alt="sold-out">-->
             <!--</div>-->
             <!--
<div class="alerta">
    <h2><?php echo __("<!--:es-->CUPO COMPLETO
             <!--:-->
             <!--:en-->REGISTRATION AT FULL CAPACITY
             <!--:-->") ?></h2>
             <p><?php echo __("<!--:es-->En base a las medidas sanitarias requeridas y a la disponibilidad de la Sede, informamos que el cupo máximo de inscripciones al Evento ha sido alcanzado<!--:--><!--:en-->Based on the required sanitary measures and the availability of the Venue, we inform that the maximum number of registrations for the event has been reached.<!--:-->") ?>
             </p>
         </div>
         -->
         <style>
         .alerta {
             TEXT-ALIGN: center;
             background-color: #efe67a;
             padding: 15px;
             margin: 40px;
             color: #f00;
         }

         .alerta h2 {
             color: #f00;
             font-weight: bold;
         }

         .card {
             border: none !important;
         }

         .form-group1 {
             width: 50%;
             display: flex;
             flex-direction: row;
             align-content: center;
             justify-content: center;
             align-items: center;
             flex-wrap: wrap;
         }

         .form-group2 {
             width: 20%;
             display: flex;
             align-items: center;
             align-content: center;
             flex-wrap: wrap;
             flex-direction: row;
             justify-content: center;

         }

         .form-group3 {
             width: 80%;
             display: flex;
             flex-direction: column;
             flex-wrap: wrap;
             align-content: center;
             justify-content: center;
             align-items: center;

         }

         .for-login {
             display: flex;
             flex-wrap: wrap;
             justify-content: center;

         }

         .for-login1 {
             display: flex;
             flex-wrap: wrap;
             justify-content: center;
             flex-direction: column;
             align-content: center;
             align-items: center;
         }


         .password_student {
             width: 100%;

         }

         .newpassword_student {
             width: 100%;
             display: flex;
             flex-direction: column;
             flex-wrap: wrap;
             align-content: center;
             justify-content: center;
             align-items: center;

         }



         .password_nosocio {
             width: 100%;

         }

         .newpassword_nosocio {
             width: 100%;
             display: flex;
             flex-direction: column;
             flex-wrap: wrap;
             align-content: center;
             justify-content: center;
             align-items: center;

         }


         .password_guest {
             width: 100%;

         }

         .coupon_code {
             width: 100%;
             display: flex;
             flex-wrap: wrap;
             align-content: center;
             justify-content: center;
             align-items: center;

         }

         .newpassword_guest {
             width: 100%;
             display: flex;
             flex-direction: column;
             flex-wrap: wrap;
             align-content: center;
             justify-content: center;
             align-items: center;

         }

         @media only screen and (max-width: 1000px) {
             .for-login {
                 display: flex;
                 flex-direction: column;
                 flex-wrap: wrap;
                 align-content: center;
                 justify-content: center;
                 align-items: center;

             }

             .form-group1 {
                 width: 100%;

             }

             .form-group2 {
                 width: 100%;

             }

             .form-group3 {
                 width: 100%;

             }
         }
         </style>
         <div class="container  paso1 "
             style="display: flex; flex-direction: row; flex-wrap: wrap; align-content: center; justify-content: center; align-items: center;width: 80%;">

             <div class="col-sm-8 col-lg" style="padding-top: 0px" id="1bloque-izquierdo">
                 <!-- FORMULARIO SOCIO-->
                 <!--<div id="socio" class="divform">
            <div class="plan-header bg-primary" style="border-radius: 30px 30px 0 0;">
            <h3 class="font-weight-bold" style="color: #fff;font-size: 16px; padding: 14px;"><?php echo $textos[$lang]['member'] ?></h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-socios" class="form" action="javascript:verifySocio()">   
                    <div class="for-login">
                        <div class="form-group form-group1">
                            <label for="email_socio"><?php echo $textos[$lang]['enter_email_asipi'] ?></label>
                            <input type="email" class="form-control" name="email_socio" id="email_socio" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                            <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group form-group1">
                            <label for="password"><?php echo $textos[$lang]['password'] ?></label><br>
                            <input type="password" class="form-control" id="password" placeholder="<?php echo $textos[$lang]['password'] ?>" required>
                        </div>
                        <div class="form-group form-group2">
                            <a type="submit" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="" data-appear-animation-delay="300" data-appear-animation-duration="1.7s" id="verifySocio"><?php echo $textos[$lang]['continue'] ?></a>
                        </div>
                    </div>

                        <div class="form-group">
                            <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                        </div>
                        <div id="mensajeErrorLogin" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        
                    </form>
                </div>
            </div>
        </div> -->
                 <section class="section-height-2 section-with-shape-divider border-0  pt-5 pb-0">
                     <div class="container" id="socio" style="display: none">
                         <div class="row justify-content-center pb-2 mb-5 align-items-end">
                             <div class="col">
                                 <h1 class="font-weight-bold text-dark text-center">
                                     <?php echo $textos[$lang]['member'] ?>
                                 </h1>
                                 <p>Todos los campos con un (*) son obligatorios.</p>

                                 <div class="card bg-color-grey mb-4">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col">
                                                 <form class="contact-form form-style-2 form-fields-rounded"
                                                     id="form-verify-socios" action="javascript:verifySocio()"
                                                     method="POST">
                                                     <div class="contact-form-success alert alert-success d-none mt-4">
                                                         <strong>Éxito!</strong> Su mensaje fue enviado.
                                                     </div>
                                                     <div class="contact-form-error alert alert-danger d-none mt-4">
                                                         <strong>Error!</strong> Hubo un error al enviar el mensaje.
                                                         <span class="mail-error-message text-1 d-block"></span>
                                                     </div>

                                                     <div class="row">
                                                         <div class="form-group col">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['enter_email_asipi'] ?></label>
                                                             <input value="" type="email" name="email_socio"
                                                                 id="email_socio"
                                                                 data-msg-required="<?php echo $textos[$lang]['enter_email'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="form-group col">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['password'] ?></label>
                                                             <input type="password" id="password" value=""
                                                                 data-msg-required="Please enter your email address."
                                                                 data-msg-email="<?php echo $textos[$lang]['password'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />
                                                         </div>
                                                     </div>

                                                     <div id="mensajeErrorLogin"
                                                         class="contact-form-error alert alert-danger mt-4 in"
                                                         style="font-size: 14px; display: none"></div>

                                                     <div class="row">
                                                         <div class="form-group col mt-3">
                                                             <input type="submit"
                                                                 value="<?php echo $textos[$lang]['continue'] ?>"
                                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-5 btn-py-3 btn-mb-5 mb-3"
                                                                 data-loading-text="Cargando..." id="verifySocio" />
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </section>

                 <!-- FORMULARIO MIEMBRO DE FIRMA -->
                 <!--<div id="miembro" class="divform">
            <h1><?php echo $textos[$lang]['member_firm_tit_form']?? '' ?></h1>
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
        </div> -->

                 <!-- FORMULARIO NO SOCIO -->
                 <!--<div id="nosocio" class="divform">
             <div class="plan-header bg-secondary" style="border-radius: 30px 30px 0 0;">
            <a href="" class="cambiar_plan">< Cambiar plan</a>
            <h3 class="font-weight-bold" style="color: #fff;font-size: 16px; padding: 14px;"><?php echo $textos[$lang]['non_member'] ?></h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-email-nosocio" class="form" action="javascript:veryfyNoSocio()">
                        <div class="for-login1">
                            <div class="form-group form-group3">
                                <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                <input type="email" class="form-control" name="email_nosocio" id="email_nosocio" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                <small id="emailHelp" class="form-text text-muted"></small>
                                <input type="hidden" id="typeLogin_nosocio" name="typeLogin_nosocio" value="verify">
                            </div>

                            
                            <div class="form-group form-group3">
                                <div class="password_nosocio" style="display: none;">
                                    <div class="form-group form-group3">
                                        <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                        <input type="password" class="form-control" name="password_nosocio" id="password_nosocio" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group form-group3">
                                        <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                                    </div>
                                </div>
                                <div class="newpassword_nosocio" style="display: none;">
                                    <br>
                                    <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>
                                    <div class="form-group form-group3">
                                        <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>
                                        <input type="password" class="form-control" name="newpassword_nosocio" id="newpassword_nosocio" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group form-group3">
                                        <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>
                                        <input type="password" class="form-control" name="repeatpassword_nosocio" id="repeatpassword_nosocio" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="mensajeError_nosocio" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        <div class="form-group ">
                                <a type="submit" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="" data-appear-animation-delay="300" data-appear-animation-duration="1.7s" id="veryfy_nosocio"><?php echo $textos[$lang]['continue'] ?></a>
                            </div>
                    </form>
                </div>
            </div>
        </div> -->
                 <section class="section-height-2 section-with-shape-divider border-0  pt-5 pb-0">
                     <div class="container" id="nosocio" style="display: none">
                         <div class="row justify-content-center pb-2 mb-5 align-items-end">
                             <div class="col">
                                 <h1 class="font-weight-bold text-dark text-center">
                                     <?php echo $textos[$lang]['non_member'] ?>
                                 </h1>
                                 <p>Todos los campos con un (*) son obligatorios.</p>

                                 <div class="card bg-color-grey mb-4">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col">
                                                 <form class="contact-form form-style-2 form-fields-rounded"
                                                     id="form-verify-email-nosocio" action="javascript:veryfyNoSocio()"
                                                     method="POST">
                                                     <div class="contact-form-success alert alert-success d-none mt-4">
                                                         <strong>Éxito!</strong> Su mensaje fue enviado.
                                                     </div>
                                                     <div class="contact-form-error alert alert-danger d-none mt-4">
                                                         <strong>Error!</strong> Hubo un error al enviar el mensaje.
                                                         <span class="mail-error-message text-1 d-block"></span>
                                                     </div>

                                                     <div class="row">
                                                         <div class="form-group col">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                                             <input value="" type="email" name="email_nosocio"
                                                                 id="email_nosocio"
                                                                 data-msg-required="<?php echo $textos[$lang]['enter_email'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />
                                                             <input type="hidden" id="typeLogin_nosocio"
                                                                 name="typeLogin_nosocio" value="verify">
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="form-group col password_nosocio"
                                                             style="display: none;">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold "><?php echo $textos[$lang]['password'] ?></label>
                                                             <input type="password" id="password_nosocio"
                                                                 name="password_nosocio" value=""
                                                                 data-msg-required="Please enter your email address."
                                                                 data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />

                                                         </div>
                                                         <div class="newpassword_nosocio form-group col"
                                                             style="display: none;">
                                                             <br>
                                                             <div style="font-weight: bold;">
                                                                 <?php echo $textos[$lang]['new_user'] ?>
                                                                 <div class="form-group col">
                                                                     <label
                                                                         class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['new_password'] ?></label>
                                                                     <input type="password" id="newpassword_nosocio"
                                                                         name="newpassword_nosocio" value=""
                                                                         data-msg-required="Please enter your email address."
                                                                         data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                         maxlength="100"
                                                                         class="form-control text-3 h-auto py-2"
                                                                         required />
                                                                 </div>
                                                                 <div class="form-group col">
                                                                     <label
                                                                         class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['new_password'] ?></label>
                                                                     <input type="password" id="repeat_password"
                                                                         name="repeat_password" value=""
                                                                         data-msg-required="Please enter your email address."
                                                                         data-msg-email="<?php echo $textos[$lang]['repeat_password'] ?>"
                                                                         maxlength="100"
                                                                         class="form-control text-3 h-auto py-2"
                                                                         required />
                                                                 </div>

                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div id="mensajeError_nosocio"
                                                         class="contact-form-error alert alert-danger mt-4 in"
                                                         style="font-size: 14px; display: none"></div>

                                                     <div class="row">
                                                         <div class="form-group col mt-3">
                                                             <input type="submit"
                                                                 value="<?php echo $textos[$lang]['continue'] ?>"
                                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-5 btn-py-3 btn-mb-5 mb-3"
                                                                 data-loading-text="Cargando..." id="veryfy_nosocio" />
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </section>
                 <!-- FORMULARIO ESTUDIANTE -->
                 <!-- <div id="student" class="divform">
            <div class="plan-header bg-quaternary" style="border-radius: 30px 30px 0 0;">
            <a href="" class="cambiar_plan">< Cambiar plan</a>
            <h3 class="font-weight-bold" style="color: #fff;font-size: 16px; padding: 14px;"><?php echo $textos[$lang]['student'] ?></h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-email-student" class="form" action="javascript:veryfyStudent()">
                        <div class="for-login1">
                            <div class="form-group form-group3">
                            <label for="email_student"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                            <input type="email" class="form-control" name="email_student" id="email_student" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                            <small id="emailHelp" class="form-text text-muted"></small>
                            <input type="hidden" id="typeLogin_student" name="typeLogin_student" value="verify">
                        </div>
                            <div class="form-group form-group3">
                            <div class="password_student" style="display: none;">
                                <div class="form-group form-group3">
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
                                <div class="form-group form-group3">
                                    <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>
                                    <input type="password" class="form-control" name="newpassword_student" id="newpassword_student" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                </div>
                                <div class="form-group form-group3">
                                    <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>
                                    <input type="password" class="form-control" name="repeatpassword_student" id="repeatpassword_student" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>
                                </div>
                            </div>
                            </div>
                        </div>
                        

                        <div id="mensajeError_student" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        <div class="form-group ">
                            <a type="submit" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="" data-appear-animation-delay="300" data-appear-animation-duration="1.7s" id="veryfy_student"><?php echo $textos[$lang]['continue'] ?></a></div>
                    </form>
                </div>
            </div>
        </div> -->

                 <section class="section-height-2 section-with-shape-divider border-0  pt-5 pb-0">
                     <div class="container" id="student" style="display: none">
                         <div class="row justify-content-center pb-2 mb-5 align-items-end">
                             <div class="col">
                                 <h1 class="font-weight-bold text-dark text-center">
                                     <?php echo $textos[$lang]['student'] ?>
                                 </h1>
                                 <p>Todos los campos con un (*) son obligatorios.</p>

                                 <div class="card bg-color-grey mb-4">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col">
                                                 <form class="contact-form form-style-2 form-fields-rounded"
                                                     id="form-verify-email-student" action="javascript:veryfyStudent()"
                                                     method="POST">
                                                     <div class="contact-form-success alert alert-success d-none mt-4">
                                                         <strong>Éxito!</strong> Su mensaje fue enviado.
                                                     </div>
                                                     <div class="contact-form-error alert alert-danger d-none mt-4">
                                                         <strong>Error!</strong> Hubo un error al enviar el mensaje.
                                                         <span class="mail-error-message text-1 d-block"></span>
                                                     </div>

                                                     <div class="row">
                                                         <div class="form-group col">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                                             <input value="" type="email" name="email_student"
                                                                 id="email_student"
                                                                 data-msg-required="<?php echo $textos[$lang]['enter_email'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />
                                                             <input type="hidden" id="typeLogin_student"
                                                                 name="typeLogin_student" value="verify">
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="form-group col password_student"
                                                             style="display: none;">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold "><?php echo $textos[$lang]['password'] ?></label>
                                                             <input type="password" id="password_student"
                                                                 name="password_student" value=""
                                                                 data-msg-required="Please enter your email address."
                                                                 data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />

                                                         </div>
                                                         <div class="newpassword_student form-group col"
                                                             style="display: none;">
                                                             <br>
                                                             <div style="font-weight: bold;">
                                                                 <?php echo $textos[$lang]['new_user'] ?>
                                                                 <div class="form-group col">
                                                                     <label
                                                                         class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['new_password'] ?></label>
                                                                     <input type="password" id="newpassword_student"
                                                                         name="newpassword_student" value=""
                                                                         data-msg-required="Please enter your email address."
                                                                         data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                         maxlength="100"
                                                                         class="form-control text-3 h-auto py-2"
                                                                         required />
                                                                 </div>
                                                                 <div class="form-group col">
                                                                     <label
                                                                         class="form-label mb-1 mt-3 text-3 font-weight-bold"><?php echo $textos[$lang]['new_password'] ?></label>
                                                                     <input type="password" id="repeatpassword_student"
                                                                         name="repeatpassword_student" value=""
                                                                         data-msg-required="Please enter your email address."
                                                                         data-msg-email="<?php echo $textos[$lang]['repeat_password'] ?>"
                                                                         maxlength="100"
                                                                         class="form-control text-3 h-auto py-2"
                                                                         required />
                                                                 </div>

                                                             </div>
                                                         </div>
                                                     </div>

                                                     <div id="mensajeError_student"
                                                         class="contact-form-error alert alert-danger mt-4 in"
                                                         style="font-size: 14px; display: none"></div>

                                                     <div class="row">
                                                         <div class="form-group col mt-3">
                                                             <input type="submit"
                                                                 value="<?php echo $textos[$lang]['continue'] ?>"
                                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-5 btn-py-3 btn-mb-5 mb-3"
                                                                 data-loading-text="Cargando..." id="veryfy_student" />
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </section>

                 <!-- FORMULARIO GUEST -->
                 <!-- <div id="guest" class="divform" >
            <div class="plan-header bg-secondary" style="border-radius: 30px 30px 0 0;">
            <a href="" class="cambiar_plan">< Cambiar plan</a>
            <h3 class="font-weight-bold" style="color: #fff;font-size: 16px; padding: 14px;"><?php echo $textos[$lang]['guest'] ?></h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-verify-email-guest" class="form" action="javascript:veryfyGuest()">
                        <div class="for-login1">
                            <div class="form-group form-group3">
                                <label for="email"><?php echo $textos[$lang]['please_enter_email'] ?></label>
                                <input type="email" class="form-control" name="email_guest" id="email_guest" required aria-describedby="emailHelp" placeholder="<?php echo $textos[$lang]['enter_email'] ?>">
                                <small id="emailHelp" class="form-text text-muted"></small>
                                <input type="hidden" id="typeLogin_guest" name="typeLogin_guest" value="verify">
                            </div>
                            <div class="form-group form-group3">
                                <div class="coupon_code" style="display: none;">
                                    <div class="form-group  form-group3">
                                        <label for="coupon_code"><?php echo $textos[$lang]['coupon'] ?></label>
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="<?php echo $textos[$lang]['enter_coupon'] ?>" autocomplete="off">
                                    </div>
                                   
                                </div>
                                <div class="password_guest" style="display: none;">
                                    <div class="form-group  form-group3">
                                        <label for="password"><?php echo $textos[$lang]['password'] ?></label>
                                        <input type="password" class="form-control" name="password_guest" id="password_guest" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group  form-group3">
                                        <a href="/ingresar/?action=forgot_password" target="_blank" style="color: #1f5494 !important;"><?php echo $textos[$lang]['forgot_password'] ?></a>
                                    </div>
                                </div>
        
                                <div class="newpassword_guest" style="display: none;">
                                    <br>
                                    <div style="font-weight: bold;"><?php echo $textos[$lang]['new_user'] ?></div>
                                    <div class="form-group  form-group3">
                                        <label for="password"><?php echo $textos[$lang]['new_password'] ?></label>
                                        <input type="password" class="form-control" name="newpassword_guest" id="newpassword_guest" placeholder="<?php echo $textos[$lang]['enter_password'] ?>" required>
                                    </div>
                                    <div class="form-group  form-group3">
                                        <label for="password"><?php echo $textos[$lang]['repeat_password'] ?></label>
                                        <input type="password" class="form-control" name="repeatpassword_guest" id="repeatpassword_guest" placeholder="<?php echo $textos[$lang]['repeat_password'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeError_guest" class="alert alert-danger in" style="font-size: 14px;display:none;"></div>
                        <div class="form-group "><a type="submit" class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-3 btn-py-2 appear-animation" data-hash data-hash-offset="0" data-hash-offset-lg="32" data-appear-animation="" data-appear-animation-delay="300" data-appear-animation-duration="1.7s" id="veryfy_guest"><?php echo $textos[$lang]['continue'] ?></a></div>
                    </form>
                </div>
            </div>
        </div> -->
                 <!-- <section
  class="section-height-2 section-with-shape-divider border-0 lazyload pt-5 pb-0"
>
  <div class="container" id="guest" style="display: none">
    <div class="row justify-content-center pb-2 mb-5 align-items-end">
      <div class="col">
        <h1 class="font-weight-bold text-dark text-center">
          <?php echo $textos[$lang]['guest'] ?>
        </h1>
        <p>Todos los campos con un (*) son obligatorios.</p>

        <div class="card bg-color-grey mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <form
                  class="contact-form form-style-2 form-fields-rounded"
                  id="form-verify-email-guest"
                  action="javascript:veryfyGuest()"
                  method="POST"
                >
                  <div
                    class="contact-form-success alert alert-success d-none mt-4"
                  >
                    <strong>Éxito!</strong> Su mensaje fue enviado.
                  </div>
                  <div
                    class="contact-form-error alert alert-danger d-none mt-4"
                  >
                    <strong>Error!</strong> Hubo un error al enviar el mensaje.
                    <span class="mail-error-message text-1 d-block"></span>
                  </div>

                  <div class="row">
                    <div class="form-group col">
                      <label
                        class="form-label mb-1 mt-3 text-3 font-weight-bold"
                        ><?php echo $textos[$lang]['please_enter_email'] ?></label
                      >
                      <input
                        value=""
                        type="email"
                        name="email_guest"
                        id="email_guest"
                        data-msg-required="<?php echo $textos[$lang]['enter_email'] ?>"
                        maxlength="100"
                        class="form-control text-3 h-auto py-2"
                        required
                      />
                      <input
                        type="hidden"
                        id="typeLogin_guest"
                        name="typeLogin_guest"
                        value="verify"
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="row coupon_code" style="display: none">
                      <div class="form-group col">
                        <label
                          class="form-label mb-1 mt-3 text-3 font-weight-bold"
                          ><?php echo $textos[$lang]['coupon'] ?></label
                        >
                        <input
                          type="text"
                          id="coupon_code"
                          name="coupon_code"
                          value=""
                          data-msg-required="Please enter your password."
                          data-msg-email="<?php echo $textos[$lang]['enter_coupon'] ?>"
                          maxlength="100"
                          class="form-control text-3 h-auto py-2"
                          required
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="row password_guest" style="display: none">
                      <div class="form-group col">
                        <label
                          class="form-label mb-1 mt-3 text-3 font-weight-bold"
                          ><?php echo $textos[$lang]['password'] ?></label
                        >
                        <input
                          type="password"
                          id="password_guest"
                          name="password_guest"
                          value=""
                          data-msg-required="Please enter your password."
                          data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                          maxlength="100"
                          class="form-control text-3 h-auto py-2"
                          required
                        />
                      </div>
                    </div>
                  </div>
                    <div
                      class="newpassword_guest form-group col"
                      style="display: none"
                    >
                      <br />
                      <div style="font-weight: bold">
                        <?php echo $textos[$lang]['new_user'] ?>
                        <div class="form-group col">
                          <label
                            class="form-label mb-1 mt-3 text-3 font-weight-bold"
                            ><?php echo $textos[$lang]['new_password'] ?></label
                          >
                          <input
                            type="password"
                            id="newpassword_guest"
                            name="newpassword_guest"
                            value=""
                            data-msg-required="Please enter your email address."
                            data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                            maxlength="100"
                            class="form-control text-3 h-auto py-2"
                            required
                          />
                        </div>
                        <div class="form-group col">
                          <label
                            class="form-label mb-1 mt-3 text-3 font-weight-bold"
                            ><?php echo $textos[$lang]['new_password'] ?></label
                          >
                          <input
                            type="password"
                            id="repeatpassword_guest"
                            name="repeatpassword_guest"
                            value=""
                            data-msg-required="Please enter your email address."
                            data-msg-email="<?php echo $textos[$lang]['repeat_password'] ?>"
                            maxlength="100"
                            class="form-control text-3 h-auto py-2"
                            required
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <div
                    id="mensajeError_guest"
                    class="contact-form-error alert alert-danger mt-4 in"
                    style="font-size: 14px; display: none"
                  ></div>

                  <div class="row">
                    <div class="form-group col mt-3">
                      <input
                        type="submit"
                        value="<?php echo $textos[$lang]['continue'] ?>"
                        class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-5 btn-py-3 btn-mb-5 mb-3"
                        data-loading-text="Cargando..."
                        id="veryfy_guest"
                      />
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
                 <section class="section-height-2 section-with-shape-divider border-0  pt-5 pb-0">
                     <div class="container" id="guest" style="display: none">
                         <div class="row justify-content-center pb-2 mb-5 align-items-end">
                             <div class="col">
                                 <h1 class="font-weight-bold text-dark text-center">
                                     <?php echo $textos[$lang]['guest'] ?>
                                 </h1>
                                 <p>Todos los campos con un (*) son obligatorios.</p>

                                 <div class="card bg-color-grey mb-4">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col">
                                                 <form class="contact-form form-style-2 form-fields-rounded"
                                                     id="form-verify-email-guest" action="javascript:veryfyGuest()"
                                                     method="POST">
                                                     <div class="contact-form-success alert alert-success d-none mt-4">
                                                         <strong>Éxito!</strong> Su mensaje fue enviado.
                                                     </div>
                                                     <div class="contact-form-error alert alert-danger d-none mt-4">
                                                         <strong>Error!</strong> Hubo un error al enviar el mensaje.
                                                         <span class="mail-error-message text-1 d-block"></span>
                                                     </div>

                                                     <div class="row">
                                                         <div class="form-group col">
                                                             <label
                                                                 class="form-label mb-1 mt-3 text-3 font-weight-bold">
                                                                 <?php echo $textos[$lang]['please_enter_email'] ?>
                                                             </label>
                                                             <input value="" type="email" name="email_guest"
                                                                 id="email_guest"
                                                                 data-msg-required="<?php echo $textos[$lang]['enter_email'] ?>"
                                                                 maxlength="100" class="form-control text-3 h-auto py-2"
                                                                 required />
                                                             <input type="hidden" id="typeLogin_guest"
                                                                 name="typeLogin_guest" value="verify" />
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="row coupon_code" style="display: none">
                                                             <div class="form-group col">
                                                                 <label
                                                                     class="form-label mb-1 mt-3 text-3 font-weight-bold">
                                                                     <?php echo $textos[$lang]['coupon'] ?>
                                                                 </label>
                                                                 <input type="text" id="coupon_code"
                                                                     name="coupon_code" value=""
                                                                     data-msg-required="Please enter your Coupon Code."
                                                                     data-msg-email="<?php echo $textos[$lang]['enter_coupon'] ?>"
                                                                     maxlength="100"
                                                                     class="form-control text-3 h-auto py-2" required  autocomplete="off"/>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="row">
                                                         <div class="row password_guest" style="display: none">
                                                             <div class="form-group col">
                                                                 <label
                                                                     class="form-label mb-1 mt-3 text-3 font-weight-bold">
                                                                     <?php echo $textos[$lang]['password'] ?>
                                                                 </label>
                                                                 <input type="password" id="password_guest"
                                                                     name="password_guest" value=""
                                                                     data-msg-required="Please enter your password."
                                                                     data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                     maxlength="100"
                                                                     class="form-control text-3 h-auto py-2" required />
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="newpassword_guest form-group col"
                                                         style="display: none">
                                                         <br />
                                                         <div style="font-weight: bold">
                                                             <?php echo $textos[$lang]['new_user'] ?>
                                                             <div class="form-group col">
                                                                 <label
                                                                     class="form-label mb-1 mt-3 text-3 font-weight-bold">
                                                                     <?php echo $textos[$lang]['new_password'] ?>
                                                                 </label>
                                                                 <input type="password" id="newpassword_guest"
                                                                     name="newpassword_guest" value=""
                                                                     data-msg-required="Please enter your email address."
                                                                     data-msg-email="<?php echo $textos[$lang]['enter_password'] ?>"
                                                                     maxlength="100"
                                                                     class="form-control text-3 h-auto py-2" required />
                                                             </div>
                                                             <div class="form-group col">
                                                                 <label
                                                                     class="form-label mb-1 mt-3 text-3 font-weight-bold">
                                                                     <?php echo $textos[$lang]['new_password'] ?>
                                                                 </label>
                                                                 <input type="password" id="repeatpassword_guest"
                                                                     name="repeatpassword_guest" value=""
                                                                     data-msg-required="Please enter your email address."
                                                                     data-msg-email="<?php echo $textos[$lang]['repeat_password'] ?>"
                                                                     maxlength="100"
                                                                     class="form-control text-3 h-auto py-2" required />
                                                             </div>
                                                         </div>
                                                     </div>


                                                     <div id="mensajeError_guest"
                                                         class="contact-form-error alert alert-danger mt-4 in"
                                                         style="font-size: 14px; display: none"></div>

                                                     <div class="row">
                                                         <div class="form-group col mt-3">
                                                             <input type="submit"
                                                                 value="<?php echo $textos[$lang]['continue'] ?>"
                                                                 class="btn btn-rounded btn-gradient-azul text-color-light custom-btn-effect-1 custom-border-radius-1 d-inline-flex align-items-center font-weight-semibold text-3-5 btn-px-5 btn-py-3 btn-mb-5 mb-3"
                                                                 data-loading-text="Cargando..." id="veryfy_guest" />
                                                         </div>
                                                     </div>
                                                 </form>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </section>

             </div>
             <div class="clear"></div>
         </div>

         <div class="row paso1">
             <div class="col-md-3" id="vacio"></div>
         </div>

         <div class="container">
             <div class="twelve columns">
                 <div id="loadingimage" style="text-align:center;display:none;"><img
                         src="https://asipi.org/wp-content/uploads/2016/05/loading.gif">
                     <p><?php if ($lang == 'en-US'): ?>Please wait...<?php else: ?>Por favor espere...<?php endif ?></p>
                 </div>
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
         iframe {
             display: none;
         }

         .soldout {
             color: #f00;
             font-weight: bold;
         }

         .btn_waiting {
             background-color: #009e4a;
             padding: 10px;
             color: #fff;
         }

         .columns {
             float: left !important;
         }
         </style>
         <?php require_once plugin_dir_path(__FILE__) . 'jotform.php'; ?>
         <?php echo do_shortcode( '[are_planesasuncion2026]' ); ?>
         <?php /* ?>
         <div class="container">
             <div class="twelve columns" style="text-align: justify;">
                 <div class="cont_list">
                     <p><b><?php echo $textos[$lang]['policies_title'] ?></b></p>
                     <?php if($lang!='en'){?>
                     <ul>
                         <li>Cancelaciones recibidas hasta el <b>15 de Octubre inclusive</b>, tendrán una devolución
                             total menos un <b>10%</b> por gastos administrativos.**</li>
                         <li>Cancelaciones recibidas entre el <b>16 de Octubre al 7 de Noviembre inclusive</b>, tendrán
                             una devolución del <b>50%. **</b></li>
                         <li>Cancelaciones recibidas a partir del <b>8 de noviembre, no tienen devolución.</b></li>
                         <li>En caso de obtener un resultado positivo de COVID-19 previo a su viaje al Evento, se
                             realizará la devolución total de la inscripción contra la presentación de un certificado
                             médico que confirme su estado.</li>
                     </ul>
                     <p>** Las devoluciones serán realizadas por la porción de la inscripción correspondiente únicamente
                         a la participación en el evento. Por la porción de alojamiento, ver las condiciones de Hotel.
                     </p>
                     <br>
                     <p><b>Cancelación del Evento por Parte de ASIPI:</b></p>
                     <p>En caso que ASIPI considere conveniente postergar el evento para el año 2022, velando por la
                         seguridad de sus participantes, el importe abonado por concepto de registro completo
                         (inscripción + alojamiento), será honrado para la nueva fecha que se confirme el Congreso en la
                         misma Sede el próximo año.</p>
                     <?php }else{ ?>
                     <ul>
                         <li>Cancellations received until <b>October 15 inclusive</b>, will receive a total refund minus
                             <b>10%</b> for administrative expenses. **</li>
                         <li>Cancellations received between <b>October 16 to November 7 inclusive</b>, will receive a
                             <b>50%</b> refund. **</li>
                         <li>Cancellations received after <b>November 8</b>, will not be refunded.</li>
                         <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund
                             of the registration will be made presenting a medical certificate confirming your status.
                         </li>
                     </ul>
                     <p>** Refunds will be made for the portion of the registration corresponding only to participation
                         in the event. For the accommodation portion, see the Hotel conditions.</p>
                     <br>
                     <p><b>HOTEL</b></p>
                     <ul>
                         <li>ASIPI is not responsible for reservations, changes, hotel cancellation and/or any other
                             matter related to the hotel regarding the attendees to the Event. All these issues should
                             be dealt directly with Perspectiva M&T (booking@asipi.org).</li>
                         <li>Cancellations received between 60 to 31 days prior to check-in, a penalty of 10% of the
                             total accommodation will be charged.</li>
                         <li>From 30 days prior to check-in, there is no refund.</li>
                         <li>In the event of a positive COVID-19 result prior to your trip to the Event, a full refund
                             of the registration will be made presenting a medical certificate confirming your status.
                         </li>
                     </ul>
                     <br>
                     <p><b>Cancellation of The Event by ASIPI</b></p>
                     <p>In the event that ASIPI considers convenient to postpone the event for the year 2022, ensuring
                         the safety of its participants, the amount paid for full registration (registration +
                         accommodation) will be honored for the new date of the Congress in the same venue next year.
                     </p>

                     <?php } ?>
                 </div>
             </div>
         </div>
         <?php */ ?>
     </div>
     </div>
 </section>
 <style>
.card-body {
    /*min-height: 178px !important;*/
}

.se-main-progress {
    display: none !important;
}
 </style>
 <script>
var tipo_asistencia = 'Presencial';
 </script>
