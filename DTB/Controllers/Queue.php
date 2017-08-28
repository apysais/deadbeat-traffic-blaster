<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_Queue extends DTB_Base{
	protected static $instance = null;
	protected $menu_slug = null;
	protected $model;
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
		$data['list'] = $this->model->get_db_list();
		$data['edit_url'] = 'admin.php?page='.$menu_slug.'&_method=edit-queue';
		$data['delete_url'] = 'admin.php?page='.$menu_slug.'&_method=delete-queue';
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
		$data['method'] = 'store_queue';
		$data['action'] = 'admin.php?page=' . $this->menu_slug;
		DTB_View::get_instance()->admin_partials('partials/queue/create.php', $data);
		//$data['create_view_form'] = $this->view_create_form();
	}
	
	public function store_queue(){
		global $wpdb;
		$queue_name = '';
		if( isset($_POST['queue_name']) && trim($_POST['queue_name']) != '' ){
			$queue_name = $_POST['queue_name'];
			$queue_id = $this->model->db_store($queue_name);
			if( $queue_id ){
				$post_id = array();
				if( isset($_POST['post_id']) ){
					$post_id = $_POST['post_id'];
				}
				$choose_fb_page = array();
				if( isset($_POST['choose_fb_page']) ){
					$choose_fb_page = $_POST['choose_fb_page'];
				}
				$this->model->store(
					$wpdb->insert_id,
					$post_id,
					$choose_fb_page
				);
			}
			
		}
	}
	
	public function edit_queue(){
		$id = false;
		if( isset($_GET['id']) && trim($_GET['id']) != '' ){
			$id = $_GET['id'];
			if( $id ){
				$db = $this->model->get_db_list($id);
				$data['edit_db'] = $db;
				//get the items
				$get_post_id_array = array();
				$current_items = $this->queue_model_items->get_db_list($id);
				if( $current_items ){
					foreach($current_items as $k => $v){
						$get_post_id_array[] = $v->post_id;
					}
				}
				$data['current_items'] = $current_items;
				$data['get_post_id_array'] = $get_post_id_array;
				
				//get the fb pages id
				$current_fb_pages = $this->queue_model_meta->get_by_queue_id($id, 'facebook_page');
				$data['choose_fb_page'] = DTB_Admin_Facebook::get_instance()->get_pages();
				if( $current_fb_pages ){
					$current_fb_pages = unserialize($current_fb_pages[0]->meta_value);
					$data['current_fb_pages'] = $current_fb_pages;
				}
				$data['method'] = 'update-queue';
				$data['action'] = 'admin.php?page=' . $this->menu_slug;
				$data['id'] = $id;
				if( is_multisite() ){
					$data['url_cron'] = ' wget "'.home_url() . '/' . DTB_Admin_CronJob::get_instance()->menu_slug($id).'"';
				}else{
					$data['url_cron'] = ' wget "'.home_url() . '/' . DTB_Admin_CronJob::get_instance()->menu_slug($id).'"';
				}
				$data['choose_posts'] = DTB_Admin_Queue::get_instance()->get_posts();
				/*echo '<pre>';
				print_r($data);
				echo '</pre>';*/
				DTB_View::get_instance()->admin_partials('partials/queue/edit.php', $data);
			}
		}
	}
	
	public function update_queue(){
		global $wpdb;
		$id = null;
		if( isset($_POST['id']) 
			&& $_POST['id'] != ''
		){
			$id = $_POST['id'];
			if( !is_null($id) ){
				$queue_name = '';
				if( isset($_POST['queue_name']) 
					&& trim($_POST['queue_name']) != ''
				){
					$queue_name = $_POST['queue_name'];
				}
				$this->model->update(
					$id,
					$queue_name,
					isset($_POST['post_id']) ? $_POST['post_id']:array(),
					isset($_POST['choose_fb_page']) ? $_POST['choose_fb_page']:array()
				);
			}//!is_null($id)
		}//$_POST['id']
		
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
		$this->model = new DTB_Model_Queue;
		$this->queue_model_items = new DTB_Model_QueueItem;
		$this->queue_model_meta = new DTB_Model_QueueMeta;
	}
}
