<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Tumblr extends DTB_Base{
	protected static $instance = null;
	protected $tumblr_menu_slug = null;
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
	
	public function create_tumblr_api(){
		$blog_id = '';
		if( trim($_POST['blog_id']) != '' ){
			$blog_id = $_POST['blog_id'];
		}
		$oauth_consumer_key = '';
		if( trim($_POST['consumer_key']) != '' ){
			$oauth_consumer_key = $_POST['consumer_key'];
		}
		$consumer_secret = '';
		if( trim($_POST['consumer_secret']) != '' ){
			$consumer_secret = $_POST['consumer_secret'];
		}
		$access_token = '';
		if( trim($_POST['access_token']) != '' ){
			$access_token = $_POST['access_token'];
		}
		$access_token_secret = '';
		if( trim($_POST['access_token_secret']) != '' ){
			$access_token_secret = $_POST['access_token_secret'];
		}
		$name = 'Tumblr';
		if( trim($_POST['name']) != '' ){
			$name = $_POST['name'];
		}
		$settings_array = array(
			'blog_id' => $blog_id,
			'consumer_key' => $oauth_consumer_key,
			'consumer_secret' => $consumer_secret,
			'access_token' => $access_token,
			'access_token_secret' => $access_token_secret,
		);
		$data = array(
			'service' => 'tumblr',
			'name' => $name,
			'settings' => serialize($settings_array),
		);
		$format_array = array(
			'%s',
			'%s',
			'%s',
		);
		$id = DTB_Admin_AccountDB::get_instance()->store($data, $format_array);
		dbtb_redirect('admin.php?page=' . DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug());
		exit();
	}
	
	public function tumblr_test(){
		$creds = DTB_Admin_AccountDB::get_instance()->get(24);
		$arr_settings = unserialize($creds->settings);
		$ret = DTB_API_Tumblr::get_instance()->oauth_info($arr_settings);
		echo '<pre>';
		print_r($ret);
		echo '</pre>';
	}
	
	public function tumblr_create_posts(){
		$creds = DTB_Admin_AccountDB::get_instance()->get(24);
		$arr_settings = unserialize($creds->settings);
		$post_array = array(
			'type' => 'text',
			'title' => 'Hello World!',
			'body' => 'The quick brown fox jumps over the lazy dog!',
		);
		$ret = DTB_API_Tumblr::get_instance()->create_new_blog_post($arr_settings, $post_array);
		echo '<pre>';
		print_r($ret);
		echo '</pre>';
	}
	
	public function dbtb_tumblr(){
		$data = array();
		$menu_slug = $this->tumblr_menu_slug;
		$data['method'] = 'create_tumblr_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		DTB_View::get_instance()->admin_partials('partials/tumblr/create.php', $data);
	}
		
	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}
	
	public function __construct(){
		$this->tumblr_menu_slug = DTB_Admin_Tumblr::get_instance()->menu_slug();
	}
}
