<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_DeadBeatTrafficBlasterCPT {
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
	
	public function cpt_init() {
		$text_domain = dbtb_get_text_domain();
		$labels = array(
			'name'               => _x( 'DeadBeat Traffic Blaster', 'post type general name', $text_domain ),
			'singular_name'      => _x( 'DeadBeat Traffic Blaster', 'post type singular name', $text_domain ),
			'menu_name'          => _x( 'DeadBeat Traffic Blaster', 'admin menu', $text_domain ),
			'name_admin_bar'     => _x( 'DeadBeat Traffic Blaster', 'add new on admin bar', $text_domain ),
			'add_new'            => _x( 'Add New', 'dtb', $text_domain ),
			'add_new_item'       => __( 'Add New DeadBeat Traffic Blaster', $text_domain ),
			'new_item'           => __( 'New Book', $text_domain ),
			'edit_item'          => __( 'Edit Book', $text_domain ),
			'view_item'          => __( 'View Book', $text_domain ),
			'all_items'          => __( 'All DTB', $text_domain ),
			'search_items'       => __( 'Search DTB', $text_domain ),
			'parent_item_colon'  => __( 'Parent DTB:', $text_domain ),
			'not_found'          => __( 'No DTB found.', $text_domain ),
			'not_found_in_trash' => __( 'No DTB found in Trash.', $text_domain )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', $text_domain ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'dtb' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'dtb', $args );
	}
	
	public function __construct(){
		$this->cpt_init();
		$textdomain = dbtb_get_text_domain();
		add_submenu_page(
			'dbtb-main',
			esc_html__( 'Social Media Accounts', $textdomain ),
			esc_html__( 'Social Media Accounts', $textdomain ),
			'manage_options',
			'edit.php?post_type=dtb'
		);
	}
}
