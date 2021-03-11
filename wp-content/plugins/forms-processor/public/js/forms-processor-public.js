(function( $ ) {
	'use strict';

	console.log('Register JS ready.')

	$.validator.methods.readioReq = function( value, element ) {
		return this.optional( element ) || value !== "";
	}

	$(document).ready(function ($) {

		if ($('#authorization_no').attr('checked')){
			$("#form-event-register_publico input[type=submit]").attr("disabled", true);
		}

		$('#form-event-register_publico input[name=reg_autorizacion]').click(function (){
			if ($(this).val() === 'si'){
				$("#form-event-register_publico input[type=submit]").removeAttr("disabled");
			} else{
				$("#form-event-register_publico input[type=submit]").attr("disabled", true)
			}

		})


		$("#form-event-register_publico").validate({
			submitHandler: function(form) {
				var values = {};
				$.each($(form).serializeArray(), function(i, field) {
						values[field.name] = field.value
				})

				$.ajax({
						type: "post",
						url: ajax_var.url,
						data: {
							action: "process_form",
							nonce: ajax_var.nonce,
							data_form: JSON.stringify(values),
						},
						success: function(result){
							console.log(result);
							var jsonResult = JSON.parse(result);
								if(jsonResult.success !== undefined){
									if(jsonResult.success){
										$('#eupc-forms').hide()
										$('#eupc-forms-gracias').show()
									}else{
										$(".sso-btn").removeAttr("disabled")
										$(form).append('<div class="form-event-error">'+ jsonResult.message +'</div>');
									}
								} else{
									$(".sso-btn").removeAttr("disabled")
									$(form).append('<div class="form-event-error">No se recibió una respuesta válida.</div>');
								}
								
						},
						beforeSend: function(){
							$(".sso-btn").attr("disabled", true)
							$(form).find(".form-event-error").remove()
							
						}
				});
				
			},
			rules: {
				reg_nombre: {
					required: true
				},
				reg_ape_paterno: {
					required: true
				},
				reg_ape_materno: {
					required: true
				},
				reg_genero: {
					required: true
			 },
				reg_tipo_doc: {
					required: true 
				},
				reg_num_doc: {
					required: true
				},
				reg_email: {
					required: true
				},
				reg_celular: {
					required: true
				},
				reg_autorizacion: {
					readioReq: true,
					normalizer: function( value ) {
						return $.trim( value );
					}
				},
			},
			messages: {
				reg_nombre: {
					required: "Este campo es necesario."
				},
				reg_ape_paterno: {
					required: "Este campo es necesario."
				},
				reg_ape_materno: {
					required: "Este campo es necesario."
				},
				reg_genero: {
					required: "Este campo es necesario."
			 },
				reg_tipo_doc: {
					required: "Este campo es necesario."
				},
				reg_num_doc: {
					required: "Este campo es necesario."
				},
				reg_email: {
					required: "Este campo es necesario."
				},
				reg_celular: {
					required: "Este campo es necesario."
				},
				reg_autorizacion: {
					readioReq: "Por favor lea y acepte los términos y condiciones."
				}
			}
		})
		

		// Subscribe emails

		$("#form-subscribe").validate({
			submitHandler: function(form) {
				var values = {};
				$.each($(form).serializeArray(), function(i, field) {
						values[field.name] = field.value
				})

				$.ajax({
						type: "post",
						url: ajax_var.url,
						data: {
							action: "email_subscribe",
							nonce: ajax_var.nonce,
							data_subscription: JSON.stringify(values),
						},
						success: function(result){
							var jsonResult = JSON.parse(result);
								if(jsonResult.success !== undefined){
									if(jsonResult.success){
										$('#form-subscribe').html("¡Gracias por registrarte!")
									}else{
										$(form).find("input[type=submit]").removeAttr("disabled")
										$(form).append('<div class="form-subscribe-error">'+ jsonResult.message +'</div>');
									}
								} else{
									$(form).find("input[type=submit]").removeAttr("disabled")
									$(form).append('<div class="form-subscribe-error">No se recibió una respuesta válida.</div>');
								}
								
						},
						beforeSend: function(){
							$(form).find("input[type=submit]").attr("disabled", true)
							$(form).find(".form-subscribe-error").remove()
							
						}
				});
				
			},
			rules: {
				email: {
					required: true,
				
				}
			},
			messages: {
				email: {
					required: "Este campo es necesario.",
					email: "Ingresa un correo válido."
				}
			}
		})


	}) // jQuery(document).ready

	

})( jQuery )



function comunidadEnrollment(alumnoData){

	return jQuery.ajax({
		type: "post",
		url: ajax_var.url,
		data: {
			action: "process_form",
			nonce: ajax_var.nonce,
			data_form: JSON.stringify(alumnoData),
		},
		success: function(result){
			console.log(result);
			var jsonResult = JSON.parse(result);
				if(jsonResult.success !== undefined){
					if(jsonResult.success){
						jQuery('#eupc-forms').hide()
						jQuery('#eupc-forms-gracias').show()
					}else{
						jQuery(".sso-btn").removeAttr("disabled")
						jQuery("#sso-container").append('<div class="form-event-error">'+ jsonResult.message +'</div>');
					}
				} else{
					jQuery(".sso-btn").removeAttr("disabled")
					jQuery("#sso-container").append('<div class="form-event-error">No se recibió una respuesta válida.</div>');
				}
				
		},
		beforeSend: function(){
			jQuery(".sso-btn").attr("disabled", true)
			jQuery("#sso-container").find(".form-event-error").remove()
			
		}
	});
}