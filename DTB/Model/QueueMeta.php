<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Model_QueueMeta{
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
		return  $wpdb->prefix . 'deadbeat_queue_meta';
	}
	
	public function get_by_queue_id($queue_id, $meta_key = null){
		global $wpdb;
		
		$table = $this->table();
		
		$where = '';
		$where = "WHERE deadbeat_queue_item_id = $queue_id";
		
		$where_meta_key = '';
		if( !is_null($meta_key) ){
			$where_meta_key = " AND meta_key = '$meta_key'";
		}
		
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $table $where $where_meta_key" );
		if( $count > 0 ){
			$sql = "SELECT * FROM $table $where $where_meta_key";
			return $wpdb->get_results($sql);
		}
		return false;
	}
	
	public function db_store($queue_id, $meta_key, $meta_value){
		global $wpdb;
		
		if( is_array($meta_value) ){
			$meta_value = serialize($meta_value);
		}

		if( is_object($meta_value) ){
			$meta_value = serialize( json_decode(json_encode($meta_value), true) );
		}
						
		$ret = $wpdb->insert(
			$this->table(),
			array(
				'deadbeat_queue_item_id' => $queue_id,
				'meta_key' => $meta_key,
				'meta_value' => $meta_value,
			),
			array('%d','%s','%s')
		);
		if( $ret ){
			return $ret;
		}
		return false;
	}
	
	public function db_update($meta_key, $meta_value, $id = null, $deadbeat_queue_item_id = null){
		global $wpdb;
		
		if( is_array($meta_value) ){
			$meta_value = serialize($meta_value);
		}

		if( is_object($meta_value) ){
			$meta_value = serialize( json_decode(json_encode($meta_value), true) );
		}
		
		$where_id = array();
		
		if( !is_null($id) ){
			$where_id = array('id' => $id);
		}
		if( !is_null($deadbeat_queue_item_id) ){
			$where_id = array('deadbeat_queue_item_id' => $deadbeat_queue_item_id);
		}
		
		$ret = $wpdb->update(
			$this->table(),
			array(
				'meta_key' => $meta_key,
				'meta_value' => $meta_value,
			),
			$where_id,
			array('%s','%s'),
			array('%d')
		);
		if( $ret ){
			return $ret;
		}
		return false;
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
