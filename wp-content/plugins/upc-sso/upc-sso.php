<?php

/**
 * SSO Integration
 *
 * Registration to posts and personalized actions.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Upc_Sso
 *
 * @wordpress-plugin
 * Plugin Name:       SSO Integration
 * Plugin URI:        http://example.com/upc-sso/
 * Description:       Registration to posts and personalized actions such as mailings or API requests.
 * Version:           1.0.0
 * Author:            Developer
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       upc-sso
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'UPC_SSO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-upc-sso-activator.php
 */
function activate_upc_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-upc-sso-activator.php';
	Upc_Sso_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-upc-sso-deactivator.php
 */
function deactivate_upc_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-upc-sso-deactivator.php';
	Upc_Sso_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_upc_sso' );
register_deactivation_hook( __FILE__, 'deactivate_upc_sso' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-upc-sso.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_upc_sso() {

	$plugin = new Upc_Sso();
	$plugin->run();

}
run_upc_sso();