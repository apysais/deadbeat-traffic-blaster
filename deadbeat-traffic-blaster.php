<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.deadbeatsuperaffiliate.com
 * @since             1.0.0
 * @package           Deadbeat_Traffic_Blaster
 *
 * @wordpress-plugin
 * Plugin Name:       Deadbeat Traffic Blaster V3
 * Plugin URI:        http://www.deadbeatsuperaffiliate.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Dan Brook
 * Author URI:        http://www.deadbeatsuperaffiliate.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       deadbeat-traffic-blaster
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
spl_autoload_register('dbtb_autoload_class');
function dbtb_autoload_class($class_name){
    if ( false !== strpos( $class_name, 'DTB' ) ) {
		$include_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
		$admin_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
		$class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
		if( file_exists($include_classes_dir . $class_file) ){
			require_once $include_classes_dir . $class_file;
		}
		//echo $admin_classes_dir . $class_file.'<br>';
		if( file_exists($admin_classes_dir . $class_file) ){
			require_once $admin_classes_dir . $class_file;
		}
	}
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-deadbeat-traffic-blaster-activator.php
 */
function activate_deadbeat_traffic_blaster() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deadbeat-traffic-blaster-activator.php';
	Deadbeat_Traffic_Blaster_Activator::activate();
	new DTB_Admin_DeadBeatTrafficBlasterDB;
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deadbeat-traffic-blaster-deactivator.php
 */
function deactivate_deadbeat_traffic_blaster() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deadbeat-traffic-blaster-deactivator.php';
	Deadbeat_Traffic_Blaster_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_deadbeat_traffic_blaster' );
register_deactivation_hook( __FILE__, 'deactivate_deadbeat_traffic_blaster' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-deadbeat-traffic-blaster.php';

function dbtb_get_plugin_details(){
	// Check if get_plugins() function exists. This is required on the front end of the
	// site, since it is in a file that is normally only loaded in the admin.
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$ret = get_plugins();
	return $ret['deadbeat-traffic-blaster/deadbeat-traffic-blaster.php'];
}
function dbtb_get_text_domain(){
	$ret = dbtb_get_plugin_details();
	return $ret['TextDomain'];
}
function dbtb_get_plugin_dir(){
	return plugin_dir_path( __FILE__ );
}
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_deadbeat_traffic_blaster() {

	$plugin = new Deadbeat_Traffic_Blaster();
	$plugin->run();
	
	new DTB_Admin_DeadBeatTrafficBlaster;
	
}
add_action('plugins_loaded', 'run_deadbeat_traffic_blaster');

