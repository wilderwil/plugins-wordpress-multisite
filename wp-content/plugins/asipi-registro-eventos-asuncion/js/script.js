(function($){

	jQuery(".menu-item-1931").hide();
	//jQuery(".menu-item-1932").hide();
	//jQuery(".menu-item-1934").hide();	
	if ( jQuery('body').hasClass('logged-in') ){
	
		jQuery(".menu-item-1931").show();
		//jQuery(".menu-item-583").hide();
	}

	$( document ).ready(function() {
		//menu
		
			

		
		// registro
		jQuery("#btn_socio").click(function () { 
	
			jQuery(".divform").hide();
			jQuery(this).hide();
			jQuery("#card_miembro").hide();
			jQuery("#card_nosocio").hide();
			jQuery("#card_student").hide();
			jQuery("#card_guest").hide();
			jQuery("#card_companion").hide();
			jQuery("#socio").show();
		    jQuery("#card_socio").hide();
		    jQuery("#nav-tabs").hide();
		    jQuery(".pricing-table").hide();
		    jQuery("#h2-plan").css('visibility', 'hidden');
		    jQuery("#coupon_code").val("");

		});
		jQuery("#btn_miembro").click(function () {  
			jQuery(this).hide();
			jQuery(".divform").hide();
			jQuery("#card_socio").hide();
			jQuery("#card_nosocio").hide();
			jQuery("#card_student").hide();
			jQuery("#card_guest").hide();
			jQuery("#miembro").show();
          jQuery("#coupon_code").val("");

			
		});
		jQuery("#btn_nosocio").click(function () {  
			jQuery(this).hide();
			jQuery("#card_miembro").hide();
			jQuery("#card_socio").hide();
			jQuery("#card_student").hide();
			jQuery("#card_guest").hide();
			jQuery(".divform").hide();
			jQuery("#nosocio").show();
			jQuery("#card_nosocio").hide();
			jQuery("#card_companion").hide();
			jQuery("#nav-tabs").hide();
			jQuery(".pricing-table").hide();
			jQuery("#h2-plan").css('visibility', 'hidden');
            jQuery("#coupon_code").val("");
			

		});
		jQuery("#btn_student").click(function () {  
			jQuery(this).hide();
			jQuery("#card_miembro").hide();
			jQuery("#card_socio").hide();
			jQuery("#card_nosocio").hide();
			jQuery("#card_guest").hide();
			jQuery(".divform").hide();
			jQuery("#student").show();
			jQuery("#card_student").hide();
			jQuery("#card_companion").hide();
			jQuery("#nav-tabs").hide();
		    jQuery(".pricing-table").hide();
		    jQuery("#h2-plan").css('visibility', 'hidden');
            jQuery("#coupon_code").val("");

		});
		jQuery("#btn_guest").click(function () {  
			jQuery(this).hide();
			jQuery("#card_miembro").hide();
			jQuery("#card_socio").hide();
			jQuery("#card_nosocio").hide();
			jQuery("#card_student").hide();
			jQuery(".divform").hide();
			jQuery("#guest").show();
			jQuery("#card_guest").hide();
			jQuery("#card_companion").hide();
			jQuery("#nav-tabs").hide();
			jQuery(".pricing-table").hide();
            jQuery("#coupon_code").val("");
			jQuery("#h2-plan").css('visibility', 'hidden');
            jQuery("#coupon_code").val("");

		});
		$(document).on('click','#verifySocio',function(e){
			e.preventDefault();
			jQuery.ajax({
				url : dcms_vars.ajaxurl,
				type: 'post',
				data: {
					action : 'are_ajax_login_socio',
					"email" : jQuery("#email_socio").val() , 
					"password" : jQuery("#password").val(),
					"lang" : 'es',
				},
				beforeSend: function () {
					jQuery("#loadingimage").show();
				},
				success: function (response) {
					response = response.replace('}0','}')
					var obj = jQuery.parseJSON(response);
					if (obj.status == "on-line" && obj.user_id!="0") {
						formatURL('LOGEADO', 'socio',obj.user_id);
					}else{
                      if (obj.user_id=="0"){
        				obj.mensaje= "Error intente nuevamente !!!!";
    					}
						jQuery("#mensajeErrorLogin").html(obj.mensaje);
						jQuery("#mensajeErrorLogin").show();
						jQuery("#password").val("");
					}
					jQuery("#loadingimage").hide();
				}
			});
		});
		$(document).on('click','#veryfyMiembro',function(e){
			e.preventDefault();
			jQuery("#mensajeErrorMiembro").hide();
			jQuery.ajax({
				url : dcms_vars.ajaxurl,
				type: 'post',
				data: { 
					action : 'are_ajax_login_miembro',
					"email_miembro" : jQuery("#email_miembro").val(), 
					"email" : jQuery("#email_fiador").val(), 
					"company" : jQuery("#company").val(),
					},
				beforeSend: function () {
					jQuery("#loadingimage").show();
				},
				success: function (response) {
					response = response.replace('}0','}');
					var obj = jQuery.parseJSON(response);
					if (obj.status == "on-line") {
						formatURL('NUEVO', 'miembro',obj.user_id);
					} else {
						jQuery("#mensajeErrorMiembro").text(obj.mensaje);
						jQuery("#mensajeErrorMiembro").show();
						jQuery("#password").val("");
					}
				}
			});
		});
		$(document).on('click','#veryfy_nosocio',function(e){
			e.preventDefault();
            
			verificador('nosocio');
		});
		$(document).on('click','#veryfy_student',function(e){
			e.preventDefault();
			verificador('student');
		});

		$(document).on('click','#veryfy_guest',function(e){
			e.preventDefault();
            
			verificadorGuest('guest');
		});
		
		$(document).on('click','#veryfy_rutas',function(e){
		   
			e.preventDefault();
			verificadorRutas('rutas');
		});
	    function verificadorRutas(user_type) {
			
			var statusUsuario = '';
			//var obj = jQuery.parseJSON(response);
			jQuery("#mensajeError_"+user_type).hide();

			if (jQuery("#typeLogin_"+user_type).val()=='verify') {
				//jQuery(".password_"+user_type).hide();
				var datos = { 
					action : 'are_ajax_login_rutas',
					"email" : jQuery("#email_"+user_type).val(),
					"userType":'rutas'
					}
			} else {
				var pass = jQuery("#password_"+user_type).val();
				if (jQuery("#typeLogin_"+user_type).val()=='new') {
					pass = jQuery("#newpassword_"+user_type).val();
				}
				var datos = { 
					action : 'are_ajax_login_rutas',
					"email" : jQuery("#email_"+user_type).val(), 
					"password" : pass,
					"tipo_password" : jQuery("#typeLogin_"+user_type).val(),
					"userType":'rutas',
					}
			}
			
			jQuery.ajax({
				url : dcms_vars.ajaxurl,
				type: 'post',
				data: datos,
				beforeSend: function () {
					jQuery("#loadingimage").show();
				},
				success: function (response) {
					response = response.replace('}0','}');
					jQuery("#loadingimage").hide();
					var obj = jQuery.parseJSON(response);
					
					if (obj.status == "activo") {
						//DESPUES DE VERIFICAR
						if (obj.userType == "unregistered") {
							//NUEVO USUARIO
							//formatURL('NUEVO', user_type);
							jQuery(".newpassword_"+user_type).show();
							jQuery("#typeLogin_"+user_type).val("new");
						}else{
							// USUARIO REGISTRADO - ACTIVA EL FORMULARIO PARA EL LOGIN
							jQuery(".password_"+user_type).show();
							jQuery("#typeLogin_"+user_type).val("login");
						}
					} else{
						if (obj.status == "on-line") {
							//USUARIO LOGEADO
						
							if(user_type=='rutas'){
							    window.location.reload();
							}else {
							    formatURL('LOGEADO', user_type, obj.user_id);
							}
							
						} else {
							// ERROR
							
							if(obj.user_id != '' && obj.mensaje =='Ya esta registrado en este evento'){
							    window.location.reload();
							}else{
							jQuery("#mensajeError_"+user_type).text(obj.mensaje);
							jQuery("#mensajeError_"+user_type).show();
							jQuery("#password_"+user_type).val("");}
						}
					} 
				}
			});
		}
		function verificador(user_type) {
			
			var statusUsuario = '';
			//var obj = jQuery.parseJSON(response);
			jQuery("#mensajeError_"+user_type).hide();
			
			if (jQuery("#typeLogin_"+user_type).val()=='verify') {
				//jQuery(".password_"+user_type).hide();
				var datos = { 
					action : 'are_ajax_login_nosocio',
					"email" : jQuery("#email_"+user_type).val()
					}
			} else {
				var pass = jQuery("#password_"+user_type).val();
				if (jQuery("#typeLogin_"+user_type).val()=='new') {
					pass = jQuery("#newpassword_"+user_type).val();
				}
				var datos = { 
					action : 'are_ajax_login_nosocio',
					"email" : jQuery("#email_"+user_type).val(), 
					"password" : pass,
					"tipo_password" : jQuery("#typeLogin_"+user_type).val(),
					}
			}
			
			jQuery.ajax({
				url : dcms_vars.ajaxurl,
				type: 'post',
				data: datos,
				beforeSend: function () {
					jQuery("#loadingimage").show();
				},
				success: function (response) {
					response = response.replace('}0','}');
					jQuery("#loadingimage").hide();
					var obj = jQuery.parseJSON(response);
				//alert(obj.status);
					if (obj.status == "activo") {
						//DESPUES DE VERIFICAR
						if (obj.userType == "unregistered") {
							//NUEVO USUARIO
							//formatURL('NUEVO', user_type);
							jQuery(".newpassword_"+user_type).show();
							jQuery("#typeLogin_"+user_type).val("new");
							jQuery("#password_"+user_type).hide();
							jQuery(".password_"+user_type).hide();
						}else{
							// USUARIO REGISTRADO - ACTIVA EL FORMULARIO PARA EL LOGIN
							jQuery(".password_"+user_type).show();
							jQuery("#typeLogin_"+user_type).val("login");
						}
					} else{
						if (obj.status == "on-line" && obj.user_id!="0") {
							//USUARIO LOGEADO
					
							if(user_type=='rutas'){
							    window.location.reload();
							}else {
							    formatURL('LOGEADO', user_type, obj.user_id);
							}
							
						} else {
							// ERROR
							 if (obj.user_id=="0"){
        				obj.mensaje= "Error intente nuevamente !!!!";
    					}
							jQuery("#mensajeError_"+user_type).text(obj.mensaje);
							jQuery("#mensajeError_"+user_type).show();
							jQuery("#password_"+user_type).val("");
						}
					} 
				}
			});
		}
				function verificadorGuest(user_type) {
			
			var statusUsuario = '';
			//var obj = jQuery.parseJSON(response);
			jQuery("#mensajeError_"+user_type).hide();
			
			if (jQuery("#typeLogin_"+user_type).val()=='verify') {
				//jQuery(".password_"+user_type).hide();
				var datos = { 
					action : 'are_ajax_login_invitados',
					"email" : jQuery("#email_"+user_type).val()
					}
			} else {
				var pass = jQuery("#password_"+user_type).val();
				var coupon = jQuery("#coupon_code").val(); 
				if (jQuery("#typeLogin_"+user_type).val()=='new') {
					pass = jQuery("#newpassword_"+user_type).val();
				}
				var datos = { 
					action : 'are_ajax_login_invitados',
					"email" : jQuery("#email_"+user_type).val(), 
					"password" : pass,
					"tipo_password" : jQuery("#typeLogin_"+user_type).val(),
					"coupon_code": coupon
					}
			}
		
			jQuery.ajax({
				url : dcms_vars.ajaxurl,
				type: 'post',
				data: datos,
				beforeSend: function () {
					jQuery("#loadingimage").show();
				},
				success: function (response) {
					response = response.replace('}0','}');
					jQuery("#loadingimage").hide();
					var obj = jQuery.parseJSON(response);
					
					if (obj.status == "activo") {
						//DESPUES DE VERIFICAR
						if (obj.userType == "unregistered") {
							//NUEVO USUARIO
							//formatURL('NUEVO', user_type);
							jQuery(".newpassword_"+user_type).show();
							jQuery(".password_"+user_type).hide();
							jQuery(".coupon_code").show();
							jQuery("#typeLogin_"+user_type).val("new");
						}else{
							// USUARIO REGISTRADO - ACTIVA EL FORMULARIO PARA EL LOGIN
							jQuery(".password_"+user_type).show();
							jQuery(".coupon_code").show();
							jQuery("#typeLogin_"+user_type).val("login");
						}
					} else{
						if (obj.status == "on-line" && obj.user_id!="0") {
							//USUARIO LOGEADO
						
							if(user_type=='rutas'){
							    window.location.reload();
							}else {
							    formatURL('LOGEADO', user_type, obj.user_id);
							}
							
						} else {
							// ERROR
							if (obj.user_id=="0"){
        				obj.mensaje= "Error intente nuevamente !!!!";
    					}
							jQuery("#mensajeError_"+user_type).text(obj.mensaje);
							jQuery("#mensajeError_"+user_type).show();
							jQuery("#password_"+user_type).val("");
						}
					} 
				}
			});
		}
		function formatURL(status, user_type,user_id) {
			if(status!=''){
				jQuery(".paso1").hide(300);

				var url = '';
				url = url + 'https://form.jotform.com/'+id_jotform+'?';
				url = url + 'user_type='+user_type; // socio miembro nosocio student
				url = url + '&costo='+precios[user_type];

				let coupon_code = jQuery("#coupon_code").val();

				var email = jQuery("#email_"+user_type).val();
				url = url + '&email='+email;
				
				//url = url + 'tipo_usuario=1'+$variable;

				if(status=='NUEVO'){
					url = url + '&billEmail='+jQuery("#email_"+user_type).val();
					jQuery("#JotFormIFrame-"+id_jotform).attr('src',url);
					jQuery("#JotFormIFrame-"+id_jotform).show(300);
					jQuery("#loadingimage").hide();
				}else{

					jQuery.ajax({
						url : dcms_vars.ajaxurl,
						type: 'post',
						data: {
							action : 'are_ajax_datos_user',
							"id_user" : user_id,  
						},
						beforeSend: function () {
							jQuery("#loadingimage").show();
						},
						success: function (response2){
							response2 = response2.replace('}0','}');
							var obj = jQuery.parseJSON(response2);
						
							
							/*if(user_type=='socio'){
								jQuery("#formSocio_id_usuario").val(obj.id_user);
								jQuery("#formSocio_user_type").val("socio");
								jQuery("#formSocio_costo").val("0");
								jQuery("#formSocio_saldoafavor").val("0");
								jQuery("#formSocio_saldodeuda").val("0");
								jQuery("#formSocio_email").val(email);
								jQuery("#formSocio_nombre").val(obj.name);
								jQuery("#formSocio_apellido").val(obj.last);

								$('#formSocio').submit();
							}else{*/

								url = url + '&costo_virtual='+costos[user_type]['virtual'];
								if(tipo_asistencia=='Virtual'){
									url = url + '&tipo_asistencia=Virtual';
								}else{

									let usuario_exento = socios_exentos.includes(parseInt(obj.id_user));
console.log(obj.isMember)
									if(usuario_exento){
										url = url + '&costo_simple=0';
										url = url + '&costo_doble=0';
										url = url + '&costo_triple=0';
									}else{
										 if(user_type != 'guest'){
										url = url + '&costo_simple='+costos[user_type]['simple'];
										url = url + '&costo_doble='+costos[user_type]['doble'];
                                         url = url + '&costo_triple='+costos[user_type]['triple'];
                                      }else{
                                        if(obj.isMember === '1'){
                                        	url = url + '&costo_simple='+costos['socio']['simple'];
											url = url + '&costo_doble='+costos['socio']['doble'];
                                         	url = url + '&costo_triple='+costos['socio']['triple'];
                                        }else{
                                        	url = url + '&costo_simple='+costos[user_type]['simple'];
										url = url + '&costo_doble='+costos[user_type]['doble'];
                                         url = url + '&costo_triple='+costos[user_type]['triple'];
                                        }
                                      }
									}
									url = url + '&costo_companion_doble='+costos.companion.doble;
									url = url + '&costo_companion_triple='+costos.companion.triple;
									url = url + '&tipo_asistencia=Presencial';
								}

								url = url + '&id_usuario='+encodeURIComponent(obj.id_user);
								url = url + '&saldoafavor='+encodeURIComponent(obj.saldoafavor);
								url = url + '&saldodeuda='+encodeURIComponent(obj.saldodeuda);
								
								url = url + '&nombre[first]='+encodeURIComponent(obj.name);
								url = url + '&nombre[last]='+encodeURIComponent(obj.last);
								if (obj.last !='' && obj.name!=''){
                                    url = url + '&can_edit=no';
								}else{
								    url = url + '&can_edit=si';
								}
								var genner = '';
								if (obj.persGenner=='M') {
									genner = 'Masculino';
								}else if(obj.persGenner=='F'){
									genner = 'Femenino';
								}else{
									genner = encodeURIComponent(obj.persGenner);
								}
								url = url + '&genero='+genner;
								//console.log(obj)
								//url = url + '&fecha_nacimiento='+obj.;
								url = url + '&fecha_nacimiento[day]='+encodeURIComponent(obj.dianacimiento);
								url = url + '&fecha_nacimiento[month]='+encodeURIComponent(obj.mesnacimiento);
								url = url + '&fecha_nacimiento[year]='+encodeURIComponent(obj.anonacimiento);
								//&fecha_nacimiento[day]=01&fecha_nacimiento[month]=01&fecha_nacimiento[year]=2001
								url = url + '&direccion[addr_line1]='+encodeURIComponent(obj.persAddress);
								url = url + '&direccion[city]='+encodeURIComponent(obj.persCity);
								url = url + '&direccion[state]='+encodeURIComponent(obj.persState);
								url = url + '&direccion[postal]='+encodeURIComponent(obj.persZip);
								url = url + '&direccion[country]='+encodeURIComponent(obj.persCountry);
								url = url + '&compania='+encodeURIComponent(obj.persCompany);
								url = url + '&universidad='+encodeURIComponent(obj.persUniversity);
								url = url + '&billEmail='+encodeURIComponent(obj.billEmail);
								url = url + '&razonSocial='+encodeURIComponent(obj.billName);
								url = url + '&nit='+encodeURIComponent(obj.billNit);
								url = url + '&bill_address[addr_line1]='+encodeURIComponent(obj.billAddress);
								url = url + '&bill_address[city]='+encodeURIComponent(obj.billCity);
								url = url + '&bill_address[state]='+encodeURIComponent(obj.billState);
								url = url + '&bill_address[postal]='+encodeURIComponent(obj.billZip);
								url = url + '&bill_address[country]='+encodeURIComponent(obj.billCountry);
								url = url + '&pais='+encodeURIComponent(obj.billCountry);
								url = url + '&country='+encodeURIComponent(obj.billCountry);
                                url = url + '&count_act_1='+encodeURIComponent(obj.count_actividad_1);
                                url = url + '&count_act_2='+encodeURIComponent(obj.count_actividad_2);
                                url = url + '&count_act_3='+encodeURIComponent(obj.count_actividad_3);
                                url = url + '&count_act_4='+encodeURIComponent(obj.count_actividad_4);
                                url = url + '&count_act_5='+encodeURIComponent(obj.count_actividad_5);
                                url = url + '&count_golf='+encodeURIComponent(obj.count_golf);
                                url = url + '&count_tenis='+encodeURIComponent(obj.count_tenis);
                                url = url + '&count_futbol='+encodeURIComponent(obj.count_futbol);
                                url = url + '&count_padel='+encodeURIComponent(obj.count_padel);
                                /*url = url + '&count_registers_by_company='+encodeURIComponent(obj.count_registers_by_company);*/
                                url = url + '&count_t1a='+encodeURIComponent(obj.count_t1a);
                                url = url + '&count_t1b='+encodeURIComponent(obj.count_t1b); 
                                /*url = url + '&count_t1c='+encodeURIComponent(obj.count_t1c);*/
                                url = url + '&count_t2a='+encodeURIComponent(obj.count_t2a);
                                url = url + '&count_t2b='+encodeURIComponent(obj.count_t2b);
                                url = url + '&count_t2c='+encodeURIComponent(obj.count_t2c);
                                /*url = url + '&count_act_7='+encodeURIComponent(obj.count_actividad_7);*/
                                url = url + '&count_act_8='+encodeURIComponent(obj.count_actividad_8);
                                url = url + '&count_act_9='+encodeURIComponent(obj.count_actividad_9);
                                //url = url + '&telefono='+encodeURIComponent(obj.telefono);
                               
                                url = url + '&coupon_code='+coupon_code;

								jQuery("#JotFormIFrame-"+id_jotform).attr('src',url);
								jQuery("#JotFormIFrame-"+id_jotform).show(300);
								jQuery("#loadingimage").hide();
							//}
						}
					});
					
				}

				
			}
			
		}
	});
	/*function datosUser() {
		jQuery.ajax({
			url : dcms_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'are_ajax_datos_user', 
			},
			beforeSend: function () {
				jQuery("#loadingimage").show();
			},
			success: function (response){
				response = response.replace('}0','}')
				jQuery("#loadingimage").hide();

				var obj = jQuery.parseJSON(response);
				var tipo_usuario='socio';
				var email=obj.email;
				var nombre=obj.name;
				var apellido=obj.last;
				var id_usuario=obj.id_user;
				var url = 'https://form.jotform.com/202745479602661?precio='+precios['socio']+'&tipo_usuario='+tipo_usuario+'&id_curso='+id_curso+'&nombre_curso='+nombre_curso+'&email='+email+'&nombre[first]='+nombre+'&nombre[last]='+apellido+'&id_usuario='+id_usuario+'&tipo_curso='+tipo_curso;
				jQuery("#JotFormIFrame-"+id_jotform).attr('src',url);
				jQuery("#JotFormIFrame-"+id_jotform).show(300);

			}
		});
	}*/

})(jQuery);
