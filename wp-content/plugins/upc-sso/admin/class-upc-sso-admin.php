<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Upc_Sso
 * @subpackage Upc_Sso/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Upc_Sso
 * @subpackage Upc_Sso/admin
 * @author     Your Name <email@example.com>
 */
class Upc_Sso_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->upc_sso, plugin_dir_url( __FILE__ ) . 'css/upc-sso-admin.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/* wp_enqueue_script( $this->upc_sso, plugin_dir_url( __FILE__ ) . 'js/upc-sso-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->upc_sso, 'ajax_var', array(
			'url'    => admin_url( 'admin-ajax.php' ),
			'nonce'  => wp_create_nonce( 'eveupc-admin-check-nounce' )
		)); */
	}

	
	/**
	 * Creates the view page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	/* public function page_view_registers() {
		
		include( plugin_dir_path( __FILE__ ) . 'partials/upc-sso-admin-view.php' );

	} // page_view() */



}