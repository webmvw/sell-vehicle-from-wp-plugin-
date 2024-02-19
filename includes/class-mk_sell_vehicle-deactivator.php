<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/includes
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Mk_sell_vehicle_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;

		// delete table when plugin deactivate
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mk_sell_vehicle");
	}

}
