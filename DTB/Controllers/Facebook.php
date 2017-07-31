<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Facebook extends DTB_Base{
	protected static $instance = null;
	protected $fb_menu_slug = null;
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
	
	public function dbtb_facebook(){
		$data = array();
		$menu_slug = $this->fb_menu_slug;
		$data['method'] = 'create_facebook_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		DTB_View::get_instance()->admin_partials('partials/fb/fb-create.php', $data);
	}
	
	public function create_facebook_api(){
		print_r($_POST);
		DTB_API_Facebook::get_instance()->login(1,2);
	}
	
	public function fallback(){
		DTB_API_Facebook::get_instance()->fallback();
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
		$this->fb_menu_slug = DTB_Admin_Facebook::get_instance()->menu_slug();
	}
}
