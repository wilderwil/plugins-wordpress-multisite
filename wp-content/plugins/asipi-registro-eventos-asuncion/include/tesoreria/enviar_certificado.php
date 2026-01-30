<?php echo "panama";

$lang='es';



global $wpdb;



if (!function_exists('limpiarCaracteresEspeciales')) {

	function limpiarCaracteresEspeciales($string ){

		$string = htmlentities($string);

		$string = str_replace("\'", "'", $string);

		$string = html_entity_decode($string);



		return $string;

	}

}

if (!function_exists('textoFecha')) {

	function textoFecha($lang, $fecha)

	{

		$mesesEsp = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

		$mesesIng = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		if ($lang=='en' || $lang=='pb') {

			$fechaFormat = strftime("%B %d, %Y",strtotime($fecha));

			$fechaMod = str_replace($mesesEsp, $mesesIng, $fechaFormat );

		} else {

			$fechaFormat = strftime("%d de %B de %Y",strtotime($fecha));

			$fechaMod = str_replace($mesesIng, $mesesEsp, $fechaFormat );

		}

		return $fechaMod;

	}

}

    function traslateText2($nombre_curso)

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



$formatoCorreo["subject-es"]= 'Certificado ASIPI Quito 2023';

$formatoCorreo["subject-en"]= 'ASIPI Academia Receipt';

$formatoCorreo["body-es"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/wp-content/uploads/2020/02/Header_logo_3_lang.png" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>

                <p>Estimado/a %%SOCIO%%,<br></p>

                <p>Nos complace informarle que su certificado por el curso: <b>%%EVENTO%%</b>, ya se encuentra disponible.</p>

                <br>

                <p>

                <a href="https://asipi.org/curso-registro-recibo/?certificado=1&data=%%CERTIFICADO%%">Haga click aquí para ver el Certificado.</a>.<br>

                </p>

                <p>Atentamente,<br>Matías Noetinger<br>Secretario - ASIPI</p><br> <p><strong>ASIPI</strong>

                <br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';

$formatoCorreo["body-en"]= '<div style="width:640px; text-align: center;"><img src="https://asipi.org/wp-content/uploads/2020/02/Header_logo_3_lang.png" alt="Logo ASIPI" border="0" style="height: 100px;" /></div><br>

                <p>Dear %%SOCIO%%,<br></p>

                <p>We are pleased to inform you that your registration has already been completed successfully at the event %%EVENTO%%.<br></p>

                <p>Payment receipt is attached.<br></p>

                <p>Best,<br></p><br> <p><strong>Ricardo Fisher</strong><br><strong>Tesorero – ASIPI</strong>

                <br><br>Calle 50, Edificio Plaza Banco General, Piso 24<br>Apartado Postal 0816-1771<br>Panamá, Panamá<br>Tel.:(5411) 4315 9200

                <br>Email:mnoetingertesorero@asipi.org<br>Web: www.asipi.org</p><p style="font-size: 10px">Esta transmisión es para uso exclusivo de la persona o entidad a quien está dirigida, y puede contener información privilegiada, confidencial que no puede ser divulgada por ley. Si Ud. recibe por error esta transmisión, por favor notifíquenoslo de inmediato a mnoetingertesorero@asipi.org y envíenoslo de regreso. Este mensaje y sus anexos han sido sometidos a programas anti-virus y entendemos que no contienen virus. En todo caso, el destinatario debe verificar que este mensaje no está afectado por virus y por tanto ASIPI no es responsable por daños derivados del uso de este mensaje.</p><hr><p style="font-size: 10px">This transmission is intended for the sole use of the individual and entity to which it is addressed, and may contain information that is privileged, confidential, and that cannot be disclosed by law. If you receive this transmission in error, please notify us immediately at mnoetingertesorero@asipi.org and return the message to us. This message and any attachments have been scanned and are believed to be free of any virus or other defect. However, its recipient should ensure that the message is virus-free. ASIPI is not responsible for any loss or damage arising from the use of this message.</p>';



        

/*echo $codeOrder = base64_encode(base64_encode( base64_encode($_GET['data']) ) );

exit();*/

if (isset($_POST['todos'])) {

    $sqlInvoice='SELECT *, YEAR(fecha) as year FROM asipi_cursos_registros where estado = 1 and curso_id='.$_POST['certificado'];

}else{

    $order_number = $_GET['certificado'] ;

    $sqlInvoice='SELECT *, YEAR(fecha) as year FROM asipi_cursos_registros where  estado = 1 and id='.$order_number;

}

$cant=0;

$queryInvoice = $wpdb->get_results($sqlInvoice);

if (count($queryInvoice) > 0) {

    foreach($queryInvoice as $invoice){

        $order_number = $invoice->id ;

        $alumno = limpiarCaracteresEspeciales( $invoice->nombres.' '.$invoice->apellidos );   

        $alumno = ucwords(strtolower($alumno));

        if ($invoice->tipo_curso=='C') {

            $sql = "SELECT * FROM pwisa_asipi_cursos WHERE id='".$invoice->curso_id."' limit 1";

            $qryCurso = $wpdb->get_results($sql);

            $qryCurso = json_decode(json_encode($qryCurso), true);

            $antCurso = ($lang=='es') ? 'Concluyó satisfactoriamente el curso: ' : 'Course registration: ' ;

            $nombre_curso = traslateText2($qryCurso[0]['nombre']);

            $fecha = 'Realizado desde el '.textoFecha($lang, $qryCurso[0]['fecha_inicio']).' al '.textoFecha($lang, $qryCurso[0]['fecha_fin']);

        } else {

            $sql = "SELECT titulo,id_asipi_cursos FROM pwisa_asipi_cursos_modulo WHERE id='".$invoice->curso_id."' limit 1";

            $qryModulo = $wpdb->get_results($sql);

            $qryModulo = json_decode(json_encode($qryModulo), true);



            $sql = "SELECT * FROM pwisa_asipi_cursos WHERE id='".$qryModulo[0]['id_asipi_cursos']."' limit 1";

            $qryCurso = $wpdb->get_results($sql);

            $qryCurso = json_decode(json_encode($qryCurso), true);

            $curso = traslateText2($qryCurso[0]['nombre']);

            $antCurso = ($lang=='es') ? 'Concluyó satisfactoriamente el módulo: ' : 'Module Registration: ' ;

            $nombre_curso = traslateText2($qryModulo[0]['titulo']).' ('.$curso.')';

            $fecha = 'Realizado desde el '.textoFecha($lang, $qryCurso[0]['fecha_inicio']).' al '.textoFecha($lang, $qryCurso[0]['fecha_fin']);



        }

        $horas= 'Intensidad horaria: '.$qryCurso[0]['horas_activas'].' horas';



        $certificado = base64_encode(base64_encode( base64_encode($order_number) ) );

        $destinatario = $invoice->email;

        //$destinatario = 'antonio@ztgroupcorp.com';

        $body = $formatoCorreo["body-".$lang];	

        $body = str_replace("%%SOCIO%%",$alumno,$body);

        $body = str_replace("%%EVENTO%%",__($nombre_curso),$body);

        $body = str_replace("%%CERTIFICADO%%",__($certificado),$body);

        $subject = $formatoCorreo["subject-".$lang];

        $headers = array('Content-Type: text/html; charset=UTF-8','Reply-To: tesoreria@asipi.org');

        $enviado = wp_mail($destinatario, $subject, $body, $headers);	

        //echo $body;

        $cant = $cant+1;

    }

}

if (isset($_POST['todos'])) {

    $mensaje = '<p>Se han enviado '.$cant.' correos de Certificados del curso: '.$nombre_curso.'</p>';

}else{

    $mensaje = '<p>Se ha enviado a <b>'.$alumno.' ('.$destinatario.')</b>, el correo de Certificado del curso: '.$nombre_curso.'</p>';

}





        //$folder2 = $asipiPath.'wp-content/uploads/facturas/'.$documentTitle;    // $fields['pdf-folder'] .

        //$attachments = array($folder2);

?>

<div class="updated notice">

<?php echo $mensaje; ?> <br>

</div>

