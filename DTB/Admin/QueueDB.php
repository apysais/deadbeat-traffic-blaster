<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_QueueDB {
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
	
	private function tb_accounts() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'tb_accounts';
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			account_id INT( 12 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			service VARCHAR( 16 ) NOT NULL ,
			name VARCHAR( 255 ) NOT NULL ,
			settings TEXT NOT NULL,
			UNIQUE KEY account_id (account_id)
		) $charset_collate;";
		dbDelta( $sql );
	}

	private function log() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'tb_log';
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
  			logid int(12) NOT NULL AUTO_INCREMENT,
  			postid int(12) NOT NULL,
  			service varchar(255) NOT NULL,
  			timestamp int(12) NOT NULL,
  			content text NOT NULL,
  			link text NOT NULL,
  			PRIMARY KEY (logid)
		)$charset_collate;";
		dbDelta( $sql );
	}
	
	private function  create_queue_table(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'deadbeat_queue';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		  name varchar(250) NOT NULL,
		  PRIMARY KEY (`id`)
		) $charset_collate;";

		dbDelta( $sql );
	}

	private function create_queue_items_table(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'deadbeat_queue_items';
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		  deadbeat_queue_id int(10) NOT NULL,
		  post_id int(10) NOT NULL,
		  is_posted tinyint(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	private function create_queue_meta_table(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'deadbeat_queue_meta';
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		  deadbeat_queue_item_id bigint(20) NOT NULL,
		  meta_key varchar(255) NOT NULL,
		  meta_value longtext NOT NULL,
		  PRIMARY KEY (`id`)
		) $charset_collate;";
		dbDelta( $sql );
	}
	
		
	public function __construct(){
		if ( is_admin() ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$this->tb_accounts();
			$this->log();
			$this->create_queue_table();
			$this->create_queue_items_table();
			$this->create_queue_meta_table();
		}
	}
}
