<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/admin
 * @author     Your Name <email@example.com>
 */
class Forms_Processor_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->forms_processor, plugin_dir_url( __FILE__ ) . 'css/forms-processor-admin.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->forms_processor, plugin_dir_url( __FILE__ ) . 'js/forms-processor-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->forms_processor, 'ajax_var', array(
			'url'    => admin_url( 'admin-ajax.php' ),
			'nonce'  => wp_create_nonce( 'eveupc-admin-check-nounce' )
		));
	}

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		add_menu_page(
			apply_filters( $this->forms_processor . '-page-title', esc_html__( 'Eventos - Registros', 'now-hiring' ) ),
			apply_filters( $this->forms_processor . '-menu-title', esc_html__( 'Eventos - Registros', 'now-hiring' ) ),
			'manage_options',
			$this->forms_processor,
			array( $this, 'page_view_registers' ),
			'',
			30
		);

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		add_submenu_page(
			$this->forms_processor,
			apply_filters( $this->forms_processor . '-page-title', esc_html__( 'Suscripciones', 'now-hiring' ) ),
			apply_filters( $this->forms_processor . '-menu-title', esc_html__( 'Suscripciones', 'now-hiring' ) ),
			'manage_options',
			$this->forms_processor.'-suscripciones',
			array( $this, 'page_view_subscriptions' )
		);


	} // add_menu()

	/**
	 * Creates the view page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_view_registers() {
		
		include( plugin_dir_path( __FILE__ ) . 'partials/forms-processor-admin-view.php' );

	} // page_view()

	public function page_view_subscriptions() {
		
		include( plugin_dir_path( __FILE__ ) . 'partials/forms-processor-admin-suscriptions-view.php' );

	} // page_view_subscriptions()

	/**
	 * Process form data sended in ajax.
	 *
	 * @since    1.0.0
	 */
	public function export_subscriptions_csv() {
		
		// Check for nonce security
    $nonce = sanitize_text_field( $_POST['nonce'] );
    if ( ! wp_verify_nonce( $nonce, 'eveupc-admin-check-nounce' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion."
			));
			exit;
		}

		$myListTable = new My_Table_Subscriptions();
		$cols_subscriptions = $myListTable->get_columns();
		$data_subscriptions = $myListTable->get_subscriptions();
		$table_headers = array();
		foreach($cols_subscriptions as $col => $label){
			$table_headers[] = $col;
		}

		
		$handle = fopen('php://output', 'w');
    ob_clean(); // clean slate

    fputcsv($handle, $table_headers);

      foreach ($data_subscriptions as $row) {
        // parse the data...
        
        fputcsv($handle, $row);   // direct to buffered output
      }

    ob_flush(); // dump buffer
    fclose($handle);
		exit;
	} // export_subscriptions_csv()

	public function export_registers_csv() {
		// Check for nonce security
    $nonce = sanitize_text_field( $_POST['nonce'] );
    if ( ! wp_verify_nonce( $nonce, 'eveupc-admin-check-nounce' ) ) {
			echo json_encode(array(
				'success' => false,
				'message' => "No se permite esta accion."
			));
			exit;
		}

		$event_id = sanitize_text_field( $_POST['event_id'] ); 
				
		$myListTable = new My_Table_Registers();
		$cols_registers = $myListTable->get_columns();
		$data_registers = $myListTable->get_registers($event_id);
		$table_headers = array();
		foreach($cols_registers as $col => $label){
			$table_headers[] = $col;
		}

		
		$handle = fopen('php://output', 'w');
    ob_clean(); // clean slate

    fputcsv($handle, $table_headers);

      foreach ($data_registers as $row) {
        fputcsv($handle, $row);   
      }

    ob_flush(); // dump buffer
    fclose($handle);
		exit;

	} // export_registers_csv()

}