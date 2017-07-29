<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_AccountDB {
	protected static $instance = null;
	protected $_wpdb;
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
	
	public function get($id = null){
		global $wpdb;
		$table_name = $wpdb->prefix . 'tb_accounts';
		
		if( !is_null($id) ){
			$str = "SELECT * FROM $table_name WHERE account_id = $id";
			$query = $wpdb->get_results($str);
		}else{
			$query = $wpdb->get_results( "SELECT * FROM $table_name" );
		}
		
		return $query;
	}
	
	public function __construct(){}
}
