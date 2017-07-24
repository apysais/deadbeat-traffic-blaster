<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.deadbeatsuperaffiliate.com
 * @since      1.0.0
 *
 * @package    Deadbeat_Traffic_Blaster
 * @subpackage Deadbeat_Traffic_Blaster/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Deadbeat_Traffic_Blaster
 * @subpackage Deadbeat_Traffic_Blaster/includes
 * @author     Dan Brook <dan@mail.com>
 */
class Deadbeat_Traffic_Blaster_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'deadbeat-traffic-blaster',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
