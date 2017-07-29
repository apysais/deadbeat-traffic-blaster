<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_DeadBeatTrafficBlaster extends DTB_Base{
	protected static $instance = null;
	protected $setting_db_entity = null;
	protected $setting_db = null;
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
		$menu_slug = DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug();
		$data['heading'] = 'DeadBeat Traffic Blaster';
		$data['method'] = '';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		$data['action_add_facebook'] = 'admin.php?page=' . $menu_slug . '&_method=add-facebook';
		//$data['all_social_media'] = DTB_Admin_AccountDB::get_instance()->get();
		DTB_View::get_instance()->admin_partials('partials/deadbeat-traffic-blaster-admin-display.php', $data);
	}
	//move this to FB Controller
	public function add_facebook(){
		$app_id = '1210726989041567';
		$app_secret = 'f02ad8e69538fb2291da6adcfbc18769';

		$fb = new Facebook\Facebook([
		  'app_id' => $app_id, // Replace {app-id} with your app id
		  'app_secret' => $app_secret,
		  'default_graph_version' => 'v2.8',
		  ]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('http://test.dev/wp/wp-admin/admin.php?page=dbtb-main&_method=fallback-facebook', $permissions);

		echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
	}
	
	public function fallback_facebook(){
		
	}
	//move this to FB Controller
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
	
	public function __construct(){}
}
