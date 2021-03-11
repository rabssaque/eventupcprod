<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Upc_Sso
 * @subpackage Upc_Sso/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    Upc_Sso
 * @subpackage Upc_Sso/public
 * @author     Your Name <email@example.com>
 */
class Upc_Sso_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $upc_sso    The ID of this plugin.
	 */
	private $upc_sso;

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
	 * @param      string    $upc_sso       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $upc_sso, $version ) {

		$this->upc_sso = $upc_sso;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->upc_sso, plugin_dir_url( __FILE__ ) . 'css/upc-sso-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->upc_sso, plugin_dir_url( __FILE__ ) . 'js/upc-sso-public.js', array( 'jquery', 'jquery-validate', 'forms-processor' ), $this->version, false );
		
		wp_localize_script( $this->upc_sso, 'sso_ajax_var', array(
			'url'    => admin_url( 'admin-ajax.php' ),
			'nonce'  => wp_create_nonce( 'sso-nounce-1' )
		));
	}


	/**
	 * Add Login menu to menu
	 *
	 * @since    1.0.0
	 */
	public function add_login_to_menu($items, $args){
		if( $args->theme_location == 'primary' )
        	return $items.'<li class="menu-sso-login"><buttom class="sso-btn-login" style="display: none;">Login UPC</buttom></form></li>';
  
    	return $items;
	} // add_login_to_menu()

	/**
	 * Check SSO token sended in ajax.
	 *
	 * @since    1.0.0
	 */
	public function check_token_function() {
		
		// Check for nonce security
    	$nonce = sanitize_text_field( $_POST['nonce'] );
    	if ( ! wp_verify_nonce( $nonce, 'sso-nounce-1' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion. (check token)",
				'nonce' => $nonce
			));
			exit;
		}

		if(isset($_POST['sso_token'])){
			
			$sso_token = $_POST['sso_token'];
			
			$curl_sso = curl_init();
			curl_setopt_array($curl_sso, array(
				CURLOPT_URL => 'https://apicert.upc.edu.pe/v3.0/TokenSSO?token='.$sso_token,
				CURLOPT_USERPWD => 'upc\usrprdpeupcsso' . ":" . 'Ro280221#',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET'
			));

			$curl_sso_res = curl_exec($curl_sso);
			$curl_sso_res_info = curl_getinfo($curl_sso);  				

			curl_close($curl_sso);
			if( $curl_sso_res_info['http_code'] == '200' ){

				$curl_sso_res_json = json_decode(stripslashes($curl_sso_res), true);

				if($curl_sso_res_json['mesaje'] || $curl_sso_res_json['mensaje'] ){
					echo json_encode(array(
						'success' => true,
						'data' => ['token' => 'invalid'],
						'message' => $curl_sso_res_json['mesaje'],
						'code' => $curl_sso_res_info['http_code']
					));
				} else{
					echo json_encode(array(
						'success' => true,
						'data' => $curl_sso_res_json,
						'code' => $curl_sso_res_info['http_code']
					));
					
				}

				
				exit;
			}else{
				echo json_encode(array(
					'success' => false,
					'message' => "Respuesta vacia del SSO.",
					'code' =>  $curl_sso_res_info['http_code']
				));
				exit;
			}
		} else{
			echo json_encode(array(
				'success' => false,
				'message' => "No se recibió un token para validar.",
			));
			exit;
		}
							
	} // check_token_function()

	/**
	 * Check SSO token sended in ajax.
	 *
	 * @since    1.0.0
	 */
	public function load_alumno_data_function() {
		
		// Check for nonce security
    	$nonce = sanitize_text_field( $_POST['nonce'] );
    	if ( ! wp_verify_nonce( $nonce, 'sso-nounce-1' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion.",
				'nonce' => $nonce
			));
			exit;
		}

		if(isset($_POST['idUPC'])){
			
			$alumno_idUPC = $_POST['codAlumno'];
			if(strlen($alumno_idUPC < 2)){
				echo json_encode(array(
					'success' => false,
					'message' => "Codigo de alumno invalido",
					'code' =>  0
				));
				exit;
			}

			$cod_negocio = substr($alumno_idUPC, 1);


			$curl_alumno_api = curl_init();
			curl_setopt_array($curl_sso, array(
				CURLOPT_URL => 'https://apicert.upc.edu.pe/v2/Alumnos?CodLineaNegocio='.$cod_negocio.'&CodUsuario='. $alumno_idUPC,
				CURLOPT_USERPWD => 'upc\usrprdpeupcsso' . ":" . 'Ro280221#',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET'
			));

			$curl_alumno_api_res = curl_exec($curl_alumno_api);
			$curl_alumno_api_res_info = curl_getinfo($curl_alumno_api);  				

			curl_close($curl_alumno_api);
			if( $curl_alumno_api_res_info['http_code'] == '200' ){

				$curl_alumno_api_res_json = json_decode(stripslashes($curl_alumno_api_res), true);

				if($curl_alumno_api_res_json['mesaje'] || $curl_alumno_api_res_json['mensaje'] ){
					echo json_encode(array(
						'success' => true,
						'data' => ['token' => 'invalid'],
						'message' => $curl_alumno_api_res_json['mesaje'],
						'code' => $curl_alumno_api_res_info['http_code']
					));
				} else{
					echo json_encode(array(
						'success' => true,
						'data' => $curl_alumno_api_res_json,
						'code' => $curl_alumno_api_res_info['http_code']
					));
				}
				
				exit;
			}else{
				echo json_encode(array(
					'success' => false,
					'message' => "Respuesta vacia del API alumno.",
					'code' =>  $curl_alumno_api_res_info['http_code']
				));
				exit;
			}
		} else{
			echo json_encode(array(
				'success' => false,
				'message' => "Se necesita un codigo de alumno",
				'code' =>  0
			));
			exit;
		}
							
	} // load_alumno_data_function()


	public function rewrite_rules() {
		// add_rewrite_rule( 'sso/(.+?)/?$', 'index.php?account_page=$matches[1]', 'top');
		add_rewrite_rule( 'upc-sso/?$', 'index.php?sso_page=return', 'top');
    add_rewrite_tag( '%sso_page%', '([^&]+)' );

	} // rewrite_rules()

	function my_flush_rules()
{
    $rules = get_option( 'rewrite_rules' );
    if ( ! isset( $rules['upc-sso/?$'] ) ) { 
        global $wp_rewrite; $wp_rewrite->flush_rules();
    }
} // my_flush_rules()



	public function return_page_sso($template) {
        //try and get the query var we registered in our query_vars() function
        $sso_page = get_query_var( 'sso_page' );

        //if the query var has data, we must be on the right page, load our custom template
        if($sso_page) {
        	return plugin_dir_path( __FILE__ ) . 'views/upc-sso-page.php';
				}

				return $template;
  
  } // return_page_sso()

	/**
	 * Process shortcode to display forms.
	 *
	 * @since    1.0.0
	 */
	public function show_form_sso($atts = array()) {
		ob_start();
		$variables = shortcode_atts(array(),
			$atts);

		include(plugin_dir_path(__FILE__).'forms/form-type-comunidad.php');
		

		$output = ob_get_contents();

		ob_end_clean();

		return $output;


	} // show_form_sso()


	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'sso_login_form', array( $this, 'show_form_sso' ) );

	} // register_shortcodes()

}
