<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_WP extends DTB_Base{
	protected static $instance = null;
	protected $wp_menu_slug = null;
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
	
	public function post_status(){
		$cred = DTB_Admin_WP::get_instance()->get_credentials(22);
		$content = array(
			'title' => 'Hello World',
			'content' => 'Hello. I am a test post. I was created by the API',
		);
		$ret = DTB_API_WP::get_instance()->post_status($cred, $content);
		print_r($ret);
	}
	
	public function create_wp_api(){
		DTB_API_WP::get_instance()->oauth_authorize($_POST);
	}
	
	public function dbtb_wp(){
		$data = array();
		if( isset($_GET['code']) ){
			$ret = DTB_API_WP::get_instance()->auth_after_redirect();
			$access_token = $ret['secret']->access_token;
			$me = DTB_API_WP::get_instance()->me($access_token);
			/*echo '<pre>';
			print_r($ret);
			print_r($me);
			echo '</pre>';
			exit();*/
			$settings_array = array(
				'client_id' => $_SESSION['client_id'],
				'client_secret' => $_SESSION['client_secret_key'],
				'api_token' => $ret['secret']->access_token,
				'blog_id' => $me->primary_blog,
				'secret' => $ret['secret'],
			);
			$data = array(
				'service' => 'wordpress',
				'name' => 'WordPress',
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
		$menu_slug = $this->wp_menu_slug;
		$data['method'] = 'create_wp_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		$data['redirect_url'] = DTB_Admin_WP::get_instance()->redirect_url();
		$data['plugin_details'] = dbtb_get_plugin_details();
		$data['root_url'] = dbtb_root_url();
		DTB_View::get_instance()->admin_partials('partials/wp/wp-create.php', $data);
	}
	
	public function syndicate_html(){
		$wp = DTB_Admin_AccountDB::get_instance()->get_by_service('wordpress');
		$data['wp'] = $wp;
		DTB_View::get_instance()->admin_partials('partials/syndicate-now/wp.php', $data);
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
		$this->wp_menu_slug = DTB_Admin_WP::get_instance()->menu_slug();
	}
}
