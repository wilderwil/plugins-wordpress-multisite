<?php
function asipi_config_registro_lista(){
    //var_dump($data);exit();
	global $wpdb;
    global $blog_id;
	if ($_POST['editar']) { 
		$edit = "UPDATE evento_meta SET valor = '".$_POST['valor']."',clave ='".$_POST['clave']."' WHERE id = '".$_POST['id']."'";
		$queryResult = $wpdb->get_results($edit);
		echo '<div class="updated notice">
			Registro "'.$_POST['clave'].'" editado con exito.
		</div>';
	}  
    if ($_GET['editar'] and $_GET['editar']>=0) { 
		$sql = "SELECT * FROM evento_meta where id='".$_GET['editar']."' order by clave desc";
        $data = $wpdb->get_results($sql);
        $data = json_decode(json_encode($data), true);
        $value = $data[0];
        //var_dump($value);
		/* echo '<div class="updated notice">
			Registro "'.$value.'" .
		</div>'; */
        //exit();
	}  

    $sql = "SELECT * FROM evento_meta where evento_id='$blog_id' order by clave desc";
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
		<h1>Configuración Eventos
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
        <?php if($_GET['editar'] and $_GET['editar']>=0){ ?>
        <div>
			<br>
			<form action="?page=asipi-config-evento" method="post" >
				<h4>Enviar todos los certificados del curso: </h4> 
                <input type="hidden" name="id" value="<?php echo $value["id"] ?>">
                <input type="hidden" name="editar" value="true">
				<input type="text" name="clave" value="<?php echo $value["clave"] ?>" style="width: 300px;"><br><br>
                <input type="text" name="valor" value="<?php echo $value["valor"] ?>" style="width: 300px;"><br><br>
				<button type="submit">Actualizar</button>
			</form>
			<br>
		</div>
        <?php }else{ ?>    
		<table id="example" class="display" style="width:100%">
		    <thead>
		        <tr>
		            <th>Id</th>
                    <th>key</th>
                    <th>valor</th>
                    <th>Acciones</th>
		        </tr>
		    </thead>
		    <style>
		    	.vencido{
		    		color: #fb6666;
		    	}
		    </style>
		    <tbody>
				<?php if ($data) {?>
				<?php $arrayCursos = array(); ?>
		    	<?php foreach ($data as $key => $value): ?>
					<?php 
						$sql = "SELECT valor FROM evento_meta WHERE evento_id=$value->evento_id and clave='name_es' limit 1";
						$nombre_evento = $value->evento_id.' - '.$wpdb->get_var($sql);
		    		?>
		    		<tr>
                        <!--<td><a href="admin.php?page=teso-settings&tab=5&detail=<?php echo $value->id ?>"><?php echo $value->id ?></a></td>-->
						<td><?php echo $value->id ?></td>
						<td><?php echo $value->clave ?></td>
                        <td><?php echo $value->valor ?></td>
			            <td>
                            <a style="text-decoration: none;" href="?page=asipi-config-evento&editar=<?php echo $value->id ?>">Editar</a><br>
							<!-- <div id="loadingimage-<?php echo $value->id ?>"></div>
							<a style="text-decoration: none;" href="" id="btnSendInvoice" id_invoice="<?php echo $value->id ?>">Enviar Recibo</a><br>
							<a style="text-decoration: none;" href="/curso-registro-recibo/?numero=<?php echo $value->id ?>&tipo=view" target="_blank">ver Recibo</a><br>
							
							<a style="text-decoration: none;" href="/wp-admin/admin.php?page=teso-settings&tab=7&certificado=<?php echo $value->id ?>">Enviar Certificado</a><br>
							<?php $certificado = base64_encode(base64_encode( base64_encode($value->id) ) ); ?>
							<a style="text-decoration: none;" href="/curso-registro-recibo/?certificado=1&data=<?php echo $certificado ?>" target="_blank">ver Certificado</a><br>
							
		                	<a style="text-decoration: none;" href="" class="btnDeleteReg" id_delete="<?php echo $value->id ?>">Eliminar</a> -->
			            </td>
			        </tr>
		    	<?php endforeach ?>
			    <?php }?>    
		    </tbody>
		    <tfoot>
		        <tr>
                    <th>Id</th>
                    <th>Clave</th>
                    <th>valor</th>
                    <th>Acciones</th>
		        </tr>
		    </tfoot>
		</table>
        <?php } ?>
</div>
<style>
	#select_cursos{
		width: 120px;
	}
	.col2clave{
		width: 220px !important;
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
	    
		var buttonCommon = {
			exportOptions: {
				format: {
					header: function ( data, row, column, node ) {
						// Strip $ from salary column to make it numeric
						data = row === 1 ? 'Clave' : data;
						// data = row === 5 ? 'Perfil' : data;
						//data = row === 6 ? 'País' : data; 

						return data
					}
				}
			}
		};
		<?php // foreach ($arrayCursos as $key => $value) { ?>
			//$('#selCertificado').append( '<option value="<?php echo $key; ?>"><?php echo $value; ?></option>' )
		<?php //}  ?>
		
	
        var table = $('#example').DataTable( {
	        dom: 'Bfrtip',
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			},
            initComplete: function () {
	            
	            this.api().columns([1]).every( function () {
	                var column = this;
	                var select = $('<select class="form-control form-control-sm" id="select_cursos"><option value="">Clave</option></select>')
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
			buttons: [
				$.extend( true, {}, buttonCommon, {
					extend: 'excelHtml5',
					text: 'Exportar a Excel',
				} ),
			],
			columnDefs: [
				{
					targets: 0
				}, {
					class: 'col2clave',
					targets: 1
				}, {
					targets: 2
				}, {
					targets: 3
				}, {
					targets: 4
				}
			],
		} );
		table.order([0,'desc']).draw();

	    



       
	

		
		$(document).on('click','#menuEnviarCertificado',function(e){
			e.preventDefault();
			$("#bloqueEnviarCertificado").show(300);
			
        });

	} );
</script>
<?php

}
?>