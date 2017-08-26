<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Queue extends DTB_Base{
	protected static $instance = null;
	protected $menu_slug = null;
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
	
	public function dbtb_queue(){
		$data = array();
		$menu_slug = $this->menu_slug;
		$data['menu_slug'] = $menu_slug;
		DTB_View::get_instance()->admin_partials('partials/queue/main.php', $data);
	}
	
	public function create_queue(){
		$data = array();
		$menu_slug = $this->menu_slug;
		$data['menu_slug'] = $menu_slug;
		$data['title'] = 'Create New Queue Name';
		$data['choose_posts'] = DTB_Admin_Queue::get_instance()->get_posts();
		$fb = DTB_Admin_AccountDB::get_instance()->get_by_service('facebook');
		$data['fb'] = $fb;
		DTB_View::get_instance()->admin_partials('partials/queue/create.php', $data);
		//$data['create_view_form'] = $this->view_create_form();
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
		$this->menu_slug = DTB_Admin_Queue::get_instance()->menu_slug();
	}
}
