<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DTB_API_Tumblr {
	protected static $instance = null;
	public $url = 'https://api.tumblr.com/v2/blog/';
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
	
	public function oauth_info($creds = array()){
		$client = new Tumblr\API\Client($creds['consumer_key'], $creds['consumer_secret']);
		$client->setToken($creds['access_token'], $creds['access_token_secret']);
		return $client->getUserInfo();
	}
	
	public function create_new_blog_post($creds = array(), $post_data){
		//* /post — Create a New Blog Post
		//api.tumblr.com/v2/blog/{blog-identifier}/post
		
		$client = new Tumblr\API\Client($creds['consumer_key'], $creds['consumer_secret']);
		$client->setToken($creds['access_token'], $creds['access_token_secret']);
		return $client->createPost($creds['blog_id'], $post_data);
	}
	
	
	
	public function __construct(){}
}

