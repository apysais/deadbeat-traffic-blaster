<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
use Abraham\TwitterOAuth\TwitterOAuth;

class DTB_API_Twitter {
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
	
	public function oauth($creds = array()){
		$connection = new TwitterOAuth($creds['consumer_key'], $creds['consumer_secret'], $creds['access_token'], $creds['access_token_secret']);
		return $connection->get("account/verify_credentials");
	}
	
	public function __construct(){}
}

