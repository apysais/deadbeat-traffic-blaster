<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_LogDB {
	protected static $instance = null;
	protected $_wpdb;
	protected $table_name;
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
	
	public function get($id = null){
		$table_name = $this->table_name;
		
		if( !is_null($id) ){
			$str = "SELECT * FROM $table_name WHERE account_id = $id";
			$query = $this->_wpdb->get_results($str);
		}else{
			$query = $this->_wpdb->get_results( "SELECT * FROM $table_name" );
		}
		
		return $query;
	}
	
	public function store($data = array()){
		//$wpdb->insert( $table, $data, $format );
		if( !empty($data) ){
			return $this->_wpdb->insert($this->table_name, $data);
		}else{
			return false;
		}
	}
	
	public function update($id, $data = array()){
		//$wpdb->update( $table, $data, $where, $format = null, $where_format = null )
		if( !empty($data) ){
			return $this->_wpdb->update($this->table_name, $data, $id);
		}else{
			return false;
		}
	}
	
	public function delete($id){
		//$wpdb->delete( $table, $where, $where_format = null );
		if($id != ''){
			return $this->_wpdb->delete($this->table_name, $id);
		}else{
			return false;
		}
	}
	
	public function __construct(){
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'tb_log';
		$this->_wpdb = $wpdb;
	}
}
