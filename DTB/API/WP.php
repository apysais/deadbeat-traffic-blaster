<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DTB_API_WP {
	protected static $instance = null;
	public $url = 'https://public-api.wordpress.com';
	public $url_end_point = 'rest/v1.2/sites';
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
	
	public function oauth_authorize($creds = array()){
		//https://public-api.wordpress.com/oauth2/authorize?client_id=your_client_id&redirect_uri=your_url&response_type=code&blog=1234
		$_SESSION['client_id'] = $creds['client_id'];
		$_SESSION['redirect_url'] = $creds['redirect_url'];
		$_SESSION['client_secret_key'] = $creds['client_secret'];
		$url = $this->url . '/oauth2/authorize?client_id='.$creds['client_id'].'&redirect_uri='.$creds['redirect_url'].'&response_type=code';
		$response = wp_remote_get($url);
		if ( is_array( $response ) ) {
			$_SESSION['client_id'] = $creds['client_id'];
			$_SESSION['redirect_url'] = $creds['redirect_url'];
			$_SESSION['client_secret_key'] = $creds['client_secret'];
			$header = $response['headers']; // array of http header lines
			echo $response['body']; // use the content
		}
	}
	
	public function auth_after_redirect(){
		$post_fields = array(
			'client_id' => $_SESSION['client_id'],
			'redirect_uri' => DTB_Admin_WP::get_instance()->redirect_url(),
			'client_secret' => $_SESSION['client_secret_key'],
			'code' => $_GET['code'], // The code from the previous request
			'grant_type' => 'authorization_code'
		) ;

		$curl = curl_init( 'https://public-api.wordpress.com/oauth2/token' );
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $post_fields);
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
		$auth = curl_exec( $curl );
		$secret = json_decode($auth);
		$access_key = $secret->access_token;
		return array(
			'secret' => $secret,
			'access_key' => $access_key,
		);
	}
	
	public function post_status($creds = array(), $content){
		$url = $this->url . '/' . $this->url_end_point . '/' . $creds['blog_id'] . '/posts/new/';
		$response = wp_remote_post( $url, array(
			'ignore_errors' => 'true',
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array (
			  'Authorization' => 'Bearer '.$creds['api_token'],
			  'Content-Type' =>'application/x-www-form-urlencoded;charset=UTF-8',
			),
			'body' => array (
				'title' => $content['title'],
				'content' => $content['content']
			  ),
			'cookies' => array()
			)
		);
		return $response;

	}
		
	public function __construct(){}
}

