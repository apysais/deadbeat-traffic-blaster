<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Model_Queue{
	protected $queue_model_items;
	protected $queue_model_meta;
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
	
	private function table(){
		global $wpdb;
		return $wpdb->prefix . 'deadbeat_queue';
	}

	public function get_db_list($id = null){
		global $wpdb;
		
		$table = $this->table();
		$where = '';
		if( !is_null($id) ){
			$where = "WHERE id = $id";
		}
		$sql_count = "SELECT COUNT(*) FROM $table $where";
		$count = $wpdb->get_var($sql_count);
		if( $count > 0 ){
			$sql = "SELECT * FROM $table $where";
			if( !is_null($id) ){
				return $wpdb->get_row($sql);
			}else{
				return $wpdb->get_results($sql);
			}
		}
		return false;
	}
	
	
	public function store($queue_id, $post_id = array(), $choose_fb_page = array()){
		global $wpdb;
		if( !empty($post_id) ){
			$items_array = array();
			foreach($post_id as $k => $v){
				$items_array = array(
					'deadbeat_queue_id' => $queue_id,
					'post_id' => $v
				);
				$this->queue_model_items->db_store($items_array);
			}
		}
		if( !empty($choose_fb_page) ){
			$fb_pages_id = $choose_fb_page;
			$this->queue_model_meta->db_store($queue_id,'facebook_page', $fb_pages_id);
		}
	}
	
	public function db_store($name){
		global $wpdb;
		$queue_name = '';
		if( trim($name) != '' ){
			$queue_name = $name;
			return $wpdb->insert(
				$this->table(),
				array('name' => $queue_name),
				array('%s')
			);
		}
		return false;
	}
	
	public function update($id, $queue_name, $post_id = array(), $choose_fb_page = array()){
		global $wpdb;

		$fb_page_id = $choose_fb_page;
		
		$db_items = $this->get_db_list($id);
		$orig_name = $db_items->name;
		if( trim($queue_name) != ''
			&& strcmp($orig_name, trim($queue_name)) !== 0
		){
			$this->db_update($id, array('name' => $queue_name));
		}

		//get the items
		$get_post_id_array = array();
		$current_items = $this->queue_model_items->get_db_list($id);
		if( $current_items ){
			foreach($current_items as $k => $v){
				$get_post_id_array[] = $v->post_id;
			}
		}else{
			$current_items = array();
		}
		$array_diff_post_id_insert = array_diff($post_id,$get_post_id_array);
		$array_diff_post_id_del = array_diff($get_post_id_array,$post_id);
		
		if( !empty($array_diff_post_id_insert) ){
			$store_queue_array = array();
			foreach($array_diff_post_id_insert as $k => $v){
				$store_queue_array = array(
					'deadbeat_queue_id' => $id,
					'post_id' => $v,
				);
				$this->queue_model_items->db_store($store_queue_array);
			}
		}
		if( !empty($array_diff_post_id_del) ){
			$delet_queue_array = array();
			foreach($array_diff_post_id_del as $k => $v){
				$delet_queue_array = array(
					'deadbeat_queue_id' => $id,
					'post_id' => $v,
				);
				$delet_queue_array_format = array('%d','%d');
				$this->queue_model_items->db_delete_where($delet_queue_array,$delet_queue_array_format);
			}
		}

		//get the fb pages id
		$db_current_fb_pages = $this->queue_model_meta->get_by_queue_id($id, 'facebook_page');
		if( $db_current_fb_pages ){
			$this->queue_model_meta->db_update('facebook_page', $fb_page_id, null, $id);
		}else{
			$this->queue_model_meta->db_store($id, 'facebook_page', $fb_page_id);
		}
	}
	
	public function db_update($id, $update_data_array = array()){
		global $wpdb;
		$res = $wpdb->update(
			$this->table(),
			$update_data_array,
			array('id' => $id),
			array('%s'),
			array('%d')
		);
		if( $res ){
			return true;
		}
		return false;
	}
	
	public function db_delete($id){
		global $wpdb;

		if( trim($id) != '' ){
			$queue = $wpdb->delete( $this->table(), array( 'id' => $id ), array( '%d' ) );
			if( $queue ){
				$this->queue_model_items->db_delete_where(array('deadbeat_queue_id'=>$id),array('%d'));
				$this->queue_model_meta->db_delete_where(array('deadbeat_queue_item_id'=>$id), array('%d'));
			}
		}
		
		return false;
	}
	
	public function __construct(){
		$this->queue_model_items = new DTB_Model_QueueItem;
		$this->queue_model_meta = new DTB_Model_QueueMeta;
	}
}
