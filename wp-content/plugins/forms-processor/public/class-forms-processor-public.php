<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/public
 * @author     Your Name <email@example.com>
 */
class Forms_Processor_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $forms_processor    The ID of this plugin.
	 */
	private $forms_processor;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $forms_processor       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $forms_processor, $version ) {

		$this->forms_processor = $forms_processor;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->forms_processor, plugin_dir_url( __FILE__ ) . 'css/forms-processor-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->forms_processor, plugin_dir_url( __FILE__ ) . 'js/forms-processor-public.js', array( 'jquery', 'jquery-validate' ), $this->version, false );
		wp_enqueue_script( 'jquery-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->forms_processor, 'ajax_var', array(
			'url'    => admin_url( 'admin-ajax.php' ),
			'nonce'  => wp_create_nonce( 'eveupc-check-nounce' ),
			'action' => 'process_form'
		));
	}

	/**
	 * Process form data sended in ajax.
	 *
	 * @since    1.0.0
	 */
	public function processor_function() {
		
		// Check for nonce security
    $nonce = sanitize_text_field( $_POST['nonce'] );
    if ( ! wp_verify_nonce( $nonce, 'eveupc-check-nounce' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion."
			));
			exit;
		}

		if(isset($_POST['data_form'])){
			$form_data = json_decode(stripslashes($_POST['data_form']), true);
			
			if(count($form_data) > 0){
				
				
				$nombre = isset($form_data['reg_nombre']) ? sanitize_text_field ($form_data['reg_nombre']) : '';
				$ape_paterno = isset($form_data['reg_ape_paterno']) ? sanitize_text_field ($form_data['reg_ape_paterno']) : '';
				$ape_materno = isset($form_data['reg_ape_materno']) ? sanitize_text_field ($form_data['reg_ape_materno']) : '';
				$genero = isset($form_data['reg_genero']) ? sanitize_text_field ($form_data['reg_genero']) : '';
				$doc_tipo = isset($form_data['reg_tipo_doc']) ? sanitize_text_field ($form_data['reg_tipo_doc']) : '';
				$doc_numero = isset($form_data['reg_num_doc']) ? sanitize_text_field ($form_data['reg_num_doc']) : '';
				$email = isset($form_data['reg_email']) ? sanitize_text_field ($form_data['reg_email']) : '';
				$celular = isset($form_data['reg_celular']) ? sanitize_text_field ($form_data['reg_celular']) : '';
				$acepta_terminos = isset($form_data['reg_autorizacion']) ? sanitize_text_field ($form_data['reg_autorizacion']) : '';
				$evento_id = isset($form_data['hidden_evento_id']) ? sanitize_text_field ($form_data['hidden_evento_id']) : '';
				// $zoom_admin = isset($form_data['hidden_evento_zoom_admin']) ? sanitize_text_field ($form_data['hidden_evento_zoom_admin']) : '';
				$zoom_meeting_id = isset($form_data['hidden_zoom_meeting_id']) ? sanitize_text_field ($form_data['hidden_zoom_meeting_id']) : '';
				$fecha_registro = current_time('mysql');

				if($email != '' && $evento_id != '' && $nombre != '' && $ape_paterno != '' ){
					
					$e_product = wc_get_product( $evento_id );
					if ( ! $e_product ) {
						echo json_encode(array(
							'success' => false,
							'message' => "No se econtró el evento."
						));
					}
					// Stock 

					if(!$e_product->get_manage_stock() && !$e_product->is_in_stock()){
						echo json_encode(array(
							'success' => false,
							'message' => "No hay cupos disponibles."
						));
						exit;
					}
					
					// Estado del evento
					$current_date = current_time('timestamp');
					$fecha_evento_timestamp = strtotime(get_field('fecha_de_evento', $evento_id));
					$fecha_fin_timestamp = strtotime(get_field('fecha_de_evento_final', $evento_id));
					if(!$fecha_fin_timestamp){
						$fecha_fin_timestamp = $fecha_evento_timestamp;
					}
					if ( $fecha_fin_timestamp <= $current_date ) {
						echo json_encode(array(
							'success' => false,
							'message' => "El evento está vencido. $current_date - $fecha_fin_timestamp"
						));
						exit;
					}

					global $wpdb;

					$sql_search_email = "SELECT count(email) FROM {$wpdb->prefix}eventos_registros WHERE evento_id = {$evento_id} AND email = '{$email}'";
      				$count_email = $wpdb->get_var( $sql_search_email );
					if($count_email > 0) {
						echo json_encode(array(
							'success' => false,
							'message' => "Este correo ya está registrado."
						));
						exit;
					}
					
					$table_name = $wpdb->prefix . 'eventos_registros';
					$data = array(
						'evento_id' => $evento_id,
						'nombre' => $nombre,
						'ape_paterno' => $ape_paterno,
						'ape_materno' => $ape_materno,
						'genero'    => $genero,
						'doc_tipo' => $doc_tipo,
						'doc_numero' => $doc_numero,
						'email'    => $email,
						'celular' => $celular,
						'acepta_terminos' => $acepta_terminos,
						'zoom_meeting_id'  => $zoom_meeting_id,
						'zoom_register_id' => '',
						'fecha_registro' => $fecha_registro
					);
            		$format = array(
          					'%d',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
              				'%s',
            		);
            		$success_bd=$wpdb->insert( $table_name, $data, $format );
            		if($success_bd){
						wc_update_product_stock($e_product, 1, 'decrease');
						if($zoom_meeting_id != ''){
							
							$curl_zoom = curl_init();
							curl_setopt_array($curl_zoom, array(
								CURLOPT_URL => 'https://api.zoom.us/v2/meetings/'.$zoom_meeting_id.'/registrants',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => '',
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 0,
								CURLOPT_FOLLOWLOCATION => true,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => 'POST',
								CURLOPT_POSTFIELDS =>'{
									"email": "'.$email.'",
									"first_name": "'.$nombre.'",
									"last_name": "'.$ape_paterno.'"
								}',
								CURLOPT_HTTPHEADER => array(
									'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IlJPXy1CNzBJVFFhU3A2cFVrbHBPNVEiLCJleHAiOjE4OTQ2NjkyMDAsImlhdCI6MTYxMDY2NzA0NH0.Maujxa0XAEyIB4pNoQz_GxTbxa6LbuY_W8p5GXCWwtA',
									'Content-Type: application/json',
									'Cookie: cred=BAD5EF7DDC421083F7B3F311E3A2547F'
								)
							));
							$curl_zoom_response = curl_exec($curl_zoom);

							curl_close($curl_zoom);
							if( $curl_zoom_response ){
								$zoom_response = json_decode(stripslashes($curl_zoom_response),true);

								$wpdb->update( $table_name, array( 'zoom_register_id' => $zoom_response['registrant_id']),array('id'=>$wpdb->insert_id));
								echo json_encode(array(
									'success' => true,
									'message' => "Registro exitoso y Zoom."
								));
								exit;
							}else{
								echo json_encode(array(
									'success' => true,
									'message' => "Registro exitoso. Zoom error.",
									'data' => $curl_zoom_response
								));
								exit;
							}
						}
						
						
						echo json_encode(array(
							'success' => true,
							'message' => "Registro exitoso."
						));
						exit;
					}
				} else{
					echo json_encode(array(
						'success' => false,
						'message' => "No se enviaron los datos necesarios."
					));
					exit;
				}
				
			} else{
				echo json_encode(array(
					'success' => false,
					'message' => "La data esta vacia."
				));
				exit;
			}
			
		} else{
			echo json_encode(array(
				'success' => false,
				'message' => "No hay data para procesar"
			));
			exit;
		}
		
	} // processor_function()

	/**
	 * Process form data sended in ajax.
	 *
	 * @since    1.0.0
	 */
	public function processor_subscriptions() {
		
		// Check for nonce security
    $nonce = sanitize_text_field( $_POST['nonce'] );
    if ( ! wp_verify_nonce( $nonce, 'eveupc-check-nounce' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion."
			));
			exit;
		}

		if(isset($_POST['data_subscription'])){
			$data_subscription = json_decode(stripslashes($_POST['data_subscription']), true);
			
			if(count($data_subscription) > 0){
				
				$email = isset($data_subscription['email']) ? sanitize_text_field ($data_subscription['email']) : '';
				
				$fecha_registro = current_time('mysql');

				if($email != ''){
									
					global $wpdb;

					$sql_search_email = "SELECT count(email) FROM {$wpdb->prefix}eventos_suscripciones WHERE email = '{$email}'";
      		$count_email = $wpdb->get_var( $sql_search_email );
					if($count_email > 0) {
						echo json_encode(array(
							'success' => false,
							'message' => "Este correo ya está registrado."
						));
						exit;
					}
					
					$table_name = $wpdb->prefix . 'eventos_suscripciones';
					$data = array(
						'email'    => $email,
						'fecha_registro' => $fecha_registro
					);
					$format = array(
						'%s',
						'%s'
					);
					$success_bd=$wpdb->insert( $table_name, $data, $format );
					if($success_bd){
						echo json_encode(array(
							'success' => true,
							'message' => "Registro exitoso."
						));
						exit;
					} else{
						echo json_encode(array(
							'success' => false,
							'message' => "Error al registrar los datos."
						));
						exit;
					}

				} else{
					echo json_encode(array(
						'success' => false,
						'message' => "No se enviaron los datos necesarios."
					));
					exit;
				}
				
			} else{
				echo json_encode(array(
					'success' => false,
					'message' => "La data esta vacia."
				));
				exit;
			}
			
		} else{
			echo json_encode(array(
				'success' => false,
				'message' => "No hay data para procesar"
			));
			exit;
		}
		
	} // processor_subscriptions()


	/**
	 * Process shortcode to display forms.
	 *
	 * @since    1.0.0
	 */
	public function show_form($atts = array()) {
		ob_start();
		$variables = shortcode_atts(array(
				"form_type"=> ""
			),
			$atts);

		if($variables['form_type']=='publico'){
		
			include(plugin_dir_path(__FILE__).'forms/form-type-publico.php');

		} elseif($variables['form_type']=='comunidad'){
			include(plugin_dir_path(__FILE__).'forms/form-type-comunidad.php');
		} 

		$output = ob_get_contents();

		ob_end_clean();

		return $output;


	} // show_form()


	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'register_form', array( $this, 'show_form' ) );

	} // register_shortcodes()

}
