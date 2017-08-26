<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_CronJob {
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
	
		
	public function menu_slug($id){
		return '?dbtb-cronjob='.$id;
	}
	
	public function http_request_print(){
		global $wp_query;
		//wget "http://test.dev/wp/?dtbcronjob=123"
		//curl "http://test.dev/wp/?dtbcronjob=123"
		//print_r($wp_query);
		print_r($_GET);
		die();
	}
	
	public function __construct(){
		if( !is_admin() ){
			add_action('parse_request', array($this,'http_request_print'));
		}
	}	
}
