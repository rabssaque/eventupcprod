<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Forms_Processor
 * @subpackage Forms_Processor/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Forms_Processor
 * @subpackage Forms_Processor/includes
 * @author     Your Name <email@example.com>
 */
class Forms_Processor_Activator {

	/**
	 * Sincronizacion con BD
	 *
	 * Verifica y crea la tabla donde se guardaran los registros.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;


		$table_name = $wpdb->prefix . 'eventos_registros';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id int(20) NOT NULL AUTO_INCREMENT,
			email tinytext DEFAULT '' NOT NULL,
			nombre tinytext DEFAULT '' NOT NULL,
			ape_paterno tinytext DEFAULT '' NOT NULL,
			ape_materno tinytext DEFAULT '' NOT NULL,
			genero tinytext DEFAULT '' NOT NULL,
			doc_tipo tinytext DEFAULT '' NOT NULL,
			doc_numero tinytext DEFAULT '' NOT NULL,
			celular tinytext DEFAULT '' NOT NULL,
			acepta_terminos tinytext DEFAULT '' NOT NULL,
			evento_id tinytext DEFAULT '' NOT NULL,
			zoom_meeting_id tinytext DEFAULT '' NOT NULL,
			zoom_register_id tinytext DEFAULT '' NOT NULL,
			fecha_registro datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,		
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$table_suscripciones = $wpdb->prefix . 'eventos_suscripciones';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql_suscripciones = "CREATE TABLE $table_suscripciones (
			id int(20) NOT NULL AUTO_INCREMENT,
			email tinytext DEFAULT '' NOT NULL,
			fecha_registro datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,		
			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql_suscripciones );

	}

	

}