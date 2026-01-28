<?php 
//<link rel="stylesheet" href="https://asipi.org/asipi-helper/fonts/Candara/fonts.css" type="text/css" charset="utf-8" />
/*$textoteso = 'Matías Noetinger<br>
		Calle 50, Edificio Plaza Banco General, Piso 24<br>
		Apartado Postal 0816-1771<br>
		Panamá, Panamá.';*/
$textoteso = 'Enrique A. Díaz<br>
		Paseo de la Reforma 265, Mezzanine 2. <br>
		Col. Cuauhtémoc<br>

		Del. Cuauhtémoc.<br>
		CP 06500, Ciudad de México.';
$mailteso = '<a href="mailto:mnoetingertesorero@asipi.org">mnoetingertesorero@asipi.org</a>';
/*if (condition) {
	$textoadicional = <<<EOF
	Fecha límite de pago: 31 de marzo <br>
	En pagos realizados después de la fecha límite se aplicará un recargo de USD 100. <br>
	En caso de realizar el pago con transferencia bancaria, ASIPI acreditará a su cuenta el monto ingresado a Comerica Bank, por lo que le pedimos considerar que las diferencias originadas por los intermediarios bancarios no serán absorbidas por ASIPI y permanecerán en su cuenta como saldo pendiente a cubrir con la próxima facturación.
	<br><br>
	El pago de la presente factura constituye la aceptación del Código de Ética Profesional de ASIPI www.asipi.org 
	EOF;
} else {
	$textoadicional = <<<EOF
	Fecha límite de pago: 31 de marzo <br>
	En pagos realizados después de la fecha límite se aplicará un recargo de USD 100. <br>
	En caso de realizar el pago con transferencia bancaria, ASIPI acreditará a su cuenta el monto ingresado a Comerica Bank, por lo que le pedimos considerar que las diferencias originadas por los intermediarios bancarios no serán absorbidas por ASIPI y permanecerán en su cuenta como saldo pendiente a cubrir con la próxima facturación.
	<br><br>
	El pago de la presente factura constituye la aceptación del Código de Ética Profesional de ASIPI www.asipi.org 
	EOF;
}*/
/*
$NIT<br>
$billAddress<br>
$line2<br>
$zipCode</p>
*/
//,Sans-Serif

$content=<<<EOF
<link rel="stylesheet" href="https://asipi.org/asipi-helper/fonts/Candara/fonts.css" type="text/css" charset="utf-8" />
<table border="0">
	<tr>
		<td align="left">
			<div class="asipi-logo">
				<img src="https://asipi.org/wp-content/uploads/2020/05/Asipi-Plain.png" alt="Logo ASIPI" border="0" style="height: 100px;" />
			</div>
		</td>
		<td align="right" style="font-size: 12px;">
			<br>
			<b style="font-family:'font';">Fundación ASIPI</b><br>	
			Calle 50, Edificio Plaza Banco General, Piso 24<br>
			Apartado Postal 0816-1771<br>
			Ciudad de Panamá, Panamá
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table cellspacing="0" style="padding: 15px 0px 15px 6px; margin: 0px 20px 0px 20px;">
                <tr><td style="vertical-align: middle;border-bottom: 5px solid #00338a">
                    <br>
					<span style="font-family:'candara'; font-size: 20px;"><b>$lang_receipt $number</b></span><br>								
					<span style="font-family:'candara'; font-size: 10.5px;">$fecha_factura</span><br>
					
                    <p style="font-size:12px;"><b style="font-family:'font';">$alumno</b></p>	
					<p style="font-size:12px;">
					$campoNombre<br>
					$NIT<br>
					$billAddress<br>
					$line2<br>
					$zipCode
					</p>				
				</td></tr>
			</table>
		</td>
	</tr>
</table>

<style>
.montosFactura{
	text-align: right !important;
}
</style>
<p style="font-size:12px;">$lang_we_appreciate $ftotal $lang_through $metodo. </p>
<table style="font-family:'font';font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black;border-top: 1px solid black;">	
	<tr>
		<td><b>$lang_description</b></td>
		<td class="montosFactura"><b>USD</b></td>
	</tr>
</table>
$stringConcepto
<table style="font-family:'font';font-size:12px;margin: 15px 0 15px 0;padding: 10px 10px 10px 10px;border-bottom: 1px solid black">	
	<tr>
		<td><b>Total</b></td>
		<td class="montosFactura"><b>USD $ftotal</b></td>						
	</tr>	
</table>
$espacios
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
	<span style="font-family:'candara'; font-size: 12px;"><b>Matías Noetinger</b><br>
		Tesorero – ASIPI
	</span>
<span style="font-size: 10px;">
	<p>
		Email: <a href="mailto:mnoetingertesorero@asipi.org">mnoetingertesorero@asipi.org</a><br>
		Web: <a href="www.asipi.org">www.asipi.org</a>
	</p>
</span>		
EOF;
$pag2=<<<EOF
<h4 style="font-family:'candara'; font-size: 14px;">Opciones de Pago / Payment Options</h4>
<ol style="font-size: 11px;">
<li><p>Cheque a nombre de Fundación ASIPI emitido por un banco en Estados Unidos. Deberá ser enviado por Courier con copia de su factura a:<br>
USA bank check addressed to Fundación ASIPI. Must be sent by courier with a copy of your invoice to: </p>

<p>$textoteso</p>
</li>
<li><p>Transferencia bancaria. Tras completarla, favor de enviar comprobante para dar seguimiento a <a href="mailto:tesoreria@asipi.org">tesoreria@asipi.org</a> y/o $mailteso.<br>
Wire transfer. Once completed, please send the transfer confirmation to <a href="mailto:tesoreria@asipi.org">tesoreria@asipi.org</a> and/or $mailteso.</p>
<p>Comerica Bank<br>
Detroit, MI<br>
ABA: 072000096<br>
Swift: MNBDUS33<br>
<br>
Beneficiary: Fundación ASIPI<br>
Beneficiary account: 1853304994<br>
<br>
Referencia/Reference: Número de factura/invoice number<br></p>

</li>
<li><p>PayPal. Ingresando a <a target="_blank" href="http://asipi.org">www.asipi.org</a> con su usuario, dentro del menú Estado de Cuenta encontrará la orden a pagar, al abrirla podrá ver los detalles de la orden y los botones de pago de PayPal.</p><br>
<p>PayPal. Log in on <a target="_blank" href="http://asipi.org">www.asipi.org</a> with your username, in the Statement menu you will find the order that is due, click to see details and PayPal payment buttons.</p>
</li></ol>
EOF;
/*$content=<<<EOF
	<div class="demo" style="font-size:25px;
		width:800px;
		margin:10px auto;
		text-align:center;
		border:1px solid #666;
		padding:25px;">
		Factura 18260
	</div>
	<div class="demo2" style="font-size:25px;
		width:800px;
		margin:10px auto;
		text-align:center;
		border:1px solid #666;
		padding:10px;">
		The quick brown fox jumps over the lazy dog.
	</div>

	<br>
	<br>
EOF;
echo $content;*/
 ?>