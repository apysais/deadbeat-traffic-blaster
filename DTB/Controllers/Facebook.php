<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Facebook extends DTB_Base{
	protected static $instance = null;
	protected $fb_menu_slug = null;
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
	
	public function dbtb_facebook(){
		$data = array();
		$menu_slug = $this->fb_menu_slug;
		$data['method'] = 'create_facebook_api';
		$data['action'] = 'admin.php?page=' . $menu_slug;
		$data['plugin_details'] = dbtb_get_plugin_details();
		$data['root_url'] = dbtb_root_url();
		DTB_View::get_instance()->admin_partials('partials/fb/fb-create.php', $data);
	}
	
	public function create_facebook_api(){
		$app_id = '';
		if( isset($_POST['app_id']) 
			&& trim($_POST['app_id']) != ''
		){
			$app_id = $_POST['app_id'];
		}
		$app_secret = '';
		if( isset($_POST['app_secret']) 
			&& trim($_POST['app_secret']) != ''
		){
			$app_secret = $_POST['app_secret'];
		}
		$_SESSION['facebook_name'] = $_POST['name'];
		DTB_API_Facebook::get_instance()->login($app_id, $app_secret);
	}
	
	public function fallback(){
		$ret = DTB_API_Facebook::get_instance()->fallback();

		if( !empty($ret['error']) ){
			print_r($ret['error']);
		}else{
			$settings_array = array(
				'app_id' => $_SESSION['app_id'],
				'app_secret' => $_SESSION['app_secret'],
				'fb_access_token' => $ret['success']['fb_access_token'],
				'accessTokenLogged' => $ret['success']['accessTokenLogged'],
				'tokenMetadata' => $ret['success']['tokenMetadata']
			);
			$data = array(
				'service' => 'facebook',
				'name' => $_SESSION['facebook_name'],
				'settings' => serialize($settings_array),
			);
			$format_array = array(
				'%s',
				'%s',
				'%s',
			);
			$id = DTB_Admin_AccountDB::get_instance()->store($data, $format_array);
			
			unset($_SESSION['facebook_name']);
			unset($_SESSION['app_id']);
			unset($_SESSION['app_secret']);
			dbtb_redirect('admin.php?page=' . DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug());
			exit();
		}
	}
	
	public function fb_me($account_id){
		$cred = DTB_Admin_Facebook::get_instance()->get_credentials(18);
		$me = DTB_API_Facebook::get_instance()->me($cred['app_id'], $cred['app_secret'], $cred['fb_access_token']);
		print_r($me);
	}
	
	public function fb_account($account_id){
		$cred = DTB_Admin_Facebook::get_instance()->get_credentials(1);
		$me = DTB_API_Facebook::get_instance()->me_account(
			$cred['app_id'], 
			$cred['app_secret'], 
			$cred['fb_access_token']
		);
		print_r($me->getDecodedBody());
	}

	public function fb_publish_account($account_id){
		$cred = DTB_Admin_Facebook::get_instance()->get_credentials(18);
		$me = DTB_API_Facebook::get_instance()->publish_account(
			'102815823111268',
			$cred['app_id'],
			$cred['app_secret'],
			$cred['fb_access_token']
		);
		print_r($me);
	}
	
	public function syndicate_html(){
		$fb = DTB_Admin_AccountDB::get_instance()->get_by_service('facebook');
		$data['fb'] = $fb;
		DTB_View::get_instance()->admin_partials('partials/syndicate-now/fb.php', $data);
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
		$this->fb_menu_slug = DTB_Admin_Facebook::get_instance()->menu_slug();
	}
}
