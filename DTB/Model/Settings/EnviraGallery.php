<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Lbc_Model_Settings_EnviraGallery{
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
	
	public function get_images($envira_post_id){
		$array_img = array();
		
		$img = $this->get_data($envira_post_id);
		
		$unserialize = '';
		if( isset($img['_eg_gallery_data'][0]) ){
			$unserialize = unserialize($img['_eg_gallery_data'][0]);
		}

		if( isset($unserialize['gallery']) ){
			foreach($unserialize['gallery'] as $k => $val){
				$array_img[] = $val['src'];
			}
		}
		return $array_img;
	}
	
	public function get_data($envira_post_id){
		return get_post_meta($envira_post_id);
	}
		
	public function __construct(){}
}
