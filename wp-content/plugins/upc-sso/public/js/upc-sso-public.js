


'use strict';

console.log('SSO ready')

class Sso_Session{
	constructor(){
		this.token = localStorage.getItem('sso_token') ? localStorage.getItem('sso_token') : ''
		this.enroll = localStorage.getItem('sso_enroll') === 'true' ? true : false 
		this.loged = localStorage.getItem('sso_loged') === 'true' ? true : false 
		this.returnPage = localStorage.getItem('sso_returnPage') ? localStorage.getItem('sso_returnPage') : ''
		this.alumnoData = {}
	}

	getToken(){ return this.token }
	setToken(token){
		this.token = token
		localStorage.setItem('sso_token', this.token)
	}

	getEnroll(){ return this.enroll }
	
	/**
	 * @param {Boolean} enroll Activate enrollment
	 */
	setEnroll(enroll){ 
		this.enroll = enroll 
		localStorage.setItem('sso_enroll', this.enroll )
	}

	getLoged(){ return this.loged }

	/**
	 * @param {Boolean} loged Activate enrollment
	 */
	setLoged(loged){ 
		this.loged = loged
		localStorage.setItem('sso_loged', this.loged )
	}

	getReturnPage(){
		return this.returnPage
	}
	setReturnPage(returnPage){ 
		this.returnPage = returnPage
		localStorage.setItem('sso_returnPage', this.returnPage )
	}

	getAlumnoData(){
		return this.alumnoData
	}
	setAlumnodata(newData){
		this.alumnoData = newData
	}

	goLogin(){
		this.setLoged(false)
		this.setReturnPage(window.location.href)
		window.location.href = "https://micuenta-cer.upc.edu.pe/home/index?_f=5"
	}
	goLogout(){
		this.setLoged(false)
		this.setToken('')
		this.setReturnPage(window.location.href)
		window.location.href = "https://micuenta-cer.upc.edu.pe/home/endsession?_f=5"
	}

	loginSucess(token){
		this.setToken(token)
		this.setLoged(true)
		const sso_redirect = getReturnPage()
		this.setReturnPage('')
		window.location.href = sso_redirect
	}

	checkToken = function(){

		return jQuery.ajax({
			type: "post",
			url: sso_ajax_var.url,
			data: {
				action: "check_token",
				nonce: sso_ajax_var.nonce,
				sso_token: ssoSession.getToken(),
			},
			success: function(result){
				// console.log(result);
				var jsonResult = JSON.parse(result);
				jQuery('.sso-btn-login').removeAttr("disabled")
				jQuery("#sso-btn-enrollment").removeAttr("disabled")
				if(jsonResult.success !== undefined){
					jQuery('.sso-btn-login').removeAttr("disabled")
					if(jsonResult.token && jsonResult.token == 'invalid' ){
						console.log('token invalido')
						jQuery('#sso-btn-enrollment').text('Acceder')
						jQuery('.sso-btn-login').text('Login UPC')
						jQuery('.sso-btn-login').removeClass('loged')
						jQuery('.sso-btn-login').show()
					}else{
						
						console.log('Token valido')
						
						jQuery('#sso-btn-enrollment').text('Inscribirme')
						jQuery('.sso-btn-login').text('Cerrar sesión')
						jQuery('.sso-btn-login').addClass('loged')
						jQuery('.sso-btn-login').show()
						
					}
				} else{
					jQuery('.sso-btn-login').removeAttr("disabled")
					jQuery("#sso-btn-enrollment").removeAttr("disabled")
					jQuery("#sso-container .form-event-error").append('<div class="form-event-error">No se pudo validar.</div>');
				}	
			},
			beforeSend: function(){
				jQuery('.sso-btn-login').attr("disabled", true)
				jQuery("#sso-btn-enrollment").attr("disabled", true)
				jQuery("#sso-container .form-event-error").remove()
				
			}
		})

	} // checkToken

	loadAlumnoData = function(codAlumno){
		console.log('load codalumno:', codAlumno)
		return jQuery.ajax({
			type: "post",
			url: sso_ajax_var.url,
			data: {
				action: "load_alumno_data",
				nonce: sso_ajax_var.nonce,
				codAlumno: codAlumno
			},
			success: function(result){
				// console.log(result);
				var jsonResult = JSON.parse(result);


				if(jsonResult.success !== undefined){
					jQuery('.sso-btn-login').removeAttr("disabled")
					if(jsonResult.token && jsonResult.token == 'invalid' ){
						console.log('respuesta invalida')
						
					}else{
						this.alumnoData = jsonResult
						console.log('Alumno cargado:', this.alumnoData)
	
						
					}
				} else{

				}	
			},
			beforeSend: function(){
				
				
			}
		})

	} // loadAlumnoData
}

const ssoSession = new Sso_Session()


jQuery(document).ready(function () {

	if(ssoSession.getLoged()){
		ssoSession.checkToken().then((res) => {
			if(res.token !== 'invalid'){
				// Revisar!!!!
				console.log('Alumno:', res)
				ssoSession.setAlumnodata(res)
				if(ssoSession.getEnroll()){
					
					enrollComunidad(ssoSession.getAlumnoData())
					console.log('Alumno get',ssoSession.getAlumnoData())
				}
				
			}
		})
	} else{
		console.log('Sesion no iniciada')
		jQuery('.sso-btn-login').text('Login UPC')
		jQuery('#sso-btn-enrollment').text('Acceder')
		jQuery('.sso-btn-login').removeClass('loged')
		jQuery('.sso-btn-login').show()
	}



	



	jQuery('#sso-btn-enrollment').click(function() {
		
		ssoSession.setEnroll(true)

		if(!ssoSession.getLoged()){

			ssoSession.goLogin()

		} else{


			
			enrollComunidad(ssoSession.getAlumnoData())
		}
	})

	jQuery('.sso-btn-login').click(function() {
		if(!ssoSession.getLoged()){
			ssoSession.goLogin()
		} else{
			ssoSession.goLogout()
		}
	})

})

function enrollComunidad(ssoAlumnoData){
	console.log('Inscribiendo', ssoAlumnoData)
	const evento_id = jQuery('#sso-btn-enrollment').data('evento-id')
	const zoom_meeting_id = jQuery('#sso-btn-enrollment').data('zoom-meeting-id')
	
	

	console.log('alumnoData:', ssoAlumnoData.IdUPC)
	ssoSession.loadAlumnoData(ssoAlumnoData.IdUPC).then((data)=>{
		const alumnoDataForm = {
			reg_nombre: ssoAlumnoData.Nombre,
			reg_ape_paterno: ssoAlumnoData.Apellido,
			reg_ape_materno: '-',
			reg_genero: 'sso-genero',
			reg_tipo_doc: 'sso-tipodoc',
			reg_num_doc: 'sso-numdoc',
			reg_email: 'demo1@demo.com',
			reg_celular: 'sso-celular',
			reg_autorizacion: 'sso-aceptacion',
			hidden_evento_id: evento_id,
			hidden_zoom_meeting_id: zoom_meeting_id
		}
		comunidadEnrollment(alumnoDataForm).then((alumnoDataForm) =>{
			ssoSession.setEnroll(false)
		})
	})
	
}







