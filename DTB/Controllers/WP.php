<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_WP extends DTB_Base{
	protected static $instance = null;
	protected $wp_menu_slug = null;
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
	
	public function wp_redirect_url(){
		
	}
	
	public function create_wp_api(){
		DTB_API_WP::get_instance()->oauth_authorize($_POST);
	}
	
	public function dbtb_wp(){
		$data = array();
		if( isset($_GET['code']) ){
			$ret = DTB_API_WP::get_instance()->auth_after_redirect();

			$settings_array = array(
				'client_id' => $_SESSION['client_id'],
				'client_secret' => $_SESSION['client_secret_key'],
				'api_token' => $ret['secret']->access_token,
				'blog_id' => $ret['secret']->blog_id,
				'secret' => $ret['secret'],
			);
			$data = array(
				'service' => 'wordpress',
				'name' => 'WordPress',
				'settings' => serialize($settings_array),
			);
			$format_array = array(
				'%s',
				'%s',
				'%s',
			);
			$id = DTB_Admin_AccountDB::get_instance()->store($data, $format_array);
			dbtb_redirect('admin.php?page=' . DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug());
			exit();
		}
		$menu_slug = $this->wp_menu_slug;
		$data['method'] = 'create_wp_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		$data['redirect_url'] = DTB_Admin_WP::get_instance()->redirect_url();
		DTB_View::get_instance()->admin_partials('partials/wp/wp-create.php', $data);
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
		$this->wp_menu_slug = DTB_Admin_WP::get_instance()->menu_slug();
	}
}
