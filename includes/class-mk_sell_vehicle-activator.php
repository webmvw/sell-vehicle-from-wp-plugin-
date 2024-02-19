<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/includes
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Mk_sell_vehicle_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		if( ! function_exists('dbDelta') ){
			require_once(ABSPATH. 'wp-admin/includes/upgrade.php');
		}

		$mk_sell_vehicle_table_query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}mk_sell_vehicle`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`make` varchar(250) DEFAULT NULL,
			`model` varchar(250) DEFAULT NULL,
			`trim` varchar(250) DEFAULT NULL,
			`created_at` timestamp NOT NULL DEFAULT current_timestamp(),
			PRIMARY KEY (`id`)
		) $charset_collate";
		
		dbDelta( $mk_sell_vehicle_table_query );
	}

}
