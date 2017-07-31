<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_DeadBeatTrafficBlaster extends DTB_Base{
	protected static $instance = null;
	protected $deadbeat_menu_slug = null;
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	public function dbtb_main(){
		global $wpdb;
		$data = array();
		$menu_slug = $this->deadbeat_menu_slug;
		$data['heading'] = 'DeadBeat Traffic Blaster';
		$data['method'] = '';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		$data['action_add_facebook'] = 'admin.php?page=' . $menu_slug . '&_method=add-facebook';
		//$data['all_social_media'] = DTB_Admin_AccountDB::get_instance()->get();
		DTB_View::get_instance()->admin_partials('partials/deadbeat-traffic-blaster-admin-display.php', $data);
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}
	
	public function __construct(){
		$this->deadbeat_menu_slug = DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug();
	}
}
