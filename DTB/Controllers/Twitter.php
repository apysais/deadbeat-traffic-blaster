<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Twitter extends DTB_Base{
	protected static $instance = null;
	protected $twitter_menu_slug = null;
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
	
	public function dbtb_twitter(){
		$data = array();
		$menu_slug = $this->twitter_menu_slug;
		$data['method'] = 'create_twitter_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		DTB_View::get_instance()->admin_partials('partials/twitter/twitter-create.php', $data);
	}
	
	public function create_twitter_api(){
		$consumer_key = '';
		if( trim($_POST['consumer_key']) != '' ){
			$consumer_key = $_POST['consumer_key'];
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
		$settings_array = array(
			'consumer_key' => $_POST['consumer_key'],
			'consumer_secret' => $_POST['consumer_secret'],
		);
		$name = 'Twitter';
		if( trim($_POST['name']) != '' ){
			$name = $_POST['name'];
		}
		$settings_array = array(
			'consumer_key' => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'access_token' => $access_token,
			'access_token_secret' => $access_token_secret,
		);
		$data = array(
			'service' => 'twitter',
			'name' => $name,
			'settings' => serialize($settings_array),
		);
		$format_array = array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
		);
		$id = DTB_Admin_AccountDB::get_instance()->store($data, $format_array);
		dbtb_redirect('admin.php?page=' . DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug());
		exit();
	}
	
	public function twit_me(){
		$cred = DTB_Admin_Twitter::get_instance()->get_credentials(19);
		print_r($cred);
		$account = DTB_API_Twitter::get_instance()->oauth($cred);
		print_r($account);
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
		$this->twitter_menu_slug = DTB_Admin_Twitter::get_instance()->menu_slug();
	}
}
