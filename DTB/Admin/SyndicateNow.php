<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_SyndicateNow {
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
		return 'dbtb-syndicate-now';
	}
	
	public function redirect_url(){
		return admin_url('admin.php?page=' . $this->menu_slug() );
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
			esc_html__( 'Syndicate', $textdomain ),
			esc_html__( 'Syndicate Now', $textdomain ),
			'manage_options',
			$this->menu_slug(),
			array(DTB_Controllers_SyndicateNow::get_instance(), 'controller')
		);
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
