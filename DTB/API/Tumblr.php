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
		//https://public-api.wordpress.com/oauth2/authorize?client_id=your_client_id&redirect_uri=your_url&response_type=code&blog=1234
		$blog_id = $creds['blog_id'];
		$consumer_key = $creds['oauth_consumer_key'];
		$url = $this->url . $blog_id . '/info?api_key=' . $consumer_key;
		$response = wp_remote_get($url);
		if ( is_array( $response ) ) {
			$header = $response['headers']; // array of http header lines
			//echo $response['body']; // use the content
			return $response;
		}
	}
	
	public function create_new_blog_post(){
		//* /post — Create a New Blog Post
		//api.tumblr.com/v2/blog/{blog-identifier}/post
		$blog_id = $creds['blog_id'];
		$consumer_key = $creds['oauth_consumer_key'];
		$url = $this->url . $blog_id . '/info?api_key=' . $consumer_key;
		$response = wp_remote_get($url);
		if ( is_array( $response ) ) {
			$header = $response['headers']; // array of http header lines
			//echo $response['body']; // use the content
			return $response;
		}
	}
	
	
	
	public function __construct(){}
}

