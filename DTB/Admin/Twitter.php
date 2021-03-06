<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_Twitter {
	protected static $instance = null;
	
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
		
	public function menu_slug(){
		return 'dbtb-twitter';
	}
	
	/**
	 * Add sub menu page
	 *
	 * @since 1.0.0
	 */
	public function add_admin_submenu() {
		$textdomain = dbtb_get_text_domain();
		$parent = DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug();
		add_submenu_page(
			$parent,
			esc_html__( 'Twitter', $textdomain ),
			esc_html__( 'Create New Twitter', $textdomain ),
			'manage_options',
			$this->menu_slug(),
			array(DTB_Controllers_Twitter::get_instance(), 'controller')
		);
	}
	
	public function get_credentials($account_id){
		$cred = DTB_Admin_AccountDB::get_instance()->get_by_service_id($account_id, 'twitter');
		return unserialize($cred->settings);
	}
	
	public function init_hook(){
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'add_admin_submenu' ) );
		}
	}
	
	public function __construct(){
		$this->init_hook();
	}	
}
