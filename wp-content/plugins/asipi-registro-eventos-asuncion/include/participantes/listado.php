<?php 
//echo "llego";die;

add_shortcode( 'listado_participantes', function () {
    

	echo '<br>

			<style type="text/css">
  span.dt-column-title {
    color: #ffffff;
}
  thead{ border-style: none;}
  th.desktop.tablet-1.tablet-p.bg-primary.dt-orderable-asc.dt-orderable-desc, th.all.bg-primary.dt-orderable-asc.dt-orderable-desc.dt-ordering-asc{
    border-style: none;
  }
  thead >tr {
    border-style: none;
}
  div.container{max-width:1200px;}
  input#dt-search-0 {
    padding-right: 15px;
}
			.avatar{

			max-width:60px;

			}

            .btnlogincont{

                cursor: pointer;

                padding: 8px;

                border: 1px solid #00873f;

                margin-top: 10px;

                margin-bottom: 20px;

            }
            .login-app{
                display:block
            }
div#contenedor-listado {
    display: flex
;
}
  #listado td {
  padding: 15px;
}
			</style>';

	

	global $wpdb;

	global $blog_id;

		

	$asipiPath = $_SERVER['DOCUMENT_ROOT'];

    require ( $asipiPath . '/wp-load.php');

    //require ( $asipiPath . '/asipi-helper/montevideo2020/_config.php');




    $lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;

    $event_id = $blog_id;



    $current_user = wp_get_current_user();

    $user_id = $current_user->ID;

    $sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and estado IN ('C','E','R','P') and evento_id = '$event_id'";

    $user_id_2 = $wpdb->get_var($sql_user);

    $user_is_secretary = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND (meta_value LIKE "%tesoreria%" or meta_value LIKE "%secretaria%")  AND user_id ='.$user_id);

    if ( current_user_can('manage_options') || $user_is_secretary !=NULL ) {

        //el usuario actual es administrador

        $user_id_2 = $current_user->ID;

    }



    $user_is_member = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND meta_value LIKE "%secretaria%" AND user_id ='.$user_id);


	if($user_id_2 == NULL){

		// NO REGISTRADO (NO SOCIO - ESTUDIANTE)

        

        //echo wp_logout_url( home_url() );

        //echo '<div style="display:none">'.$sql_user.'</div>';



        ?>

        <div class="twelve columns">



            <div class="four columns" align="center">

                .              

            </div>



            <div class="four columns" align="center">
   

                <div class="twelve columns">

 <section class="section-height-2 section-with-shape-divider border-0 lazyload pt-5 pb-0" >

             <div class="container">
                

                                 <div class="col-md-10 appear-animation evento bg-color-grey mt-5" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                                   <div class="card border-0">
                                     <div class="card-body text-center bg-color-grey">
                                       <h4>NOTA:</h4>
                                       <p><?php echo __("<!--:es-->Debe Ingresar con su usuario y contraseña para acceder al listado.<!--:--><!--:en-->Please login with your email and password to access the list.<!--:-->") ?></p>
                                     </div>
                                   </div>
                                 </div>

                </div>
             </div>
          </section>

                    <div class="four columns" align="center">

                        .              

                    </div>



                    <div class="four columns" align="center">

                        </br >

                       

                    </div>
                    <div class="four columns login-app" align="center">

                        </br >

                        

                    </div>

        



                </div>

                <br>

                <br>

            </div>

 



        </div>

            <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

            <script>

            jQuery( "document" ).ready( function() { 

                jQuery( "#loginlik" ).click( function() { 

                    jQuery( ".login-button" ).trigger( "click" ); 

                } ); 

            } ); 

            </script>

        

        <?php



        //exit();

	}else{


 echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.css" />
 <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/r-3.0.3/datatables.min.js"></script>';
      
        $objUser = new stdClass();

		echo ' <div class="twelve columns">';
        echo '<div class="container twelve columns" ><br>';
        $resp= '
        	<table id="listado" class="compact  hover" style="width:100%;text-align:left;">
		    <thead>
		    <tr>
		           
		            <th class="all  "  width="30%" style="text-align:center; background-color:#255e70; color:#fff;">'.__("<!--:es-->Nombre<!--:--><!--:en-->Name<!--:-->").'</th>
		            <th class="desktop " width="30%" style="text-align:center;background-color:#255e70; color:#fff;">'.__("<!--:es-->Firma<!--:--><!--:en-->Law Firm<!--:-->").'</th>
                    <th class="desktop " style="text-align:center; background-color:#255e70; color:#fff;">'.__("<!--:es-->País<!--:--><!--:en-->Country<!--:-->").'</th>
                    <th class="desktop tablet-1 tablet-p " width="20%" style="text-align:center; background-color:#255e70; color:#fff">'.__("<!--:es-->Contactar<!--:--><!--:en-->Contact<!--:-->").'</th>
      	  </tr>	      
      </thead>        
          
              <tbody>';

        $ord = 2 ;



        if (isset($_POST['order'])){

            $ord = ($_POST['order'] == "country") ? 44 : 2 ;

        }



        if (isset($_POST['lang'])){

            $lang = ($_POST['lang'] == "en-US") ? 'en' : 'es' ;

        }



        if($ord==44){

            $sql = 'SELECT distinct o.pwisa_users_ID, p.value,c.name_'.$lang.',

                    (select ta.valor from evento_info_adicional as ta where ta.orden_id = o.id and ta.clave="tipo_asistencia" limit 1) as tipo_asistencia  

                    FROM evento_orden as o,pwisa_bp_xprofile_data as p,country_names as c 

                    WHERE o.estado IN ("C","E","R") AND o.visible=1 AND o.paso = 4 AND o.evento_id = ' . $event_id . ' AND o.pwisa_users_ID = p.user_id AND p.field_id = ' .$ord.' AND c.id=p.value ORDER BY c.name_'.$lang;

        }else{

           $sql = 'SELECT distinct o.pwisa_users_ID, p.value,

                    (select ta.valor from evento_info_adicional as ta where ta.orden_id = o.id and ta.clave="tipo_asistencia" limit 1) as tipo_asistencia  

                    FROM evento_orden as o,pwisa_bp_xprofile_data as p 

                    WHERE o.estado IN ("C","E","R",P) AND o.visible=1 AND o.paso = 4 AND o.tipo <> 3 AND o.evento_id = ' . $event_id . ' AND o.pwisa_users_ID = p.user_id AND p.field_id = ' .$ord.' ORDER BY p.value';
               // $sql ='SELECT o.pwisa_users_ID,p.value, "Presencial" AS tipo_asistencia  fROM evento_orden as o,pwisa_bp_xprofile_data AS p WHERE o.estado IN ("C","E","R","P") AND o.subnumero=1 AND o.visible=1 AND o.paso = 4  AND o.evento_id = ' . $event_id . '   AND p.field_id = ' .$ord.'  AND o.pwisa_users_ID = p.user_id ORDER BY p.value';
                $sql ='SELECT eo.*, "Presencial" AS tipo_asistencia, MAX(CASE WHEN xd.field_id = 1 THEN xd.value END) AS name, MAX(CASE WHEN xd.field_id = 2 THEN xd.value END) AS last, MAX(CASE WHEN xd.field_id = 12 THEN xd.value END) AS firm, MAX(CASE WHEN xd.field_id = 44 THEN xd.value END) AS country FROM evento_orden eo LEFT JOIN pwisa_bp_xprofile_data xd ON eo.pwisa_users_ID = xd.user_id WHERE eo.evento_id=' . $event_id . '  and eo.estado IN ("C","E","R","P") and eo.subnumero=1 AND eo.visible=1 AND eo.paso = 4 GROUP BY eo.id;' ;
      }

        $attendees = $wpdb->get_results($sql);
   
        foreach ($attendees as $att) {
          $boton_enviar='';
			if($att->pwisa_users_ID != 6112)
          		$boton_enviar = '<a class="btn btn-rounded font-weight-semibold text-3 p-relative bottom-1 custom-header-1-btn-1 " style="background-color:#255e70; color:#fff;" align="center" href="https://asipi.org/asuncion2026/contacto-a-participantes/?id='.$att->pwisa_users_ID.'">'.__("<!--:es-->Enviar Mensaje<!--:--><!--:en-->Send Message<!--:-->").'</a>';
            if($att->tipo_asistencia == 'Presencial'){
                //name
               $objUser->name = ucwords(strtolower($att->name));
                //last
              $objUser->last = ucwords(strtolower($att->last));  
                 $objUser->firm = $att->firm; 
               
                 $sqlCountry = $wpdb->get_var('SELECT name_'.$lang.' FROM country_names where id ='.$att->country); 

                $objUser->Country = $sqlCountry;


                $resp.= '

                                <tr >

                                

                                   <td style=" align-content: center;">

                                        '.$objUser->last.', '.$objUser->name.'              

                                    </td>

                                    

                                    <td style=" align-content: center;" class="notranslate">

                                        '.$objUser->firm.'

                                    </td>

                                    

                                    <td style="align-content: center;">

                                        '.$objUser->Country.'

                                    </td>    

                                  

                                    <td style="text-align: center; align-content: center;">'.$boton_enviar.'

                                
                                    </td>    



                                </tr>';

            }



            



        }
        echo $resp;

        echo ' </tbody></table>';

        

      
        echo '</div>';
		echo '</div>';
        echo '

    

        <style>
      
            #button-back{display:none;}

            @media only screen and (max-width: 400px) {

                .nombreUser{

                    text-align: center;

                }

                #button-back{display:block;}

                .avatar{

                    padding-bottom: 10px;

                    width: 60px;

                }

            }

        </style>';
        
        
         echo '<script>

   
function search_attendant() {
    let input = document.getElementById("searchbar").value
    input=input.toLowerCase();
    let x = document.querySelectorAll("div.nombreUser > p");
      
    for (i = 0; i < x.length; i++) { 
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            let parent = x[i].parentElement;
            parent.parentElement.style.display="none";
            parent.parentElement.nextElementSibling.style.display="none";
        }
        else {
            x[i].parentElement.style.display="block";                 
        }
    }
}


         
            </script>';
	echo '	<script> 
     
	 new DataTable("#listado", {
      destroy: true,
      responsive:true,
      columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 },
        { responsivePriority: 3, targets: 1 },
        { responsivePriority: 4, targets: 2 },

        
    ],
      
       paging: true,
       
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        "sSearch": "[:es]Buscar:[:en]Search:[:]",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "[:es]Primero[:en]First[:]",
            "sLast":    "[:es]Último[:en]Last[:]",
            "sNext":    "[:es]Siguiente[:en]Next[:]",
            "sPrevious": "[:es]Anterior[:en]Prev[:][:]"
        },
       
        
      
        "sInfo": "[:en][:es][:]",
  "sInfoEmpty": "[:en][:es][:]",
  "sInfoFiltered": "[:en][:es][:]"
    }
}); 
     


	</script>';
    }



} );



add_shortcode( 'contacto_participantes', function () {

	

    global $wpdb;

	$memberid = $_REQUEST['id'];

	$senderQuery = "SELECT user_email FROM pwisa_users WHERE ID='".$memberid."'";

	$result = $wpdb->get_results( $senderQuery );

    

	if (count($result) > 0) {

		foreach ($result as $data) {

			$recipient = $data->user_email;

			echo '<script>var recipient = "'.$recipient.'";</script>';

		}

	}else{

        //echo 'fff';

    }

    

	echo '

    <script>

		window.onload = function() {

			inputs = document.getElementsByClassName("nomb_contact");



			campo = inputs[0];

			campo.setAttribute("onkeypress", "return alpha(event)");

            campo.setAttribute("onchange", "return alpha(event)");



		};



		function alpha(e) {

			//document.getElementById("email-member").value = recipient; 

            document.getElementById("email-member").setAttribute("value", recipient);

            console.log(recipient);

			var k;

			document.all ? k = e.keyCode : k = e.which;

			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 ); //|| (k >= 48 && k <= 57)

		}
		
	
 
	</script>';
	


});