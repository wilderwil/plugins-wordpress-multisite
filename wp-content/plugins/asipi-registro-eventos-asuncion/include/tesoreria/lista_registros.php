<?php https://asipi.org

    //var_dump($data);exit();

	global $wpdb;

	/*if ($_GET['del'] and $_GET['del']>=0) { 

		$Delete = "UPDATE asipi_cursos_registros SET estado = '0' WHERE id = '".$_GET['del']."'";

		$queryResult = $wpdb->get_results($Delete);

		echo '<div class="updated notice">

			Registro "'.$_GET['del'].'" eliminado con exito.

		</div>';

	}  */

    $sql = "SELECT * FROM asipi_cursos_registros where estado = '1' order by id desc";

    $qryCurso = $wpdb->get_results($sql);

    $data = $qryCurso;//json_decode(json_encode($qryCurso), true);

    /*echo '<pre>';

    var_dump($data);

    echo '</pre>';

    exit();*/

 ?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/cr-1.5.2/fh-3.1.6/r-2.2.3/rr-1.2.6/sl-1.3.1/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/cr-1.5.2/fh-3.1.6/r-2.2.3/rr-1.2.6/sl-1.3.1/datatables.min.js"></script>



<link href="https://www.asipi.org/wp-content/themes/enterprise-pro/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" >

<script src="https://www.asipi.org/wp-content/themes/enterprise-pro/js/jquery-ui/jquery-ui.min.js" ></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.2.5/css/tableexport.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>

<!--link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div id="page-content">   

		<br>

		<h1>Registros en Cursos ASIPI Académia

        <a href="admin.php?page=teso-settings&tab=7&new=true" class="page-title-action">Nuevo Registro</a>

        <a href="" id="menuEnviarCertificado" class="page-title-action">Enviar Certificados</a>

        <!-- <a href="admin.php?page=teso-settings&tab=5&workshops=true&event=<?php echo $event_id ?>" class="page-title-action">Registrados en Talleres</a> -->

        <!-- <a href="admin.php?page=teso-settings&tab=5&sports=true&event=<?php echo $event_id ?>" class="page-title-action">Registrados en Actividades</a> -->

        <!-- <a href="admin.php?page=teso-settings&tab=5&guests=true&event=<?php echo $event_id ?>" class="page-title-action">Listado de Acompañantes</a> -->

		</h1>

		<div id="bloqueEnviarCertificado" hidden>

			<br>

			<form action="/wp-admin/admin.php?page=teso-settings&tab=7" method="post" >

				<h4>Enviar todos los certificados del curso: </h4> 

				<select name="certificado" id="selCertificado">

					<option value="">Seleccione Curso</option>

				</select>

				<input type="hidden" name="todos" value="true">

				<button type="submit">Enviar Certificados</button>

			</form>

			<br>

		</div>

        <br>

		<table id="example" class="display" style="width:100%">

		    <thead>

		        <tr>

		            <th>Id</th>

                    <th>Fecha</th>

                    <th>Curso</th>

		            <th>Email</th>

		            <th>Alumno</th>

		            <th>Perfil</th>

		            <th>Pais</th>

		            <th>Referencia</th>

                    <th>Monto Pagado</th>

                    <th>Acciones</th>

		        </tr>

		    </thead>

		    <style>

		    	.vencido{

		    		color: #fb6666;

		    	}

		    </style>

		    <tbody>

				<?php

				function traslateText($nombre_curso)

				{

					$posEN = strpos($nombre_curso, '[:en]');

					if ($posEN !== false) {

						$posES = strpos($nombre_curso, '[:es]');

						if ($posES !== false) {

							$nombre_curso = substr($nombre_curso, $posES+5, $posEN-5);

						} 

					} 

					return $nombre_curso;

				}

				?>

				<?php if ($data) {?>

				<?php $arrayCursos = array(); ?>

		    	<?php foreach ($data as $key => $value): ?>

					<?php 

						if($value->tipo_curso=='C'){

							$sql = "SELECT id, nombre FROM pwisa_asipi_cursos WHERE id=$value->curso_id limit 1";

							$qryCurso = $wpdb->get_results($sql);

							$qryCurso = json_decode(json_encode($qryCurso), true);

							$nombre_curso = traslateText($qryCurso[0]['nombre']);

						}elseif($value->tipo_curso=='M'){

							$sql = "SELECT id, titulo, id_asipi_cursos FROM pwisa_asipi_cursos_modulo WHERE id=$value->curso_id limit 1";

							$qryModulo = $wpdb->get_results($sql);

							$qryModulo = json_decode(json_encode($qryModulo), true);

						

							$sql = "SELECT id, nombre, costo_socio, costo_miembro, costo_nosocio, cant_modulos, cupos FROM pwisa_asipi_cursos WHERE id=".$qryModulo[0]['id_asipi_cursos']." limit 1";

							$qryCurso = $wpdb->get_results($sql);

							$qryCurso = json_decode(json_encode($qryCurso), true);

						

							$nombre_curso = traslateText($qryCurso[0]['nombre']).' Modulo: '.traslateText($qryModulo[0]['titulo']);

						}

						$arrayCursos[$value->curso_id] = $nombre_curso;

						



						if ($value->pwisa_users_ID>0) {
                            $sql = "SELECT value FROM `pwisa_bp_xprofile_data` where user_id = $value->pwisa_users_ID and field_id = 7 order by id desc limit 1";
                            $dPais = $wpdb->get_var($sql);
							#$dPais =  bp_get_profile_field_data( array('user_id'	=> $value->pwisa_users_ID,'field'	=> 7) );

							if(is_numeric($dPais)){

								$countryName = $wpdb->get_var("SELECT name_es FROM country_names WHERE id = " . $dPais);

							}else{

								$countryName = $dPais;

							}

						} else {

							$countryName = $value->bill_country;

						}

						

						

		    		?>

		    		<tr>

                        <!--<td><a href="admin.php?page=teso-settings&tab=5&detail=<?php echo $value->id ?>"><?php echo $value->id ?></a></td>-->

						<td><?php echo $value->id ?></td>

						<td><?php 

                        //$myDateTime = DateTime::createFromFormat('Y-m-d', $value->fecha);

						//$fecha = $myDateTime->format('d-m-Y');

						$date=date_create($value->fecha);

                        echo date_format($date, 'd-m-Y'); 

                        ?></td>

						<td><?php echo __($nombre_curso); ?></td>

						<td><?php echo $value->email ?></td>

                        <td><?php echo $value->nombres ?> <?php echo $value->apellidos ?></td>

						<td>

							<?php 

							if($value->tipo=='socio'){

								echo "Socio"; 

							}else{

								echo "No Socio"; 

							}?>

						</td>

			            <td><?php echo $countryName ?></td>

			            <td><?php echo $value->pay_reference; ?></td>

			            <td><?php echo number_format((float) $value->costo, 2, '.', '') ?></td>

			            <td>

							<div id="loadingimage-<?php echo $value->id ?>"></div>

							<a style="text-decoration: none;" href="" id="btnSendInvoice" id_invoice="<?php echo $value->id ?>">Enviar Recibo</a><br>

							<a style="text-decoration: none;" href="/curso-registro-recibo/?numero=<?php echo $value->id ?>&tipo=view" target="_blank">ver Recibo</a><br>

							

							<a style="text-decoration: none;" href="/wp-admin/admin.php?page=teso-settings&tab=7&certificado=<?php echo $value->id ?>">Enviar Certificado</a><br>

							<?php $certificado = base64_encode(base64_encode( base64_encode($value->id) ) ); ?>

							<a style="text-decoration: none;" href="/curso-registro-recibo/?certificado=1&data=<?php echo $certificado ?>" target="_blank">ver Certificado</a><br>

							

		                	<a style="text-decoration: none;" href="" class="btnDeleteReg" id_delete="<?php echo $value->id ?>">Eliminar</a>

			            </td>

			        </tr>

		    	<?php endforeach ?>

			    <?php }?>    

		    </tbody>

		    <tfoot>

		        <tr>

                    <th>Id</th>

                    <th>Fecha</th>

					<th>Curso</th>

					<th>email</th>

		            <th>Alumno</th>

		            <th>Perfil</th>

		            <th>Pais</th>

		            <th>Referencia</th>

                    <th>Monto Pagado</th>

					<th>Acciones</th>

		        </tr>

		    </tfoot>

		</table>

</div>

<style>

	#select_cursos{

		width: 120px;

	}

	.col2curso{

		width: 130px !important;

	}

	.col3alumno{

		width: 220px !important;

	}

	.col5pais{

		max-width: 110px;

	}

	#select_pais{

		width: 70px;

	}

	#select_perfil{

		width: 75px;

	}

</style>

<script>

	$(document).ready(function() {

	    //$('#example').DataTable();

	    /*$('#example').DataTable( {

	    	buttons: [

		        'copy', 'excel', 'pdf'

		    ],

            "language": {

                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"

            }

		} );*/

		var buttonCommon = {

			exportOptions: {

				format: {

					header: function ( data, row, column, node ) {

						// Strip $ from salary column to make it numeric

						data = row === 2 ? 'Curso' : data;

						data = row === 5 ? 'Perfil' : data;

						data = row === 6 ? 'País' : data;



						return data

					}

				}

			}

		};

		<?php foreach ($arrayCursos as $key => $value) { ?>

			$('#selCertificado').append( '<option value="<?php echo $key; ?>"><?php echo $value; ?></option>' )

		<?php } ?>

		

	

        var table = $('#example').DataTable( {

	        dom: 'Bfrtip',

            "language": {

                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"

			},

            initComplete: function () {

	            this.api().columns([6]).every( function () {

	                var column = this;

	                var select = $('<select class="form-control form-control-sm" id="select_pais"><option value="">País</option></select>')

	                    .appendTo( $(column.header()).empty() )

	                    .on( 'change', function () {

	                        var val = $.fn.dataTable.util.escapeRegex(

	                            $(this).val()

	                        );

	 

	                        column

	                            .search( this.value )

	                            .draw();

	                    } );

	                column.data().unique().sort().each( function ( d, j ) {

	                    select.append( '<option value="'+d+'">'+d+'</option>' )

	                } );

	            } );

	            this.api().columns([5]).every( function () {

	                var column = this;

	                var select = $('<select class="form-control form-control-sm" id="select_perfil"><option value="">Perfil</option></select>')

	                    .appendTo( $(column.header()).empty() )

	                    .on( 'change', function () {

	                        var val = $.fn.dataTable.util.escapeRegex(

	                            $(this).val()

	                        );

	 

	                        column

	                            .search( this.value )

	                            .draw();

	                    } );

	                column.data().unique().sort().each( function ( d, j ) {

	                    select.append( '<option value="'+d+'">'+d+'</option>' )

	                } );

	            } );

	            this.api().columns([2]).every( function () {

	                var column = this;

	                var select = $('<select class="form-control form-control-sm" id="select_cursos"><option value="">Curso</option></select>')

	                    .appendTo( $(column.header()).empty() )

	                    .on( 'change', function () {

	                        var val = $.fn.dataTable.util.escapeRegex(

	                            $(this).val()

	                        );

	 

	                        column

	                            .search( this.value )

	                            .draw();

	                    } );

					

	                column.data().unique().sort().each( function ( d, j ) {

	                    select.append( '<option value="'+d+'">'+d+'</option>' )

	                } );

	            } );

			},

			/*buttons: [

				{

					extend: 'excelHtml5',

					text: 'Exportar a Excel',

				}

			],*/

			buttons: [

				$.extend( true, {}, buttonCommon, {

					extend: 'excelHtml5',

					text: 'Exportar a Excel',

				} ),

			],

			columnDefs: [

				{

					/*class: 'details-control',

					orderable: false,

					data: null,

					defaultContent: '',*/

					targets: 0

				}, {

					targets: 1

				}, {

					class: 'col2curso',

					targets: 2

				}, { 

					visible: false, 

					targets: 3

				}, {

					class: 'col3alumno',

					targets: 4

				}, {

					targets: 5

				}, {

					class: 'col5pais',

					targets: 6

				}, {

					targets: 7

				}, {

					targets: 8

				}, {

					targets: 9

				}

			],

		} );

		table.order([0,'desc']).draw();



	    





/*/

        var table = $('#example').DataTable();

 

		new $.fn.dataTable.Buttons( table, {

		    buttons: [

		        'copy', 'excel', 'pdf'

		    ]

		} );

		/*/

		$(document).on('click','.btnDeleteReg',function(e){

			e.preventDefault();

			var param = $(this).attr('id_delete');

			if( confirm('¿Realmente desea eliminar el registro? Esta acción no se puede deshacer') ){

				location.href='admin.php?page=teso-settings&tab=7&del='+param;

			}

		});



		$(document).on('click','#btnSendInvoice',function(e){

			e.preventDefault();

			var param = $(this).attr('id_invoice');

            jQuery.ajax({

                url : '/curso-registro-recibo/?numero='+param+'&tipo=invoice',

                type: 'post',

                data: {

                },

                beforeSend: function () {

                    $("#loadingimage-"+param).html('<img src="https://asipi.org/wp-content/uploads/2016/05/loading.gif">');

                },

                success: function (response) {

					$("#loadingimage-"+param).html('');

					alert('Recibo enviado');

					//$("#mensajeEnvioFactura").show();

                }

            });

        });

		

		$(document).on('click','#menuEnviarCertificado',function(e){

			e.preventDefault();

			$("#bloqueEnviarCertificado").show(300);

			

        });



	} );

</script>







