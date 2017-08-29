<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Model_QueueItem{
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
		return  $wpdb->prefix . 'deadbeat_queue_items';
	}
	
	public function get_item_not_posted($deadbeat_queue_id){
		global $wpdb;
		
		$table = $this->table();
		
		$where = "WHERE deadbeat_queue_id = $deadbeat_queue_id AND is_posted = 0";
		
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $table $where" );
		if( $count > 0 ){
			
			$sql = "SELECT * FROM $table $where";
			return $wpdb->get_results($sql);
		}
		return false;
	}
	
	public function get_db_list($deadbeat_queue_id = null, $where = null){
		global $wpdb;
		
		$table = $this->table();
		
		$where = '';
		if( !is_null($deadbeat_queue_id) ){
			$where = "WHERE deadbeat_queue_id = $deadbeat_queue_id";
		}
		
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $table $where" );
		if( $count > 0 ){
			
			$sql = "SELECT * FROM $table $where";
			return $wpdb->get_results($sql);
		}
		return false;
	}
	
	public function get_db_query($deadbeat_queue_id, $sql_query){
		global $wpdb;
		
		$table = $this->table();
		$sql = "SELECT * FROM $table $sql_query";

		return $wpdb->get_results($sql);
	}
	
	public function db_store($data = array()){
		global $wpdb;
		
		if( !empty($data) ){
			$deadbeat_queue_id = '';
			if( isset($data['deadbeat_queue_id']) 
				&& trim($data['deadbeat_queue_id']) != '' 
			){
				$deadbeat_queue_id = $data['deadbeat_queue_id'];
				return $wpdb->insert(
					$this->table(),
					array(
						'deadbeat_queue_id' => $deadbeat_queue_id,
						'post_id' => $data['post_id'],
						'is_posted' => 0,
					),
					array('%d','%d','%d')
				);
			}
		}
		return false;
	}
	
	public function db_update($id, $queue_name){
		global $wpdb;
		
		if( trim($queue_name) != '' ){
			return $wpdb->update(
				$this->table(),
				array(
					'name' => $queue_name
				),
				array(
					'id' => $id
				),
				array(
					'%s'
				),
				array(
					'%d'
				)
			);
		}
		return false;
	}

	public function db_update_is_posted($deadbeat_queue_id, $post_id){
		global $wpdb;

		return $wpdb->update(
			$this->table(),
			array('is_posted' => 1),
			array('deadbeat_queue_id' => $deadbeat_queue_id, 'post_id' => $post_id	),
			array('%d'),
			array('%d','%d')
		);
	}
	
	public function db_reset_post($deadbeat_queue_id){
		global $wpdb;
		$ret = $wpdb->update(
			$this->table(),
			array('is_posted' => 0),
			array('deadbeat_queue_id' => $deadbeat_queue_id),
			array('%d'),
			array('%d')
		);
		//var_dump( $wpdb->last_query );
		return $ret;
	}
	
	public function db_delete($id){
		global $wpdb;
		
		if( trim($id) != '' ){
			return $wpdb->delete( $this->table(), array( 'id' => $id ), array( '%d' ) );
		}
		
		return false;
	}

	public function db_delete_where($where_array = array(), $where_array_format = array()){
		global $wpdb;
		
		if( !empty($where_array) && !empty($where_array_format) ){
			return $wpdb->delete( $this->table(), $where_array, $where_array_format );
		}
		
		return false;
	}
	
	public function __construct(){}
}
