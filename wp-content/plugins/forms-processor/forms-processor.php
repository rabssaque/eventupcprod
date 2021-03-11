<?php

/**
 * Forms processor
 *
 * Registration to posts and personalized actions.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Forms_Processor
 *
 * @wordpress-plugin
 * Plugin Name:       Forms processor
 * Plugin URI:        http://example.com/forms-processor/
 * Description:       Registration to posts and personalized actions such as mailings or API requests.
 * Version:           1.0.0
 * Author:            Developer
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       forms-processor
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'FORMS_PROCESSOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-forms-processor-activator.php
 */
function activate_forms_processor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-forms-processor-activator.php';
	Forms_Processor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-forms-processor-deactivator.php
 */
function deactivate_forms_processor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-forms-processor-deactivator.php';
	Forms_Processor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_forms_processor' );
register_deactivation_hook( __FILE__, 'deactivate_forms_processor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-forms-processor.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_forms_processor() {

	$plugin = new Forms_Processor();
	$plugin->run();

}
run_forms_processor();