<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Lbc_Model_Settings_DBEntity{
	protected static $instance = null;
	protected $setting_model = null;
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
	
	public function get_slider_front(){
		return Lbc_Model_Settings::get_instance()->slider_front('r');
	}

	public function get_slider_inner(){
		return Lbc_Model_Settings::get_instance()->slider_inner('r');
	}
	
	public function update_slider_front($val){
		return Lbc_Model_Settings::get_instance()->slider_front('u', $val);
	}

	public function update_slider_inner($val){
		return Lbc_Model_Settings::get_instance()->slider_inner('u', $val);
	}
		
	public function __construct(){}
}
